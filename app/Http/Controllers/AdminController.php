<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\TmpHotel;
use App\Models\TmpHotelImage;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\ApprovalHistory;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role_id', 3)->count();

        return view('adminpage.home', compact('totalUsers'));
    }

    public function customers()
    {
        return view('adminpage.customer.customers'); // Customer表用
    }

    public function hotels()
    {
        return view('adminpage.hotel.hotels'); // Hotel表用
    }

    public function addHotel()
    {
        return view('adminpage.hotel.add');
    }
    public function editHotel()
    {
        return view('adminpage.hotel.edit');
    }

    public function restaurants()
    {
        return view('adminpage.restaurant.restaurants'); // Restaurant表用
    }
    public function editRestaurant()
    {
        return view('adminpage.restaurant.edit');
    }
    public function addRestaurant()
    {
        return view('adminpage.restaurant.add');
    }

    public function admins()
    {
        // 管理者一覧ページのビュー
        return view('adminpage.admin.admin');
    }


    public function analysisHotel()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.hotel.analysis-hotel');
    }

    public function analysisRestaurant()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.restaurant.analysis-restaurant');
    }

    public function addAdmin()
    {
        return view('adminpage.admin.add');
    }

    public function editAdmin()
    {
        return view('adminpage.admin.edit');
    }

    // AdminController.php
    public function editCustomer()
    {
        return view('adminpage.customer.edit-customers');
    }
    public function addCustomer()
    {
        return view('adminpage.customer.add-customers');
    }


    /**
     * 2/6
     * ホテル申請を承認する
     * - users を作成
     * - hotels を users.id を使って作成
     * - tmp 画像を public ストレージに移動して hotel_images を作成
     * - tmp レコードと tmp 画像レコードを削除
     *
     * 注意:
     * - ファイル移動は DB トランザクション外で行うため、失敗時の整合性をログに残す
     * - メール送信はトランザクション外で行う（ここではサンプル）
     */


    public function approveHotel($id)
    {
        $tmp = TmpHotel::with('images')->findOrFail($id);

        Log::info('approveHotel start', [
            'tmp_id' => $id,
            'rep_email' => $tmp->representative_email ?? null,
            'rep_name' => $tmp->representative_name ?? null,
            'images_count' => $tmp->images->count(),
        ]);

        $email = $tmp->representative_email ?? null;
        $tempPassword = Str::random(12);

        DB::beginTransaction();

        try {
            Log::info('approveHotel before email checks', ['email' => $email]);

            if (! $email) {
                Log::warning('approveHotel abort: no email', ['tmp_id' => $id]);
                DB::rollBack();
                return redirect()->back()->withErrors(['email' => '代表者のメールアドレスが登録されていません。']);
            }

            if (User::where('email', $email)->exists()) {
                Log::warning('approveHotel abort: email exists', ['email' => $email, 'tmp_id' => $id]);
                DB::rollBack();
                return redirect()->back()->withErrors(['email' => 'このメールアドレスは既に登録されています。別のメールアドレスで申請してください。']);
            }

            Log::info('approveHotel creating user', ['email' => $email]);

            // 1) users を作成
            $user = User::create([
                'name' => $tmp->name ?? ($tmp->representative_name ?? 'No Name'),
                'email' => $email,
                'password' => Hash::make($tempPassword),
                'role_id' => User::HOTEL_ROLE_ID ?? 3,
            ]);

            // 2) hotels を作成（id を users.id に合わせる）
            $hotel = Hotel::create([
                'id' => $user->id,
                'name' => $tmp->name,
                'description' => $tmp->description,
                'address' => $tmp->address,
                'city' => $tmp->city,
                'latitude' => $tmp->latitude,
                'longitude' => $tmp->longitude,
                'star_rating' => $tmp->star_rating,
                'phone' => $tmp->phone,
                'website' => $tmp->website,
                'representative_name' => $tmp->representative_name ?? null,
                'representative_email' => $tmp->representative_email ?? null,
            ]);
            
            // 3)画像移行（修正版）
            $movedImages = [];
            foreach ($tmp->images as $tmpImage) {
                // tmpImage->image が "tmp/hotels/{id}/file.jpg" の場合はそのまま使い、
                // 単に "file.jpg" の場合は tmp/hotels/{tmp->id}/file.jpg を想定する
                $stored = ltrim($tmpImage->image, '/');
                if (Str::startsWith($stored, 'tmp/hotels/')) {
                    $oldPath = $stored;
                } else {
                    $oldPath = "tmp/hotels/{$tmp->id}/" . basename($stored);
                }

                $filename = basename($oldPath);
                $newDir = "hotels/{$hotel->id}";
                $newPath = "{$newDir}/{$filename}";

                try {
                    if (! Storage::disk('public')->exists($newDir)) {
                        Storage::disk('public')->makeDirectory($newDir);
                    }

                    if (Storage::disk('public')->exists($oldPath)) {
                        // move を使って確実に移動（コピー＋削除より簡潔）
                        Storage::disk('public')->move($oldPath, $newPath);
                    } else {
                        Log::warning('Tmp image file not found during approval', ['path' => $oldPath, 'tmp_image_id' => $tmpImage->id]);
                        // 見つからない場合は既存の値を保持（運用に合わせて変更可）
                        $newPath = $oldPath;
                    }

                    // HotelImage には保存先パスを入れる（必要なら basename のみを入れる方針に統一）
                    HotelImage::create([
                        'hotel_id' => $hotel->id,
                        'image' => $newPath,
                    ]);

                    $movedImages[] = $newPath;
                } catch (\Throwable $e) {
                    Log::error('Failed to move tmp image during hotel approval', [
                        'error' => $e->getMessage(),
                        'old' => $oldPath,
                        'new' => $newPath,
                    ]);
                    throw $e;
                }
            }


            // 4) tmp 側の DB レコードと物理ファイルをクリーンアップ（承認成功時）
            // try {
            //     // DB の tmp image レコードを削除
            //     $tmp->images()->delete();

            //     // 物理ファイル（tmp ディレクトリ）を削除
            //     $tmpDir = "tmp/hotels/{$tmp->id}";
            //     if (Storage::disk('public')->exists($tmpDir)) {
            //         // ファイルをすべて削除してからディレクトリを削除
            //         $files = Storage::disk('public')->files($tmpDir);
            //         foreach ($files as $file) {
            //             Storage::disk('public')->delete($file);
            //         }
            //         Storage::disk('public')->deleteDirectory($tmpDir);
            //         Log::info('Tmp files removed after approval', ['tmp_id' => $tmp->id, 'dir' => $tmpDir]);
            //     } else {
            //         Log::info('No tmp directory to remove after approval', ['tmp_id' => $tmp->id, 'dir' => $tmpDir]);
            //     }

            //     // tmp レコードは softDeletes を使っているので delete() で deleted_at をセット
            //     $tmp->delete();
            // } catch (\Throwable $cleanupEx) {
            //     // クリーンアップ失敗は致命的にせずログに残して続行
            //     Log::error('Tmp cleanup failed after approval', [
            //         'tmp_id' => $tmp->id,
            //         'error' => $cleanupEx->getMessage(),
            //         'trace' => $cleanupEx->getTraceAsString(),
            //     ]);
            // }


            // 5) 承認履歴
            if (class_exists(ApprovalHistory::class)) {
                ApprovalHistory::create([
                    'approvable_type' => 'hotel',
                    'approvable_id' => $hotel->id,
                    'approved_by' => auth()->id() ?? null,
                    'notes' => 'Approved via admin panel',
                ]);
            }

            DB::commit();

            // 承認成功後（DB commit の後） データを物理削除 必要に応じて4）は削除
            $this->cleanupTmpAfterDecision($tmp);


            // 6) メール送信（トランザクション外）
            try {
                Log::info('Hotel approved', ['hotel_id' => $hotel->id, 'user_id' => $user->id]);
                // Mail::to($user->email)->send(new \App\Mail\ApprovedNotification($user, $tempPassword));
            } catch (\Throwable $e) {
                Log::error('Failed to send approval email', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            }

            return redirect()->back()->with('status', 'ホテル申請を承認しました！');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Hotel approval failed', ['error' => $e->getMessage(), 'tmp_id' => $id, 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors('承認処理中にエラーが発生しました。');
        }
    }
    /**
     * 承認一覧ページ（左に一覧、右に最初の申請を表示）
     */
    public function hotelApproval()
    {
        $tmpHotels = TmpHotel::with('images')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $tmpHotel = $tmpHotels->first();

        return view('adminpage.hotel.pending-approval', compact('tmpHotels', 'tmpHotel'));
    }

    /**
     * 個別申請を選択して表示（Review ボタンでここに飛ばす）
     */
    public function showPending($id)
    {
        $tmpHotels = TmpHotel::with('images')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $tmpHotel = TmpHotel::with('images')->findOrFail($id);

        return view('adminpage.hotel.pending-approval', compact('tmpHotels', 'tmpHotel'));
    }

    public function rejectHotel($id)
    {
        $tmp = TmpHotel::findOrFail($id);

        DB::beginTransaction();
        try {
            // 1) ステータス更新（運用に合わせてカラム名を調整）
            $tmp->status = 'rejected';
            $tmp->save();

            // 2) 承認履歴（任意）
            if (class_exists(ApprovalHistory::class)) {
                ApprovalHistory::create([
                    'approvable_type' => 'hotel',
                    'approvable_id' => $id,
                    'approved_by' => auth()->id() ?? null,
                    'notes' => 'Rejected via admin panel',
                ]);
            }

            DB::commit();
            // 承認成功後（DB commit の後）データを物理削除
            $this->cleanupTmpAfterDecision($tmp);


            // 3) ログとフラッシュ
            Log::info('Hotel rejected', ['tmp_id' => $id, 'by' => auth()->id() ?? null]);
            return redirect()->route('admin.hotel.approval')->with('status', 'ホテル申請を却下しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Hotel reject failed', ['tmp_id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()->withErrors('却下処理中にエラーが発生しました。');
        }
    }

    private function cleanupTmpAfterDecision(\App\Models\TmpHotel $tmp)
    {
        try {
            // 1) tmp ディレクトリ内の物理ファイルをすべて削除
            $tmpDir = "tmp/hotels/{$tmp->id}";
            $disk = \Illuminate\Support\Facades\Storage::disk('public');

            if ($disk->exists($tmpDir)) {
                $files = $disk->allFiles($tmpDir);
                foreach ($files as $file) {
                    if ($disk->exists($file)) {
                        $disk->delete($file);
                    }
                }
                // ディレクトリ削除（空なら削除される）
                $disk->deleteDirectory($tmpDir);
                \Illuminate\Support\Facades\Log::info('Tmp files physically removed', ['tmp_id' => $tmp->id, 'dir' => $tmpDir]);
            } else {
                \Illuminate\Support\Facades\Log::info('No tmp directory to remove', ['tmp_id' => $tmp->id, 'dir' => $tmpDir]);
            }

            // 2) tmp_hotel_images テーブルのレコードを物理削除（モデルが SoftDeletes なら forceDelete、なければ delete）
            foreach ($tmp->images()->get() as $img) {
                $imgPath = ltrim($img->image ?? '', '/');
                if ($imgPath && $disk->exists($imgPath)) {
                    $disk->delete($imgPath);
                }
                if (method_exists($img, 'forceDelete')) {
                    $img->forceDelete();
                } else {
                    $img->delete();
                }
            }
            // 代替でクエリ一括削除するなら（外部キーやトリガーに注意）
            // \DB::table('tmp_hotel_images')->where('tmp_hotel_id', $tmp->id)->delete();

            // 3) tmp レコード自体を物理削除（SoftDeletes があるなら forceDelete）
            if (method_exists($tmp, 'forceDelete')) {
                $tmp->forceDelete();
            } else {
                $tmp->delete();
            }

            \Illuminate\Support\Facades\Log::info('Tmp DB records physically removed', ['tmp_id' => $tmp->id]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Cleanup (physical delete) failed', [
                'tmp_id' => $tmp->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
