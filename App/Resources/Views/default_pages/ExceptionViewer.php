<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exception Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --background: 240 10% 98%;
            --foreground: 240 10% 10%;
            --card: 255 255 255;
            --card-foreground: 240 10% 95%;
            --primary: 0 123 255;
            --primary-foreground: 255 255 255;
            --error: 220 38 38;
            /* Red for error messages */
            --error-foreground: 255 255 255;
            --border: 240 5.9% 90%;
            --radius: 0.5rem;
        }

        img[src="/placeholder.svg"],
        img[src="/placeholder-user.jpg"] {
            filter: sepia(0.3) hue-rotate(-60deg) saturate(0.5) opacity(0.8);
        }

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

<body class="bg-slate-800">
    <div class="flex flex-col min-h-screen">
        <header class="bg-slate-800 text-white py-3 px-6 shadow-md">
            <div class="container mx-auto flex items-center justify-between">
                <h1 class="text-2xl font-bold">Exception Viewer</h1>
            </div>
        </header>
        <main class="flex-1 p-8 bg-slate-100">
            <div class="bg-white rounded-md shadow-md p-6">
                <div class="bg-card-foreground rounded-md p-4 my-4 border border-error">
                    <h2 class="text-xl font-semibold text-error">Exception Message:</h2>
                    <p class="font-medium text-error-foreground"><?= htmlspecialchars($message) ?></p>
                </div>
                <?php if ($extra) { ?>
                    <div class="bg-card-foreground rounded-md p-4 my-4 font-mono text-sm overflow-auto border border-error">
                        <h3 class="text-lg font-semibold text-primary">Additional Info:</h3>
                        <pre class="whitespace-pre-wrap"><?= json_encode($extra, JSON_PRETTY_PRINT) ?></pre>
                    </div>
                <?php } ?>
                <div class="bg-card-foreground rounded-md p-4 my-4 font-mono text-sm overflow-auto border border-error">
                    <h3 class="text-lg font-semibold text-primary">Stack Trace:</h3>
                    <pre class="whitespace-pre-wrap"><?= htmlspecialchars($stack_trace) ?></pre>
                </div>
            </div>
        </main>
    </div>
</body>

</html>