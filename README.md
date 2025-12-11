# HaulHaus - E-Commerce Bag Store

A full-featured e-commerce web application built with Laravel for selling trendy bags. This project includes a complete admin panel, user authentication, shopping cart, order management, product reviews, and RESTful APIs.

## Project Overview

HaulHaus is an online bag store that allows customers to browse products by category (Tote Bags, Backpacks, Cross Body Bags, Hobo Bags), add items to cart, place orders, and submit reviews with images. The application features a comprehensive admin panel for managing products, categories, orders, and customer contacts.

### Key Features

- **User Authentication**: Registration, login, and profile management
- **Product Management**: CRUD operations for products with categories
- **Shopping Cart**: Add, update, and remove items
- **Order Management**: Complete order processing with payment methods
- **Product Reviews**: Users can submit reviews with ratings and images
- **AJAX Search**: Real-time product search functionality
- **RESTful APIs**: Complete API endpoints for products, categories, reviews, and orders
- **Admin Panel**: Full administrative interface for managing all aspects of the store
- **Responsive Design**: Mobile-friendly interface

## Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Bootstrap 5, JavaScript (Vanilla), CSS
- **Database**: MySQL (configurable)
- **Authentication**: Laravel Sanctum (for API)

## Project Structure

```
haulhaus/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── Api/             # API controllers
│   │   └── frontend/        # Frontend controllers
│   ├── Models/              # Eloquent models
│   └── Middleware/          # Custom middleware
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   └── views/
│       ├── admin/           # Admin panel views
│       └── frontend/        # Frontend views
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API routes
└── public/
    └── frontend/            # Public assets (images, CSS)
```

## Setup Instructions

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js and NPM (for frontend assets)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd haulhaus
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=haulhaus
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Create admin user**
   ```bash
   php artisan make:admin
   ```
   Or follow instructions in `MAKE_ADMIN.md`

9. **Build frontend assets**
   ```bash
   npm run build
   ```
   Or for development:
   ```bash
   npm run dev
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```

11. **Access the application**
    - Frontend: http://localhost:8000
    - Admin Panel: http://localhost:8000/admin/products (login required)

## Database Migrations

The project includes migrations for all modules:

- `users` - User authentication
- `products` - Product catalog
- `categories` - Product categories
- `reviews` - Product reviews with images
- `orders` - Customer orders
- `contacts` - Contact form submissions

Run migrations:
```bash
php artisan migrate
```

## Usage Guide

### For Customers

1. **Browse Products**
   - Visit the shop page to see all products
   - Use the search bar in the navbar for quick product search
   - Filter by category using the Shop dropdown menu

2. **Add to Cart**
   - Click on any product to view details
   - Click "Add To Cart" button
   - View cart by clicking the cart icon in navbar

3. **Checkout**
   - Go to cart page
   - Review items and quantities
   - Proceed to checkout
   - Fill in shipping details and select payment method
   - Confirm order

4. **Submit Reviews**
   - View product details
   - Fill in review form (name, rating, comment)
   - Optionally upload an image
   - Submit review (preview appears before submission)

5. **View Orders**
   - Login to your account
   - Navigate to "My Orders" from user menu
   - View order details and status

### For Administrators

1. **Access Admin Panel**
   - Login with admin credentials
   - Click "Admin Panel" in navbar

2. **Manage Products**
   - View all products at `/admin/products`
   - Create new products with image upload
   - Edit existing products
   - Delete products
   - Search products using AJAX search

3. **Manage Categories**
   - View all categories at `/admin/categories`
   - Create, edit, and delete categories

4. **Manage Orders**
   - View all orders at `/admin/orders`
   - View order details
   - Update order status
   - Delete orders

5. **Manage Contacts**
   - View contact form submissions at `/admin/contacts`
   - View and delete messages

## API Documentation

The application provides RESTful APIs for accessing data. All API endpoints are prefixed with `/api`.

### Products API

