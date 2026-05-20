# Deployment Guide

This project publishes a Docker image that can be deployed to any container platform.

## Local Deployment

```bash
docker compose up --build
```

Visit:

```text
http://localhost:8080
```

Health check:

```text
http://localhost:8080/health
```

## Docker Hub Deployment

Pull the latest image:

```bash
docker pull devmehedi/ci-cd-blueprint:latest
```

Run the container:

```bash
docker run --rm -p 8080:80 \
  -e APP_NAME="CI/CD Blueprint" \
  -e APP_ENV=production \
  devmehedi/ci-cd-blueprint:latest
```

## Production Checklist

- [ ] Use a dedicated Docker Hub access token.
- [ ] Configure GitHub repository secrets.
- [ ] Protect the `main` branch.
- [ ] Confirm `/health` responds before routing traffic.
- [ ] Keep deployment credentials outside the repository.
- [ ] Roll back by redeploying the previous SHA-tagged image.

## Rollback Example

```bash
docker pull devmehedi/ci-cd-blueprint:sha-previous
docker run --rm -p 8080:80 devmehedi/ci-cd-blueprint:sha-previous
```
