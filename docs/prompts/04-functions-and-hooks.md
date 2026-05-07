# Prompt 04 — Functions, hooks, redirects & SEO

> **Goal:** Wire up the WordPress side of the theme — `after_setup_theme` registration, asset enqueuing, the legacy redirects, basic SEO `<head>` output, nav menu registration, and the helper functions the templates have been calling as TODOs.
>
> **Files Claude should create:**
>
> - `themes/lubben-vet/inc/setup.php`
> - `themes/lubben-vet/inc/enqueue.php`
> - `themes/lubben-vet/inc/nav-menus.php`
> - `themes/lubben-vet/inc/redirects.php`
> - `themes/lubben-vet/inc/seo.php`
> - `themes/lubben-vet/inc/helpers.php`
> - And updates to `functions.php` to require all of the above

---

## Prompt to paste

```
Prompt 04 of the build plan.

Goal: Move all the TODOs we left in earlier prompts into properly organized
inc/ files, wire up enqueuing, register menus, and ship the legacy redirects.

Read first:
- docs/01-information-architecture.md (the full redirects table — every
  legacy URL must resolve)
- docs/03-content-migration.md (SEO metadata table)
- The existing functions.php from prompt 01.

Create these files:

1. themes/lubben-vet/inc/setup.php
   - lubben_vet_setup() hooked to 'after_setup_theme':
     - load_theme_textdomain('lubben-vet', get_template_directory() . '/languages')
     - add_theme_support: 'title-tag', 'post-thumbnails',
       'html5' for search-form, comment-form, comment-list, gallery, caption,
       'responsive-embeds', 'editor-styles', 'align-wide', 'wp-block-styles'
     - add_editor_style('assets/css/editor.css')
     - add_image_size('lubben-hero', 1920, 900, true)
     - add_image_size('lubben-card', 800, 600, true)
   - Set the content width to 1140 via the $content_width global.

2. themes/lubben-vet/inc/enqueue.php
   - lubben_vet_enqueue_assets() hooked to 'wp_enqueue_scripts':
     - Enqueue assets/css/theme.css (handle 'lubben-vet-theme', version
       LUBBEN_VET_VERSION).
     - Enqueue assets/js/nav.js (handle 'lubben-vet-nav', deps [], version
       LUBBEN_VET_VERSION, in_footer true) — only if the file exists.
     - DO NOT enqueue jQuery. We don't need it.
   - lubben_vet_enqueue_block_editor_assets() hooked to 'enqueue_block_editor_assets':
     - Enqueue assets/css/editor.css. (Yes, theme.json + add_editor_style
       overlap; this third hook makes sure the editor iframe always picks up
       our latest editor styles when we're iterating.)

3. themes/lubben-vet/inc/nav-menus.php
   - register_nav_menus() with two locations:
     - 'primary' => __('Primary menu', 'lubben-vet')
     - 'footer'  => __('Footer menu', 'lubben-vet')

4. themes/lubben-vet/inc/redirects.php
   - lubben_vet_legacy_redirects() hooked to 'template_redirect' at priority 1:
     - Build a static map of legacy paths → new paths. Use exactly the table
       in docs/01-information-architecture.md.
     - Compare $_SERVER['REQUEST_URI'] (sanitized via esc_url_raw and
       wp_parse_url) against the map.
     - On match, wp_safe_redirect(home_url($new_path), 301) and exit.
     - Be defensive about trailing slashes — match both '/welcome.html' and
       '/welcome.html/' (some bots add slashes).
   - This must run before WordPress's own 404 handler so we 301 instead of 404.

5. themes/lubben-vet/inc/seo.php
   - lubben_vet_meta_description() hooked to 'wp_head' at priority 1:
     - Per-page description map matching the table in docs/03-content-migration.md
       (key by post slug or page ID — slug is more robust during dev).
     - Output a single <meta name="description" content="..."> tag, escaped.
     - If no per-page description matches, fall back to the site tagline
       (get_bloginfo('description')).
   - lubben_vet_open_graph() hooked to 'wp_head':
     - Output basic OG tags: og:title, og:description, og:type (website on
       front page, article elsewhere), og:url, og:image (use the post
       thumbnail, or fall back to a theme-provided default at
       assets/images/og-default.jpg — create a 1200x630 placeholder).

6. themes/lubben-vet/inc/helpers.php
   - get_lubben_hours(): returns an associative array of weekdays => hours
     strings. Single source of truth for hours that's used by the footer,
     contact page, and homepage visit-us section.
   - get_lubben_staff(): returns an array of staff members (Michaela, Candy,
     LeAnn) with keys: name, role, bio, photo_id (attachment ID, can be 0
     for now).
   - get_lubben_address(): returns an array with street, suite, city, state,
     zip — single source for the address.
   - get_lubben_phone(): returns the phone number. Add a sibling
     get_lubben_phone_tel() that returns the tel: URL (digits only).
   - All of these are filterable (apply_filters at the end of each) so a
     future plugin or child theme can override.
   - Now go back to template-parts/layout/site-footer.php,
     template-parts/sections/visit-us.php, page-templates/page-contact.php,
     and page-templates/page-about.php and replace the hard-coded TODOs
     with calls to these helpers.

Update functions.php:
   - require_once each of the new inc/ files. Order matters slightly:
     setup → enqueue → nav-menus → helpers → redirects → seo. Helpers should
     load before SEO and templates that call them.

Constraints:
- All callbacks are prefixed with `lubben_vet_` to avoid collisions.
- All hooks attach with proper priority arguments. Don't rely on default
  priority for anything that could collide (template_redirect especially).
- The redirect map is a single PHP array literal, not pulled from the DB.
  We want this to work even if the database is restored from a fresh dump.
- Output of every helper that goes to the front-end is escaped at the
  template, not in the helper. Helpers return raw values.

When done, walk me through how to test the legacy redirects locally
(visiting /welcome.html on the dev site should 301 to /).
```

---

## Acceptance criteria

- [ ] **Appearance → Menus** lists "Primary menu" and "Footer menu" as available locations.
- [ ] Visiting any legacy URL (`/welcome.html`, `/ourpractice.html`, etc.) 301-redirects to the new URL.
- [ ] View source on the homepage: a single `<meta name="description">` tag is present with the correct copy from the migration spec.
- [ ] No `Notice: undefined function get_lubben_hours()` in the error log — all template calls resolve.
- [ ] **Network tab** on a fresh page load: no jQuery, one CSS file, one (small) JS file.
