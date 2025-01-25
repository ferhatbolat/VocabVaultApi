# Language Learning Mobile API

A backend API service developed for a mobile language learning application. This API supports core language learning functionalities including vocabulary management, story generation, and interactive exercises.

## Technologies & Libraries

-   **Framework:** Laravel 10.x
-   **PHP Version:** 8.1+
-   **Database:** MySQL 8.0
-   **Cache:** Redis
-   **Authentication:** Laravel Sanctum
-   **Documentation:** Laravel Scribe, darkaonline/l5-swagger
-   **Testing:** PHPUnit
-   **API Standard:** RESTful

## Project Architecture

The project follows a layered architecture pattern:

-   **Controllers:** Handle HTTP requests/responses
-   **Services:** Contain business logic
-   **Repositories:** Manage data persistence
-   **Resources:** Transform API responses
-   **Requests:** Handle request validation

## Database Schema

Core tables:

-   **words** - Stores vocabulary words and their metadata
-   **stories** - Contains generated stories and related content
-   **exercises** - Manages learning exercises and answers
-   **user_progress** - Tracks user learning progress
-   **categories** - Word categories and groupings

## API Endpoints

### Word Management

```
GET    /api/words          - List all words
POST   /api/words          - Create new word
GET    /api/words/{id}     - Get word details
PUT    /api/words/{id}     - Update word
DELETE /api/words/{id}     - Delete word
```

### Story Management

```
GET    /api/stories        - List stories
POST   /api/stories        - Generate new story
GET    /api/stories/{id}   - Get story details
```

### Exercise Management

```
GET    /api/exercises          - List exercises
POST   /api/exercises/check    - Check answer
GET    /api/exercises/progress - Get progress
```

## Installation

1. Clone the repository:

```
git clone https://github.com/ferhatbolat/VocabVaultApi.git
```

2. Install dependencies:

```
composer install
```

4. Set up database in `.env`:

```
DB_DATABASE=vocab_vault //your database
```

## API Documentation

This project uses Swagger UI for API documentation powered by `darkaonline/l5-swagger` package.

Access the API documentation:

1. Install dependencies (if not already installed):

```
composer require darkaonline/l5-swagger
```

2. Publish Swagger assets:

```
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
```

3. Generate documentation:

```
php artisan l5-swagger:generate
```

4. View documentation:

-   Local: `http://localhost:8000/api/documentation`

## Testing

Run tests:

```
php artisan test
```

## Deployment

For production deployment:

```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
```

## Error Codes

-   200: Success
-   201: Created
-   400: Bad Request
-   401: Unauthorized
-   404: Not Found
-   422: Validation Error
-   500: Server Error

## License

This project is licensed under the MIT License.
