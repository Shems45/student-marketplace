# Student Marketplace

A marketplace website for students to buy and sell study materials, textbooks, electronics, furniture, and more. Think 2dehands.be but specifically for students. Built with Laravel 12 for the Web Development 2 course.

## What This Project Does

This is a marketplace platform where students can:
- Post items they want to sell with photos, prices, and descriptions
- Browse and search for items by category, tags, location, and price
- Message sellers directly through the platform
- Save favorite listings to view later
- See how far away items are based on location

Admins can:
- Manage all listings, users, and content through an admin panel
- Post news updates and manage FAQs
- Respond to contact form submissions
- View platform statistics on the dashboard

## Tech Stack

- Laravel 12.x with PHP 8.4
- SQLite database (can be changed to MySQL/PostgreSQL if needed)
- Tailwind CSS for styling
- Laravel Breeze for authentication
- Heroicons for icons
- Vite for asset bundling

## Requirements

Before you start, make sure you have:
- PHP 8.2 or higher
- Composer
- Node.js (version 18 or higher) and npm
- Git

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/Shems45/student-marketplace.git
cd student-marketplace
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Set Up Environment

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Your Environment

Open the `.env` file and check these settings:

```env
APP_NAME="Student Marketplace"
APP_URL=http://localhost:8000

# Database - SQLite is already configured by default
DB_CONNECTION=sqlite

# Mail - For contact form emails
# Using public Gmail account for development/testing:
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=u3503098154@gmail.com
MAIL_PASSWORD=fhkz ymop ozuo dgfa
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=u3503098154@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** If you don't configure email, the contact form will still work but won't send emails. For testing, you can check the log files in `storage/logs/`.

### 5. Set Up the Database

```bash
# Create the SQLite database file
touch database/database.sqlite

# Run migrations to create all tables
php artisan migrate

# Seed the database with example data
php artisan db:seed
```

**Important:** The seeder will create the required admin account and some sample listings/users.

### 6. Link Storage

```bash
# Create symbolic link for file uploads
php artisan storage:link
```

### 7. Build Frontend Assets

```bash
# For development (watches for changes)
npm run dev

# OR for production (one-time build)
npm run build
```

### 8. Start the Application

```bash
# Start Laravel's built-in development server
php artisan serve
```

Now open your browser and go to `http://localhost:8000`

**If you're using Laravel Herd:** Just navigate to the project folder in your browser (e.g., `http://student-marketplace.test`)

## Login Credentials

After running the seeder, you can log in with these accounts:

**Admin Account (required by assignment):**
- Email: `admin@ehb.be`
- Password: `Password!321`

**Regular User Accounts (for testing):**
- Email: `alice@student.ehb.be` / Password: `password`
- Email: `bob@student.ehb.be` / Password: `password`
- Email: `claire@student.ehb.be` / Password: `password`

## Project Features

### For Regular Users
- Create an account and log in
- Edit your profile with username, birthday, profile photo, and bio
- Post listings with photos, categories, tags, and location
- Search for listings by category, tags, location, and price
- Message sellers directly
- Save favorite listings
- View your own listings and conversations

### For Admins
- Access admin panel at `/admin`
- Manage all users (create users, make users admin, remove admin rights)
- Manage all listings
- Post and manage news items
- Manage FAQ categories and items
- View and respond to contact form messages
- See platform statistics on dashboard

## Assignment Requirements Coverage

This project fulfills all the assignment requirements:

**Login System:**
- ✅ Visitors can log in
- ✅ Anyone can create a new account
- ✅ User accounts are either regular users or admins
- ✅ Only admins can promote/demote other users
- ✅ Only admins can manually create new users

**Profile Pages:**
- ✅ Every user has a public profile page accessible to everyone
- ✅ Users can edit their own profile
- ✅ Profiles include: username, birthday, profile photo, and bio

**News Section:**
- ✅ Admins can create, edit, and delete news items
- ✅ Everyone can view a list of news and individual news details
- ✅ News items have: title, image, content, and publication date

**FAQ Page:**
- ✅ FAQs are grouped by category
- ✅ Admins can manage categories and FAQ items
- ✅ Everyone can view the FAQ page

**Contact Page:**
- ✅ Anyone can fill in a contact form
- ✅ Submitting the form sends an email to the admin
- ✅ Admins can view and respond to messages in the admin panel

**Extra Features (for higher grade):**
- ✅ Real-time messaging system between buyers and sellers
- ✅ Favorites/bookmarking system
- ✅ Advanced search with multiple filters
- ✅ Location-based features with distance calculations
- ✅ Admin dashboard with statistics
- ✅ Image uploads for listings and profiles

