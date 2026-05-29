<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$users = DB::table('users')->get(['id', 'name', 'avatar']);
foreach ($users as $u) {
    echo "id={$u->id} name={$u->name} avatar={$u->avatar}\n";
}

$animes = DB::table('ghibli_animes')->get(['id', 'title', 'poster']);
foreach ($animes as $a) {
    echo "anime id={$a->id} title={$a->title} poster={$a->poster}\n";
}
