# Repository guidelines

The five data files (`php-src.json`, `target.txt`, `results.txt`,
`run.json`, `apps.jsonl`) are the whole product of this repository. Keep website, runner,
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

## Releases

Every change lands through a pull request to `main`. Tags
(`results-<commit>`) are created by the release owner, never from a feature
branch, and are never moved or deleted.
