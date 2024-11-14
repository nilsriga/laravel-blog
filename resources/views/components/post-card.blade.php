@props(['post'])

<a href="{{ route('posts.show', $post) }}">
    <div class="block transform transition-transform duration-200 hover:scale-[101%]">
        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg my-4">
            <h2 class="text-xl font-semibold">{{ strip_tags($post->title, '<p><br><strong><em>') }}</h2>
            <p>{{ strip_tags($post->body, '<p><br><strong><em>') }}</p>

            <p class="text-sm text-gray-500">
                By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
            </p>

            {{-- Categories section, displayed if there are categories --}}
            @if ($post->categories->isNotEmpty())
                <p class="text-sm text-gray-500">Categories:
                    @foreach ($post->categories as $category)
                        <a href="{{ route('categories.posts', $category) }}"
                            class="bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </p>
            @endif

            <!-- Display the comments count -->
            <p class="text-sm text-gray-500">
                {{ $post->comments_count }} {{ Str::plural('comment', $post->comments_count) }}
            </p>

            {{-- Action buttons (Edit and Delete) for authorized users --}}
            <div class="mt-2">
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 mr-2">Edit</a>
                @endcan

                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</a>
