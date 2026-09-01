# Contributing

Thanks for taking the time to contribute. This repository is a blueprint, so
changes should keep it small, readable and copy-pasteable into a real service.

## Getting set up

```bash
git clone https://github.com/dev-aunik/ci-cd-blueprint.git
cd ci-cd-blueprint
composer install
```

Docker is only needed for the container workflow:

```bash
make up        # build and run on http://localhost:8080
make health    # curl the health endpoint
make down      # stop
```

## Before you open a pull request

Run the same three checks CI runs. All of them must pass:

```bash
composer run lint      # PHP-CS-Fixer, dry run
composer run analyse   # PHPStan, level 9
composer run test      # PHPUnit
```

`composer run fix` rewrites files to match the style rules.

## Expectations for a change

- **Keep `main` releasable.** Every pull request should leave the repository in
  a state where the Docker image builds and the health endpoint answers.
- **No suppressions.** Do not add `@phpstan-ignore`, baselines or casts to
  silence static analysis. If level 9 complains, the type is genuinely unclear
  at that point and the fix belongs in the code.
- **Test behaviour, not implementation.** Tests live in `tests/` and mirror the
  class they cover.
- **One concern per pull request.** A style sweep and a behaviour change in the
  same diff are hard to review and harder to revert.

## Commit messages

Conventional Commits, lowercase, imperative:

```text
feat: add readiness endpoint
fix: narrow the REQUEST_URI read
ci: cache composer downloads between runs
docs: explain the release flow
```

Pair work should carry a trailer so both people show up in the history:

```text
Co-authored-by: Name <email@example.com>
```

## Releasing

Releases are cut from tags. Pushing a `v*.*.*` tag builds a multi-architecture
image, publishes it to GHCR with an SBOM, and attests provenance:

```bash
git tag -a v1.2.0 -m "v1.2.0"
git push origin v1.2.0
```

Nothing publishes from `main` directly.

## Reporting security issues

Do not open a public issue. Follow [SECURITY.md](SECURITY.md).
