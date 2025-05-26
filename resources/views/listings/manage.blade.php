<x-layout>
    <div class="mx-4">
        <div class=" border border-gray-200 p-10 rounded">
            <header>
                <h1 class="text-3xl text-center font-bold my-6 uppercase">
                    Manage Gigs
                </h1>
            </header>

            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @if (count($listings) < 1)
                        <p>No job listings found.</p>
                    @endif

                    @foreach ($listings as $listing)
                        <tr class="border-gray-300">
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <div class="flex">
                                    <img class="hidden w-48 mr-6 md:block"
                                        src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png') }}"
                                        alt="" />
                                    <div>
                                        <h3 class="text-2xl">
                                            <a href="/index/{{ $listing->id }}">{{ $listing->title }}</a>
                                        </h3>
                                        <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>
                                        <x-listing-tags :tagsCsv="$listing->tags" />
                                        <div class="text-lg mt-4">
                                            <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <a href="/edit/{{ $listing->id }}t" class="text-blue-400 px-6 py-2 rounded-xl"><i
                                        class="fa-solid fa-pen-to-square"></i>
                                    Edit</a>
                            </td>
                            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                <form action="/delete/{{ $listing->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    <div class="mt-6 p-4">
                        {{ $listings->links() }} {{-- This is the pagination --}}
                    </div>

                </tbody>
            </table>
        </div>
    </div>
</x-layout>
