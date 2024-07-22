# DICT Prereg website

Preregistration website

## How to run (Docker)

1. Edit email credentials by copying `/src/.env.template` to `/src/.env` and modify relevant fields

```ini
email=your.email@address.com
password=your.email.password.recomended.to.use.app.key
```

2.
```sh
docker compose up
```

## How to run (XAMPP)

1. Edit email credentials by copying `/src/.env.template` to `/src/.env` and modify relevant fields

```ini
email=your.email@address.com
password=your.email.password.recomended.to.use.app.key
```
2. Copy whole folder into htdocs
3. Create new mysql database name `prereg`
4. Run sql files from `database` in ascending order
