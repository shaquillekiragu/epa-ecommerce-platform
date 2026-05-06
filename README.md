# MerchFlow

## Enter docker container:
```sh
cd backend
docker compose exec superadmin bash
```

## Format frontend files:
```sh
cd frontend
npx prettier . --write  # formats everything
npx prettier "**/*.vue" --write  # formats vue files
```
