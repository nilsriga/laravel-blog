<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Edit Post</h1>
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title:</label>
                <input type="text" name="title" id="title" value="{{ $post->title }}" class="w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="body" class="block text-gray-700">Body:</label>
                <textarea name="body" id="body" class="w-full border-gray-300 rounded-md">{{ $post->body }}</textarea>
            </div>
            <div class="mb-4">
                <label for="categories" class="block text-gray-700">Categories:</label>
                <select name="categories[]" id="categories" multiple class="w-full border-gray-300 rounded-md">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if($post->categories->contains($category->id)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md">Update</button>
        </form>
    </div>
</x-app-layout>
