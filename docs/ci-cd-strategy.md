# CI/CD Strategy

This blueprint uses a simple pipeline that is easy to explain in interviews, portfolio reviews, and team onboarding.

## Branch Model

- `main` is always expected to be deployable.
- Feature work should happen in short-lived branches.
- Pull requests validate code before merge.
- Releases can be marked with semantic tags such as `v1.0.0`.

## Pipeline Stages

### 1. Validate

Runs on pull requests and pushes to `main`.

- Check out the repository.
- Lint all PHP files.
- Validate the Docker Compose configuration.
- Build the Docker image.

### 2. Publish

Runs only outside pull requests.

- Logs in to Docker Hub when credentials are available.
- Builds the production image with Docker Buildx.
- Publishes `latest`, short SHA, and tag-based image tags.
- Skips publishing gracefully when secrets are not configured.

## Required Secrets

| Secret | Purpose |
| --- | --- |
| `DOCKER_USERNAME` | Docker Hub username |
| `DOCKER_PASSWORD` | Docker Hub access token or password |

## Recommended Repository Settings

- Protect the `main` branch.
- Require pull request reviews.
- Require the `Validate application` workflow to pass before merging.
- Disable direct pushes to `main` for collaborators.
- Store deployment credentials only in GitHub Actions secrets.

## Release Flow

```bash
git checkout main
git pull
git tag v1.0.0
git push origin v1.0.0
```

The workflow will publish a versioned Docker tag when a release tag is pushed.
