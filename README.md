# DICT Prereg website

Preregistration website

## How to run (Docker)

1. Download CDN files locally

```sh
wget -i cdn.txt -P /assets/cdn/ -N
```

2. Edit email credentials by copying `/src/.env.template` to `/src/.env` and modify relevant fields

```ini
email=your.email@address.com
password=your.email.password.recomended.to.use.app.key
```

3.
```sh
docker compose up
```

## How to run (XAMPP)

1. Download CDN files locally

```sh
wget -i cdn.txt -P /assets/cdn/ -N
```

2. Edit email credentials by copying `/src/.env.template` to `/src/.env` and modify relevant fields

```ini
email=your.email@address.com
password=your.email.password.recomended.to.use.app.key
```
3. Copy whole folder into htdocs
4. Create new mysql database name `prereg`
5. Run sql files from `database` in ascending order
