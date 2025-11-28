# How to Create/Update Admin User

## Quick Fix - Update Existing User to Admin

Run this command in your terminal:

```bash
php artisan tinker
```

Then paste this code:
```php
$user = App\Models\User::where('email', 'YOUR_EMAIL@example.com')->first();
$user->name = 'admin';
$user->save();
echo "User updated to admin!";
exit
```

Replace `YOUR_EMAIL@example.com` with your actual email address.

## Alternative: Create New Admin User

Run this command:
```bash
php artisan admin:create admin@example.com password123
```

Or run it interactively:
```bash
php artisan admin:create
```

## Manual Method via Tinker

1. Run: `php artisan tinker`
2. Execute:
```php
App\Models\User::create([
    'name' => 'admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('your_password'),
]);
```

## After Creating Admin User

1. Logout if you're currently logged in
2. Login with:
   - Username/Email: (the email you used)
   - Password: (the password you set)
3. The system will recognize you as admin because your name is "admin"
4. Access `/admin/products` to manage products



