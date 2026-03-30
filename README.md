# Forestory

Local demo app for **tropical forest stand generation** and **selective-logging scenarios**. It builds a synthetic stand in MySQL, applies minimum-diameter harvest regimes (45–60 cm), models simple felling damage and 30-year growth, and exposes stand tables, maps, and production charts in the browser.

**Scope:** educational / portfolio / offline XAMPP use. This is not hardened for public hosting without further security work (prepared statements, auth, HTTPS, etc.).

## Stack

- PHP 8+ (uses `str_contains` and typed mysqli)
- MySQL / MariaDB (InnoDB)
- HTML, CSS, JavaScript (charts and maps)

## Requirements

- [XAMPP](https://www.apachefriends.org/) (or any Apache + PHP + MySQL stack)
- A MySQL database (default name `tree`) with the tables this app expects (`speciesnames`, `new_forest`, regime copies, damage tables, etc.). The repository does not ship a full SQL schema; import your own dump if you have one, or mirror structure from an existing install.

## Setup

1. Clone or copy the project under your web root, e.g. `htdocs/forestory`.
2. Create the MySQL database and tables (see your existing dump or team docs).
3. **Environment file**
   - Copy `.env.example` to `.env` in the project root.
   - Edit `.env` with your MySQL host, user, password, and database name.

   ```ini
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=
   DB_NAME=tree
   ```

   If `.env` is missing, the app falls back to the same defaults as above (typical local XAMPP).

4. Open the app in a browser, e.g. `http://localhost/forestory/index.html`.

## Configuration

| File | Role |
|------|------|
| `.env` | **Local only.** DB credentials; never commit (see `.gitignore`). |
| `.env.example` | Template for new clones; safe to commit. |
| `config/env.php` | Loads `.env` into `getenv()` / `$_ENV`. |
| `config/database.php` | `forestory_db_connect()` used across the PHP entry points. |

## Using the app (short)

1. **Generate New Forest** — populates `new_forest` and mirrors base columns into `new_forest_50`, `_55`, `_60`.
2. **Select Regime** — runs calculation (and follow-on scripts) for regime 45 / 50 / 55 / 60.
3. Explore **Stand Table**, **Final Output**, **Distribution** plots, and **Production Chart** from the sidebar.

## GitHub checklist

- [x] `.env` ignored; `.env.example` committed.
- [x] No database passwords in tracked PHP files.
- [ ] Add a SQL schema or migration when you have one to share.
- [ ] Optional: replace remaining dynamic SQL with prepared statements for production-style hardening.

## License

This project is released under the [MIT License](LICENSE). Replace “Forestory contributors” in the license file with your name if you prefer.
