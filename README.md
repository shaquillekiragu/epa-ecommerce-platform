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

## SSH and Deployment:
```sh
.ssh % ssh -i "~/.ssh/SKKey.pem" ubuntu@ec2-18-133-204-127.eu-west-2.compute.amazonaws.com
rsync -avz -e "ssh -i ~/.ssh/SKKey.pem" . ubuntu@ec2-18-133-204-127.eu-west-2.compute.amazonaws.com:/var/www/production
```
