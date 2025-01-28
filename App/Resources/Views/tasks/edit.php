<h1 class="text-2xl font-semibold text-slate-800 text-center mb-6">Edit a Task</h1>
<form action="/tasks/<?= $task->id ?>" method="post" class="max-w-md mx-auto space-y-6">
    <input type="hidden" name="_method" value="patch">
    <!-- Task Input -->
    <div class="space-y-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Task Description</label>
        <input type="text" id="description" name="description" placeholder="I will do..."
            value="<?= htmlspecialchars(old('description', $task->description)) ?>"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800 transition">
        <?php if ($errors = error('description')) { ?>
            <div class="mt-1 text-sm text-red-600">
                <?php foreach ($errors as $value) { ?>
                    <p><?= htmlspecialchars($value) ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <!-- complete Checkbox -->
    <div class="space-y-2">
        <label for="complete" class="block text-sm font-medium text-gray-700">Mark as complete</label>
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="complete" name="complete" <?= old('complete', $task->complete) ? 'checked' : '' ?>
                value="1"
                class="h-4 w-4 text-slate-800 border-gray-300 rounded focus:ring-2 focus:ring-slate-800 transition">
            <label for="complete" class="text-sm text-gray-600">Yes</label>
        </div>
        <?php if ($errors = error('complete')) { ?>
            <div class="mt-1 text-sm text-red-600">
                <?php foreach ($errors as $value) { ?>
                    <p><?= htmlspecialchars($value) ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full bg-slate-800 text-white py-3 rounded-lg hover:bg-slate-700 transition duration-200">
        Submit
    </button>
</form>