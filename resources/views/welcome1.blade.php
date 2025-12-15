<x-app-layout>
<!-- قسم البحث -->
<div class="hero-section">
    <form action="{{ url()->current() }}" method="GET">
        <div class="search-box">
            <input type="text" name="city" placeholder="البحث بالمدينة" value="{{ old('city', $city ?? request('city')) }}">
            <input type="date" name="check_in" value="{{ old('check_in', $check_in ?? request('check_in')) }}">
            <input type="date" name="check_out" value="{{ old('check_out', $check_out ?? request('check_out')) }}">
            <button type="submit">بحث</button>
        </div>
    </form>
</div>

<!-- الفنادق المميزة -->
<!--  -->





  <table class="min-w-full divide-y divide-gray-200 border mt-4">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</span>
                            </th>
                          
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                        @if($hotels->isEmpty())
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900" colspan="2">
                                    لا توجد نتائج لعرضها.
                                </td>
                            </tr>
                        @else
                            @foreach($hotels as $hotel )
                            <tr class="bg-white">
                                <td><a href="{{ route('hotels.show', $hotel) }}" class="text-blue-600 underline">{{ $hotel->name }}</a></td>
                                


                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <a href="{{ route('hotels.edit', $hotel) }}" class="underline">Edit</a>
                                    
                                        |
                                        <form action="{{ route('hotels.destroy', $hotel) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure?');"
                                              class="inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="text-red-500 underline">Delete</button>
                                        </form>
                                    
                                </td>
                                
                               
                            </tr>
                                


                            @endforeach
                        @endif
                        </tbody>
                    </table>
<div class="mt-4">
                        {{ $hotels->links() }}
                    </div>



</x-app-layout>

