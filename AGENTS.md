# Repository guidelines

The six data files (`php-src.json`, `target.txt`, `results.txt`,
`run.json`, `apps.jsonl`, `roadmap.json`) are the whole product of this repository. Keep website, runner,
build and deployment code out of it.

## Changes

- `results.txt` has exactly one line per `target.txt` line, in the same
  order, and `run.json`'s counts match it. A change that breaks either is
  wrong, whatever else it does.
- New results come from a full p8 gate run at a commit on p8's `main`; put
  that commit in `run.json`. Never edit a result by hand.
- `target.txt` changes only when the PHP version changes, and then
  `php-src.json` changes with it.
- `apps.jsonl` comes from p8's app gate at the same commit as `run.json`
  (its first line names it). Never edit a check by hand.
- `roadmap.json` is the plan, not a result: the apps and frameworks whose
  own PHPUnit (or Pest) test suites p8 will run next, in order. Only apps
  with such a suite belong here;
  apps without one are checked by hand, not listed. It is edited by hand. An app leaves it once its suite's
  results are in `apps.jsonl`.

## Releases

Every change lands through a pull request to `main`. Tags
(`results-<commit>`) are created by the release owner, never from a feature
branch, and are never moved or deleted.
