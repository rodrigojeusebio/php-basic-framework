<?php
use Core\Config;
use Libs\Auth;

?>

<header class="bg-slate-800 text-white py-4 shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo and App Name -->
        <div class="flex items-center space-x-4">
            <a href="/" class="flex items-center space-x-2">
                <h1 class="text-2xl font-bold"><?= Config::get('app_name', 'PHP Basic Framework') ?></h1>
            </a>
            @auth
            <nav class="flex space-x-6 text-lg">
                <a href="/tasks" class="relative group text-xl font-bold hover:text-blue-400 transition-colors">
                    <span
                        class="underline-offset-4 decoration-blue-400 decoration-2 group-hover:underline bg-slate-700 py-2 px-4 rounded-xl">Tasks</span>
                </a>
            </nav>
            @endauth
        </div>
        <!-- Navigation Links -->
        @guest
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
        @endguest
    </div>
</header>