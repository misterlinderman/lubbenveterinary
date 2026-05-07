# Lubben Vet — project rules

## Stack & hosting

- WordPress on **Bluehost** shared hosting; **Local by Flywheel** (LocalWP) for local development.
- Deploy to production via **FTP** only after a development phase is reviewed and confirmed — do not sync unfinished work to Bluehost blindly.
- **PHP 8.1+**. No build step at launch: CSS/JS are static files under `themes/lubben-vet/assets/`.

## Absolutely out of scope

- **No Weave** (scheduling widget, Text Connect, or any Weave integration). All contact and scheduling intent goes through **one Gravity Forms** form with conditional notifications per `docs/04-gravity-forms-spec.md`.
- No e-commerce in WordPress; the online pharmacy is an external link (MyVetStoreOnline).
- No page builders; Michaela edits in the block editor and Customizer only.

## Non-negotiables

1. **Legacy redirects:** Seven legacy `.html` URLs must 301 to the new routes (with anchors where specified). Implement in `inc/redirects.php` (loaded from `functions.php`), not a redirect plugin.
2. **Anchor IDs are a public contract:** `#practice`, `#dr-lubben`, `#our-staff`, `#hours`, `#appointment-form` — changing them requires updating redirects and any deep links.
3. **Gravity Forms:** Theme must disable Gravity Forms’ bundled form theme CSS (`gform_disable_form_theme_css`) so the form uses theme tokens. **WP Mail SMTP** (or equivalent) is a **launch blocker** on Bluehost so conditional notification emails actually deliver.
4. **Plugins:** Do not commit third-party plugin code. Only the form JSON export under `themes/lubben-vet/inc/gravity-forms/` once built, plus the written spec in `docs/`.

## Content & client

- Confirm **stale copy** (e.g. tenure “26 years” vs Dr. Lubben’s 1990 graduation) with Michaela per `docs/content/legacy-pages.md` — do not silently rewrite facts.
- **Email recipients** in the Gravity Forms spec are placeholders until intake confirms real addresses.

## Workflow

- Follow `docs/05-build-plan.md` and run `docs/prompts/` in order starting with `00-orientation.md`.
