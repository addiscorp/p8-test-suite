<?php
// Strings: interpolation, concatenation and the common string functions.
require __DIR__ . '/_bench.php';
bench(function () {
    $out = '';
    for ($i = 0; $i < 400000; $i++) {
        $s = "item-{$i}: " . str_pad((string) ($i * 7), 8, '0', STR_PAD_LEFT);
        $out .= strtoupper(substr($s, 0, 6)) . str_replace('-', '_', $s) . "\n";
    }
    return strlen($out) . ':' . md5($out);
});
