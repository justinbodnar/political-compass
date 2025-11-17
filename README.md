# Political Compass

This repository ships two ways to run the classic four-quadrant political compass quiz and reuses the same weighted prompts everywhere:

- **`compass.py`** — an interactive Python CLI that queries MySQL for prompts and renders a `political_compass.png` chart with Matplotlib.
- **`html/`** — a drop-in PHP site that reads `political_compass_question-weights.csv`, sanitizes every POST, validates CSRF tokens, and now emits hardened HTTP headers for browsers.
- **Data exports** — MySQL dump (`political-compass-question-weights.sql`) plus CSV versions (English + French) so either implementation can ingest identical weights.

## Python CLI quiz
1. Install requirements: `pip install -r requirements.txt`.
2. Import the schema: `mysql -u root -p -e "CREATE DATABASE political_compass;"` then `mysql -u root -p political_compass < political_compass_question-weights.sql`.
3. Update the credentials inside `compass.py`, run `python compass.py`, and read the coordinates plus generated PNG.

## Browser quiz (PHP)
1. Serve the folder locally: `php -S 0.0.0.0:8000 -t html` and visit <http://localhost:8000>.
2. Flip `$testing = false`/`true` in `html/index.php` while developing to allow blank submissions.
3. Each page enforces secure sessions, CSRF validation, strict input filtering, escaped output, and default security headers (`Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`).
4. The PHP implementation targets PHP 7.1+ (strict typing and `void` returns) and now gracefully falls back to the legacy session cookie API on PHP 7.2 and earlier whenever the PHP 7.3+ options-array signature is unavailable.

Everything else in the repo—CSV variants, SQL dump, and stylesheet assets—exists to support those two quiz front-ends.
