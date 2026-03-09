<?php

namespace App\Http\Controllers;

use App\Models\DailyFortuneLog;
use App\Models\FortuneSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyFortuneController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $fortuneLog = DailyFortuneLog::with('fortuneSpot')
            ->where('user_id', $user->id)
            ->where('fortune_date', $today)
            ->first();

        return view('daily_fortune', compact('fortuneLog'));
    }

    public function draw()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $existingLog = DailyFortuneLog::with('fortuneSpot')
            ->where('user_id', $user->id)
            ->where('fortune_date', $today)
            ->first();

        if ($existingLog) {
            return redirect()->route('daily.fortune.show')
                ->with('message', '今日はすでにおみくじを引いています。');
        }

        $spot = FortuneSpot::where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (!$spot) {
            return redirect()->route('home')
                ->with('error', 'おすすめスポットが登録されていません。');
        }

        DailyFortuneLog::create([
            'user_id' => $user->id,
            'fortune_spot_id' => $spot->id,
            'fortune_date' => $today,
        ]);

        return redirect()->route('daily.fortune.show')
            ->with('success', '今日のおすすめスポットが決まりました。');
    }
}
