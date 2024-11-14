<x-app-layout>
    <div class="container bg-white mx-auto mt-5 p-3 rounded-lg shadow-sm my-3">

        <h1 class="text-2xl font-semibold">{{ strip_tags($post->title, '<p><br><strong><em>') }}</h1>
        <p class="mt-3">{{ strip_tags($post->body, '<p><br><strong><em>') }}</p>

        <h2 class="text-xl font-semibold mt-10">Comments</h2>

        @foreach ($post->comments as $comment)
            <x-comment-card :comment="$comment" />
        @endforeach

        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-5">
                @csrf
                <textarea name="body" rows="3" class="w-full border-gray-300 rounded-md" required></textarea>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 mt-2 rounded">Add Comment</button>
            </form>
        @endauth
    </div>
</x-app-layout>
