<h1 class="text-2xl font-semibold text-slate-800 text-center mb-6">Create a User</h1>
<form action="/users" method="post" class="max-w-md mx-auto space-y-6">
    <!-- Name Input -->
    <div class="space-y-2">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" id="name" name="name" placeholder="Human name..."
            value="<?= htmlspecialchars(get_val($attributes, 'name', '')) ?>"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
        <?php foreach (get_val($errors, 'name', []) as $key => $value) { ?>
            <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
                <p><?= htmlspecialchars($value) ?></p>
            </div>
        <?php } ?>
    </div>

    <!-- Password Input -->
    <div class="space-y-2">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">

        <?php foreach (get_val($errors, 'password', []) as $key => $value) { ?>
            <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
                <p><?= htmlspecialchars($value) ?></p>
            </div>
        <?php } ?>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700 transition duration-200">
        Submit
    </button>
</form>