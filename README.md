# CI/CD Blueprint

Small PHP app with Docker and GitHub Actions. Use it as a simple starting point for a CI/CD setup.

## Includes

- PHP 8.3 with Apache
- Docker Compose for local work
- `/health` endpoint
- GitHub Actions for checking and publishing the Docker image

## Files

```text
.
├── .github/
│   └── workflows/
├── src/
├── Dockerfile
├── docker-compose.yml
├── Makefile
├── README.md
└── LICENSE
```

## Requirements

- Docker 24+
- Docker Compose v2+
- Git

## Run Locally

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

## Commands

```bash
make build      # Build the Docker image
make up         # Start the app
make down       # Stop the app
make logs       # Follow container logs
make lint       # Run PHP syntax checks in Docker
```

## CI/CD

The workflow does this:

1. Checks PHP syntax.
2. Validates the Docker Compose file.
3. Builds the Docker image.
4. Pushes `latest` to Docker Hub when code is pushed to `main`.

## Docker Hub Publishing

Add these repository secrets in GitHub:

| Secret | Description |
| --- | --- |
| `DOCKER_USERNAME` | Docker Hub username |
| `DOCKER_PASSWORD` | Docker Hub access token or password |

Update the image name in `.github/workflows/ci.yml` if you want to publish to a different Docker Hub repository.

## Setup Checklist

- [ ] Fork or clone this repository.
- [ ] Copy `.env.example` to `.env` if you want local values.
- [ ] Change the Docker image name in `.github/workflows/ci.yml`.
- [ ] Add Docker Hub secrets in GitHub.
- [ ] Push to GitHub and check the Actions tab.

## License

This project is released under the [MIT License](LICENSE).
