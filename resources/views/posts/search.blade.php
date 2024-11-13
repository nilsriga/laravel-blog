<x-app-layout>

    <x-post-navigation />

    <h1>Search Results for "{{ $query }}"</h1>

    @if ($posts->isEmpty())
        <p>No results found.</p>
    @else
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach

        {{ $posts->links() }}
    @endif
</x-app-layout>
