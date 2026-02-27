# CRM Inertia.js Project

A modern CRM application built with Laravel, Vue.js 3, and Inertia.js, using pnpm for package management.

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Vue.js 3 with Composition API
- **Full-stack framework**: Inertia.js
- **Build tool**: Vite
- **Styling**: Tailwind CSS
- **Package Manager**: pnpm

## Features

- Seamless SPA experience with server-side routing
- Vue 3 Composition API for modern component development
- Tailwind CSS for rapid UI development
- Hot module replacement with Vite
- Efficient dependency management with pnpm

## Prerequisites

- PHP 8.4+
- Node.js 18+
- pnpm 10+
- Composer
- SQLite (default) or MySQL/PostgreSQL

### To run the project use:
| Step                                       | Command                                                                       |
|--------------------------------------------|------------------------------------------------------------------------------|
| Install dependencies                       | `composer install`                                                           |
| Create environment file                    | `cp .env.example .env`                                                       |
| Generate app key                           | `php artisan key:generate`                                                   |
| Start containers locally                   | `./vendor/bin/sail -f docker-compose.yml -f compose.local.yml up -d` |
| Start containers with traefik              | `./vendor/bin/sail -f docker-compose.yml -f compose.traefik.yml up -d` |
| Migrate database                           | `./vendor/bin/sail artisan migrate`                                          |
| Seed database with initial data            | `./vendor/bin/sail artisan migrate:fresh --seed`                             |
| Install JS dependencies (in container)     | `./vendor/bin/sail pnpm install`                                             |
| Start Vite dev server                      | `./vendor/bin/sail composer run dev`                                         |


you can merge compose files by using     multiple -f flags, for example:
    ```bash
    docker compose -f docker-compose.yml -f compose.local.yml up -d
    ```

    Choose specific compose files to merge depending on your    enviroment.


## Credentials

### Admin Access
- **Email**: `spoluprace@fondly.cz`
- **Password**: `admin`

> **Note**: The application is protected by authentication. Only public links for calculations with a valid access token are accessible without logging in.


## Development

### Quick Start (Both servers)
Run both Laravel and Vite development servers concurrently:
```bash
pnpm run dev:concurrent
```

### Individual Servers

Start the Laravel development server:
```bash
php artisan serve
```

Start the Vite development server (in a new terminal):
```bash
pnpm run dev
```

### Building for Production

Build assets for production:
```bash
pnpm run build
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
