<?php
// Sorting with a user callback (usort with a closure), as collections do.
require __DIR__ . '/_bench.php';
bench(function () {
    $rows = [];
    mt_srand(42);
    for ($i = 0; $i < 60000; $i++) {
        $rows[] = ['id' => $i, 'score' => mt_rand(0, 1000), 'name' => 'n' . mt_rand(0, 99)];
    }
    usort($rows, fn($a, $b) => [$b['score'], $a['name'], $a['id']] <=> [$a['score'], $b['name'], $b['id']]);
    return implode(',', array_column(array_slice($rows, 0, 50), 'id'));
});
