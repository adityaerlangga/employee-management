# Employee Management App - Laravel 12 Boilerplate

A modern Laravel 12 boilerplate project with Tailwind CSS v4 pre-configured and ready for development. This project serves as a starting point for building web applications with a clean, utility-first styling approach.

## 🚀 Tech Stack

- **Backend Framework**: [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Frontend Styling**: [Tailwind CSS v4](https://tailwindcss.com)
- **Build Tool**: [Vite 7](https://vitejs.dev)
- **Database**: SQLite (default, easily configurable)
- **Package Manager**: Composer (PHP) & npm (JavaScript)

## ✨ Features

- ✅ **Laravel 12** - Latest Laravel framework with modern PHP features
- ✅ **Tailwind CSS v4** - Pre-configured utility-first CSS framework
- ✅ **Vite Integration** - Fast build tool with HMR (Hot Module Replacement)
- ✅ **OpenSpec** - Specification-driven development workflow
- ✅ **SQLite Database** - Zero-configuration database for quick setup
- ✅ **Development Tools** - Laravel Pint, Pail, Tinker, and more
- ✅ **Test Page** - Ready-to-use Tailwind CSS demonstration page

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2 with extensions:
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - Tokenizer
  - XML
- **Composer** - PHP dependency manager
- **Node.js** >= 18.x and **npm** - For frontend dependencies
- **Git** - Version control

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd employee-management-app
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup

The project uses SQLite by default. The database file is automatically created at `database/database.sqlite`.

To use a different database, update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then run migrations:

```bash
php artisan migrate
```

### 6. Build Frontend Assets

```bash
# Production build
npm run build

# Or for development with HMR
npm run dev
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 📁 Project Structure

```
employee-management-app/
├── app/                    # Application core
│   ├── Http/
│   │   └── Controllers/    # Application controllers
│   ├── Models/             # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/              # Framework bootstrap files
├── config/                 # Configuration files
├── database/               # Database files
│   ├── factories/         # Model factories
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── openspec/              # OpenSpec documentation
│   ├── changes/           # Change proposals
│   ├── specs/             # Specifications
│   └── project.md         # Project conventions
├── public/                 # Public assets
├── resources/              # Frontend resources
│   ├── css/
│   │   └── app.css        # Tailwind CSS entry point
│   ├── js/
│   │   ├── app.js         # JavaScript entry point
│   │   └── bootstrap.js   # Bootstrap configuration
│   └── views/              # Blade templates
│       ├── welcome.blade.php
│       └── test-tailwind.blade.php
├── routes/                 # Route definitions
│   └── web.php            # Web routes
├── storage/                # Storage directory
├── tests/                  # Test files
├── vendor/                 # Composer dependencies
├── vite.config.js          # Vite configuration
├── package.json            # npm dependencies
└── composer.json           # PHP dependencies
```

## 🎨 Using Tailwind CSS

### Basic Usage

Tailwind CSS is already configured and ready to use. Simply include the Vite directive in your Blade templates:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### Example Blade Template

```blade
<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900">Hello World</h1>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Click Me
        </button>
    </div>
</body>
</html>
```

### Test Page

A comprehensive Tailwind CSS test page is available at `/test-tailwind` route. It demonstrates:

- Color utilities
- Typography variations
- Spacing and layout
- Buttons with hover effects
- Card components
- Responsive design patterns

Visit `http://localhost:8000/test-tailwind` to see it in action.

### Tailwind Configuration

Tailwind CSS v4 uses a new configuration approach. Customization is done in `resources/css/app.css`:

```css
@import 'tailwindcss';

@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    /* Custom theme configuration */
    --font-sans: 'Your Font', sans-serif;
}
```

## 🛣️ Available Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/` | Welcome page (default Laravel welcome) |
| GET | `/test-tailwind` | Tailwind CSS demonstration page |

## 🔧 Development Workflow

### Running the Development Server

```bash
# Start Laravel server
php artisan serve

# In another terminal, start Vite dev server with HMR
npm run dev
```

### Using Composer Scripts

The project includes convenient Composer scripts:

```bash
# Complete setup (install dependencies, generate key, migrate, build)
composer setup

# Development mode (runs server, queue, logs, and Vite concurrently)
composer dev

# Run tests
composer test
```

### Code Style

Laravel Pint is configured for code formatting:

```bash
# Format code
./vendor/bin/pint
```

### Database Migrations

```bash
# Create a new migration
php artisan make:migration create_example_table

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback
```

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Or using Composer
composer test
```

## 📚 OpenSpec

This project uses [OpenSpec](https://github.com/openspec/openspec) for specification-driven development. Specifications and change proposals are located in the `openspec/` directory.

### Viewing Changes

```bash
# List active changes
openspec list

# List specifications
openspec list --specs

# View a specific change
openspec show setup-tailwind-css
```

## 🚢 Building for Production

### 1. Optimize Composer Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

### 2. Build Frontend Assets

```bash
npm run build
```

### 3. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Environment

Ensure your `.env` file has:

```env
APP_ENV=production
APP_DEBUG=false
```

## 📝 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev/guide)
- [Laracasts](https://laracasts.com) - Video tutorials

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework
- [Tailwind CSS](https://tailwindcss.com) - The utility-first CSS framework
- [Vite](https://vitejs.dev) - The build tool

---

**Happy Coding! 🎉**
