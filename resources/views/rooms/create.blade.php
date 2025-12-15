<x-app-layout>


<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl mb-4">Add Room to {{ $hotel->name }}</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hotels.rooms.store', $hotel) }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Room number</label>
            <input type="text" name="room_number" value="{{ old('room_number') }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Max guests</label>
            <input type="number" name="max_guests" value="{{ old('max_guests', 2) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Size (m²)</label>
            <input type="number" name="size" value="{{ old('size') }}" class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium">slug </label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity', 1) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border p-2">{{ old('description') }}</textarea>
        </div>
        

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Add Room</button>
        </div>
    </form>
</div>

</x-app-layout>