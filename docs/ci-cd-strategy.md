# CI/CD Strategy

This project keeps the pipeline small on purpose. Pull requests run checks. Pushes to `main` can publish a Docker image.

## Branches

- Keep `main` working.
- Use short branches for changes.
- Open pull requests before merging.
- Use tags such as `v1.0.0` when you want a release tag.

## Pipeline

### Validate

Runs on pull requests and pushes to `main`.

- Check out the repository.
- Lint all PHP files.
- Validate the Docker Compose configuration.
- Build the Docker image.

### Publish

Runs only outside pull requests.

- Logs in to Docker Hub if credentials exist.
- Builds the image.
- Publishes `latest`, short SHA, and tag-based image tags.
- Skips publishing if secrets are missing.

## Required Secrets

| Secret | Purpose |
| --- | --- |
| `DOCKER_USERNAME` | Docker Hub username |
| `DOCKER_PASSWORD` | Docker Hub access token or password |

## Suggested GitHub Settings

- Protect the `main` branch.
- Require the CI workflow to pass before merging.
- Store Docker credentials in GitHub Actions secrets.

## Release Flow

```bash
git checkout main
git pull
git tag v1.0.0
git push origin v1.0.0
```

The workflow publishes a matching Docker tag when a Git tag is pushed.
