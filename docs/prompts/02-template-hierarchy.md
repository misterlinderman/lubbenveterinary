# Prompt 02 — Template hierarchy

> **Goal:** Build the standard WordPress template files so every page on the site has a real template, not just `index.php`. Establishes the chrome (header, footer, nav) that all pages share.
>
> **Files Claude should create:**
>
> - `themes/lubben-vet/header.php`
> - `themes/lubben-vet/footer.php`
> - `themes/lubben-vet/page.php`
> - `themes/lubben-vet/front-page.php`
> - `themes/lubben-vet/404.php`
> - `themes/lubben-vet/searchform.php`
> - `themes/lubben-vet/template-parts/layout/site-header.php`
> - `themes/lubben-vet/template-parts/layout/site-footer.php`
> - `themes/lubben-vet/template-parts/layout/skip-link.php`

---

## Prompt to paste

```
Prompt 02 of the build plan. The theme scaffold is in place from prompt 01.
Now build the template hierarchy.

Read first:
- docs/01-information-architecture.md (page structure, nav, footer contents)
- docs/02-design-system.md (layout tokens, container width)
- The existing theme files from prompt 01, so you know what tokens & helpers
  are available.

Create these files:

1. themes/lubben-vet/header.php
   - Open <html>, <head>, wp_head().
   - <body class="<?php echo esc_attr(implode(' ', get_body_class())); ?>">
   - Include the skip-link template part.
   - Include the site-header template part.
   - Open <main id="main" class="site-main">.

2. themes/lubben-vet/footer.php
   - Close </main>.
   - Include the site-footer template part.
   - wp_footer(), close body and html.

3. themes/lubben-vet/template-parts/layout/skip-link.php
   - Standard accessibility skip link: <a class="skip-link screen-reader-text"
     href="#main">Skip to main content</a>. The CSS to make it visible on
     focus goes in assets/css/theme.css — add that rule there too.

4. themes/lubben-vet/template-parts/layout/site-header.php
   - <header class="site-header" role="banner">
   - Logo or wordmark (use bloginfo('name') for now; we'll swap in an SVG
     wordmark when the design's locked).
   - Primary nav via wp_nav_menu(['theme_location' => 'primary',
     'container' => 'nav', 'container_class' => 'site-nav', 'menu_class' =>
     'site-nav__list', 'fallback_cb' => false ]). If the menu isn't yet
     assigned, fall back to a hard-coded list of Home / About / Contact so
     the site doesn't look broken pre-config.
   - A "Request an Appointment" button (link to /contact/#appointment-form)
     styled as primary button.
   - A `tel:` link with the phone number, visible on mobile, hidden in the
     header on desktop (it's in the footer there).
   - A mobile hamburger toggle that expands the nav. Use a checkbox-based
     CSS-only pattern OR a tiny vanilla JS toggle (NOT jQuery). Whichever
     you pick, make sure it's keyboard accessible — the toggle button must
     be a real <button>, not a styled div, with aria-expanded and
     aria-controls.

5. themes/lubben-vet/template-parts/layout/site-footer.php
   - <footer class="site-footer" role="contentinfo">
   - Three columns on desktop, stacked on mobile:
       a. Practice name + mission line + address (link to Google Maps).
       b. Hours (use a placeholder helper get_lubben_hours() that we'll
          define in prompt 04 — for now, hard-code the hours and add a
          // TODO comment).
       c. Quick links: Home, About, Contact, Online Pharmacy (external,
          rel="noopener", target="_blank").
   - Bottom strip: © <?php echo esc_html(date('Y')); ?> Lubben Veterinary
     Services LLC.

6. themes/lubben-vet/page.php
   - Standard page template: get_header(), while(have_posts()): the_post()
     loop with the_title() and the_content(), get_footer().
   - Wrap the content in <article class="page"> with appropriate semantic
     classes.

7. themes/lubben-vet/front-page.php
   - For now, just delegate to page.php's structure. We'll fill in the
     homepage sections in prompt 03.
   - Add a HTML comment <!-- front-page placeholder; populated in prompt 03 -->
     so I know it's a stub.

8. themes/lubben-vet/404.php
   - Friendly 404 per docs/01-information-architecture.md. Mission line,
     a "Go home" button, the office phone. Wrapped in <main>'s parent in
     header.php.

9. themes/lubben-vet/searchform.php
   - Standard accessible search form, with a real <label> and a hidden-text
     submit button labeled "Search". This is mostly defensive — we don't
     surface search anywhere in the UI, but if a plugin or block calls for a
     search form, we want one that matches the design.

Add the necessary CSS rules to assets/css/theme.css for: site-header
layout, nav layout (mobile + desktop), the hamburger toggle, the skip link's
focus-visible styles, the footer columns, and the 404 page. Keep the new CSS
in named sections with comment headers like /* ============================
   Site header
   ============================ */ so the file stays readable.

Constraints:
- All output must be escaped (esc_html, esc_url, esc_attr).
- Mobile-first CSS. The 768px and 1024px breakpoints from the design system
  are the only ones that matter.
- No JS dependencies. If you write the hamburger toggle in JS, it goes in
  assets/js/nav.js as a small vanilla module and we'll wire its enqueue in
  prompt 04 — for now, just create the JS file with a TODO comment up top.
- Accessibility: focus must be visible everywhere, the hamburger button must
  manage aria-expanded, and the mobile menu must trap focus when open OR
  close cleanly on Esc.

When done, summarize what's in place and what I should manually click through
to verify.
```

---

## Acceptance criteria

- [ ] Every page on the site renders with a header and footer matching the IA spec.
- [ ] Tabbing through the page goes: skip link → logo → nav items → appointment button → main content → footer links. Focus ring visible at every stop.
- [ ] On a phone viewport, the hamburger toggle opens and closes a menu with a real button (you can verify with `aria-expanded` toggling in devtools).
- [ ] Pressing **Esc** closes the mobile menu and returns focus to the toggle.
- [ ] 404 page renders for an unknown URL with the correct copy.
