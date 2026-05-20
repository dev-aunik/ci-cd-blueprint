# Contributing

Thank you for improving this CI/CD blueprint. Keep changes practical, documented, and easy for another developer to adopt.

## Development Workflow

1. Create a branch from `main`.
2. Make a focused change.
3. Run the local checks:

```bash
make lint
make build
make smoke
```

4. Open a pull request with a short summary and test notes.

## Commit Style

Use small, meaningful commits. Good examples:

```text
docs: add deployment guide
ci: publish docker image from main
docker: add production-ready container defaults
```

## Pull Request Checklist

- [ ] The change is focused and easy to review.
- [ ] Documentation is updated when behavior changes.
- [ ] Local checks pass.
- [ ] Secrets or credentials are not committed.
