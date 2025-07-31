# Zenith - Job Application Tracker

<div align="center">
  <img src="public/zenith-logo.png" alt="Zenith Logo" width="200"/>
  <h3>Find Your Focus</h3>
</div>

[![Laravel](https://img.shields.io/badge/Laravel-12.0-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.0-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🎯 Overview

Zenith is a modern, elegant job application tracking system designed to help job seekers manage their application process with focus and clarity. Built with Laravel 12 and featuring a beautiful, responsive interface, Zenith provides comprehensive tools for tracking applications, managing tasks, and visualizing your job search progress.

## ✨ Features

### 📋 Application Management
- **Comprehensive Application Tracking**: Store detailed information about each job application including company, position, salary range, and application status
- **Status Tracking**: Monitor applications through different stages (Applied, Interviewing, Offer, Rejected, Withdrawn)
- **File Management**: Upload and store resumes and cover letters for each application
- **Event Timeline**: Track important events and milestones for each application
- **Notes & Documentation**: Keep detailed notes for interviews, follow-ups, and application details

### 📅 Task Management
- **Smart Task System**: Create and manage tasks related to your job search
- **Priority Levels**: Organize tasks by priority (Low, Normal, High)
- **Categories**: Categorize tasks (General, Application, Interview, Follow-up, Research)
- **Due Dates**: Set deadlines and track task completion
- **Today's Focus**: Special view for today's tasks to maintain focus

### 📊 Analytics & Insights
- **Progress Visualization**: Beautiful progress rings and charts showing application status
- **Application Statistics**: Track total applications, active applications, and offers
- **Stage-based Analytics**: Monitor applications by stage (Applied, Interviewing, etc.)
- **Performance Metrics**: Visual insights into your job search progress

### 🎨 Modern UI/UX
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Beautiful Interface**: Clean, modern design with smooth animations and transitions
- **Glass Morphism**: Contemporary glass-morphism design elements
- **Intuitive Navigation**: Easy-to-use interface with clear navigation
- **Dark/Light Theme Support**: Adaptive design that works in any lighting condition

### 🔐 Security & Authentication
- **User Authentication**: Secure login and registration system
- **Data Privacy**: All data is private and user-specific
- **File Security**: Secure file upload and storage system

## 🛠️ Technology Stack

### Backend
- **Laravel 12**: Modern PHP framework for robust backend development
- **PHP 8.2+**: Latest PHP features and performance improvements
- **MySQL/PostgreSQL**: Reliable database systems
- **Eloquent ORM**: Powerful database abstraction layer

### Frontend
- **Tailwind CSS 4.0**: Utility-first CSS framework for rapid UI development
- **Vanilla JavaScript**: Lightweight, performant frontend interactions
- **Vite**: Fast build tool and development server
- **Three.js**: 3D animations and visual effects

### Development Tools
- **Laravel Sail**: Docker-based development environment
- **Laravel Pint**: PHP code style fixer
- **PHPUnit**: Comprehensive testing framework
- **Laravel Pail**: Real-time log viewing

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL/PostgreSQL database

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/zenith-app.git
   cd zenith-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=zenith_app
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Visit the application**
   Open your browser and navigate to `http://localhost:8000`

### Development Commands

```bash
# Start all development services
composer run dev

# Run tests
composer run test

# Build for production
npm run build

# Watch for changes
npm run dev
```

## 📁 Project Structure

```
zenith-app/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/
│   └── web.php             # Web routes
└── public/                 # Public assets
```

## 🗄️ Database Schema

### Core Tables

#### `users`
- Standard user authentication and profile information

#### `job_applications`
- Company name, job title, department
- Employment type, location, salary range
- Application status, dates, and notes
- File paths for resumes and cover letters

#### `application_events`
- Timeline events for each application
- Event types, descriptions, and dates
- Priority levels for event tracking

#### `tasks`
- Task title, description, and priority
- Due dates and completion status
- Categories and optional application linking

## 🎨 Design System

### Color Palette
- **Primary**: `#2d3e2e` (Deep Forest Green)
- **Secondary**: `#6b7c6d` (Sage Gray)
- **Accent**: `#ff6b6b` (Coral Red)
- **Background**: Gradient from `#f5f1e8` to `#e8f2e8`

### Typography
- **Font Family**: Inter (Google Fonts)
- **Weights**: 400, 500, 600, 700, 800, 900
- **Letter Spacing**: -0.01em to -0.02em

### Components
- **Cards**: Glass-morphism with backdrop blur
- **Buttons**: Rounded with hover effects
- **Forms**: Clean inputs with focus states
- **Modals**: Smooth animations and transitions

## 🔧 Configuration

### Environment Variables

Key environment variables to configure:

```env
APP_NAME=Zenith
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zenith_app
DB_USERNAME=your_username
DB_PASSWORD=your_password

FILESYSTEM_DISK=public
```

### File Storage

The application uses Laravel's public disk for file storage:
- Resumes: `storage/app/public/resumes/`
- Cover Letters: `storage/app/public/cover_letters/`

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/JobApplicationTest.php

# Run with coverage
php artisan test --coverage
```

## 📦 Deployment

### Production Build

1. **Optimize for production**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Set up web server**
   - Configure your web server (Apache/Nginx) to point to the `public` directory
   - Ensure proper permissions for storage and bootstrap/cache directories

3. **Environment setup**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Configure production database credentials

### Docker Deployment

```bash
# Build Docker image
docker build -t zenith-app .

# Run container
docker run -p 8000:8000 zenith-app
```

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use conventional commit messages

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The amazing PHP framework
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS framework
- [Inter Font](https://rsms.me/inter/) - Beautiful typography
- [Three.js](https://threejs.org) - 3D graphics library

## 📞 Support

If you have any questions or need support:

- Create an issue on GitHub
- Check the documentation
- Review the code examples

---

<div align="center">
  <p>Made with ❤️ for job seekers everywhere</p>
  <p>Find your focus. Land your dream job.</p>
</div>
