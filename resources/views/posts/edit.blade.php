<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Edit Post</h1>
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                    class="w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="body" class="block text-gray-700">Body:</label>
                <textarea name="body" id="body" class="w-full border-gray-300 rounded-md">{{ old('body', $post->body) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="categories" class="block text-gray-700">Categories:</label>
                <select name="categories[]" id="categories" multiple class="w-full border-gray-300 rounded-md">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($post->categories->contains($category->id)) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Update Post Image (Optional):</label>
                <input type="file" name="image" id="image" class="w-full border-gray-300 rounded-md">
                @if ($post->image_url)
                    <p>Current Image: <img src="{{ asset('storage/' . $post->image_url) }}" alt="Current Post Image"
                            class="w-32 mt-2 rounded-md"></p>
                @endif
            </div>
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md">Update</button>
        </form>
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
