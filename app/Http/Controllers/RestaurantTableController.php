<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RestaurantTable;
use App\Models\RestaurantTableType;
use App\Models\Status;
use App\Models\TableImage;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantTableController extends Controller
{
    private $type;
    private $category;
    private $status;
    private $restaurantTableType;
    private $restaurantTable;
    protected string $target_restaurant;
    protected string $target_all;

    public function __construct(Type $type, Category $category, Status $status, RestaurantTableType $restaurantTableType, RestaurantTable $restaurantTable)
    {
        $this->type = $type;
        $this->category = $category;
        $this->status = $status;
        $this->restaurantTableType = $restaurantTableType;
        $this->restaurantTable = $restaurantTable;
        $this->target_restaurant  = config('app.target_type_restaurant');
        $this->target_all = config('app.target_type_all');
    }
    
    public function tableOverview()
    {
        $restaurant_id = Auth::user()->id;
        
        $all_types = $this->type->where('target_type', $this->target_restaurant)->get();
        $all_categories = $this->category->whereIn('target_type', [$this->target_restaurant, $this->target_all])->get();
        $all_statuses = $this->status->whereIn('target_type', [$this->target_restaurant, $this->target_all])->get();

        $all_table_types = $this->restaurantTableType
            ->where('restaurant_id', $restaurant_id)
            ->withCount([
                'tables as reserved_cnt' => fn($query) => $query->where('status_id', 3),
                'tables as available_cnt' => fn($query) => $query->where('status_id', 1),
                'tables as tmpUnavailable_cnt' => fn($query) => $query->where('status_id', 4),
                'tables as unavailable_cnt' => fn($query) => $query->where('status_id', 2),
            ])
            ->with('type')
            ->get();
        
        $all_tables = $this->restaurantTable->where('restaurant_id', $restaurant_id)->orderBy('table_number')->with(['type', 'status', 'categories'])->get();

        return view('staffpage.tabletype.tabletype',
            compact('all_types', 'all_categories', 'all_statuses', 'all_table_types', 'all_tables'));
    }

    public function storeTableType(Request $request)
    {
        $restaurant_id = Auth::user()->id;

        $request->validate(
            [
                'table_type' => 'required',
                'total_tables' => 'required',
            ],[
                'table_type.required' => '【Table Overview】The table type field is required.',
                'total_tables.required' => '【Table Overview】The total tables field is required.',
            ]
        );

        $exists = $this->restaurantTableType->where('restaurant_id', $restaurant_id)
                                        ->where('type_id', $request->table_type)->exists();

        if ($exists) {
            return redirect()->back()->withErrors([
                'table_type' => '【Table Overview】The table type already exists.'
                ])->withInput();
        }

        $this->restaurantTableType->restaurant_id = $restaurant_id;
        $this->restaurantTableType->type_id = $request->table_type;
        $this->restaurantTableType->total_tables = $request->total_tables;

        $this->restaurantTableType->save();

        return redirect()->back();
    }

    public function updateTableType(Request $request, string $id)
    {
        $request->validate([
            'total_tables' => 'required'
        ]);

        $table_type = $this->restaurantTableType->findOrFail($id);
        $all_tables = $this->restaurantTable->where('restaurant_id', $table_type->restaurant_id)
                                        ->where('type_id', $table_type->type_id)->get();

        $newTotal = (int) $request->total_tables;
        $oldTotal = (int) $table_type->total_tables;

        if ($newTotal < $oldTotal) {
            $exists = $all_tables->whereIn('status_id', [2, 3])->isNotEmpty();;

            if ($exists) {
                return redirect()->back()->withErrors([
                    'total_tables' => 'There are tables with status that cannot be changed.'
                ])->withInput();
            }
        }

        $table_type->total_tables = $request->total_tables;

        $table_type->save();

        return redirect()->back();
    }

    public function destroyTableType($id) 
    {
        $table_type = $this->restaurantTableType->findOrFail($id);

        $table_type->Delete();

        return redirect()->back();
    }

    public function createTable() 
    {
        $restaurant_id = Auth::user()->id;

        $all_categories = $this->category->whereIn('target_type', [$this->target_restaurant, $this->target_all])->get();
        $all_table_types = $this->restaurantTableType->where('restaurant_id', $restaurant_id)->with('type')->get();
        
        return view('staffpage.tabletype.table-create', compact('all_categories', 'all_table_types'));
    }

    public function storeTable(Request $request)
    {
        $restaurant_id = Auth::user()->id;

        $request->validate([
            'table_num' => 'required',
            'type_id' => 'required',
            'guests' => 'required',
            'charges' => 'required',
            'detail' => 'required',

            'images.*' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $this->restaurantTable->restaurant_id = $restaurant_id;
        $this->restaurantTable->table_number = $request->table_num;
        $this->restaurantTable->type_id = $request->type_id;
        $this->restaurantTable->max_guests = $request->guests;
        $this->restaurantTable->charges = $request->charges;
        $this->restaurantTable->detail = $request->detail;
        $this->restaurantTable->status_id = 4; // preparing

        $this->restaurantTable->save();

        if ($request->filled('category')) {
            $this->restaurantTable->categories()->attach($request->category);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $base64 = 'data:image/' . $imageFile->extension() . ';base64,' .
                          base64_encode(file_get_contents($imageFile));

                TableImage::create([
                    'table_id' => $this->restaurantTable->id,
                    'image'   => $base64
                ]);
            }
        }

        return redirect()->route('restaurant.tableOverview');
    }

    public function editTable($id) 
    {
        $restaurant_id = Auth::user()->id;

        $table = $this->restaurantTable->findOrFail($id);

        $all_categories = $this->category->whereIn('target_type', [$this->target_restaurant, $this->target_all])->get();
        $all_table_types = $this->restaurantTableType->where('restaurant_id', $restaurant_id)->with('type')->get();
        
        return view('staffpage.tabletype.table-update', compact('table', 'all_categories', 'all_table_types'));
    }

    public function updateTable(Request $request, string $id)
    {
        $request->validate([
            'table_num' => 'required',
            'type_id' => 'required',
            'guests' => 'required',
            'charges' => 'required',
            'detail' => 'required',

            'images.*' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $table = $this->restaurantTable->findOrFail($id);

        $table->table_number = $request->table_num;
        $table->type_id = $request->type_id;
        $table->max_guests = $request->guests;
        $table->charges = $request->charges;
        $table->detail = $request->detail;

        $table->save();

        $table->categories()->sync($request->category ?? []);
    
        if ($request->filled('delete_images')) {
            $table->images()->whereIn('id', $request->delete_images)->delete();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedImage) {
                $table->images()->create([
                    'image' => 'data:image/' . $uploadedImage->extension() . ';base64,' 
                                . base64_encode(file_get_contents($uploadedImage))
                ]);
            }
        }

        return redirect()->back()->with('success', 'Table updated successfully.');
    }

    public function destroyTable($id) 
    {
        $table = $this->restaurantTable->findOrFail($id);
        
        $table->Delete();

        return redirect()->back();
    }

    public function updateStatus(Request $request, string $id) {
        $request->validate([
            'status' => 'required'
        ]);

        $table = $this->restaurantTable->findOrFail($id);

        $table->status_id = $request->status;

        $table->save();

        return redirect()->back();
    }

    public function viewTable($id) 
    {
        $table = $this->restaurantTable->with(['categories', 'type', 'status'])->findOrFail($id);
        
        return view('staffpage.tabletype.table-detail', compact('table'));
    }
}
