<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($f = 1; $f <= 9; $f++) {
            for ($i = 1; $i <= 10; $i++) {
                Room::create([
                    'floor'         => $f,
                    'room_number'   => $f * 100 + $i,
                    'index_on_floor'=> $i,
                    'is_available'  => true,
                ]);
            }
        }
        for ($i = 1; $i <= 7; $i++) {
            Room::create([
                'floor'         => 10,
                'room_number'   => 1000 + $i,
                'index_on_floor'=> $i,
                'is_available'  => true,
            ]);
        }
    }
}
