@props(['post'])

<a href="{{ route('posts.show', $post) }}">
    <div class="bg-white p-4 rounded-lg shadow-md my-4 hover:bg-gray-100 transition-all duration-200 flex flex-col md:flex-row">
        <!-- Left side content -->
        <div class="flex-1">
            <h2 class="text-xl font-semibold">{{ strip_tags($post->title, '<p><br><strong><em>') }}</h2>
            <p>{{ strip_tags($post->body, '<p><br><strong><em>') }}</p>
            <p class="text-sm text-gray-500">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
            <p class="text-sm text-gray-500">Categories:
                @foreach ($post->categories as $category)
                    <a href="{{ route('categories.posts', $category) }}" class="bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700">
                        {{ $category->name }}
                    </a>
                @endforeach
            </p>
            <!-- Display the comments count -->
            <p class="text-sm text-gray-500">
                {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
            </p>

            <span>
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-500">Edit</a>
                @endcan
                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                @endcan
            </span>
        </div>

        <!-- Right side image (if available) -->
        @if ($post->image_url) <!-- Check if there is an image -->
            <div class="w-full md:w-48 mt-4 md:mt-0 ml-0 md:ml-4">
                <img src="/storage/{{ $post->image_url }}" alt="Image for {{ $post->title }}" class="w-full h-auto rounded-lg object-cover">
            </div>
        @endif
    </div>
</a>
