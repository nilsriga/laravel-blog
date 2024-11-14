<x-app-layout>
    <div class="container bg-white mx-auto mt-5 p-3 rounded-lg shadow-sm my-3">
        <!-- Post Image -->
        @if ($post->image_url)
            <div class="w-full mb-5">
                <img src="{{ asset('storage/' . $post->image_url) }}" alt="Image for {{ $post->title }}"
                    class="w-full h-64 object-cover rounded-lg">
            </div>
        @endif


        <!-- Post Title and Body -->
        <h1 class="text-2xl font-semibold">{{ strip_tags($post->title, '<p><br><strong><em>') }}</h1>
        <p class="mt-3">{{ strip_tags($post->body, '<p><br><strong><em>') }}</p>

        <!-- Comments Section -->
        <h2 class="text-xl font-semibold mt-10">Comments</h2>
        @foreach ($post->comments as $comment)
            <x-comment-card :comment="$comment" />
        @endforeach

        <!-- Add Comment Form -->
        @auth
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-5">
                @csrf
                <textarea name="body" rows="3" class="w-full border-gray-300 rounded-md" required></textarea>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 mt-2 rounded">Add Comment</button>
            </form>
        @endauth
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops! Something went wrong.</strong>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</x-app-layout>
