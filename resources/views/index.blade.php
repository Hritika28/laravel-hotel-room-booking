<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #444;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            background-color: #007BFF;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }   

        button[type="submit"] {
            background-color: #69b34f;
        }

        .rooms-arrangement {
            margin-top: 30px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: max-content;
        }

        .rooms-arrangement h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }

        .floors {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .floor {
            line-height: 4px;
            margin-top: 20px;
            margin-right: 5px;
        }

        .stairs {
            width: 100px;
            text-align: center;
            border-right: 1px solid #ccc;
            padding: 5px;
        }

        .rooms {
            display: flex;
            grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
            gap: 5px;
        }

        .room {
            width: 40px;
            height: 40px;
            background-color: #69b34f;
            color: #ffffff;
            text-align: center;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .random, .reset {
            margin-bottom: 16px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        {{-- Success / Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <br>
                <strong>Rooms Numbers   :</strong> {{ session('assigned_rooms') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <h1>Room Booking</h1>
        <div class="d-flex gap-2 align-items-end">
            <form method="POST" action="{{ route('book') }}" class="mb-0">
                @csrf
                <div class="form-group d-flex gap-2 align-items-center">
                    <label for="number_of_rooms" class="mb-0">Number of Rooms:</label>
                    <input type="number" id="number_of_rooms" name="rooms" min="1" value="1" max="5" required class="form-control" style="width: 80px;">
                    <button type="submit" class="btn btn-success">Book</button>
                </div>
            </form>

            <form method="POST" action="{{ route('random') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-warning random">Book Random Rooms</button>
            </form>

            <form method="POST" action="{{ route('reset') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-danger reset">Reset All Bookings</button>
            </form>
        </div>
    </div>

    <div class="rooms-arrangement">
        <h2>Room Arrangement</h2>
        <div class="mb-4 d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded" style="width: 25px; height: 25px; background-color: #28a745;"></div>
                <span>Available</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="rounded" style="width: 25px; height: 25px; background-color: #6c757d;"></div>
                <span>Booked</span>
            </div>
        </div>
        <div class="floors">
            @foreach($roomsByFloor as $floor => $rooms)
                <div class="mb-3" style="display: flex">
                    <div class="floor">Floor {{ $floor }}</div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($rooms as $room)
                            <div class="p-3 text-white fw-bold rounded" style="width: 70px; text-align: center; background-color: {{ $room->is_available ? '#28a745' : '#6c757d';}}">
                                {{$room->room_number}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>