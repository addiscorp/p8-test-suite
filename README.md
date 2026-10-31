# p8 test suite

How close p8 is to PHP 8.4, test by test. p8 is a drop-in PHP 8.4 written in
safe Rust; its correctness gate is php-src's own test suite (p8 APS 7). This
repository records which of those tests p8 passes. The site at
p8-test-suite.addis.gg draws it as one square per test.

## Files

| file | what |
|---|---|
| `php-src.json` | the php-src release the tests come from: tag, commit, archive URL and the archive's SHA-256 |
| `target.txt` | the 16,077 php-src tests that real PHP 8.4.27 passes, sorted bytewise. "100%" for p8 means passing every one |
| `results.txt` | one line per target test, in `target.txt` order: `pass`, `fail` or `skip`, a space, the test's path in php-src |
| `run.json` | the run behind `results.txt`: PHP version, the p8 commit, when it ran, and the counts |
| `apps.jsonl` | apps and frameworks run under p8: the run (its p8 commit), each app (name, version, kind: application, framework, plugin or theme; what it is in a line; source), then one line per check: the apps it shows working, what it did, as whom, and whether it matched PHP |
| `perf/` | the performance snippets: each `NAME.php` does one kind of work real apps do (calls, objects, typed code, arrays, strings, sorting, JSON, regex) and times only that work (`perf/_bench.php`) |
| `perf.json` | the latest timing of `perf/` under PHP and p8: the p8 commit, PHP version, the machine, and per snippet the median time under each and whether p8's output matched PHP's |
| `history.jsonl` | every release of this suite, oldest first: its tag, p8 commit, p8 version (once p8 has releases), when it ran, php-src passes, each app suite's passes, and the perf geometric mean (a re-release, `results-<commit>.N`, is the same line) |
| `roadmap.json` | the plan: the apps and frameworks whose own test suites p8 runs next, in order (name, kind, what it is in a line, source); only apps with their own PHPUnit (or Pest) suite; edited by hand |

In `results.txt`:

- `pass`: p8's output matches the test's expectation.
- `fail`: p8 ran the test and the output differs, it errored, or it timed out.
- `skip`: p8 did not run it, either because the test's `--SKIPIF--` skipped it
  (usually an extension p8 doesn't have yet) or because it is not run yet.

The test sources are not copied here. Consumers download the php-src archive
named in `php-src.json` and check its SHA-256. Some paths, such as
`ext/pdo_sqlite/tests/bug_34630.phpt`, are tests php-src keeps once in
`ext/pdo/tests/` and runs once per PDO driver; read those from
`ext/pdo/tests/<name>`.

## How the files are made

- `target.txt` comes from running php-src's `run-tests.php` with the official
  `php:8.4-cli` image and keeping every test whose JUnit entry has no failure,
  error or skip (`tests/php-src/make-target.sh` in p8).
- `results.txt` comes from p8's gate run: `php-test` over the php-src checkout
  at the same tag, against `target.txt`.
- `apps.jsonl` comes from p8's app gate (`crates/php-cli/tests/wordpress/gate.sh`)
  at the same p8 commit. It installs WordPress on MariaDB under PHP 8.4 and under
  p8, then makes the same requests of each: pages, signed-in wp-admin screens,
  writes (with the mail they send and the rows they leave), and the same again
  with each theme and plugin switched on through WordPress itself. A check
  passes when p8's output is byte-identical to PHP's, apart from clock readings
  and random tokens, which are normalised. In a check line, `what` is
  `install`, `page`, `write`, `mail`, `database` or `activate`, and `as` is
  `visitor` or `admin`.

- `perf.json` comes from `php-perf` in p8 (`php-perf --suite . --php php2
  --reference docker:php:8.4-cli --write`). Each snippet prints one JSON line,
  `{"check": …, "ns": …}`: what the work returned and how long it took by
  `hrtime`, so process and container start-up don't count. Runs alternate PHP
  and p8; a time is the median of 5, and it counts only when p8's `check`
  equals PHP's. The headline is the geometric mean of p8's time over PHP's.
- `history.jsonl` gets one line per release, added by the release itself.

## Releases

This repository is content only. Changes land through pull requests to
`main`. A release is an immutable tag, `results-<p8 commit, 7 characters>`.
Consumers pin a tag together with the SHA-256 of its GitHub archive and
update both in one reviewed change.
