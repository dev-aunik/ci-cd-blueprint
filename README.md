# CI/CD Blueprint

[![CI](https://github.com/dev-aunik/ci-cd-blueprint/actions/workflows/ci.yml/badge.svg)](https://github.com/dev-aunik/ci-cd-blueprint/actions/workflows/ci.yml)
[![CodeQL](https://github.com/dev-aunik/ci-cd-blueprint/actions/workflows/codeql.yml/badge.svg)](https://github.com/dev-aunik/ci-cd-blueprint/actions/workflows/codeql.yml)
[![Container scan](https://github.com/dev-aunik/ci-cd-blueprint/actions/workflows/container-scan.yml/badge.svg)](https://github.com/dev-aunik/ci-cd-blueprint/actions/workflows/container-scan.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A deliberately small PHP service wrapped in the pipeline a real service should
have. The application is trivial on purpose — the point is everything around it.

Copy this repository when you want a container project that ships with tests,
static analysis, supply-chain scanning and a signed release path already wired
together, instead of adding them one by one six months in.

## What it demonstrates

| Concern | How it is handled |
| --- | --- |
| Structure | PSR-4 autoloading, front controller in `public/`, no framework |
| Tests | PHPUnit in strict mode, 17 tests across routing, config and health |
| Static analysis | PHPStan at level 9, no baseline and no suppressions |
| Style | PHP-CS-Fixer, PSR-12 plus the PHP 8.2 migration set |
| Build | Multi-stage Dockerfile, dependencies resolved from `composer.lock` |
| Runtime hardening | opcache, `expose_php=0`, errors to stderr, security updates applied at build |
| CI | Parallel style, analysis and matrix test jobs gating a real container smoke test |
| Supply chain | CodeQL on workflows, Trivy image scan with SARIF, grouped Dependabot updates |
| Release | Tag-driven multi-arch build to GHCR with SBOM and build provenance attestation |

## Quick start

```bash
git clone https://github.com/dev-aunik/ci-cd-blueprint.git
cd ci-cd-blueprint
composer install
make check        # lint + analyse + test
```

Run it in Docker:

```bash
make up           # http://localhost:8080
make health       # {"status": "ok", ...}
make down
```

`make help` lists every target.

## Endpoints

| Path | Response |
| --- | --- |
| `/` | HTML page showing the configured name, environment and version |
| `/health` | JSON health payload, used by the container `HEALTHCHECK` and by CI |
| anything else | `404` with a JSON body |

Trailing slashes and query strings are normalised, so `/health/?debug=1` and
`/health` resolve identically.

## Configuration

All configuration is environment driven, with defaults baked in. Copy
`.env.example` to `.env` to override locally.

| Variable | Default | Purpose |
| --- | --- | --- |
| `APP_NAME` | `CI/CD Blueprint` | Service name, shown on the page and in `/health` |
| `APP_ENV` | `local` | Environment label |
| `APP_VERSION` | `0.1.0` | Version reported by `/health` |
| `APP_PORT` | `8080` | Host port compose publishes to |

## Layout

```text
.
├── .github/
│   ├── ISSUE_TEMPLATE/          Structured bug and improvement forms
│   ├── workflows/
│   │   ├── ci.yml               Style, analysis, matrix tests, build + smoke test
│   │   ├── codeql.yml           CodeQL over the workflow definitions
│   │   ├── container-scan.yml   Trivy image scan, SARIF upload, fixable-CVE gate
│   │   └── release.yml          Tag-driven multi-arch publish to GHCR
│   ├── CODEOWNERS
│   └── dependabot.yml
├── docker/
│   ├── apache/000-default.conf  Document root and FallbackResource routing
│   └── php/                     opcache and hardening ini
├── public/index.php             Front controller
├── resources/views/             Templates
├── src/                         Config, Router, Response, HealthCheck
├── tests/                       PHPUnit suite
├── Dockerfile                   composer vendor stage + apache runtime stage
└── docker-compose.yml
```

## The pipeline

Every pull request runs four jobs. The first three run in parallel; the build
only starts once they all pass.

```text
style ─┐
analysis ─┼─→ build + container smoke test
tests (8.2, 8.3, 8.4) ─┘
```

The build job is not just `docker build`. It boots the image, polls `/health`
until the container answers, asserts the payload, and dumps container logs if
anything fails. A build that compiles but does not serve traffic is still a
failure.

Two more workflows run on their own schedule: CodeQL over the workflow files,
and Trivy against the built image. Trivy uploads SARIF to code scanning
unconditionally, then fails separately on **fixable** HIGH and CRITICAL
findings — unfixable upstream CVEs are visible without blocking merges.

## Releasing

Releases come from tags, never from `main`:

```bash
git tag -a v1.2.0 -m "v1.2.0"
git push origin v1.2.0
```

That builds `linux/amd64` and `linux/arm64`, derives semver tags, publishes to
`ghcr.io/dev-aunik/ci-cd-blueprint`, attaches an SBOM, and attests build
provenance so the image can be traced back to the workflow run that produced it.
Authentication uses the built-in `GITHUB_TOKEN`, so there is no long-lived
registry password to rotate.

## Adopting this for a real service

1. Change `name` in `composer.json` and the namespace in `autoload`.
2. Update `CODEOWNERS`, `SECURITY.md` and the badge URLs to your repository.
3. **Pin the actions to commit SHAs.** They are on major tags here for
   readability; Dependabot will move SHA pins for you.
4. Protect `main`: require pull requests, require the CI checks, and disallow
   force pushes.
5. Decide whether `opcache.validate_timestamps` should be `0` in production. It
   is `1` here so the compose bind mounts pick up edits.

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md). Security issues go through a private
advisory, per [SECURITY.md](SECURITY.md).

## License

[MIT](LICENSE).
