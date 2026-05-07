# Prompt 06 — Content population

> **Goal:** Get the migrated and drafted content into the actual WordPress pages, swap placeholder images for real ones, and lock the menus to the right items in the right order.
>
> **Files Claude should create / edit:**
>
> - WP-CLI commands in a script at `themes/lubben-vet/bin/seed-pages.sh` (or `.php`) so the page seeding is reproducible
> - `themes/lubben-vet/patterns/*.php` — block patterns for the structured content (so Michaela has reusable starting blocks)
> - Real images committed to `themes/lubben-vet/assets/images/` (or imported into the Media Library — see notes below)

---

## Prompt to paste

```
Prompt 06 of the build plan.

Goal: Populate Home, About, and Contact with real content. Establish block
patterns so Michaela has reusable, theme-styled blocks when she goes to edit.

Read first:
- docs/03-content-migration.md (everything we're moving in, plus the cleaned
  drafts from docs/content/drafts/)
- docs/01-information-architecture.md (page structure)

Approach: page content is split between TWO sources of truth:
- Theme-rendered structured sections (hero, services-grid, pharmacy-cta,
  visit-us, hours block, staff cards) — content for these is in helpers
  and template parts, edited via theme files.
- WP-editable blocks — the freeform body of each page, which Michaela
  controls. We seed initial content here.

Steps:

1. Create themes/lubben-vet/bin/seed-pages.php — a CLI-runnable PHP script
   (run via `wp eval-file themes/lubben-vet/bin/seed-pages.php`) that:
   - Creates the three pages (Home, About, Contact) if they don't exist
     using slugs 'home', 'about', 'contact'.
   - Sets the page templates: About uses 'page-templates/page-about.php',
     Contact uses 'page-templates/page-contact.php'.
   - Sets Home as the static front page (Settings → Reading equivalent
     via update_option('show_on_front', 'page') and 'page_on_front').
   - Seeds initial post_content for each page with WP block markup.
     For About, the editable region above the structured sections gets a
     short intro paragraph. For Contact, a one-line greeting above the
     hours/visit/form sections. For Home — Home doesn't have editable body
     content (the homepage is fully theme-driven via section parts), so
     leave post_content empty but write a comment in the post excerpt
     reminding editors that the homepage layout lives in the theme.

2. Create block patterns in themes/lubben-vet/patterns/:
   - hero-banner.php — a homepage hero block pattern (won't actually be
     used since we render the hero from the template, but it's available
     if Michaela ever wants to use a similar structure on a future page).
   - staff-card.php — a single staff member card. Used as a starting point
     if Michaela ever adds a fourth staff member; she duplicates this
     pattern, fills in the new info, and the styling matches automatically.
   - cta-pharmacy.php — the online-pharmacy CTA band, available as a
     pattern Michaela can drop into a future page if she wants.
   Each pattern file uses register_block_pattern semantics — see the WP
   docs on file-based patterns (https://developer.wordpress.org/themes/features/block-patterns/).

3. Update inc/helpers.php:
   - Replace the staff array placeholder with the real (intake-collected)
     names, roles, and bios. Use attachment IDs of 0 if photos haven't
     been uploaded yet — the templates render a styled initials avatar as
     fallback.
   - If photos are available, walk me through uploading them to the Media
     Library and getting their attachment IDs. Tell me exactly which CLI
     command to use (`wp media import path/to/photo.jpg --post_id=...`).
   - Update get_lubben_hours() with the final hours including Sunday closed
     and the after-hours emergency note.

4. Real homepage hero image:
   - If a real photo is available, instruct me how to set it as the
     hero. The hero template part should accept either an attachment ID
     constant (defined via add_theme_support or a Customizer setting) or
     fall back to a theme-bundled default at assets/images/hero-default.jpg.
   - Add a Customizer setting "Homepage hero image" (image control) to
     inc/customizer.php (create that file as part of this prompt). The
     hero template part reads from get_theme_mod('lubben_vet_hero_image').

5. Maps:
   - Replace the static Google Maps placeholder in visit-us section and
     contact page with a real lazy-loaded Google Maps iframe. Use the
     loading="lazy" attribute. Wrap the iframe in a styled aspect-ratio
     container.
   - Optionally generate a static map image fallback for users with iframes
     blocked, using a <noscript> or a JS-conditional swap. Static map fallback
     is a nice-to-have — skip if it complicates the build meaningfully.

6. Menus:
   - Provide the WP-CLI commands to create the Primary and Footer menus
     and assign them to their theme locations:
     - Primary: Home, About, Contact, Online Pharmacy (external)
     - Footer: Home, About, Contact, Online Pharmacy
   - The "Request an Appointment" button in the header is rendered from
     the theme directly (not a menu item) — confirm.

Constraints:
- The seed-pages script must be idempotent: running it twice does not
  create duplicate pages. Check by slug before inserting.
- All real content respects the line-by-line decisions in
  docs/03-content-migration.md (what to keep verbatim, what to drop, what
  to elevate). If you find yourself rewriting the mission line — stop.
- All content images need alt text. The seed script populates alt text
  for any images it sets. The block patterns include alt-text reminders
  in HTML comments.

When done, give me a manual checklist of what to click through in WP admin
to verify (Pages list, Settings → Reading, Appearance → Menus).
```

---

## Acceptance criteria

- [ ] Pages list in WP shows Home (set as front page), About, Contact — each with the right template assigned.
- [ ] Visiting `/`, `/about/`, `/contact/` renders the right content.
- [ ] Hours, address, phone, and staff names appear consistently across the site (footer, contact, homepage visit-us section) — confirming the helpers are doing their job.
- [ ] **Block patterns** appear in the editor's *Patterns* sidebar under a "Lubben Vet" category.
- [ ] Real hero image renders if uploaded; default fallback renders if not.
- [ ] Menu assignments survive a `wp menu location list` check.
