# Copilot Instructions

## Project Overview

This is a PHP-based real estate listing web application (Emlak/Kobi Emlak Scripti) with an admin panel. The application is in Turkish and serves as a property listing and management platform.

## Repository Structure

- `index.php` — Main entry point; handles theme loading and routing
- `admin/` — Admin panel (dashboard, property management, user management, settings)
- `sistem/` — Core system files:
  - `baglan.php` — Database connection (MySQL via both legacy `mysql_*` and PDO)
  - `fonksiyon.php` — Shared helper functions
  - `sistem.php` — System initialization (includes `fonksiyon.php`)
  - `PHPMailer/` — Email sending library
  - `verot/` — File upload library (`class.upload.php`)
- `tema/` — Front-end themes (each sub-directory is a theme, e.g. `tema139/`)
- `uploads/` — User-uploaded files (images, etc.)
- `images/` — Static image assets
- `sitemap.php` — XML sitemap generator
- `404.php` — Custom 404 error page

## Tech Stack

- **Backend:** PHP (no framework), MySQL database
- **Database access:** PDO (preferred) and legacy `mysql_*` functions
- **Frontend:** Bootstrap 3, AdminLTE (admin panel), jQuery, Font Awesome
- **Email:** PHPMailer
- **File uploads:** Verot upload library

## Coding Conventions

- Use PDO with prepared statements for all new database queries to prevent SQL injection.
- The existing codebase uses `$vt` as the PDO connection variable (defined in `sistem/baglan.php`).
- The `mysql_*` functions are deprecated since PHP 5.5, removed in PHP 7.0+, and **must not be used in any new code**.
- Input sanitization: use `htmlspecialchars`, `strip_tags`, `stripslashes`, and `trim` on user input where appropriate.
- PHP files should start with `<?php` (no closing `?>` tag in pure PHP files).
- Existing code uses Turkish variable names and comments in places — maintain consistency with surrounding code.
- Admin panel pages should include `../sistem/baglan.php` and `../sistem/fonksiyon.php` at the top.
- Theme files live under `tema/<theme-name>/` and are loaded dynamically via `index.php`.

## Security Notes

- Always use PDO prepared statements for queries involving user input — never interpolate `$_GET`/`$_POST` variables directly into SQL strings.
- Avoid using deprecated `mysql_*` functions in new code; use PDO instead.
- Session handling is started in `baglan.php` via `session_start()`.
- Admin access is controlled by `$_SESSION["id"]` and the `yonetici` table.

## Database

- Primary connection variables: `$vt` (PDO — use this for all new code), `$baglan` (legacy mysql link — do not use in new code)
- Key tables include: `ayarlar` (site settings), `ayar_tema` (theme settings), `yonetici` (admin users), `odeme_paytr` (payment settings)
