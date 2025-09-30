# Longhair Records — Ecommerce Website

A custom WordPress + WooCommerce codebase for the Longhair Records online store. This repo contains the primary theme and the Square integration plugin. Note: WooCommerce itself is not tracked in this repository (install it separately from WordPress.org).

**Current Version**: v2.0.3

## Repository layout

- **themes/longhairrecords**: Primary site theme (templates, CSS/JS, includes)
- **plugins/woocommerce-square**: Square integration plugin (included)
- **docs/**: Operational notes and runbooks
  - **docs/TODO.md**: Current implementation and operations checklist
  - **docs/Sync_Fix_Gameplan.md**: Sync troubleshooting plan
  - **docs/Server_Maintenance.md**: Server and environment maintenance notes
- **WooCommerce plugin (not tracked)**: Install via WP Admin → Plugins → Add New → "WooCommerce"

## Screenshots / Preview

- Main theme preview:

  ![Theme screenshot](docs/imgs/screenshot.png)
- To add more previews, place images in `docs/imgs/` and reference them here like so:

  ```markdown
  ![Product grid](docs/imgs/product-grid.png)
  ```

## Prerequisites

- WordPress 6.x
- PHP 8.0+ (8.1+ recommended)
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Nginx or Apache)

## Getting started (local)

This repo mirrors a typical `wp-content` structure. Use one of the approaches below.

### Option A: Use this repo as your `wp-content`

1. Create a fresh local WordPress site (LocalWP, Docker, or LAMP/WAMP).
2. Replace the site’s `wp-content` with this repo (or clone this repo into that path).
3. In WP Admin → Plugins:
   - Install and activate WooCommerce (from WordPress.org).
   - Activate WooCommerce Square (from this repo).
4. In WP Admin → Appearance → Themes, activate the `Longhair Records` theme.
5. Visit Settings → Permalinks and click Save to flush rewrite rules.

### Option B: Copy into an existing site

1. Copy `themes/longhairrecords` → `<your-site>/wp-content/themes/`.
2. Copy `plugins/woocommerce-square` → `<your-site>/wp-content/plugins/`.
3. In WP Admin → Plugins: install and activate WooCommerce (from WordPress.org).
4. Activate the theme and Square plugin via WP Admin and flush permalinks.

### Option C: LocalWP (recommended for speed)

1. Create a new site in LocalWP.
2. Open the site folder → `app/public/wp-content/`.
3. Copy:
   - `themes/longhairrecords` → `wp-content/themes/`
   - `plugins/woocommerce-square` → `wp-content/plugins/`
4. Start the site, then in WP Admin → Plugins: install and activate WooCommerce. Activate the Square plugin and theme.

### Option D: Docker (docker-compose)

Use Docker to spin up WordPress + DB and mount this repo’s theme and Square plugin.

```yaml
# docker-compose.yml
version: "3.8"
services:
  db:
    image: mariadb:10.6
    environment:
      MYSQL_DATABASE: wordpress
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpress
      MYSQL_ROOT_PASSWORD: root
    volumes:
      - db_data:/var/lib/mysql

  wordpress:
    image: wordpress:6-php8.1-apache
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
      WORDPRESS_DB_NAME: wordpress
      WP_DEBUG: "true"
    depends_on:
      - db
    volumes:
      - ./themes/longhairrecords:/var/www/html/wp-content/themes/longhairrecords
      - ./plugins/woocommerce-square:/var/www/html/wp-content/plugins/woocommerce-square

volumes:
  db_data:
```

- Start: `docker compose up -d`
- Open: http://localhost:8080
- In WP Admin → Plugins: install and activate WooCommerce. Then activate the Square plugin and theme.

### Option E: wp-env (@wordpress/env)

Lightweight Docker-based local dev managed by the WordPress toolchain.

1. Install: `npm i -g @wordpress/env`
2. Create a `wp-env.json` at repo root:

   ```json
   {
     "core": "latest",
     "plugins": [
       "./plugins/woocommerce-square"
     ],
     "themes": [
       "./themes/longhairrecords"
     ],
     "port": 8888,
     "config": {
       "WP_DEBUG": true
     }
   }
   ```
3. Start: `wp-env start`
4. Open: http://localhost:8888
5. In WP Admin → Plugins: install and activate WooCommerce. Then activate the Square plugin and theme.

## Square integration quick-start

- **System of Record**: Square
- **Match by SKU**: On
- **Update existing products**: Enabled
- **Sync direction**: Square → Woo (initial full import)
- **Batch size/Throttle**: 50–100 items per request (if available in your version)
- Perform a pilot import (e.g., 500 items), verify products, images, stock, and logs.
- If the pilot succeeds, run a full import and monitor a single continuous Square log.

Details and the full checklist: see `docs/TODO.md`.

## Development notes

- Prefer WooCommerce hooks/filters and theme functions for customizations instead of editing Woo templates directly.
- Consider creating a child theme for long-term overrides to minimize updates to the parent theme.
- When WooCommerce or the Square plugin is updated, verify compatibility with the theme and re-run the Square sync pilot.

## Contributor guide / Coding standards

- **Standards**: Follow WordPress Coding Standards (WPCS) for PHP; eslint/prettier for JS; stylelint for CSS if available.
- **PHPCS + WPCS**:
  1. Install PHPCS and WPCS (global example):
     ```bash
     composer global require squizlabs/php_codesniffer wp-coding-standards/wpcs
     phpcs --config-set installed_paths ~/.composer/vendor/wp-coding-standards/wpcs
     ```
  2. Run on theme:
     ```bash
     phpcs --standard=WordPress --extensions=php --colors themes/longhairrecords
     ```
- **Git workflow**:
  - Create feature branches from `main`: `feat/*`, `fix/*`, `chore/*`.
  - Use small, focused PRs; include screenshots for UI changes.
  - Write clear commit messages (Conventional Commits encouraged):
    - `feat(theme): add mobile menu toggle animation`
    - `fix(square): prevent duplicate SKU syncs`
- **PHP tips**:
  - Escape, sanitize, and validate per WP guidelines (`esc_html`, `sanitize_text_field`, `wp_verify_nonce`).
  - Prefer dependency-free solutions inside the theme when possible.
- **Assets**:
  - Keep images in `themes/longhairrecords/imgs/`.
  - Place JS/CSS in `themes/longhairrecords/js/` and `themes/longhairrecords/css/`.

## Operations

- Review server and PHP configuration guidance in `docs/Server_Maintenance.md`.
- Reference `docs/Sync_Fix_Gameplan.md` for sync debugging steps.

## Deployment

- Ensure environment config (PHP limits, memory, timeouts) is adequate for bulk sync operations.
- Confirm email delivery is configured (AWS SES / WP Offload SES) before going live.
- Monitor WooCommerce and Square logs after deployments.

## License

Private repository — all rights reserved. Contact the site owner for questions about usage and distribution.

## Contact

For access requests, deployment help, or operational support, contact the Longhair Records web team.

