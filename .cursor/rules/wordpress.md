# WordPress / PHP rules (Lubben Vet)

## Standards

- Follow WordPress PHP coding standards: readable names, Yoda where WP core does, no short tags.
- Every PHP file: `defined( 'ABSPATH' ) || exit;` at the top after the file docblock when appropriate.
- **Sanitize, validate, escape:** `sanitize_*` / `wp_kses*` on input; `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post` on output. Never echo raw `$_GET`, `$_POST`, or DB fields.
- **Nonces and capabilities** for any write: `check_admin_referer` / `wp_nonce_field`, and `current_user_can` where relevant.
- Prefer WordPress APIs: `wp_remote_*`, transients, `wp_enqueue_*`, `get_theme_file_path`, etc.

## Theme structure

- `functions.php` is a manifest: `require_once` files from `inc/` only. Put logic in `inc/*.php`.
- Text domain: `lubben-vet`. All user-visible strings wrapped for translation where appropriate.
- **FSE note:** This theme uses classic templates (`header.php`, `footer.php`, etc.) per the build plan unless the plan explicitly migrates to full FSE.

## Forms & mail

- Gravity Forms markup may be filtered — use hooks documented in GF dev docs; do not edit plugin core.
- Assume `mail()` on Bluehost is unreliable; document SMTP for launch.

## Performance & security

- Enqueue scripts/styles with version constants or `filemtime` for cache busting when files change.
- No `eval`, no arbitrary `include` from user input. Query with `WP_Query` / blocks, not raw SQL unless unavoidable and then `$wpdb->prepare`.
