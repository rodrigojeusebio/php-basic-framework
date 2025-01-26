<?php
use Core\Config;
use Libs\Auth;

?>

<header class="bg-slate-800 text-white py-4 shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo and App Name -->
        <a href="/" class="flex items-center space-x-2">
            <h1 class="text-2xl font-bold"><?= Config::get('app_name', 'PHP Basic Framework') ?></h1>
        </a>

        <!-- Navigation Links -->
        <?php if (Auth::guest()) { ?>
            <nav class="flex space-x-6 text-lg">
                <a href="/login" class="hover:text-blue-400 transition-colors">Login</a>
                <a href="/register" class="hover:text-blue-400 transition-colors">Register</a>
            </nav>
        <?php } else { ?>
            <nav class="flex space-x-6 text-lg">
                <form action="/logout" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="hover:text-blue-400 transition-colors" type="submit">Logout</button>
                </form>
            </nav>
        <?php } ?>
    </div>
</header>