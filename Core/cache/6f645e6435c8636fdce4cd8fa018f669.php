<?php use Libs\Auth;use Core\Request; ?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP basic framework</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-800">
    <div class="flex flex-col min-h-screen">
        
<header class="bg-slate-800 text-white py-4 shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo and App Name -->
        <div class="flex items-center space-x-4">
            <a href="/" class="flex items-center space-x-2">
                <h1 class="text-2xl font-bold">PHP Basic Framework</h1>
            </a>
            <?php if (Auth::check()): ?>
            <nav class="flex space-x-6 text-lg">
                <a href="/tasks" class="relative group text-xl font-bold hover:text-blue-400 transition-colors">
                    <span
                        class="underline-offset-4 decoration-blue-400 decoration-2 group-hover:underline bg-slate-700 py-2 px-4 rounded-xl">Tasks</span>
                </a>
            </nav>
            <?php endif; ?>
        </div>
        <!-- Navigation Links -->
        <?php if (Auth::guest()): ?>
        <nav class="flex space-x-6 text-lg">
            <a href="/login" class="hover:text-blue-400 transition-colors">Login</a>
            <a href="/register" class="hover:text-blue-400 transition-colors">Register</a>
        </nav>
        <?php else: ?>
        <nav class="flex space-x-6 text-lg">
            <form action="/logout" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <button class="hover:text-blue-400 transition-colors" type="submit">Logout</button>
            </form>
        </nav>
        <?php endif; ?>
    </div>
</header>        <main class="flex-1 p-8 bg-slate-100">
            <div class="bg-white rounded-md shadow-md p-6">
                <div class="rounded-md p-4 my-4 border border-error">
                    <h1 class="text-2xl font-semibold text-slate-800 text-center mb-6">Edit a Task</h1>
<form action="/tasks/<?= htmlspecialchars($task->id) ?>" method="post" class="max-w-md mx-auto space-y-6">
    <input type="hidden" name="_method" value="'patch'">
    <!-- Task Input -->
    <div class="space-y-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Task Description</label>
        <input type="text" id="description" name="description" placeholder="I will do..."
            value="@old('description', $task->description)"
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-slate-800 transition">
        <?php if (errors('description')): ?>
        <div class="mt-1 text-sm text-red-600">
            <?php foreach (errors("description") as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- complete Checkbox -->
    <div class="space-y-2">
        <label for="complete" class="block text-sm font-medium text-gray-700">Mark as complete</label>
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="complete" name="complete"                 value="1"
                class="h-4 w-4 text-slate-800 border-gray-300 rounded focus:ring-2 focus:ring-slate-800 transition">
            <label for="complete" class="text-sm text-gray-600">Yes</label>
        </div>
        <?php if (errors('complete')): ?>
        <div class="mt-1 text-sm text-red-600">
            <?php foreach (errors("complete") as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full bg-slate-800 text-white py-3 rounded-lg hover:bg-slate-700 transition duration-200">
        Submit
    </button>
</form>                </div>
            </div>
        </main>
    </div>
</body>

</html>