- `GET /api/products` - Get all products
- `GET /api/products/{id}` - Get specific product
- `GET /api/products/category/{category}` - Get products by category

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Product Name",
      "category": "tote",
      "price": "2500.00",
      "image": "product.jpg",
      "description": "Product description",
      "reviews": []
    }
  ],
  "message": "Products retrieved successfully"
}
```

### Categories API

- `GET /api/categories` - Get all categories
- `GET /api/categories/{id}` - Get specific category with products

### Reviews API

- `GET /api/reviews` - Get all reviews
- `GET /api/reviews/product/{productId}` - Get reviews for a product
- `GET /api/reviews/{id}` - Get specific review

### Orders API

- `GET /api/orders` - Get all orders (or user's orders if authenticated)
- `GET /api/orders/{id}` - Get specific order by ID

**Authentication:** 
- If user is logged in via web session, returns only their orders
- If not authenticated, returns all orders (useful for testing/demo purposes)

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "order_number": "ORD-2025-001",
      "user_id": 1,
      "items": [...],
      "total_amount": "5000.00",
      "status": "pending",
      "created_at": "2025-01-15T10:30:00.000000Z"
    }
  ],
  "message": "Orders retrieved successfully"
}
```

## Relationships

The project implements the following Eloquent relationships:

1. **Product → Reviews** (One-to-Many)
   - A product can have many reviews
   - Defined in `Product` model: `hasMany(Review::class)`

2. **Review → Product** (Many-to-One)
   - A review belongs to one product
   - Defined in `Review` model: `belongsTo(Product::class)`

3. **Review → User** (Many-to-One)
   - A review belongs to one user (optional)
   - Defined in `Review` model: `belongsTo(User::class)`

## CRUD Operations

### Products
- ✅ Create: `/admin/products/create`
- ✅ Read: `/admin/products` and `/admin/products/{id}`
- ✅ Update: `/admin/products/{id}/edit`
- ✅ Delete: `/admin/products/{id}` (DELETE)

### Categories
- ✅ Create: `/admin/categories/create`
- ✅ Read: `/admin/categories` and `/admin/categories/{id}`
- ✅ Update: `/admin/categories/{id}/edit`
- ✅ Delete: `/admin/categories/{id}` (DELETE)

### Orders
- ✅ Read: `/admin/orders` and `/admin/orders/{id}`
- ✅ Update Status: `/admin/orders/{id}/status` (PATCH)
- ✅ Delete: `/admin/orders/{id}` (DELETE)

### Contacts
- ✅ Read: `/admin/contacts` and `/admin/contacts/{id}`
- ✅ Delete: `/admin/contacts/{id}` (DELETE)

## AJAX Features

1. **Product Search** (Navbar)
   - Real-time search as you type
   - Shows product images and details
   - Click to navigate to product page
   - Endpoint: `/shop/search`

2. **Admin Product Search**
   - AJAX search in admin panel
   - Filters products dynamically
   - Endpoint: `/admin/products/search`

3. **Review Submission**
   - AJAX form submission
   - Dynamic review display
   - Image preview before submission

## Code Quality

- Clean, well-commented code following Laravel best practices
- Separation of concerns (Controllers, Models, Views)
- Reusable components and traits
- Proper error handling and validation
- Security measures (CSRF protection, authentication middleware)

## Frontend Standards

- All links are functional and tested
- No dead or disabled links
- Clean, polished user interface
- Responsive design for mobile and desktop
- Consistent styling throughout

## Git Repository

The repository should contain:
- Complete project code
- At least 2 branches (e.g., `main` and `develop`)
- Proper `.gitignore` file
- All migrations and seeders

## Testing

Run tests:
```bash
php artisan test
```

## Security Features

- CSRF protection on all forms
- Authentication middleware for protected routes
- Admin-only access for admin panel
- Input validation and sanitization
- SQL injection prevention (Eloquent ORM)

## License

This project is proprietary and created for educational purposes.

## Support

For issues or questions, please contact the development team.

---

**Note**: Make sure to configure your `.env` file properly before running the application. The database must be created and migrations must be run before accessing the application.
