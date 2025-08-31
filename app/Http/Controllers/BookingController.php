<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Room;

class BookingController extends Controller
{

    public function index() {

        $roomsByFloor = Room::orderByDesc('floor')
                            ->orderBy('index_on_floor')
                            ->get()
                            ->groupBy('floor');

        return view('index', compact('roomsByFloor'));
    }

    public function book(Request $request) {

        $validated = $request->validate([
            'rooms' => 'required|integer|min:1|max:5',
        ]);

        $assigned_rooms = $this->assign_rooms($validated['rooms']);

        if (!$assigned_rooms) {
            return back()->with('error', 'Not enough available rooms.');
        }

        return back()->with('success', 'Rooms booked successfully!')
                        ->with('assigned_rooms', implode(', ', $assigned_rooms));
    }

    public function assign_rooms(int $count): ?array {

        $available_rooms = Room::where('is_available', true)
                                ->orderBy('floor')
                                ->orderBy('index_on_floor')
                                ->get();

        if ($available_rooms->count() < $count) {
            return null;
        }

        foreach ($available_rooms->groupBy('floor') as $floor_rooms) {
            if ($floor_rooms->count() >= $count) {
                $selected = $floor_rooms->take($count)->pluck('room_number')->toArray();
                $this->book_rooms($selected);
                return $selected;
            }
        }

        $selected = $available_rooms->take($count)->pluck('room_number')->toArray();
        $this->book_rooms($selected);

        return $selected;
    }

    protected function book_rooms(array $rooms): void {

        Room::whereIn('room_number', $rooms)->update(['is_available' => false]);

    }

    public function reset() {

        Room::query()->update(['is_available' => true]);
        return redirect()->route('rooms')->with('success', 'All rooms reset to available!');

    }

    public function random_book() {
    
        $totalRoomsToBook = 20;
        $rooms = Room::where('is_available', true)->get();

        $roomsShuffled = $rooms->shuffle();

        $roomsToBook = $roomsShuffled->take($totalRoomsToBook);

        foreach ($roomsToBook as $room) {
            $room->is_available = false;
            $room->save();
        }

        return redirect()->route('rooms')->with('success', 'Random booking done!');
    }
}
