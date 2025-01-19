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
        <!-- Header -->
        <header class="bg-slate-800 text-white py-4 px-6 flex items-center justify-between">
            <a class="flex items-center gap-2" href="https://www.github.com/rdrigoe/php-basic-framework"
                target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-6 w-6" aria-hidden="true">
                    <polyline points="16 18 22 12 16 6"></polyline>
                    <polyline points="8 6 2 12 8 18"></polyline>
                </svg>
                <span class="text-lg font-semibold">Basic PHP Framework</span>
            </a>
        </header>

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