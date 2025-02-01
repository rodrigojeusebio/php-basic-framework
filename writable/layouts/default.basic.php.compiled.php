<?php
use Core\Config;
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
</body>

</html>