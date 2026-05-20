# CI/CD Blueprint

A practical CI/CD starter blueprint for containerized PHP applications. It includes a small Apache/PHP demo app, Docker Compose for local development, and GitHub Actions workflows for validation, image builds, and Docker Hub publishing.

## What This Blueprint Gives You

- Dockerized PHP 8.3 application using Apache
- Local development with Docker Compose
- Health check endpoint for release verification
- GitHub Actions pipeline for linting and Docker builds
- Optional Docker Hub publishing from protected secrets
- Project hygiene files: license, changelog, contributing guide, security policy, and templates

## Repository Structure

```text
.
├── .github/
│   ├── ISSUE_TEMPLATE/
│   ├── workflows/
│   └── dependabot.yml
├── docs/
├── scripts/
├── src/
├── Dockerfile
├── docker-compose.yml
├── Makefile
├── README.md
└── LICENSE
```

## Quick Start

### Requirements

- Docker 24+
- Docker Compose v2+
- Git

### Run Locally

```bash
docker compose up --build
```

Open the app:

```text
http://localhost:8080
```

Check the health endpoint:

```text
http://localhost:8080/health
```

### Useful Commands

```bash
make build      # Build the Docker image
make up         # Start the app
make down       # Stop the app
make logs       # Follow container logs
make lint       # Run PHP syntax checks in Docker
make smoke      # Run a local HTTP smoke test
```

## CI/CD Flow

The default GitHub Actions pipeline is designed for a professional but easy-to-adopt workflow:

1. Validate pull requests with PHP syntax checks and Docker builds.
2. Build the container image on pushes to `main`.
3. Push the image to Docker Hub only when Docker credentials are configured.
4. Keep dependency metadata fresh with Dependabot.

## Docker Hub Publishing

Add these repository secrets in GitHub:

| Secret | Description |
| --- | --- |
| `DOCKER_USERNAME` | Docker Hub username |
| `DOCKER_PASSWORD` | Docker Hub access token or password |

Update the image name in `.github/workflows/ci.yml` if you want to publish to a different Docker Hub repository.

## Implementation Checklist

- [ ] Fork or clone this repository.
- [ ] Update `APP_NAME` and `APP_ENV` in `.env.example`.
- [ ] Change the Docker image name in `.github/workflows/ci.yml`.
- [ ] Add Docker Hub secrets in GitHub.
- [ ] Open a pull request and confirm the CI workflow passes.
- [ ] Merge to `main` and verify the image is published.
- [ ] Deploy the published image to your target platform.

## Documentation

- [Deployment Guide](docs/deployment.md)
- [CI/CD Strategy](docs/ci-cd-strategy.md)

## License

This project is released under the [MIT License](LICENSE).
