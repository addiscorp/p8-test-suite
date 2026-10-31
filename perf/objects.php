<?php
// Objects: method calls, property reads and writes, as framework code is.
require __DIR__ . '/_bench.php';
class Point {
    public function __construct(private float $x = 0.0, private float $y = 0.0) {}
    public function x(): float { return $this->x; }
    public function y(): float { return $this->y; }
    public function add(Point $o): static { $this->x += $o->x(); $this->y += $o->y(); return $this; }
}
bench(function () {
    $sum = new Point();
    for ($i = 0; $i < 1000000; $i++) {
        $sum->add(new Point($i % 7, $i % 11));
    }
    return round($sum->x() + $sum->y());
});
