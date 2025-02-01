<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Inter', sans-serif;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body>
    <div class="flex flex-col min-h-screen">
        @component('layouts/navigation')

        <!-- Main Content -->
        <main class="flex-1">
            <section class="bg-slate-800 py-16 px-6 text-center text-white">
                <div class="container mx-auto max-w-3xl space-y-6">
                    <h1 class="text-4xl font-bold">Basic PHP Framework</h1>
                    <p class="text-lg">
                        A lightweight and flexible PHP framework that helps you build modern web applications with ease.
                    </p>
                    <a class="text-bold inline-flex items-center justify-center rounded-md bg-white px-6 py-3 text-bold text-slate-800 font-medium transition-colors hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2"
                        href="https://www.github.com/rdrigoe/php-basic-framework" target="_blank">
                        GitHub
                    </a>
                </div>
            </section>
        </main>
        <!-- Footer -->
        <footer class="bg-slate-800 text-white py-4 px-6 flex items-center justify-between">
            <p class="text-sm">© 2025 Basic PHP Framework. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>