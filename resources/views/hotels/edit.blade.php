
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl mb-4">Edit Hotel</h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hotels.update', $hotel) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $hotel->name) }}" class="w-full border p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">City</label>
            <input type="text" name="city" value="{{ old('city', $hotel->city) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Country</label>
            <input type="text" name="country" value="{{ old('country', $hotel->country) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Address</label>
            <input type="text" name="address" value="{{ old('address', $hotel->address) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $hotel->phone) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $hotel->email) }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Star Rating</label>
            <input type="number" name="star_rating" value="{{ old('star_rating', $hotel->star_rating) }}" min="0" max="5" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $hotel->slug) }}" class="w-full border p-2" required>
        </div>
 
        <div class="mb-4">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border p-2">{{ old('description', $hotel->description) }}</textarea>
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
        </div>
    </form>
</div>


