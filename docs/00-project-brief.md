# 00 — Project Brief

**Client:** Lubben Veterinary Services LLC
**Location:** 1276 Sand Hill Circle, Suite 1, Louisville, NE 68037
**Phone:** 402-234-1054
**Domain:** lubbenveterinary.com
**Mission statement (keep verbatim):** "Providing quality veterinary care to all of God's creatures great and small."
**Owner / sole vet:** Dr. Scott Lubben, DVM (Kansas State University, 1990)
**Primary point of contact:** Michaela Nielsen (office manager / lead admin user)
**Other named staff:** Candy Damme, LeAnn Burger
**Service area:** Cass, Sarpy, Otoe, and Saunders counties (southeast Nebraska)
**Practice type:** Mixed animal — small animal surgery & advanced medicine in-clinic, plus farm/home large-animal mobile work. After-hours emergencies handled by Dr. Lubben directly via the office line.

---

## What we're building

A small, modern WordPress site (Home, About, Contact — plus a Services overview if it earns its keep during design) on a custom lightweight theme called `lubben-vet`. The site will:

1. **Replace** the legacy Parallels Plesk Sitebuilder site at lubbenveterinary.com.
2. **Remove** two dead "online store" links (MyEquineStoreOnline, MyPharmStoreOnline).
3. **Promote** the still-active online pharmacy at https://lubbenveterinary.myvetstoreonline.pharmacy as a clear "Shop Our Online Pharmacy" CTA.
4. **Capture leads** through a single Gravity Forms contact/appointment form with conditional logic that routes inquiries to the right person (see `04-gravity-forms-spec.md`).
5. **Be editable** by Michaela using stock WordPress block editor controls — no page builders, no custom block library to learn.

## What we're NOT building

- **No Weave integrations.** The proposal originally included Weave's online scheduling link and Text Connect widget. The client has opted out of these for now. **All scheduling and contact flows go through the Gravity Forms contact form.**
- No e-commerce. The MyVetStoreOnline pharmacy stays externally hosted; we just link to it.
- No custom logo or photography commission. We use what the client provides plus tasteful stock.
- No SEO campaign, paid ads, or social setup.
- No PMS integration.
- No blog (yet — the theme should support `single.php` and `archive.php` so it can be turned on later without a rebuild, but no blog posts at launch).

---

## Tone & feel

The existing site is plain but its voice is right: warm, plainspoken, locally rooted, faith-flavored ("all of God's creatures great and small"), proud of long service to the area. The redesign keeps that voice and dresses it in a clean, modern, mobile-first layout. Think *country veterinary clinic that takes its website seriously* — not corporate-pet-hospital chrome, not folksy-cluttered.

Visual direction:

- Generous whitespace, calm earth-leaning palette (greens, warm neutrals, a single accent), one or two genuine photos on the homepage rather than a stock-photo carousel.
- Type pairing: a humanist sans for body, a sturdier sans or slab for headings. No script fonts.
- No autoplaying anything. No popups. No cookie banner unless legally required (we are not collecting analytics or marketing cookies at launch).

The design system lives in `02-design-system.md`.

---

## Constraints & non-negotiables

- **Editability over flexibility.** If a feature would require Michaela to touch theme code, we don't build it. Everything she's expected to update lives in the block editor or in Customizer.
- **No build step at launch.** CSS and JS ship as static files in `assets/`. We can introduce a build step later if the project grows; we're not paying that complexity tax for ~3 pages.
- **Accessibility floor: WCAG 2.1 AA.** Color contrast, keyboard nav, focus styles, alt text on all content images, semantic landmarks.
- **Performance floor:** Lighthouse mobile performance ≥ 90 at launch. No web fonts beyond two families, lazy-loaded images, no jQuery dependencies in the theme.
- **PHP 8.1+ compatible.** Bluehost shared hosting supports current PHP; we set the theme's `Requires PHP` accordingly.
- **WP coding standards.** Sanitize on input, escape on output, nonce + capability check on anything that writes. No raw `$_GET`/`$_POST`. See `.cursor/rules/wordpress.md`.

---

## Success looks like

- Michaela can update homepage copy, swap a staff photo, and change office hours without calling.
- A prospective client lands on the site from a phone search, sees the phone number and address above the fold, taps "Request an Appointment," fills the form in under a minute, and the right staff member gets the email.
- Lighthouse mobile: Performance ≥ 90, Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95.
- Existing search rankings for "Lubben Veterinary" and related queries are preserved or improved through the migration (we keep the domain, redirect the legacy URLs, and ship a sitemap).
