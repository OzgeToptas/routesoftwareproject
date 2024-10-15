## Order Service

Setup for localhost <a href="https:://localhost">https:://localhost</a>

```
composer install
cp .env.example .env
php artisan key:generate
npm install && npm run build
php artisan serve
php artisan queue:work --sleep=3 --tries=3
```

Setup for docker

```
docker compose up --build -d
docker exec -it orderservice bash -c "
    composer install &&
    cp .env.example .env &&
    php artisan key:generate &&
    php artisan migrate --seed &&
    php artisan queue:work --sleep=3 --tries=3
"
```

### Order API

| Method     | URI           | Action                                            |
| ---------- | ------------- | ------------------------------------------------- |
| `GET/HEAD` | `/api/orders` | `App\Http\Controllers\Api\OrderController@orders` |
# routesoftwareproject
