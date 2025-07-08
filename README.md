## 1. copy .env.example to .env
```
cp .env.example .env
```
## 2. run the docker compose
```
docker compose up -d
```
## 3. install compose dependencies
```
composer install
```
## 4. generate app key
```
sail artisan key:generate
```
## 5. migrate and seed the db
```
sail artisan migrate
sail db:seed
```
