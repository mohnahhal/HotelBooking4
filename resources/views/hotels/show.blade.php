
<div class="max-w-3xl mx-auto p-6">
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-4">{{ $hotel->name }}</h1>

    <p class="mb-2"><strong>City:</strong> {{ $hotel->city }}</p>
    <p class="mb-2"><strong>Country:</strong> {{ $hotel->country }}</p>
    <p class="mb-2"><strong>Address:</strong> {{ $hotel->address }}</p>
    <p class="mb-2"><strong>Phone:</strong> {{ $hotel->phone }}</p>
    <p class="mb-2"><strong>Email:</strong> {{ $hotel->email }}</p>
    <p class="mb-2"><strong>Rating:</strong> {{ $hotel->star_rating }}</p>
    <p class="mb-4"><strong>Description:</strong><br>{{ $hotel->description }}</p>

    @can('update', $hotel)
        <a href="{{ route('hotels.edit', $hotel) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded">Edit</a>
    @else
        @if(auth()->check() && auth()->id() === $hotel->user_id)
            <a href="{{ route('hotels.edit', $hotel) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded">Edit</a>
        @endif
    @endcan

    <a href="{{ route('hotels') }}" class="inline-block ml-2 px-4 py-2 border rounded">Back to list</a>
</div>

<div class="max-w-3xl mx-auto p-6 mt-6">
    <h2 class="text-2xl font-semibold mb-3">Rooms</h2>
    @if($hotel->rooms->isEmpty())
        <p>No rooms yet.</p>
    @else
        <ul class="list-disc pl-6 mb-4">
            @foreach($hotel->rooms as $room)
                <li class="mb-2">
                    <strong>{{ $room->name }}</strong> — Guests: {{ $room->max_guests ?? 'N/A' }} — Quantity: {{ $room->quantity }}
                </li>
                @can('update', $hotel)
        <a href="{{ route('hotels.edit', $hotel) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded">Edit</a>
    @else
        @if(auth()->check() && auth()->id() === $hotel->user_id)
            <a href="{{ route('rooms.edit', $room) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded">Edit</a>
        @endif
    @endcan
            @endforeach
        </ul>
    @endif

    @if(auth()->check() && auth()->id() === $hotel->user_id)
        <a href="{{ route('hotels.rooms.create', $hotel) }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded">Add Room</a>
    @endif
</div>

