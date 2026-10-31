<?php
// Regular expressions: matching, capturing and replacing, as routers and
// templates do.
require __DIR__ . '/_bench.php';
bench(function () {
    $n = 0;
    $out = '';
    for ($i = 0; $i < 300000; $i++) {
        $path = "/users/{$i}/posts/" . ($i * 3) . '?page=' . ($i % 9);
        if (preg_match('#^/users/(\d+)/posts/(\d+)(?:\?page=(\d+))?$#', $path, $m)) {
            $n += (int) $m[1] + (int) $m[3];
        }
        $out = preg_replace('/\{\{\s*(\w+)\s*\}\}/', '<$1>', "Hello {{ name }}, you have {{ count }} items");
    }
    return $n . $out;
});
