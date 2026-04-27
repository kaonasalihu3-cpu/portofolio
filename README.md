# KAONA SALIHU - Full Stack College Project

Complete PHP + MySQL project with:

- Public website pages (Home, About, Products, News, Contact)
- Authentication (Register/Login/Logout)
- Role-based access (`admin`, `user`)
- Admin dashboard with CRUD
- Contact messages stored in database
- OOP PHP architecture with PDO prepared statements
- Frontend + backend validation
- File uploads (image + optional PDF)

## 1) Requirements

- PHP 8+
- Apache (XAMPP or Laragon)
- MySQL/MariaDB

## 2) Project Placement

Place the folder in web root:

- XAMPP: `C:\xampp\htdocs\kaona-salihu-project`
- Laragon: `C:\laragon\www\kaona-salihu-project`

## 3) Database Setup

1. Create/import schema:
   - Open phpMyAdmin
   - Import: `database/schema.sql`
2. Seed data:
   - Import: `database/seed.sql`

This creates database `kaona_salihu_db`.

## 4) Configure DB Credentials

Edit file: `config/config.php`

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'kaona_salihu_db');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Environment/Debug Mode

`config/config.php` supports two optional environment variables:

- `APP_ENV=development` or `APP_ENV=production`
- `APP_DEBUG=1` or `APP_DEBUG=0` (overrides `APP_ENV` behavior)

Default behavior:

- `development` => errors are shown
- `production` => errors are hidden, but still logged by PHP

## 5) Default Accounts

- Admin
  - Email: `admin@kaona.local`
  - Password: `password`
- User
  - Email: `user@kaona.local`
  - Password: `password`

## 6) Run Locally

Open in browser:

- `http://localhost/kaona-salihu-project/`

Admin dashboard:

- `http://localhost/kaona-salihu-project/admin/dashboard.php`

## 7) Uploads

Uploaded files are saved in:

- `assets/uploads/images`
- `assets/uploads/pdf`

Accepted file types:

- Images: `jpg`, `jpeg`, `png`, `webp`
- PDF: `pdf`

## 8) Security Implemented

- `password_hash` / `password_verify`
- PDO prepared statements
- Session-based authentication
- Admin role guard
- Backend validation on forms
- Frontend JavaScript validation
- Upload type and size checks

## 9) Suggested Git Milestones

1. Project structure
2. Database schema + seed
3. Config and DB classes
4. Includes and layout
5. Auth and role protection
6. Public dynamic pages
7. Admin dashboard
8. CRUD implementation
9. Validation and uploads
10. Responsive polish and documentation

## 10) Implemented Pages

Public:

- `index.php`
- `about.php`
- `products.php`
- `product-details.php`
- `news.php`
- `news-details.php`
- `contact.php`
- `login.php`
- `register.php`
- `logout.php`

Admin:

- `admin/dashboard.php`
- `admin/users.php`
- `admin/messages.php`
- `admin/content.php`
- `admin/edit-content.php`
- `admin/products.php`
- `admin/create-product.php`
- `admin/edit-product.php`
- `admin/delete-product.php`
- `admin/news.php`
- `admin/create-news.php`
- `admin/edit-news.php`
- `admin/delete-news.php`
- `admin/logout.php`

## 11) Validation Coverage

- Frontend JS:
  - contact form validation
  - login/register validation
  - admin create/edit form validation
- Backend PHP:
  - auth validation
  - contact validation
  - content/product/news validation
  - CSRF checks for destructive admin actions

## 12) Collaborator Push Workflow

Use repository-level identity before pushing:

```bash
git config user.name "kaonasalihu3-cpu"
git config user.email "kaonasalihu3@gmail.com"
```

or:

```bash
git config user.name "olisashabani1"
git config user.email "olisashabani06@gmail.com"
```

Push command used in this project:

```bash
git push https://github.com/kaonasalihu3-cpu/portofolio.git main:main
```

## 13) Troubleshooting

- If SSH remote fails with `Permission denied (publickey)`, verify the correct SSH key is added to the matching GitHub account.
- If admin pages redirect, confirm you are logged in as an `admin` role user.
- If dynamic content does not load, verify DB credentials in `config/config.php` and re-import `database/schema.sql` + `database/seed.sql`.
