# Copilot Instructions

## Repository Overview

This is a PHP-based real estate listing platform (emlak scripti) with a multi-theme front end and an AdminLTE-based administration panel.

## Tech Stack

- **Backend:** PHP (procedural + PDO for database access; some legacy `mysql_*` functions remain)
- **Database:** MySQL (UTF-8, `emlakbudur_joker` schema)
- **Frontend:** Bootstrap 3, jQuery 3, AdminLTE 2
- **Plugins:** Plupload (file uploads), CKEditor, Froala Editor, Select2, DataTables, iCheck
- **Email:** PHPMailer (`sistem/PHPMailer/`)

## Project Structure

| Path | Purpose |
|------|---------|
| `index.php` | Application entry point – routes requests and loads the active theme |
| `sistem/baglan.php` | Database connection and global constants (`PATH`, `URL`, `RESIM`, etc.) |
| `sistem/sistem.php` | Bootstraps helper functions via `fonksiyon.php` |
| `sistem/fonksiyon.php` | Shared utility functions |
| `tema/` | Front-end themes; each subdirectory is a self-contained theme |
| `admin/` | Back-office panel (AdminLTE); contains its own `bower_components` and `dist` assets |
| `uploads/` | User-uploaded files (images, etc.) |
| `sistem/verot/` | `class.upload.php` file-upload helper |

## Development Guidelines

- Always use **PDO prepared statements** for new database queries; avoid raw string interpolation into SQL to prevent SQL injection.
- Avoid using deprecated `mysql_*` functions in new code; use PDO instead.
- Follow the existing file-include pattern: load `sistem/baglan.php` first, then `sistem/sistem.php`.
- Theme files live under `tema/<theme-name>/` and are loaded dynamically based on `ayarlar.tema_url`.
- Keep admin assets (CSS/JS) under `admin/bower_components/` or `admin/dist/`; do not mix them with theme assets.
- Use UTF-8 for all new files and set `charset=utf8` on every new PDO connection.
- Error reporting is suppressed in production (`error_reporting(0)`); enable it locally for debugging.
- The timezone is set to `Europe/Istanbul`.

## Testing

There is no automated test suite. Validate changes manually by:
1. Verifying database queries execute without errors.
2. Checking page output in a browser with a local MySQL instance seeded from `emlakbudur_joker.sql`.
3. Confirming the admin panel (`/admin`) remains functional after any back-end change.