**Technical Requirements:**
- ✅ Multiple layouts (public layout and admin layout)
- ✅ Reusable Blade components
- ✅ CSRF protection on all forms
- ✅ XSS protection (Blade automatic escaping)
- ✅ Client-side validation (HTML5 validation attributes)
- ✅ All routes use controller methods
- ✅ Proper middleware usage (auth, admin)
- ✅ Grouped routes
- ✅ Resource controllers for CRUD operations
- ✅ Eloquent models for all entities
- ✅ One-to-many relationships (User→Listings, Category→Listings, etc.)
- ✅ Many-to-many relationships (Listing↔Tags, User↔Listings for favorites)
- ✅ Migrations and seeders work with `php artisan migrate:fresh --seed`
- ✅ Default admin account (admin@ehb.be / Password!321)
- ✅ Authentication system with login, logout, register, remember me, password reset## Database Models and Relationships

**Models:**
- User - User accounts with authentication
- Listing - Items posted for sale
- Category - Categories for listings (Books, Electronics, etc.)
- Tag - Tags for better listing discoverability
- Conversation - Chat conversations between users
- Message - Individual chat messages
- NewsItem - News posts created by admins
- FaqCategory - FAQ categories
- FaqItem - Individual FAQ questions and answers
- ContactMessage - Messages sent through contact form

**Relationships:**
- One-to-Many: User → Listings, User → News Items, Category → Listings, Conversation → Messages
- Many-to-Many: Listing ↔ Tags, User ↔ Listings (favorites table)

## File Structure

```
app/
├── Http/
│   ├── Controllers/          # All controllers (resource controllers for CRUD)
│   │   ├── Admin/           # Admin panel controllers
│   │   └── Auth/            # Authentication controllers
│   ├── Middleware/          # Custom middleware (AdminMiddleware)
│   └── Requests/            # Form request validation
├── Models/                  # Eloquent models
├── Policies/                # Authorization policies
└── Mail/                    # Mailable classes

resources/
├── views/
│   ├── components/          # Reusable Blade components
│   │   ├── layouts/         # Layout components (public, admin)
│   │   └── ui/              # UI components
│   ├── admin/               # Admin panel views
│   ├── listings/            # Listing views
│   ├── profiles/            # Profile views
│   ├── news/                # News views
│   ├── faq/                 # FAQ views
│   └── contact/             # Contact form views
├── css/                     # Tailwind CSS
└── js/                      # JavaScript files

routes/
├── web.php                  # Main routes (grouped with middleware)
└── auth.php                 # Authentication routes (Laravel Breeze)

database/
├── migrations/              # Database structure
└── seeders/                 # Sample data (includes required admin)
```

## Common Issues and Solutions

**Problem:** `npm run dev` fails
- **Solution:** Make sure you ran `npm install` first

**Problem:** Images don't show up
- **Solution:** Run `php artisan storage:link` to create the symbolic link

**Problem:** Database errors when running migrations
- **Solution:** Make sure the `database/database.sqlite` file exists. Run `touch database/database.sqlite` on Mac/Linux or create an empty file on Windows.

**Problem:** Contact form doesn't send emails
- **Solution:** Make sure you configured the mail settings in `.env`. For local testing, emails are logged in `storage/logs/laravel.log`

**Problem:** "Access denied" when trying to access admin panel
- **Solution:** Make sure you're logged in with the admin account (`admin@ehb.be`)

## Sources and References

During development, I used the following resources:

- Laravel documentation: https://laravel.com/docs
- Tailwind CSS documentation: https://tailwindcss.com/docs
- Stack Overflow for troubleshooting specific issues
- Laravel Breeze documentation for authentication setup
- Heroicons for icon components: https://heroicons.com
- Course materials and exercises from Web Development 2

Specific code snippets adapted from:
- Haversine formula for distance calculation between coordinates (from Stack Overflow)
- Belgian city/postal code autocomplete logic (custom implementation)
- Email notification setup (Laravel documentation)

All adapted code was understood, modified for this project, and properly tested.

## Notes

This project was built for the Web Development 2 course at Erasmushogeschool Brussel. Tailored specifically for student needs (textbooks, electronics, furniture, etc.).

The project uses SQLite by default for ease of setup, but can be easily switched to MySQL or PostgreSQL by changing the database configuration in `.env`.

All images uploaded by users are stored in `storage/app/public` and linked to `public/storage` for web access.

## License

This project is open-source and available under the MIT License.
