<div class="p-6 bg-white shadow rounded-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">
        Task: {{$task->description}}
    </h1>
    <p class="text-lg text-gray-600">
        Status:
        <span class="<?= $task->complete ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' ?>">
            {{ $task->complete ? 'Complete' : 'Not complete' }}
        </span>
    </p>

    <div class="flex space-x-4 mt-4">
        <!-- Back Button -->
        <a href="/tasks">
            <button class="w-20 bg-slate-800 text-white py-3 rounded-lg hover:bg-slate-700 transition duration-200">
                Back
            </button>
        </a>

        <!-- Edit Button -->
        <a href="/tasks/{{$task->id}}/edit">
            <button class="w-20 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-500 transition duration-200">
                Edit
            </button>
        </a>

        <!-- Delete Button -->
        <form action="/tasks/{{$task->id}}" method="POST"
            onsubmit="return confirm('Are you sure you want to delete this task?');">
            @method('delete')
            <button type="submit"
                class="w-20 bg-red-600 text-white py-3 rounded-lg hover:bg-red-500 transition duration-200">
                Delete
            </button>
        </form>
    </div>
</div>