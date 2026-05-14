# Blog API Test Task

Тестовое задание на `PHP / Laravel`: API и админ-панель для мобильного приложения "Блог".

## Что реализовано

### API

- регистрация пользователя
- авторизация пользователя через `Laravel Sanctum`
- создание публикации от имени авторизованного пользователя
- получение списка всех публикаций
- получение списка публикаций текущего пользователя
- фильтрация публикаций по дате
- сортировка и пагинация через `limit` и `offset`

### Админ-панель

- админ-панель на `Orchid`
- вход в админку только для администратора
- стандартный CRUD пользователей
- CRUD публикаций через `orchid/crud`

## Основные маршруты API

- `POST /api/register`
- `POST /api/login`
- `GET /api/posts`
- `GET /api/posts/me`
- `POST /api/post`

Для защищённых маршрутов используется заголовок:

```http
Authorization: Bearer <accessToken>
```

## Запуск проекта

### 1. Установка зависимостей

```bash
composer install
npm install
```

### 2. Подготовка окружения

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Запуск через Laravel Sail

```bash
./vendor/bin/sail up
```

