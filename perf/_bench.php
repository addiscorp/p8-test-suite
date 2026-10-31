<?php
// The harness every snippet includes: run(fn) times the work with hrtime
// and prints one JSON line, {"check": <what the work returned>, "ns": <time>}.
// The check must be the same under PHP and p8 for the time to count.
function bench(callable $work): void {
    $t = hrtime(true);
    $check = $work();
    $ns = hrtime(true) - $t;
    echo json_encode(['check' => is_string($check) ? md5($check) : $check, 'ns' => $ns]), "\n";
}
