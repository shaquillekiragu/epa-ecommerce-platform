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

## SSH:
```sh
ssh -i "~/.ssh/SKKey.pem" ubuntu@ec2-18-133-204-127.eu-west-2.compute.amazonaws.com
```

## Deployment (On the Mac):
```sh
rsync -avz -e "ssh -i ~/.ssh/SKKey.pem" . ubuntu@ec2-18-133-204-127.eu-west-2.compute.amazonaws.com:/var/www/production
```

## Note:
If website gets stuck/crashes, then go to EC2 service instance page, then click reboot instance using Instance State button on the right.
