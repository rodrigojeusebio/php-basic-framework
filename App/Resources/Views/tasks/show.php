<div class="p-6 bg-white shadow rounded-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">
        Task: <?= htmlspecialchars($task->description, ENT_QUOTES, 'UTF-8') ?>
    </h1>
    <p class="text-lg text-gray-600">
        Status:
        <span class="<?= $task->complete ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' ?>">
            <?= $task->complete ? 'complete' : 'Not complete' ?>
        </span>
    </p>

    <a href="/tasks">
        <button class="w-20 bg-slate-800 text-white py-3 rounded-lg hover:bg-slate-700 transition duration-200">
            Back
        </button></a>
</div>