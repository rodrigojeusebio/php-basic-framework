<?php
use Core\Config;
use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?  echo htmlspecialchars(Config::get('app_name', 'PHP basic framework'));  ?></title>
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
<?  include '/home/reusebio/php-basic-framework/writable/layouts/navigation.basic.php.compiled.php';  ?>
        <main class="flex-1 p-8 bg-slate-100">
            <div class="bg-white rounded-md shadow-md p-6">
                <div class="rounded-md p-4 my-4 border border-error">
<?  use Libs\BasicTemplater;  ?> <?  $__compiled_view = BasicTemplater::compile(BasicTemplater::get_view_path($__view)); include $__compiled_view  ?>
                </div>
            </div>
        </main>
    </div>
<?  if(Session::has('notification')):  ?>
    <?php
    $session = Session::get('notification');
    $color = match ($session['type'] ?? 'info') {
        'info' => 'slate',
        'warning' => 'amber',
        'error' => 'rose',
        default => 'gray'
    };
    ?>

    <div id="toast-notification"
        class="fixed bottom-4 right-4 border-<?  echo htmlspecialchars($color);  ?>-700 bg-<?  echo htmlspecialchars($color);  ?>-100 text-<?  echo htmlspecialchars($color);  ?>-900 border-4 rounded-lg shadow-lg p-4 transition-opacity duration-500 opacity-100 max-w-xs">
        <h3 class="font-bold text-<?  echo htmlspecialchars($color);  ?>-800"><?  echo htmlspecialchars(get_val($session, 'title', ''));  ?></h3>
        <p class="text-<?  echo htmlspecialchars($color);  ?>-700"><?  echo htmlspecialchars(get_val($session, 'message', ''));  ?></p>
    </div>


    <script>
        setTimeout(() => {
            let toast = document.getElementById('toast-notification');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500); // Remove after fade out
            }
        }, 5000);
    </script>
<?  endif;  ?>

</body>

</html>