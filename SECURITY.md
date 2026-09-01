# Security Policy

## Supported versions

| Version | Supported |
| --- | --- |
| `main` | Yes |
| Latest `v*` tag | Yes |
| Older tags | No |

This is a reference blueprint. Only the current `main` branch and the most
recent release tag receive fixes.

## Reporting a vulnerability

**Do not open a public issue for a security problem.**

Report it privately through GitHub:

1. Go to the [Security tab](https://github.com/dev-aunik/ci-cd-blueprint/security/advisories/new).
2. Open a draft security advisory.
3. Include the affected version or commit, reproduction steps, and the impact
   you believe it has.

You can expect an acknowledgement within 5 working days and an assessment
within 15. If a fix is warranted, it lands on `main` and in a new tag, and the
advisory is published once users have had a chance to upgrade.

## Scope

In scope:

- The application code in `src/` and `public/`
- The `Dockerfile` and the image it produces
- The GitHub Actions workflows, especially anything affecting the release
  pipeline or registry credentials

Out of scope:

- Vulnerabilities in upstream base images that have no fix available. These are
  reported by the Trivy workflow but do not block merges by design.
- Findings that require an attacker to already control the CI runner or the
  repository settings.

## Hardening notes for anyone adopting this blueprint

- Workflows reference actions by major tag. For a production repository, pin
  each action to a full commit SHA and let Dependabot move the pin.
- The release workflow uses the built-in `GITHUB_TOKEN` scoped to the publish
  job. Avoid replacing it with a long-lived personal access token.
- Protect `main`: require pull requests, require the CI checks to pass, and
  disallow force pushes and deletion.
- Enable secret scanning and push protection on any fork used for real work.
