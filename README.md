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

### Docker Installation (Recommended)

1. Clone the repository:

```bash
git clone https://github.com/ferhatbolat/VocabVaultApi.git
cd VocabVaultApi
```

2. Build and start Docker containers:

```bash
docker-compose up -d --build
```

3. Install dependencies inside the container:

```bash
docker-compose exec app composer install
```

4. Copy environment file and generate app key:

```bash
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate
```

5. Run migrations:

```bash
docker-compose exec app php artisan migrate
```

The application will be available at:

-   **API:** http://localhost:8000
-   **Database:** localhost:3307 (root/root) - External access
-   **Database (Internal):** db:3306 (root/root) - Container to container

### Manual Installation

1. Clone the repository:

```bash
git clone https://github.com/ferhatbolat/VocabVaultApi.git
```

2. Install dependencies:

```bash
composer install
```

3. Set up database in `.env`:

```
DB_DATABASE=vocab_vault //your database
```

## VS Code Debug Setup

This project is configured for debugging with VS Code and Docker:

### Prerequisites

1. Install VS Code extensions:
    - PHP Debug
    - Docker
    - Laravel Extension Pack (optional)

### Debug Configuration

The project includes pre-configured debug settings:

1. **Launch Configuration** (`.vscode/launch.json`):

    - "Launch Laravel with Docker" - Start debugging session
    - "Listen for Xdebug" - Listen for debug connections

2. **Tasks** (`.vscode/tasks.json`):
    - "Docker: Build and Start" - Build and start containers
    - "Docker: Start" - Start existing containers
    - "Docker: Stop" - Stop containers
    - "Laravel: Run Migrations" - Run database migrations
    - "Laravel: Clear Cache" - Clear application cache

### How to Debug

1. Start Docker containers:

    ```bash
    docker-compose up -d --build
    ```

2. In VS Code:

    - Press `F5` or go to Run and Debug panel
    - Select "Launch Laravel with Docker"
    - Set breakpoints in your PHP code
    - Make API requests to trigger breakpoints

3. Alternative: Use Command Palette (`Cmd+Shift+P`):
    - Run "Tasks: Run Task"
    - Select "Docker: Build and Start"

### Xdebug Configuration

Xdebug is pre-configured with:

-   **Port:** 9003
-   **IDE Key:** VSCODE
-   **Client Host:** host.docker.internal

### Useful Docker Commands

```bash
# View logs
docker-compose logs -f app

# Access container shell
docker-compose exec app bash

# Restart containers
docker-compose restart

# Stop and remove containers
docker-compose down
```

## API Documentation

This project uses Swagger UI for API documentation powered by `darkaonline/l5-swagger` package.

Access the API documentation:

1. Generate documentation (if not already generated):

```bash
docker-compose exec app php artisan l5-swagger:generate
```

2. View documentation:

-   **Swagger UI:** http://localhost:8000/swagger.html
-   **JSON API Docs:** http://localhost:8000/docs/api-docs.json
-   **Alternative:** http://localhost:8000/api/documentation (may be slow)

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
