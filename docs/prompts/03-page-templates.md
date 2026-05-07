# Prompt 03 — Page templates & homepage sections

> **Goal:** Build the homepage's seven sections as composable template parts, and create page templates for About and Contact. By the end of this prompt, the site has its real visual layout — even before content is populated, the chrome looks like the finished site.
>
> **Files Claude should create:**
>
> - `themes/lubben-vet/template-parts/sections/hero.php`
> - `themes/lubben-vet/template-parts/sections/about-teaser.php`
> - `themes/lubben-vet/template-parts/sections/services-grid.php`
> - `themes/lubben-vet/template-parts/sections/pharmacy-cta.php`
> - `themes/lubben-vet/template-parts/sections/visit-us.php`
> - `themes/lubben-vet/page-templates/page-about.php`
> - `themes/lubben-vet/page-templates/page-contact.php`
> - And updates to `front-page.php` to wire the homepage sections together
> - And updates to `assets/css/theme.css` for section-specific styles

---

## Prompt to paste

```
Prompt 03 of the build plan.

Goal: Build the homepage as a composition of section template parts, and
create custom page templates for About and Contact.

Read first:
- docs/01-information-architecture.md (sections in order, anchors)
- docs/03-content-migration.md (content for each section)
- docs/02-design-system.md (component specs: cards, buttons, hero rules)

Approach: each homepage section is its own file in
themes/lubben-vet/template-parts/sections/, included from front-page.php.
This keeps front-page.php readable — it's just a list of section includes.

Create section template parts:

1. template-parts/sections/hero.php
   - Full-width hero with a single image (use a placeholder gray block now;
     real photo lands in prompt 06 / content phase).
   - Headline (use the working draft from docs/03-content-migration.md:
     "Caring for the animals of southeast Nebraska.")
   - Subhead = the mission line from docs/00-project-brief.md.
   - Two buttons: "Request an Appointment" (primary, → /contact/#appointment-form)
     and "Call 402-234-1054" (secondary, tel: link).
   - The hero image gets fetchpriority="high" and loading="eager"; everything
     else on the page lazy-loads.

2. template-parts/sections/about-teaser.php
   - Two-column on desktop, stacked on mobile.
   - Left: heading "About Our Practice" + 2–3 sentence teaser pulled from
     the legacy "Our Practice" copy + a "Meet Dr. Lubben" link to /about/#dr-lubben.
   - Right: a portrait or placeholder.

3. template-parts/sections/services-grid.php
   - 4 tiles in a grid (2x2 on tablet, 4 across on desktop, 1 column on mobile).
   - Each tile: inline SVG icon (use Lucide-style placeholders — paw, tractor,
     stethoscope, alert-triangle), heading, one-line description from
     docs/03-content-migration.md.
   - Tiles are NOT links unless we have somewhere meaningful to send people.
     Keep them as informational cards for now.

4. template-parts/sections/pharmacy-cta.php
   - Full-width band, contrasting background (use --color-primary or a tinted
     surface — your call, justify it briefly in the comment header).
   - Headline: "Shop Our Online Pharmacy"
   - Supporting copy: ~20 words about ordering food, prescriptions, and
     supplies for delivery.
   - Single primary button → https://lubbenveterinary.myvetstoreonline.pharmacy
     with target="_blank" rel="noopener noreferrer".

5. template-parts/sections/visit-us.php
   - Two-column on desktop, stacked on mobile.
   - Left: address, hours summary, phone link, primary button → /contact/#appointment-form.
   - Right: embedded map. Use a static image placeholder for now (NOT an
     iframe yet — Google Maps embed iframes hurt performance and we'll add
     the iframe lazy-loaded in prompt 06). For now, an <a> with a map-pin
     icon linking to Google Maps for the address.

Update front-page.php:
- get_header()
- get_template_part('template-parts/sections/hero')
- get_template_part('template-parts/sections/about-teaser')
- get_template_part('template-parts/sections/services-grid')
- get_template_part('template-parts/sections/pharmacy-cta')
- get_template_part('template-parts/sections/visit-us')
- get_footer()

Create page templates:

6. page-templates/page-about.php
   - Template Name: "About — Lubben Vet"
   - Renders the page's WP block-editor content inside a styled wrapper, but
     also adds the three anchored sections (#practice, #dr-lubben, #our-staff)
     as defined in docs/01-information-architecture.md.
   - The page's block editor content goes ABOVE these structured sections,
     so Michaela can add a freeform intro paragraph if she wants. The
     structured sections render from theme code so the anchors stay stable.
   - For staff cards: show a 3-column grid on desktop, 1-column on mobile.
     Each card pulls from a placeholder helper get_lubben_staff() (we'll
     define it in prompt 04 — for now, hard-code an array inline with a
     TODO comment).

7. page-templates/page-contact.php
   - Template Name: "Contact — Lubben Vet"
   - Sections in order:
     a. Page header.
     b. #hours block — pull hours from the same get_lubben_hours() helper
        the footer uses (hard-code for now with TODO).
     c. #visit block — address + map placeholder (same approach as visit-us
        section on the homepage).
     d. #appointment-form block — heading + intro copy + a placeholder
        comment <!-- Gravity Form #1 will be inserted via shortcode in
        prompt 05 -->. The placeholder block must already be styled to look
        like the form's container (correct padding, border, background) so
        prompt 05 just drops the form in.

Add CSS for all sections to assets/css/theme.css under labeled comment blocks.
The pharmacy-cta band, services grid, and hero are the most visually
prominent — invest CSS effort there. The rest can be more utilitarian.

Constraints:
- Section template parts are flat HTML — no nested template parts inside
  section parts (keep the include tree shallow so it stays grep-friendly).
- All section files start with a single-line comment naming the section
  and which doc spec they implement: e.g.
  <?php /** Hero section — see docs/01-information-architecture.md §Home */ ?>
- All hard-coded copy strings use __('...', 'lubben-vet') so we could
  translate later. (We won't actually translate; this is hygiene.)
- Headings inside sections use h2; the page's main h1 lives in the page
  header (front-page.php's hero contains the h1 for /).

When done, list the page templates that should now appear in WP's
"Page Attributes → Template" dropdown, and tell me what to assign to each
of the three pages once I create them in WP admin.
```

---

## Acceptance criteria

- [ ] The homepage shows all five sections in the right order with placeholder content.
- [ ] About and Contact page templates appear in the WordPress *Page Attributes → Template* dropdown.
- [ ] Anchor links work: visiting `/about/#dr-lubben` jumps to the right section.
- [ ] No `console.log`s left in any JS. No `var_dump` left in PHP.
- [ ] All headings form a sensible outline (one h1 per page).
