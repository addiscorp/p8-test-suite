<?php
// Typed parameters and returns: class, interface, scalar and nullable types.
declare(strict_types=1);
require __DIR__ . '/_bench.php';
interface Shape { public function area(): float; }
final class Rect implements Shape { public function __construct(public readonly float $w, public readonly float $h) {} public function area(): float { return $this->w * $this->h; } }
function total(Shape $s, ?float $scale, int $times): float { return $s->area() * ($scale ?? 1.0) * $times; }
bench(function () {
    $r = new Rect(2.0, 3.0);
    $t = 0.0;
    for ($i = 0; $i < 2000000; $i++) {
        $t += total($r, $i % 2 ? 0.5 : null, 1);
    }
    return $t;
});
