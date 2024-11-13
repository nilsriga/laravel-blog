<div class="flex items-center justify-between mb-4">

    <div class="space-y-20">
        <form action="{{ route('search') }}" method="GET" class="flex">
            <input type="text" name="query" placeholder="Search Posts..." class="px-3 py-2 border rounded" required>
            <button type="submit" class="px-3 py-2 bg-gray-500 text-white rounded ml-2">Search</button>
        </form>
    </div>

    @can('create', App\Models\Post::class)
        <a href="{{ route('posts.create') }}" class="text-blue-500">Create New Post</a>
    @endcan
</div>
