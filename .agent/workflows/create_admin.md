---
description: How to create an admin account using Seeders
---

1. Open your terminal.
2. Run the following command to seed the admin user:
// turbo
   `php artisan db:seed --class=AdminSeeder`

3. The admin account will be created with the following credentials:
   - **Email**: `admin@bimba.com`
   - **Password**: `password`
   - **Role**: `admin`

4. You can login at `/login`.
