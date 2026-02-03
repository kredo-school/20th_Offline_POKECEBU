<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryRoom;
use App\Models\CategoryTable;
use App\Models\HotelRoom;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;
    private $categoryRoom;
    private $categoryTable;
    private $room;
    private $table;

    public function __construct(
        Category $category,
        CategoryRoom $categoryRoom,
        CategoryTable $categoryTable,
        HotelRoom $room,
        RestaurantTable $table
    ) {
        $this->category = $category;
        $this->categoryRoom = $categoryRoom;
        $this->categoryTable = $categoryTable;
        $this->room = $room;
        $this->table = $table;
    }

   public function index()
{
    $all_categories = $this->category->all();

    // 1. ホテル用カテゴリーの中で、部屋が一つも紐づいていないものをカウント
    $uncategorized_rooms = $this->category
        ->where('target_type', 'hotel')
        ->whereDoesntHave('categoryRooms')
        ->count();

    // 2. レストラン用カテゴリーの中で、テーブルが一つも紐づいていないものをカウント
    $uncategorized_tables = $this->category
        ->where('target_type', 'restaurant')
        ->whereDoesntHave('categoryTables')
        ->count();

    return view('adminpage.category.index', [
        'all_categories' => $all_categories,
        'rooms'          => $this->room->all(),
        'tables'         => $this->table->all(),
        'uncategorized_rooms'  => $uncategorized_rooms,
        'uncategorized_tables' => $uncategorized_tables
    ]);
}


    public function store(Request $request)
{
    // バリデーション
    $request->validate([
        'name' => 'required|max:50',
        'target_type' => 'required|in:hotel,restaurant'
    ]);

    // カテゴリ作成
    $category = new Category();
    $category->name = $request->name;
    $category->target_type = $request->target_type;
    $category->save();

    // ここから pivot テーブルへの紐付け
    if ($request->target_type === 'hotel' && $request->room_ids) {
        foreach ($request->room_ids as $roomId) {
            CategoryRoom::create([
                'category_id' => $category->id,
                'room_id' => $roomId,
            ]);
        }
    }

    if ($request->target_type === 'restaurant' && $request->table_ids) {
        foreach ($request->table_ids as $tableId) {
            CategoryTable::create([
                'category_id' => $category->id,
                'table_id' => $tableId,
            ]);
        }
    }

        return redirect()->route('admin.category.index', ['type' => $request->target_type]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:50',
        'target_type' => 'required|in:hotel,restaurant'
    ]);

    $category = $this->category->findOrFail($id);
    
    // カテゴリ基本情報の更新
    $category->name = $request->name;
    $category->target_type = $request->target_type;
    $category->save();

    // 1. 一旦、そのカテゴリに紐づくすべての紐付け(Room/Table両方)を削除
    // これにより、タイプ変更時やチェックを外した時の不整合を防ぐ
    CategoryRoom::where('category_id', $id)->delete();
    CategoryTable::where('category_id', $id)->delete();

    // 2. 新しく選択されたタイプとIDに基づいて紐付け直す
    if ($request->target_type === 'hotel') {
        if ($request->room_ids) {
            foreach ($request->room_ids as $roomId) {
                CategoryRoom::create([
                    'category_id' => $id,
                    'room_id' => $roomId,
                ]);
            }
        }
    } elseif ($request->target_type === 'restaurant') {
        if ($request->table_ids) {
            foreach ($request->table_ids as $tableId) {
                CategoryTable::create([
                    'category_id' => $id,
                    'table_id' => $tableId,
                ]);
            }
        }
    }

    return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
}

 public function destroy($id)
{
    $category = $this->category->findOrFail($id);

    // 中間テーブル（pivot）の紐付けを削除
    // モデルに belongsToMany が正しく定義されていない場合、detach() はエラーになります。
    // そのため、update メソッドと同じく明示的に delete() します。
    if ($category->target_type === 'hotel') {
        CategoryRoom::where('category_id', $id)->delete();
    } else {
        CategoryTable::where('category_id', $id)->delete();
    }

    // カテゴリ本体を削除
    $category->delete();

    // indexには引数(type)はもう不要なのでシンプルにリダイレクト
    return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
}
}