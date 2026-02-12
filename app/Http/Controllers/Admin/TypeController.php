<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    private $type;
    protected string $target_all;
    protected string $target_hotel;
    protected string $target_restaurant;

    public function __construct(Type $type)
    {
        $this->type = $type;
        $this->target_all = config('app.target_type_all');
        $this->target_hotel = config('app.target_type_hotel');
        $this->target_restaurant = config('app.target_type_restaurant');
    }

    public function index()
    {
        $all_types = $this->type->all();
        return view('adminpage.category.type-index', compact('all_types'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:50',
            'target_type' => 'required|in:all,hotel,restaurant'
        ]);

        // カテゴリ作成
        $this->type->name = $request->name;
        $this->type->target_type = $request->target_type;
        $this->type->save();
        return redirect()->back();
    }
    
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:50'
        ]);

        $type = $this->type->findOrFail($id);

        // カテゴリ作成
        $type->name = $request->name;

        $type->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $type = $this->type->findOrFail($id);
        
        $type->delete();

        return redirect()->back();
    }
}
