<?php
use Core\Config;

?>
<header class="bg-slate-800 text-white py-3 px-6 shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        <a href="/">
            <h1 class="text-2xl font-bold"><?= Config::get('app_name', 'PHP basic framework') ?></h1>
        </a>
    </div>
</header>