# Changelog

All notable changes to this project are documented here.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- PSR-4 application structure with a front controller, `Config`, `Router`,
  `Response` and `HealthCheck`.
- PHPUnit suite in strict mode covering path normalisation, environment
  fallback, JSON and HTML responses, and view escaping.
- PHPStan at level 9 across `src`, `public` and `tests`, with no baseline.
- PHP-CS-Fixer enforcing PSR-12 and the PHP 8.2 migration set.
- CI split into parallel style, static analysis and matrix test jobs gating a
  Docker build that boots the image and smoke tests `/health`.
- Tag-driven release workflow publishing multi-arch images to GHCR with an SBOM
  and build provenance attestation.
- CodeQL analysis over the workflow definitions and Trivy scanning of the built
  image, with SARIF uploaded to code scanning.
- Grouped Dependabot updates for Composer, GitHub Actions and Docker.
- Contributing guide, code of conduct, security policy, code owners, issue
  forms and a pull request template.
- opcache and PHP hardening configuration, and OCI image labels.

### Fixed

- `composer.lock` was resolved against PHP 8.4, which broke installation on the
  8.2 and 8.3 matrix legs. The platform is now pinned to the minimum supported
  version.
- CodeQL was configured for PHP, which it does not support, so every run failed
  at initialisation. It now analyses the workflows instead.
- The image build copied only `composer.json`, re-resolving dependencies and
  ignoring the committed lock file.
- Invalid JSON escaping in the `autoload-dev` namespace declaration.
- Fixable HIGH and CRITICAL CVEs inherited from the base image are now patched
  during the build.

[Unreleased]: https://github.com/dev-aunik/ci-cd-blueprint/commits/main
