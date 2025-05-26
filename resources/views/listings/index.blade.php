<x-layout>
    @include('partials._hero') {{-- This is the hero section --}}
    @include('partials._search') {{-- This is the search section --}}
 
        @if (count($listings) < 1)
            <p>No job listings found.</p>
        @endif
        <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
            @foreach ($listings as $listing)
                {{-- @dd($listing) --}}
                <x-listing-card :listing="$listing" />
            @endforeach
        </div>
        <div class="mt-6 p-4">
            {{ $listings->links() }} {{-- This is the pagination --}}
        </div>
</x-layout>
