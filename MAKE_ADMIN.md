# How to Create/Update Admin User

## Recommended Method

Run the seeder command:

```bash
php artisan db:seed --class=AdminSeeder
```

This will automatically create or update the admin user with the following credentials:
- **Username**: `admin`
- **Email**: `admin@haulhaus.com`
- **Password**: `12345678`

## Alternative: Console Command

You can also use the custom command which has been updated to use the same hardcoded credentials:

```bash
php artisan admin:create
```

## Important Notes

- You **cannot** register a new user with the name "admin" via the registration form. This is now blocked for security/consistency.
- The admin user is identified by the name "admin".
