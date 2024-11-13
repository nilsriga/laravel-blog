<x-app-layout>
    <div class="container mx-auto">

        <x-post-navigation />

        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
</x-app-layout>
