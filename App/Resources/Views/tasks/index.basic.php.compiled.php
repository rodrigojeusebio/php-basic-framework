<?php
use Core\Request;

?>
<div class="space-y-6">
    <!-- Header Section -->
    <header>
        <h3 class="text-2xl font-bold tracking-tight text-gray-900">Tasks</h3>
        <p class="text-sm text-gray-600">View your daily tasks</p>
    </header>

    <!-- Filters and Create Task Section -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Filters -->
        <div class="max-w-md w-full">
            <form method="GET" action="/tasks">
                <div class="flex items-center gap-2">
                    <input type="text" name="description" placeholder="Search for a task"
                        value="<?php echo htmlspecialchars(Request::get('description', '')); ?>"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 transition">
                    <button type="submit"
                        class="bg-gray-800 text-white px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Create Task Button -->
        <a href="/tasks/create" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-500 transition">
            Create Task
        </a>
    </div>

    <!-- Tasks Table Section -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 font-medium text-gray-600">Description</th>
                    <th class="px-6 py-3 font-medium text-gray-600">Complete</th>
                    <th class="px-6 py-3 font-medium text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($tasks as $task) {  ?>
                <tr class="border-b last:border-0 hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($task->description); ?>
                    </td>
                    <td class="px-6 py-4">
                        <span class="<?= $task->complete ? 'text-green-600' : 'text-red-600' ?>">
                            <?php echo htmlspecialchars($task->complete ? 'Yes' : 'No'); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <!-- Show Task -->
                        <a href="/tasks/<?php echo htmlspecialchars($task->id); ?>" class="text-blue-600 hover:underline">
                            Show
                        </a>
                        <!-- Edit Task -->
                        <a href="/tasks/<?php echo htmlspecialchars($task->id); ?>/edit" class="text-yellow-600 hover:underline">
                            Edit
                        </a>
                    </td>
                </tr>
<?php }  ?>
            </tbody>
        </table>
    </div>
</div>