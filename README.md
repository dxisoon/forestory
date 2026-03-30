# Forestory

A small web app for generating a synthetic forest in a database and running simple selective-logging scenarios. You pick a minimum cutting diameter (regimes 45–60 cm), and the app works out volumes, which trees are cut, rough damage from felling, and a simple 30-year growth step, then shows stand tables and charts.

It was built to run locally on XAMPP (Apache, PHP, MySQL), not as a public website.

## What you need

- XAMPP or similar (PHP 8+, MySQL).
- A MySQL database named `tree` (or change it) with the tables the project uses. There is no full SQL dump in this repo; I used a database set up for the assignment.

## How to run it

1. Put the folder under `htdocs` (or your web root).
2. Create the database and tables, or restore from a dump if you have one.
3. Copy `.env.example` to `.env` and set `DB_HOST`, `DB_USER`, `DB_PASSWORD`, and `DB_NAME`. If you skip `.env`, it defaults to `localhost`, `root`, empty password, and database `tree`.
4. In the browser, open something like `http://localhost/forestory/index.html`, then use **Generate New Forest** and **Select Regime** from the menu.

## Config files

- `.env` — your local database settings (not committed).
- `.env.example` — example only.
- `config/env.php` and `config/database.php` — load `.env` and open the MySQL connection.

## License

[MIT](LICENSE). You can change the copyright line in `LICENSE` to your own name if you want.
