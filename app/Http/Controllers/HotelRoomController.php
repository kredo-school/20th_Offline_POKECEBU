<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HotelRoom;
use App\Models\HotelRoomType;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;

class HotelRoomController extends Controller
{
    private $type;
    private $category;
    private $status;
    private $hotelRoomType;
    private $hotelRoom;
    protected string $hotel;

    public function __construct(Type $type, Category $category, Status $status, HotelRoomType $hotelRoomType, HotelRoom $hotelRoom)
    {
        $this->type = $type;
        $this->category = $category;
        $this->status = $status;
        $this->hotelRoomType = $hotelRoomType;
        $this->hotelRoom = $hotelRoom;
        $this->hotel  = config('app.target_type_hotel');
    }
    
    public function index($hotel_id)
    {
        $all_types = $this->type->where('target_type', $this->hotel)->get();
        $all_categories = $this->category->where('target_type', $this->hotel)->get();
        $all_statuses = $this->status->whereIn('target_type', [$this->hotel, 'all'])->get();

        $all_room_types = $this->hotelRoomType
            ->where('hotel_id', $hotel_id)
            ->withCount([
                'rooms as reserved_cnt' => fn($query) => $query->where('status_id', 3),
                'rooms as available_cnt' => fn($query) => $query->where('status_id', 1),
                'rooms as tmpUnavailable_cnt' => fn($query) => $query->where('status_id', 2),
                'rooms as unavailable_cnt' => fn($query) => $query->where('status_id', 4),
            ])
            ->with('type')
            ->get();
        
        $all_rooms = $this->hotelRoom->where('hotel_id', $hotel_id)->with(['type', 'status', 'categories'])->get();

        return view('staffpage.roomtype.roomtype',
            compact('all_types', 'all_categories', 'all_statuses', 'all_room_types', 'all_rooms'));
    }

    public function storeRoomType(Request $request, int $hotel_id)
    {
        $request->validate(
            [
                'room_type' => 'required',
                'total_rooms' => 'required',
            ],[
                'room_type.required' => '【Room Overview】The room type field is required.',
                'total_rooms.required' => '【Room Overview】The total rooms field is required.',
            ]
        );

        $exists = $this->hotelRoomType->where('hotel_id', $hotel_id)
                                        ->where('type_id', $request->room_type)->exists();

        if ($exists) {
            return redirect()->back()->withErrors([
                'room_type' => '【Room Overview】The room type already exists.'
                ])->withInput();
        }

        $this->hotelRoomType->hotel_id = $hotel_id;
        $this->hotelRoomType->type_id = $request->room_type;
        $this->hotelRoomType->total_rooms = $request->total_rooms;

        $this->hotelRoomType->save();

        return redirect()->back();
    }

    public function updateRoomType(Request $request, string $id)
    {
        $request->validate([
            'total_rooms' => 'required'
        ]);

        $room_type = $this->hotelRoomType->findOrFail($id);
        $all_rooms = $this->hotelRoom->where('hotel_id', $room_type->hotel_id)
                                        ->where('type_id', $room_type->type_id)->get();

        $newTotal = (int) $request->total_rooms;
        $oldTotal = (int) $room_type->total_rooms;

        if ($newTotal < $oldTotal) {
            $exists = $all_rooms->whereIn('status_id', [2, 3])->isNotEmpty();;

            if ($exists) {
                return redirect()->back()->withErrors([
                    'total_rooms' => 'There are rooms with status that cannot be changed.'
                ])->withInput();
            }
        }

        $room_type->total_rooms = $request->total_rooms;

        $room_type->save();

        return redirect()->back();
    }

    public function destroyRoomType($id) {
        $room_type = $this->hotelRoomType->findOrFail($id);

        $room_type->Delete();

        return redirect()->back();
    }

    public function storeRoom(Request $request, int $hotel_id)
    {
        $request->validate([
            'room_num' => 'required',
            'type_id' => 'required',
            'floor_num' => 'required',
            'guests' => 'required',
            'charges' => 'required' 
        ]);

        $this->hotelRoom->hotel_id = $hotel_id;
        $this->hotelRoom->room_number = $request->room_num;
        $this->hotelRoom->type_id = $request->type_id;
        $this->hotelRoom->floor_number = $request->floor_num;
        $this->hotelRoom->max_guests = $request->guests;
        $this->hotelRoom->charges = $request->charges;
        $this->hotelRoom->status_id = 1; // priparing

        $this->hotelRoom->save();

        foreach ($request->category as $category_id) {
            $category_room[] = ['category_id' => $category_id];
        }

        $this->hotelRoom->categories()->attach($category_room);

        return redirect()->back();
    }

    public function updateRoom(Request $request, string $id)
    {
        $request->validate([
            'room_num' => 'required',
            'type_id' => 'required',
            'floor_num' => 'required',
            'guests' => 'required',
            'charges' => 'required' 
        ]);

        $room = $this->hotelRoom->findOrFail($id);

        $room->room_number = $request->room_num;
        $room->type_id = $request->type_id;
        $room->floor_number = $request->floor_num;
        $room->max_guests = $request->guests;
        $room->charges = $request->charges;

        $room->save();

        return redirect()->back();
    }

    public function destroyRoom($id) {
        $room = $this->hotelRoom->findOrFail($id);
        
        $room->Delete();

        return redirect()->back();
    }

    public function updateStatus(Request $request, string $id) {
        $request->validate([
            'status' => 'required'
        ]);

        $room = $this->hotelRoom->findOrFail($id);

        $room->status_id = $request->status;

        $room->save();

        return redirect()->back();
    }
}
