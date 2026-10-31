<?php
// Arrays with string keys: insert, look up, update, iterate.
require __DIR__ . '/_bench.php';
bench(function () {
    $a = [];
    for ($i = 0; $i < 1000000; $i++) {
        $a['key' . ($i % 5000)] = ($a['key' . ($i % 5000)] ?? 0) + $i;
    }
    $sum = 0;
    foreach ($a as $k => $v) {
        $sum += $v + strlen($k);
    }
    return $sum + count(array_filter($a, fn($v) => $v % 2 === 0));
});
