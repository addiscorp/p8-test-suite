<?php
// JSON: encode and decode a nested document, as APIs do.
require __DIR__ . '/_bench.php';
bench(function () {
    $doc = [];
    for ($i = 0; $i < 2000; $i++) {
        $doc[] = ['id' => $i, 'name' => "user $i", 'tags' => ['a', 'b', (string) $i], 'score' => $i / 3, 'active' => $i % 2 === 0, 'meta' => null];
    }
    $n = 0;
    for ($k = 0; $k < 60; $k++) {
        $back = json_decode(json_encode($doc), true);
        $n += count($back) + $back[$k]['id'];
    }
    return $n . ':' . md5(json_encode($back));
});
