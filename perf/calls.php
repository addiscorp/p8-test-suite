<?php
// Function calls: recursion, as fibo in Zend/bench.php.
require __DIR__ . '/_bench.php';
function fib(int $n): int { return $n < 2 ? $n : fib($n - 1) + fib($n - 2); }
bench(fn() => fib(30));
