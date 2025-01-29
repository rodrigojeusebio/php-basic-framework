<div class="space-y-2">
    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email"
        value="<?= htmlspecialchars(old('email', '')) ?>" value="@old('email') ?>"
        class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800">
    <?php foreach (error('email') as $key => $value) { ?>
        <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
            {{$value}}
        </div>
    <?php } ?>
    @errors('email')
    <div class="mt-1 flex items-start space-x-2 bg-red-100 border border-red-500 text-red-800 p-3 rounded">
        <p>@error</p>
    </div>
    @enderrors
</div>

@auth
    <nav class="flex space-x-6 text-lg">
        <a href="/login" class="hover:text-blue-400 transition-colors">Login</a>
        <a href="/register" class="hover:text-blue-400 transition-colors">Register</a>
    </nav>
@else
    <nav class="flex space-x-6 text-lg">
        <form action="/logout" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button class="hover:text-blue-400 transition-colors" type="submit">Logout</button>
        </form>
    </nav>
@endauth