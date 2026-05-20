# Deployment Guide

This app runs as a Docker container. You can run it locally or pull the image from Docker Hub after CI publishes it.

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

## Docker Hub

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

## Checklist

- [ ] Use a dedicated Docker Hub access token.
- [ ] Configure GitHub repository secrets.
- [ ] Protect the `main` branch.
- [ ] Check `/health` before sending traffic to the container.
- [ ] Keep deployment credentials outside the repository.
- [ ] Roll back by redeploying the previous SHA-tagged image.

## Rollback

```bash
docker pull devmehedi/ci-cd-blueprint:sha-previous
docker run --rm -p 8080:80 devmehedi/ci-cd-blueprint:sha-previous
```
