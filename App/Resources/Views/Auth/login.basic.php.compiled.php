<h1 class="text-2xl font-semibold text-slate-800 text-center mb-6">Login</h1>
<form action="/login" method="post" class="max-w-md mx-auto space-y-6">
    <!-- Email Input -->
    <div class="space-y-2">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars(old('email') ?? ''); ?>"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
<?php if (errors('email')) {  ?>
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
<?php foreach (errors('email') as $error) {  ?>
            <p><?php echo htmlspecialchars($error); ?></p>
<?php }  ?>
        </div>
<?php }  ?>
    </div>

    <!-- Password Input -->
    <div class="space-y-2">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
<?php if (errors('password')) {  ?>
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
<?php foreach (errors('password') as $error) {  ?>
            <p><?php echo htmlspecialchars($error); ?></p>
<?php }  ?>
        </div>
<?php }  ?>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700 transition duration-200">
        Login
    </button>
</form>