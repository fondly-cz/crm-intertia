# CRM Inertia.js Project Instructions

This is a CRM application built with:
- **Backend**: Laravel (PHP)
- **Frontend**: Vue.js 3 with Composition API
- **Full-stack framework**: Inertia.js
- **Build tool**: Vite
- **Styling**: Tailwind CSS

## Project Structure
- `app/` - Laravel application logic (controllers, models, etc.)
- `resources/js/` - Vue.js frontend components and pages
- `resources/css/` - Stylesheets and Tailwind CSS
- `routes/` - Laravel routes (web.php for Inertia routes)
- `database/` - Database migrations and seeders

## Development Guidelines
- Use Inertia.js for seamless SPA experience with server-side routing
- Create Vue components in `resources/js/Components/`
- Create Inertia pages in `resources/js/Pages/`
- Use Laravel controllers to return Inertia responses
- Follow Vue 3 Composition API patterns
- Implement CRM features: contacts, companies, deals, tasks, etc.

## Key Commands
- `php artisan serve` - Start Laravel development server
- `pnpm run dev` - Start Vite development server
- `pnpm run dev:concurrent` - Start both servers concurrently
- `pnpm run build` - Build assets for production
- `php artisan migrate` - Run database migrations
- `php artisan make:controller` - Create new controllers

## Package Management
- This project uses **pnpm** instead of npm for faster and more efficient dependency management
- Use `pnpm install` to install dependencies
- Use `pnpm add <package>` to add new packages
- Use `pnpm remove <package>` to remove packages