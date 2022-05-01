# vue-lab

### 1) Установка модулей vue
```
npm install
```

### 2) Билд проекта
```
npm run build
```

### 3) .env
Перед запуском нужно скопировать .env.example в .env и заполнить данные для подключения к БД

### 4) Установка composer
``` shell
composer install
```

### 5) Настройка сервера
Папку **dist/** закинуть на сервер и сделать миграцию БД

``` shell
php public/migrate_tables.php
```
