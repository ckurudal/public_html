# Copilot Instructions

## Project Overview
This is a PHP-based Turkish real estate (emlak) web application. It includes a front-end theme system, an admin panel, and a database-driven backend.

## Tech Stack
- **Language**: PHP (procedural style with PDO for database access)
- **Database**: MySQL (accessed via PDO; legacy `mysql_*` functions also present in older files)
- **Frontend**: HTML, CSS, JavaScript (Bootstrap 3, AdminLTE, jQuery)
- **Architecture**: Theme-based front end (`/tema`), admin panel (`/admin`), shared system utilities (`/sistem`)

## Coding Conventions
- PHP files use UTF-8 encoding and typically start with `<?php`.
- Database queries use PDO prepared statements where possible. Avoid raw string interpolation in SQL queries to prevent SQL injection.
- Session handling is started in `sistem/baglan.php` via `session_start()`.
- Constants such as `PATH`, `URL`, `RESIM`, and `RESIMLER` are defined in `sistem/baglan.php` and should be used throughout the codebase.
- Template/theme files live under `/tema/<theme-name>/`. Each theme has its own `index.php` and supporting files.
- Admin functionality lives under `/admin/`. Admin pages follow the AdminLTE layout pattern.
- Turkish is the primary language of the UI. Keep user-facing strings in Turkish unless adding a new internationalization layer.

## Security Considerations
- Always use PDO prepared statements or parameterized queries — never interpolate user input directly into SQL strings.
- Sanitize and validate all user input before use.
- Avoid exposing database credentials or sensitive configuration in code or logs.
- Do not output raw PHP error messages to end users (`error_reporting(0)` is set for production).

## File Structure
```
/admin          - Admin panel pages and assets
/images         - Static image assets
/sistem         - Core system files (DB connection, utilities, functions)
/tema           - Front-end themes
/uploads        - User-uploaded files
index.php       - Main entry point; handles theme selection and routing
404.php         - Custom 404 error page
sitemap.php     - XML sitemap generator
```

## Testing
There is no automated test suite in this repository. Validate changes manually by loading the relevant pages in a browser connected to a MySQL database with the expected schema.
