<x-app-layout>
    <div class="container mx-auto">
        @can('create', App\Models\Post::class)
            <a href="{{ route('posts.create') }}" class="text-blue-500">Create New Post</a>
        @endcan
        @foreach ($posts as $post)
            <div class="bg-white p-4 rounded-lg shadow-md my-4">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                <p class="text-sm text-gray-500">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
                <p class="text-sm text-gray-500">Categories:
                    @foreach ($post->categories as $category)
                        <a href="{{ route('categories.posts', $category) }}" class="bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700">{{ $category->name }}</a>
                    @endforeach
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
        @endforeach
    </div>
</x-app-layout>
