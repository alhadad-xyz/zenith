# 🚀 Zenith - AI-Powered Job Application Tracker

<div align="center">
  <img src="public/zenith-logo.png" alt="Zenith Logo" width="200"/>
  <h3>🎯 Find Your Focus, Land Your Dream Job</h3>
</div>

[![Laravel](https://img.shields.io/badge/Laravel-12.0-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.0-38B2AC.svg)](https://tailwindcss.com)
[![AI Powered](https://img.shields.io/badge/AI-Powered-brightgreen.svg)](https://ai.google.dev/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 🎯 Overview

Zenith is a cutting-edge, AI-powered job application tracking system that revolutionizes how job seekers manage their career journey. Built with Laravel 12 and enhanced with artificial intelligence, Zenith offers intelligent resume analysis, automated cover letter generation, comprehensive application tracking, and insightful analytics to maximize your job search success.

## ✨ Features

### 🤖 AI-Powered Intelligence
- **🎯 Smart Resume Analysis**: Advanced AI scoring system that analyzes your resume against job descriptions
  - Overall resume score and job match percentage
  - Detailed strengths and weaknesses analysis
  - Missing keywords detection from job descriptions
  - ATS (Applicant Tracking System) optimization scoring
  - Prioritized improvement suggestions (High/Medium/Low)
- **📝 AI Cover Letter Generation**: Intelligent cover letter creation powered by multiple AI providers
  - Multi-provider support (Gemini AI, OpenAI with smart fallbacks)
  - Resume integration for personalized content
  - Job-specific customization using company and role details
  - Additional context input for enhanced personalization
  - Professional formatting and structure
- **📄 Advanced Document Processing**: Multi-format text extraction from documents
  - PDF processing with multiple extraction methods
  - Word document support (DOCX and DOC formats)
  - Clean text preview generation for UI display

### 📋 Comprehensive Application Management
- **🎯 Complete Application Tracking**: Store detailed information about every job application
  - Company details, job title, department, and location
  - Employment type classification (full-time, part-time, contract, internship)
  - Salary range tracking (minimum and maximum)
  - Job URL and detailed description storage
  - Application-specific notes and documentation
- **📊 Advanced Status Management**: Monitor applications through complete lifecycle
  - Status tracking (Applied, Interviewing, Offer, Rejected, Withdrawn)
  - Automatic status change event logging
  - Progress visualization with beautiful charts
- **📁 Intelligent File Management**: Secure document handling system
  - Resume and cover letter uploads (PDF, DOC, DOCX support - max 10MB)
  - Automatic file cleanup when applications are deleted
  - File replacement with old file cleanup

### 📅 Advanced Event Timeline System
- **⏰ Comprehensive Event Tracking**: Complete application event management
  - Multiple event types (application_submitted, interview, note, followup, rejected)
  - Rich metadata storage for each event type
  - Chronological timeline view of all activities
- **🎤 Interview Management**: Detailed interview scheduling and tracking
  - Interview type, date, time, and location
  - Interview preparation notes and follow-up actions
  - Integration with calendar system
- **📝 Notes & Follow-ups**: Organized documentation system
  - Custom notes with timestamps
  - Follow-up task creation with due dates and priorities
  - Rejection tracking with feedback and reapply preferences

### ✅ Smart Task Management System
- **🎯 Intelligent Task Organization**: Advanced task management capabilities
  - Task categories (general, application, interview, followup, research)
  - Priority levels (low, normal, high) with visual indicators
  - Due date tracking with deadline management
  - Application linking for context-aware tasks
- **📊 Task Analytics**: Performance tracking and insights
  - Completion rate monitoring
  - Today's focus view for daily productivity
  - Task filtering and sorting options
  - Productivity metrics and trends

### 📊 Advanced Dashboard & Analytics
- **📈 Comprehensive Statistics**: Real-time job search metrics
  - Total applications, active applications, and offers received
  - Response rate and average response time tracking
  - Average offer amount and salary analysis
  - AI-powered match score analytics
- **🎯 Performance Analytics**: Deep insights into your job search
  - Application funnel visualization
  - Time-based application trends
  - Source tracking (LinkedIn, company sites, referrals)
  - AI-generated insights about application patterns
  - Interview conversion rates and success metrics
- **📅 Smart Calendar Integration**: Event visualization and management
  - All application-related events in calendar view
  - Today's events and upcoming deadlines
  - Interview scheduling and reminder system

### 🔐 Advanced Authentication & Security
- **🚀 Multiple Authentication Methods**: Flexible login options
  - Traditional email/password authentication with remember me
  - Google OAuth integration via Laravel Socialite
  - Secure session management and logout
- **🛡️ Enterprise-Level Security**: Comprehensive data protection
  - Route-level and model-level authorization
  - Secure file upload validation and storage
  - CSRF protection and SQL injection prevention
  - User data encryption and privacy protection

### 🎨 Modern UI/UX Experience
- **✨ Beautiful Design System**: Contemporary visual experience
  - Glass-morphism design with backdrop blur effects
  - Responsive design optimized for all devices
  - Smooth animations and micro-interactions
  - Professional color palette and typography
- **🧭 Intuitive Navigation**: User-friendly interface design
  - Sidebar navigation with clear organization
  - Breadcrumb navigation for easy wayfinding
  - Modal system for inline editing and creation
  - Consistent page layouts with action buttons

### 🔧 Developer & Admin Features
- **⚙️ Robust Configuration System**: Flexible environment setup
  - Multiple database support (MySQL/SQLite)
  - AI service configuration with API key management
  - Configurable file storage systems
  - Email system integration ready
- **📊 Monitoring & Logging**: Comprehensive system insights
  - Detailed logging for debugging and monitoring
  - Error handling with user-friendly messages
  - Performance tracking and optimization
  - Deployment-ready configuration

## 🛠️ Technology Stack

### 🧠 AI & Machine Learning
- **🤖 Gemini AI**: Primary AI provider for cover letter generation and resume analysis
- **🔮 OpenAI GPT**: Secondary AI provider with intelligent fallback system
- **📄 Document Processing**: Multi-format text extraction (PDF, DOC, DOCX)
  - smalot/pdfparser, pdftotext, ps2ascii for PDF processing
  - ZipArchive for DOCX, antiword/catdoc for DOC files
- **🎯 Smart Fallbacks**: Robust fallback system when AI services are unavailable

### 🚀 Backend Infrastructure
- **⚡ Laravel 12**: Modern PHP framework with advanced features
- **🐘 PHP 8.2+**: Latest PHP features and performance optimizations
- **🗄️ Database Systems**: MySQL (primary) and SQLite support
- **🔗 Eloquent ORM**: Powerful database abstraction with relationships
- **🔐 Laravel Socialite**: OAuth integration for Google authentication
- **📁 Laravel Storage**: Secure file management system
- **⚙️ Service Architecture**: Dedicated services for AI and document processing

### 🎨 Frontend & Design
- **🎭 Tailwind CSS 4.0**: Utility-first CSS framework for rapid development
- **✨ Glass Morphism**: Modern design system with backdrop blur effects
- **📱 Responsive Design**: Mobile-first responsive layout
- **🖥️ Vanilla JavaScript**: Lightweight, performant frontend interactions
- **⚡ Vite**: Fast build tool and hot module replacement
- **🎬 Smooth Animations**: CSS transitions and micro-interactions

### 🔧 Development & DevOps Tools
- **🐳 Laravel Sail**: Docker-based development environment
- **🎨 Laravel Pint**: Automated PHP code style fixer
- **🧪 PHPUnit**: Comprehensive testing framework with feature tests
- **📊 Laravel Pail**: Real-time log viewing and debugging
- **📝 Composer**: PHP dependency management
- **🔄 Git**: Version control with conventional commits

### 🛡️ Security & Authentication
- **🔐 Laravel Auth**: Built-in authentication system
- **🌐 OAuth 2.0**: Google social login integration
- **🛡️ CSRF Protection**: Cross-site request forgery prevention
- **🔒 Password Hashing**: Secure bcrypt password encryption
- **🚪 Middleware**: Route protection and authorization
- **📋 File Validation**: Secure file upload with type and size validation

## 🚀 Quick Start

### 📋 Prerequisites
- 🐘 **PHP 8.2** or higher
- 📦 **Composer** (PHP dependency manager)
- 🟢 **Node.js 18+** and npm
- 🗄️ **MySQL** database (recommended) or SQLite
- 🤖 **AI API Keys** (optional but recommended):
  - Gemini AI API key for enhanced features
  - OpenAI API key as fallback

### ⚡ Quick Installation

1. **📥 Clone the repository**
   ```bash
   git clone https://github.com/yourusername/zenith-app.git
   cd zenith-app
   ```

2. **📦 Install dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Node.js dependencies
   npm install
   ```

3. **⚙️ Environment setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **🗄️ Configure database & AI services**
   Edit `.env` file with your configuration:
   ```env
   # Database Configuration
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=zenith_app
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   # AI Service Configuration (Optional but Recommended)
   GEMINI_API_KEY=your_gemini_api_key
   OPENAI_API_KEY=your_openai_api_key
   
   # Google OAuth (Optional)
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
   ```

5. **🗃️ Set up database**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Seed database with sample data (optional)
   php artisan db:seed
   
   # Create storage symbolic link
   php artisan storage:link
   ```

6. **🎨 Build frontend assets**
   ```bash
   # For development
   npm run dev
   
   # For production
   npm run build
   ```

7. **🚀 Start the application**
   ```bash
   # Start Laravel development server
   php artisan serve
   
   # In another terminal (for development), watch for changes
   npm run dev
   ```

8. **🌐 Access the application**
   Open your browser and navigate to `http://localhost:8000`

### 🔧 AI Configuration (Optional)

To unlock the full AI-powered features:

1. **🤖 Get Gemini AI API Key**:
   - Visit [Google AI Studio](https://aistudio.google.com/app/apikey)
   - Create a new API key
   - Add to `.env` as `GEMINI_API_KEY=your_key_here`

2. **🔮 Get OpenAI API Key** (fallback):
   - Visit [OpenAI API Keys](https://platform.openai.com/api-keys)
   - Create a new API key
   - Add to `.env` as `OPENAI_API_KEY=your_key_here`

3. **🌐 Google OAuth Setup** (optional):
   - Visit [Google Cloud Console](https://console.cloud.google.com/)
   - Create OAuth 2.0 credentials
   - Add credentials to `.env`

### 🔧 Development Commands

```bash
# 🚀 Start development server with hot reload
php artisan serve & npm run dev

# 🧪 Run all tests
php artisan test

# 🎨 Fix code style
./vendor/bin/pint

# 📊 View real-time logs
php artisan pail

# 🗄️ Fresh database setup
php artisan migrate:fresh --seed

# 🔄 Clear all caches
php artisan optimize:clear

# 📦 Build for production
npm run build && php artisan optimize
```

## 📁 Project Structure

```
🚀 zenith-app/
├── 🎛️ app/
│   ├── 🌐 Http/Controllers/     # Application controllers
│   │   ├── JobApplicationController.php    # Main application CRUD
│   │   ├── TaskController.php             # Task management
│   │   ├── EventController.php            # Timeline events
│   │   ├── AIController.php               # AI-powered features
│   │   └── AuthController.php             # Authentication & OAuth
│   ├── 📊 Models/              # Eloquent models with relationships
│   │   ├── User.php                       # User model with OAuth
│   │   ├── JobApplication.php             # Core application model
│   │   ├── ApplicationEvent.php           # Timeline events
│   │   └── Task.php                       # Task management
│   ├── 🔧 Services/            # Business logic services
│   │   ├── AIService.php                  # AI provider management
│   │   ├── DocumentService.php            # File processing
│   │   └── ResumeAnalysisService.php     # Resume analysis logic
│   └── 🛡️ Providers/           # Service providers
├── 🗄️ database/
│   ├── 📋 migrations/          # Database schema migrations
│   ├── 🌱 seeders/            # Sample data seeders
│   └── 🏭 factories/          # Model factories for testing
├── 🎨 resources/
│   ├── 👁️ views/              # Blade templates
│   │   ├── dashboard/                     # Dashboard views
│   │   ├── applications/                  # Application management
│   │   ├── tasks/                        # Task management UI
│   │   ├── analytics/                    # Analytics & insights
│   │   └── auth/                         # Authentication pages
│   ├── 🎭 css/                # Stylesheets with Tailwind
│   └── ⚡ js/                 # JavaScript functionality
├── 🛣️ routes/
│   ├── web.php                # Web routes
│   └── auth.php               # Authentication routes
├── 📁 storage/
│   ├── app/public/resumes/    # Resume file storage
│   └── app/public/cover_letters/ # Cover letter storage
├── 🌐 public/                 # Public assets and entry point
└── ⚙️ config/                # Configuration files
```

## 🗄️ Database Schema

### 📊 Core Tables

#### 👤 `users`
- **Authentication**: Email, password, email verification
- **Profile**: Name, avatar (from Google OAuth)
- **OAuth**: Google ID for social login integration
- **Timestamps**: Account creation and updates

#### 💼 `job_applications`
- **Company Info**: Company name, job title, department
- **Job Details**: Employment type, location, job URL
- **Compensation**: Salary range (min/max), currency
- **Application Data**: Status, applied date, notes, description
- **File Management**: Resume and cover letter file paths
- **AI Integration**: AI analysis scores and insights
- **Relationships**: Belongs to user, has many events and tasks

#### ⏰ `application_events`
- **Event System**: Event type, title, description
- **Scheduling**: Event date, time, location
- **Metadata**: Priority level, reminder settings
- **Rich Data**: JSON metadata for event-specific information
- **Timeline**: Created and updated timestamps
- **Relationships**: Belongs to application and user

#### ✅ `tasks`
- **Task Info**: Title, description, priority level
- **Organization**: Category (general, application, interview, etc.)
- **Scheduling**: Due date, completion tracking
- **Context**: Optional application linking
- **Productivity**: Completion timestamps and status
- **Relationships**: Belongs to user, optionally linked to application

### 🔗 Key Relationships

```sql
👤 User
├── 💼 has many JobApplications
├── ⏰ has many ApplicationEvents  
└── ✅ has many Tasks

💼 JobApplication
├── ⏰ has many ApplicationEvents
├── ✅ has many Tasks
└── 👤 belongs to User

⏰ ApplicationEvent
├── 💼 belongs to JobApplication
└── 👤 belongs to User

✅ Task
├── 💼 optionally belongs to JobApplication
└── 👤 belongs to User
```

### 📈 Database Features
- **🔒 Data Privacy**: All data is user-scoped and private
- **📱 Soft Deletes**: Safe deletion with recovery options
- **🕐 Timestamps**: Automatic created/updated tracking
- **🔍 Indexing**: Optimized queries for performance
- **✅ Validation**: Model-level validation rules
- **🎯 Scopes**: Convenient query scopes for filtering

## 🎨 Design System

### 🌈 Color Palette
- **🌲 Primary**: `#2d3e2e` (Deep Forest Green) - Trust and professionalism
- **🍃 Secondary**: `#6b7c6d` (Sage Gray) - Calm and balance
- **🔥 Accent**: `#ff6b6b` (Coral Red) - Energy and attention
- **✨ Background**: Gradient from `#f5f1e8` to `#e8f2e8` - Warmth and comfort
- **🌟 Success**: `#10b981` (Emerald) - Positive feedback
- **⚠️ Warning**: `#f59e0b` (Amber) - Caution and alerts
- **❌ Error**: `#ef4444` (Red) - Error states

### ✍️ Typography
- **📝 Font Family**: Inter (Google Fonts) - Modern, readable, professional
- **⚖️ Font Weights**: 400, 500, 600, 700, 800, 900 - Complete weight spectrum
- **📏 Letter Spacing**: -0.01em to -0.02em - Optimized readability
- **📐 Line Heights**: 1.4 to 1.6 - Comfortable reading experience

### 🧩 Component System
- **💎 Glass Cards**: Backdrop blur with subtle transparency
- **🔘 Interactive Buttons**: Rounded corners with smooth hover transitions
- **📝 Modern Forms**: Clean inputs with elegant focus states
- **🪟 Smart Modals**: Smooth slide animations and backdrop blur
- **📊 Progress Indicators**: Animated progress rings and bars
- **🏷️ Status Badges**: Color-coded status indicators with icons

### 🎭 Visual Elements
- **✨ Glass Morphism**: Contemporary frosted glass effect
- **🌊 Smooth Transitions**: 200-300ms ease-in-out animations
- **🎯 Focus States**: Clear accessibility indicators
- **📱 Responsive Grid**: Mobile-first responsive design
- **🎪 Micro-interactions**: Subtle hover and click feedback

## ⚙️ Configuration

### 🌍 Environment Variables

#### 🏠 Application Settings
```env
APP_NAME=Zenith
APP_ENV=local               # local, staging, production
APP_DEBUG=true             # Enable debug mode for development
APP_URL=http://localhost:8000
APP_KEY=                   # Generated by php artisan key:generate
```

#### 🗄️ Database Configuration
```env
DB_CONNECTION=mysql        # mysql (recommended) or sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zenith_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 🤖 AI Service Configuration
```env
# Primary AI Provider (Recommended)
GEMINI_API_KEY=your_gemini_api_key

# Fallback AI Provider
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4         # Optional: specify model version
```

#### 🔐 OAuth Configuration
```env
# Google OAuth Integration
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

#### 📁 File Storage Configuration
```env
FILESYSTEM_DISK=public     # File storage driver
MAX_FILE_SIZE=10240       # Max file size in KB (10MB)
```

### 📂 File Storage System

The application uses Laravel's organized file storage:

```
📁 storage/app/public/
├── 📄 resumes/           # Resume uploads (PDF, DOC, DOCX)
│   ├── user_1_resume_2024.pdf
│   └── user_2_resume_latest.docx
├── 📝 cover_letters/     # Cover letter uploads
│   ├── user_1_cover_letter_company_a.pdf
│   └── user_2_cover_letter_startup.docx
└── 🖼️ avatars/          # User profile pictures (from OAuth)
    ├── user_1_google_avatar.jpg
    └── user_2_profile.png
```

### 🔧 Advanced Configuration

#### 📧 Mail Configuration (Optional)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@zenith-app.com
MAIL_FROM_NAME="Zenith Job Tracker"
```

#### 📊 Logging & Monitoring
```env
LOG_CHANNEL=daily         # daily, single, slack, papertrail
LOG_LEVEL=debug          # debug, info, warning, error
LOG_DAYS=14              # Days to keep daily logs
```

## 🧪 Testing & Quality Assurance

### 🔬 Running Tests

```bash
# 🚀 Run all tests
php artisan test

# 🎯 Run specific test suite
php artisan test tests/Feature/JobApplicationTest.php
php artisan test tests/Feature/AIServiceTest.php

# 📊 Run tests with coverage report
php artisan test --coverage

# 🐛 Run tests with detailed output
php artisan test --verbose

# ⚡ Run tests in parallel (faster)
php artisan test --parallel
```

### 🧹 Code Quality

```bash
# 🎨 Fix code style automatically
./vendor/bin/pint

# 🔍 Check code style without fixing
./vendor/bin/pint --test

# 📝 Run static analysis (if configured)
./vendor/bin/phpstan analyse

# 🔧 Run all quality checks
composer run test && ./vendor/bin/pint --test
```

### 🧪 Test Categories

- **🌐 Feature Tests**: End-to-end functionality testing
  - Application CRUD operations
  - AI service integration
  - Authentication flows
  - File upload processes

- **🔧 Unit Tests**: Individual component testing
  - Model relationships and scopes
  - Service class methods
  - Helper functions
  - Validation rules

- **🤖 AI Integration Tests**: AI service testing
  - Mock AI responses for consistent testing
  - Fallback system verification
  - Document processing validation

## 🚀 Deployment

### 🏭 Production Build

#### 1. **⚡ Optimize Application**
```bash
# Install production dependencies only
composer install --optimize-autoloader --no-dev

# Build and optimize frontend assets
npm ci --only=production
npm run build

# Cache configuration for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimize Composer autoloader
composer dump-autoload --optimize
```

#### 2. **🌐 Web Server Configuration**

**Nginx Configuration:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/zenith-app/public;
    
    index index.php;
    
    # File upload size limits
    client_max_body_size 10M;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### 3. **⚙️ Production Environment**
```env
# Production Settings
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database (Production)
DB_CONNECTION=mysql
DB_HOST=your-production-db-host
DB_DATABASE=zenith_production
DB_USERNAME=production_user
DB_PASSWORD=secure_production_password

# AI Services (Production Keys)
GEMINI_API_KEY=your_production_gemini_key
OPENAI_API_KEY=your_production_openai_key

# Security
SESSION_SECURE_COOKIE=true
SESSION_ENCRYPT=true
```

#### 4. **🔒 File Permissions**
```bash
# Set proper ownership
sudo chown -R www-data:www-data /var/www/zenith-app

# Set directory permissions
sudo find /var/www/zenith-app -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/zenith-app -type f -exec chmod 644 {} \;

# Storage and cache permissions
sudo chmod -R 775 /var/www/zenith-app/storage
sudo chmod -R 775 /var/www/zenith-app/bootstrap/cache
```

### 🐳 Docker Deployment

#### **Single Container Deployment**
```bash
# Build production image
docker build -t zenith-app:latest .

# Run with environment variables
docker run -d \
  --name zenith-app \
  -p 80:8000 \
  -e APP_ENV=production \
  -e DB_HOST=your-db-host \
  zenith-app:latest
```

#### **Docker Compose Deployment**
```yaml
# docker-compose.yml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "80:8000"
    environment:
      - APP_ENV=production
      - DB_HOST=database
    depends_on:
      - database
      
  database:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secure_password
      MYSQL_DATABASE: zenith_app
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

### ☁️ Cloud Deployment Options

#### **🔵 DigitalOcean App Platform**
```yaml
# .do/app.yaml
name: zenith-app
services:
- name: web
  source_dir: /
  github:
    repo: your-username/zenith-app
    branch: main
  run_command: php artisan serve --host=0.0.0.0 --port=$PORT
  environment_slug: php
  instance_count: 1
  instance_size_slug: basic-xxs
  envs:
  - key: APP_ENV
    value: production
```

#### **🟠 AWS EC2 Deployment**
```bash
# Install required software
sudo apt update
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql composer nodejs npm

# Deploy application
git clone https://github.com/your-username/zenith-app.git
cd zenith-app
composer install --no-dev --optimize-autoloader
npm ci --only=production && npm run build

# Configure services
sudo systemctl enable nginx php8.2-fpm mysql
sudo systemctl start nginx php8.2-fpm mysql
```

### 🔄 Continuous Deployment

#### **GitHub Actions Workflow**
```yaml
# .github/workflows/deploy.yml
name: Deploy to Production
on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v2
    - name: Deploy to server
      run: |
        # Your deployment script here
        php artisan down
        git pull origin main
        composer install --no-dev --optimize-autoloader
        npm ci --only=production && npm run build
        php artisan migrate --force
        php artisan config:cache
        php artisan up
```

## 🤝 Contributing

We welcome contributions to make Zenith even better! Whether you're fixing bugs, adding features, or improving documentation, your help is appreciated.

### 🚀 Getting Started

1. **🍴 Fork the repository**
   ```bash
   git clone https://github.com/your-username/zenith-app.git
   cd zenith-app
   ```

2. **🌿 Create a feature branch**
   ```bash
   git checkout -b feature/amazing-feature
   # or
   git checkout -b fix/bug-description
   ```

3. **⚡ Set up development environment**
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```

4. **💻 Make your changes**
   - Write clean, documented code
   - Follow existing code patterns
   - Add tests for new functionality

5. **✅ Test your changes**
   ```bash
   php artisan test
   ./vendor/bin/pint --test
   ```

6. **📝 Commit and push**
   ```bash
   git add .
   git commit -m "✨ Add amazing feature"
   git push origin feature/amazing-feature
   ```

7. **🔄 Open a Pull Request**
   - Describe your changes clearly
   - Link any related issues
   - Include screenshots for UI changes

### 📋 Development Guidelines

#### 🎨 Code Style
- **PHP**: Follow PSR-12 coding standards
- **JavaScript**: Use consistent ES6+ syntax
- **CSS**: Follow Tailwind CSS utility patterns
- **Blade**: Keep templates clean and semantic

#### 🧪 Testing Requirements
- **New Features**: Include feature tests
- **Bug Fixes**: Add regression tests
- **AI Features**: Mock external API calls
- **File Operations**: Test with sample files

#### 📝 Documentation
- Update README for new features
- Add inline code comments for complex logic
- Include docblocks for public methods
- Update API documentation if applicable

#### 🔄 Commit Message Format
```
🎯 type(scope): description

Examples:
✨ feat(ai): add resume analysis scoring
🐛 fix(auth): resolve Google OAuth callback issue
📝 docs(readme): update installation instructions
🎨 style(ui): improve mobile responsive design
♻️ refactor(models): simplify relationship definitions
```

### 🎯 Priority Areas for Contributions

#### 🔥 High Priority
- **🤖 AI Enhancements**: Improve AI prompts and analysis
- **📱 Mobile UX**: Better mobile experience
- **🚀 Performance**: Database query optimization
- **🔐 Security**: Enhanced security features

#### 🌟 Medium Priority
- **📊 Analytics**: Advanced reporting features
- **🔔 Notifications**: Email/SMS notification system
- **📅 Calendar**: External calendar integration
- **🌐 Internationalization**: Multi-language support

#### 💡 Ideas Welcome
- **🎨 Themes**: Additional UI themes
- **📈 Integrations**: Job board API integrations
- **🔧 Tools**: Additional productivity features
- **📱 Mobile App**: React Native mobile app

### 🐛 Bug Reports

When reporting bugs, please include:
- **Environment details** (PHP version, browser, OS)
- **Steps to reproduce** the issue
- **Expected vs actual behavior**
- **Screenshots** if applicable
- **Error messages** from logs

### 💬 Feature Requests

For feature requests, please provide:
- **Use case description** - Why is this needed?
- **Proposed solution** - How should it work?
- **Alternative solutions** - Any other approaches?
- **Additional context** - Screenshots, mockups, etc.

### 👥 Community

- **💬 Discussions**: Use GitHub Discussions for questions
- **🐛 Issues**: Use GitHub Issues for bugs and features
- **📧 Contact**: Reach out to maintainers for major changes

## 📜 License

This project is open source and available under the [MIT License](LICENSE).

```
MIT License

Copyright (c) 2024 Zenith Job Application Tracker

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
```

## 🙏 Acknowledgments

### 🛠️ Core Technologies
- **[Laravel](https://laravel.com)** - The elegant PHP framework that powers our backend
- **[Tailwind CSS](https://tailwindcss.com)** - Utility-first CSS framework for rapid UI development
- **[Vite](https://vitejs.dev)** - Next generation frontend tooling
- **[MySQL](https://mysql.com)** - Reliable database management system

### 🤖 AI & Services
- **[Gemini AI](https://ai.google.dev/)** - Advanced AI capabilities for resume analysis and cover letter generation
- **[OpenAI](https://openai.com)** - Fallback AI provider for enhanced reliability
- **[Google OAuth](https://developers.google.com/identity)** - Secure authentication integration

### 🎨 Design & UI
- **[Inter Font](https://rsms.me/inter/)** - Beautiful, professional typography
- **[Heroicons](https://heroicons.com)** - Elegant SVG icons
- **[Glass Morphism](https://glassmorphism.com)** - Modern design inspiration

### 📚 Libraries & Tools
- **[Laravel Socialite](https://laravel.com/docs/socialite)** - Social authentication
- **[Composer](https://getcomposer.org)** - PHP dependency management
- **[NPM](https://npmjs.com)** - JavaScript package management

## 📞 Support & Community

### 🆘 Getting Help

If you need assistance with Zenith:

1. **📚 Documentation**: Check this comprehensive README first
2. **🐛 Issues**: [Create an issue](https://github.com/your-username/zenith-app/issues) for bugs or feature requests
3. **💬 Discussions**: Use [GitHub Discussions](https://github.com/your-username/zenith-app/discussions) for questions
4. **📧 Email**: Contact the maintainers for security issues

### 🌟 Show Your Support

If Zenith helps you land your dream job, consider:

- ⭐ **Star this repository** to show your appreciation
- 🐛 **Report bugs** to help improve the application
- 💡 **Suggest features** to make it even better
- 🤝 **Contribute code** to join our community
- 📢 **Share with others** who might benefit

### 📊 Project Stats

![GitHub stars](https://img.shields.io/github/stars/your-username/zenith-app?style=social)
![GitHub forks](https://img.shields.io/github/forks/your-username/zenith-app?style=social)
![GitHub issues](https://img.shields.io/github/issues/your-username/zenith-app)
![GitHub pull requests](https://img.shields.io/github/issues-pr/your-username/zenith-app)

---

<div align="center">
  <h3>🎯 Made with ❤️ for job seekers everywhere</h3>
  <p><strong>Find your focus. Track your progress. Land your dream job.</strong></p>
  
  <p>
    <a href="#-features">🌟 Features</a> •
    <a href="#-quick-start">🚀 Quick Start</a> •
    <a href="#-deployment">📦 Deploy</a> •
    <a href="#-contributing">🤝 Contribute</a>
  </p>
  
  <p><em>✨ Transform your job search journey with AI-powered insights ✨</em></p>
</div>
