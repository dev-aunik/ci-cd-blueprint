# Contributing

Keep changes small and easy to review.

## Workflow

1. Create a branch from `main`.
2. Make a focused change.
3. Run the local checks:

```bash
make lint
make build
make smoke
```

4. Open a pull request.

## Commit Style

Use small, meaningful commits. Good examples:

```text
docs: add deployment guide
ci: publish docker image from main
docker: update container settings
```

## Pull Request Checklist

- [ ] The change is focused.
- [ ] Documentation is updated when behavior changes.
- [ ] Local checks pass.
- [ ] Secrets or credentials are not committed.
