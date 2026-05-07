# Prompt 01 — Theme scaffold

> **Goal:** Create the bare-bones theme structure so WordPress recognizes "Lubben Vet" as an installable theme. Wire up tokens, base styles, and the editor (`theme.json`).
>
> **Files Claude should create:**
>
> - `themes/lubben-vet/style.css`
> - `themes/lubben-vet/theme.json`
> - `themes/lubben-vet/functions.php`
> - `themes/lubben-vet/index.php`
> - `themes/lubben-vet/assets/css/tokens.css`
> - `themes/lubben-vet/assets/css/theme.css`
> - `themes/lubben-vet/assets/css/editor.css`
> - `themes/lubben-vet/screenshot.png` *(can be a placeholder; just needs to exist)*

---

## Prompt to paste

```
We're starting Phase 2, prompt 01 of the build plan in docs/05-build-plan.md.

Goal: Create the theme scaffold for "lubben-vet" — enough that WordPress can
activate the theme and render a blank but token-styled page.

Read first (or confirm you already have these in context):
- docs/02-design-system.md (this is your source for tokens, type, colors)
- .cursor/rules/wordpress.md
- .cursor/rules/frontend.md

Create these files exactly:

1. themes/lubben-vet/style.css
   - Standard WP theme header: Theme Name "Lubben Vet", Author, Description
     ("Custom theme for Lubben Veterinary Services"), Version 0.1.0,
     Requires at least 6.4, Requires PHP 8.1, Text Domain "lubben-vet",
     Tags "custom-theme,blog,one-column,accessibility-ready".
   - The file should contain ONLY the theme header and nothing else; the actual
     CSS lives in assets/css/.

2. themes/lubben-vet/theme.json (schema version 2)
   - Mirror the design tokens from docs/02-design-system.md exactly:
     palette colors, type families (Source Sans 3, Fraunces), font sizes,
     spacing scale.
   - Disable "appearanceTools" we don't need; turn ON custom colors and
     custom font sizes for editor users.
   - Set "useRootPaddingAwareAlignments": true.

3. themes/lubben-vet/functions.php
   - Define a constant LUBBEN_VET_VERSION = '0.1.0'.
   - Require inc/setup.php and inc/enqueue.php with `require_once` guarded by
     file_exists (those files come in prompt 04, but the requires should be
     in place now and not fatal if missing — log a notice instead).
   - Nothing else.

4. themes/lubben-vet/index.php
   - Minimal fallback template: get_header(), the loop with `the_title()`
     and `the_content()`, get_footer(). Properly escaped.

5. themes/lubben-vet/assets/css/tokens.css
   - All the design tokens from docs/02-design-system.md as CSS custom
     properties on :root. Include the spacing scale, type scale (with clamp()
     fluid sizes), color palette, line heights, and a max-width container var.

6. themes/lubben-vet/assets/css/theme.css
   - Imports tokens.css at the top.
   - Sensible base resets (box-sizing, no underline list bullets in nav, etc.)
   - Body typography styles using the tokens.
   - Heading styles (h1–h4) using the tokens.
   - Link styles with the focus ring spec from the design system.
   - A `.container` utility using the max-width var.
   - Nothing layout-specific yet — that comes in prompt 02.

7. themes/lubben-vet/assets/css/editor.css
   - Loaded by theme.json's "styles.css" or via add_editor_style() (we do
     the latter in prompt 04). For now, just import tokens.css and apply body
     typography so the block editor preview matches the front-end roughly.

8. themes/lubben-vet/screenshot.png
   - Create a placeholder file. Even a 1x1 transparent PNG is fine for now;
     we'll replace with a real screenshot before launch.

Constraints:
- No build step. CSS files are hand-authored static files served as-is.
- No JS yet.
- All PHP must pass WordPress Coding Standards. Escape on output, sanitize on
  input. No raw $_GET/$_POST.
- Indentation: tabs in PHP files, 2 spaces in CSS/JSON.

After creating the files, give me a short summary (no code) of what you
created and one thing you'd flag for me to double-check before I move to
prompt 02.
```

---

## Acceptance criteria

- [ ] Activating the theme in a WordPress install does not throw fatal errors.
- [ ] The theme appears in **Appearance → Themes** with the correct name and version.
- [ ] **Site Editor** (Appearance → Editor) loads without warnings; the palette and font sizes from the design system are visible in the inspector.
- [ ] `style.css` is *only* the WP header — no actual styles.
- [ ] `theme.json` validates against the schema (paste into a JSON validator if unsure).
