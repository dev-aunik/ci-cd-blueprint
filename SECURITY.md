# Security Policy

## Supported Versions

This blueprint is maintained from the `main` branch.

## Reporting a Vulnerability

Please report vulnerabilities privately by opening a GitHub security advisory or contacting the repository owner. Do not include secrets, tokens, or production credentials in issues or pull requests.

## Security Practices Included

- Secrets are expected to live in GitHub Actions secrets.
- Docker builds avoid committing local environment files.
- CI runs validation before image publishing.
- Dependabot is configured for GitHub Actions and Docker metadata.
