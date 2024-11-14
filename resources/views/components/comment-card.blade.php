@props(['comment'])

<div class="bg-white p-3 rounded-lg shadow-lg my-3">
    <div x-data="{ editMode: false }">
        <!-- Display Comment Body -->
        <div x-show="!editMode">
            <p>{{ $comment->body }}</p>
            <p class="text-sm text-gray-500">By {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y') }}</p>
            
            <!-- Show Edit/Delete buttons only if the user is authorized -->
            @can('update', $comment)
                <button @click="editMode = true" class="text-blue-500">Edit</button>
            @endcan
            @can('delete', $comment)
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            @endcan
        </div>

        <!-- Editable Comment Form -->
        <form x-show="editMode" method="POST" action="{{ route('comments.update', $comment) }}">
            @csrf
            @method('PUT')
            <textarea name="body" rows="3" class="w-full p-2 border rounded">{{ $comment->body }}</textarea>
            <div class="flex items-center space-x-2">
                <button type="submit" class="text-green-500">Save</button>
                <button type="button" @click="editMode = false" class="text-gray-500">Cancel</button>
            </div>
        </form>
    </div>
</div>