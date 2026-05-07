# Lubben Vet — theme

Custom WordPress theme for **lubbenveterinary.com**. Pair this with the project documentation in `../../docs/`.

## Structure

```
themes/lubben-vet/
├── style.css                       WP theme header — no actual CSS
├── theme.json                      Source of truth for editor styles
├── functions.php                   Manifest only; requires inc/*
├── index.php                       Fallback template
├── header.php / footer.php         Site chrome
├── page.php                        Default page template
├── front-page.php                  Homepage — composes section template parts
├── 404.php                         Friendly not-found
├── searchform.php                  Defensive search form (not surfaced in UI)
├── screenshot.png                  Theme directory thumbnail
│
├── assets/
│   ├── css/
│   │   ├── tokens.css              CSS custom properties — mirrors theme.json
│   │   ├── theme.css               All front-end styles
│   │   └── editor.css              Block editor styles
│   ├── js/
│   │   └── nav.js                  Mobile nav toggle (vanilla)
│   ├── fonts/                      Self-hosted Source Sans 3 + Fraunces
│   └── images/                     Theme-bundled images (icons, defaults)
│
├── inc/                            All PHP logic — required by functions.php
│   ├── setup.php                   after_setup_theme registration
│   ├── enqueue.php                 wp_enqueue_scripts + block editor assets
│   ├── nav-menus.php               Menu locations
│   ├── helpers.php                 get_lubben_hours/staff/address/phone
│   ├── redirects.php               Legacy URL → new URL 301s
│   ├── seo.php                     <meta description> + Open Graph
│   ├── security.php                Security headers
│   ├── customizer.php              Customizer settings (hero image, etc.)
│   ├── gravity-forms-helpers.php   GF integration glue
│   └── gravity-forms/
│       └── contact-form.json       Exported form — re-importable
│
├── template-parts/
│   ├── layout/                     Site-wide chrome parts
│   │   ├── site-header.php
│   │   ├── site-footer.php
│   │   └── skip-link.php
│   └── sections/                   Homepage sections
│       ├── hero.php
│       ├── about-teaser.php
│       ├── services-grid.php
│       ├── pharmacy-cta.php
│       └── visit-us.php
│
├── page-templates/                 Selectable page templates
│   ├── page-about.php
│   └── page-contact.php
│
├── patterns/                       File-based block patterns
│   ├── hero-banner.php
│   ├── staff-card.php
│   └── cta-pharmacy.php
│
└── bin/
    └── seed-pages.php              `wp eval-file` script to seed pages
```

## Activating

1. Drop `lubben-vet/` into a WordPress install's `wp-content/themes/`.
2. Activate via *Appearance → Themes*.
3. Install **Gravity Forms** (license required) and **WP Mail SMTP** (free).
4. Run `wp eval-file themes/lubben-vet/bin/seed-pages.php` to create the three pages with the right templates.
5. Import `inc/gravity-forms/contact-form.json` via *Forms → Import/Export*.
6. Configure WP Mail SMTP against the practice's actual mail provider.
7. Test all four conditional notification paths.

## Editing rules

- All site-editable copy lives either in WP page content (block editor) or in `inc/helpers.php`. **Never hard-code copy into templates.**
- Theme tokens live in **two places that must stay in sync**: `theme.json` and `assets/css/tokens.css`. If you change one, change the other in the same commit.
- The Gravity Form is built and edited in WP admin, then exported to `inc/gravity-forms/contact-form.json`. Don't hand-edit the JSON.

## Versioning

Version bump rules:

- **Patch (0.1.x):** CSS-only or copy-only changes.
- **Minor (0.x.0):** New template part, new helper, new pattern.
- **Major (x.0.0):** Anything that breaks Michaela's editing flow or requires re-importing the Gravity Form.

Bump the version in **two places**: `style.css` and `functions.php`'s `LUBBEN_VET_VERSION` constant. Keep them identical.
