<h1 class="text-2xl font-semibold text-slate-800 text-center mb-6">Register</h1>
<form action="/register" method="post" class="max-w-md mx-auto space-y-6">
    <!-- Name Input -->
    <div class="space-y-2">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" id="name" name="name" placeholder="Your full name"
            value="<?= htmlspecialchars(old('name', '')) ?>"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
        @errors('name')
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
            <p>@error</p>
        </div>
        @enderrors
    </div>

    <!-- Email Input -->
    <div class="space-y-2">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" value="@old('email')"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
        @errors('email')
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
            <p>@error</p>
        </div>
        @enderrors
    </div>

    <!-- Password Input -->
    <div class="space-y-2">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
        @errors('password')
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
            <p>@error</p>
        </div>
        @enderrors
    </div>

    <!-- Confirm Password Input -->
    <div class="space-y-2">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
            placeholder="Repeat your password" required
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
        @errors('password_confirmation')
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
            <p>@error</p>
        </div>
        @enderrors
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700 transition duration-200">
        Register
    </button>
</form>