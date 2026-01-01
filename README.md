# 📚 Student Marketplace

A modern, feature-rich marketplace platform designed specifically for students to buy, sell, and exchange study materials, textbooks, gadgets, and furniture. Built with Laravel 12 and inspired by 2dehands.be, this platform provides a trusted environment for student-to-student transactions.

## ✨ Features

### Core Functionality
- **Listings Management**: Create, edit, and manage product listings with images, categories, tags, and detailed descriptions
- **Advanced Search**: Search listings by keyword, category, tags, location, and price range
- **Location-Based**: Belgian city autocomplete with postal codes and distance calculations
- **Status Management**: Mark items as sold, reserved, or featured
- **Favorites System**: Save favorite listings for later viewing
- **Real-time Messaging**: Built-in chat system between buyers and sellers
- **User Profiles**: Public profiles with location, bio, and listing history

### Admin Features
- **Comprehensive Dashboard**: Statistics overview with key metrics
- **User Management**: Admin panel for managing users, listings, and content
- **Content Moderation**: Review and manage contact messages, news items, and FAQs
- **Role-Based Access**: Separate admin and user interfaces with proper authorization

### Additional Features
- **News Section**: Keep users informed with announcements and updates
- **FAQ System**: Categorized frequently asked questions
- **Contact Form**: Direct communication channel with administrators
- **Email Notifications**: Automatic email notifications for messages and contact replies
- **Modern UI**: Clean, responsive design with Heroicons and Tailwind CSS
- **Custom Branding**: Professional SVG favicon and consistent visual identity

## 🛠 Tech Stack

- **Framework**: Laravel 12.x
- **PHP**: 8.4.16
- **Database**: SQLite (easily switchable to MySQL/PostgreSQL)
- **Frontend**: 
  - Tailwind CSS 3.x
  - Alpine.js
  - Heroicons (Blade UI Kit)
  - Vite
- **Email**: Gmail SMTP integration
- **Queue**: Sync driver (configurable to Redis/database)
- **Authentication**: Laravel Breeze

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and npm
- SQLite (or MySQL/PostgreSQL)
- Git

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/student-marketplace.git
cd student-marketplace
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit `.env` and update the following:

```env
APP_NAME="Student Marketplace"
APP_URL=http://localhost:8000

# Database (SQLite is default, no additional config needed)
DB_CONNECTION=sqlite

# Mail Configuration (Gmail example)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Database Setup

```bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```

### 6. Storage Setup

```bash
# Create storage link for public file access
php artisan storage:link
```

### 7. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Start the Application

```bash
# Using Laravel's built-in server
php artisan serve

# Or using Laravel Herd (recommended for local development)
# Just navigate to the project folder in your browser
```

Visit `http://localhost:8000` in your browser.

## 👥 Default Users

After seeding, you can log in with:

**Admin User:**
- Email: admin@student-marketplace.test
- Password: password

**Regular User:**
- Email: user@student-marketplace.test
- Password: password

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/      # Application controllers
│   ├── Models/                # Eloquent models
│   └── Providers/             # Service providers
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Stylesheets
│   └── js/                    # JavaScript files
├── routes/
│   ├── web.php               # Web routes
│   └── auth.php              # Authentication routes
└── public/
    └── storage/              # Public file storage (symlink)
```

## 🎨 Key Models

- **User**: Platform users with profiles and authentication
- **Listing**: Product listings with images, prices, and locations
- **Category**: Listing categories (Books, Electronics, Furniture, etc.)
- **Tag**: Flexible tagging system for listings
- **Conversation**: Chat conversations between users
- **Message**: Individual messages in conversations
- **NewsItem**: News and announcements
- **FaqCategory** & **FaqItem**: FAQ system
- **ContactMessage**: Contact form submissions

## 🔧 Configuration

### Email Setup

For Gmail SMTP:
1. Enable 2-factor authentication on your Google account
2. Generate an App Password at https://myaccount.google.com/apppasswords
3. Use the App Password in `MAIL_PASSWORD` in `.env`

### Queue Configuration

For production, configure a queue driver (Redis recommended):

```env
QUEUE_CONNECTION=redis
```

Then run the queue worker:

```bash
php artisan queue:work
```

### File Storage

Images are stored in `storage/app/public` and symlinked to `public/storage`. Ensure proper permissions:

```bash
chmod -R 775 storage bootstrap/cache
```

## 🌐 Usage

### Creating a Listing
1. Register/Login to your account
2. Click "Create Listing" in the header
3. Fill in title, description, price, category, and location
4. Upload an image (optional)
5. Add tags for better discoverability
6. Submit to publish

### Managing Listings
- **Edit**: Update listing details anytime
- **Delete**: Remove listings you no longer need
- **Mark as Sold**: Indicate when an item is sold
- **Mark as Reserved**: Show when an item is reserved for someone
- **Feature**: Admins can feature listings on the homepage

### Messaging
- Click "Contact Seller" on any listing
- Start a conversation directly with the seller
- Receive notifications for new messages
- View all conversations in your inbox

### Admin Panel
Access the admin panel at `/admin` (requires admin privileges):
- View comprehensive statistics
- Manage all users and listings
- Moderate contact messages
- Manage news and FAQs

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com)
- UI components from [Tailwind CSS](https://tailwindcss.com)
- Icons by [Heroicons](https://heroicons.com)
- Inspired by [2dehands.be](https://www.2dehands.be)

## 📧 Support

For support, email support@student-marketplace.test or create an issue in the repository.

---

Made with ❤️ for students, by students

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
