# Prompt 07 — Launch prep

> **Goal:** Tighten the screws before DNS cutover. This prompt is mostly verification and last-mile fixes — Claude shouldn't be inventing new features here, just hardening what exists.
>
> **Files Claude may create / edit:**
>
> - `themes/lubben-vet/inc/security.php` (small security headers helper)
> - `themes/lubben-vet/robots-additions.php` *(if relevant)*
> - Performance fixes in existing CSS / templates as needed
> - Updates to `docs/06-launch-checklist.md` if anything was missed

---

## Prompt to paste

```
Prompt 07 of the build plan — launch prep.

Goal: We're not adding features. We're verifying everything works and
fixing whatever the verification finds.

Read first:
- docs/06-launch-checklist.md (the full checklist)
- All the inc/ files so you know what's already in place.

Walk through the launch checklist with me, item by item, and for each item
either:
  (a) confirm Claude has already addressed it in earlier prompts and tell
      me how to verify, or
  (b) propose the smallest, most surgical change to address it now.

Specific items where I expect concrete code from Claude in this prompt:

1. SMTP plugin — Claude can't install plugins, but Claude can:
   - Confirm whether wp_mail() from this theme would currently land
     reliably from Bluehost without a plugin (no — Bluehost shared PHP
     mail is unreliable for transactional notifications).
   - Recommend a plugin (WP Mail SMTP is the conventional pick) and the
     auth flow we should use (most reliable: SMTP via the practice's
     actual mail provider, e.g., Microsoft 365 if they have it, or a
     dedicated transactional service like Postmark for $0–$15/mo).
   - Add a small admin notice that shows in WP admin if no SMTP plugin is
     active — it's a launch blocker reminder for Michaela.

2. Security headers — create themes/lubben-vet/inc/security.php:
   - Add a 'send_headers' hook that sets:
     - X-Content-Type-Options: nosniff
     - X-Frame-Options: SAMEORIGIN
     - Referrer-Policy: strict-origin-when-cross-origin
     - Permissions-Policy: limited (camera=(), microphone=(), geolocation=())
   - Skip the headers in admin.
   - Do NOT set CSP via PHP — CSP needs more careful tuning than we can
     do safely from a theme. Note this as a future improvement.
   - Disable XML-RPC via the 'xmlrpc_enabled' filter (we don't need it).
   - Disable WP REST API for unauthenticated users? — NO, leave it on.
     The block editor and theme features rely on it. Just be aware.

3. robots.txt — add a small filter on 'robots_txt' to make sure we allow
   /wp-sitemap.xml. Keep it minimal — don't try to compete with an SEO
   plugin's robots handling.

4. Performance pass:
   - Audit our enqueued assets. Theme.css should be the only CSS we ship
     (other than Gravity Forms' own CSS). If it's over ~30KB minified-
     equivalent, recommend specific rules to drop.
   - Make sure the hero image has fetchpriority="high" + loading="eager".
   - Make sure all OTHER images have loading="lazy" and decoding="async".
   - Self-hosted fonts should use font-display: swap.
   - Confirm we have no render-blocking JS in <head> (nav.js should be
     in the footer).

5. Sitemap — WordPress 5.5+ ships a core sitemap at /wp-sitemap.xml.
   Confirm it includes /, /about/, /contact/. If pages are excluded for
   any reason (e.g., a noindex flag), fix.

6. Check the 404 path for actual unknown URLs. The legacy redirects must
   run BEFORE WordPress 404s — confirm by visiting an unknown URL like
   /not-a-page that's NOT in the redirect map (should 404 with our nice
   404 template) AND a legacy URL like /welcome.html (should 301 to /).

7. Final accessibility sweep:
   - Run through the homepage with axe DevTools or Lighthouse's a11y audit.
   - Fix any violations. Common ones to expect: insufficient color contrast
     in muted text, missing alt text on auto-inserted images, focus order
     anomalies in the mobile menu.

8. Final content check:
   - All instances of "Lorem", "TODO", "placeholder" in the codebase should
     be resolved. Grep the theme.
   - All hard-coded test email addresses are out of the Gravity Form
     notifications.

When done, update docs/06-launch-checklist.md with anything we discovered
that wasn't already on the list. Keep that document the source of truth
for cutover day — don't introduce a new doc for it.

Then tell me the order I should perform the cutover steps tomorrow morning
(or whenever) — sequenced, with rough timing.
```

---

## Acceptance criteria

- [ ] Every item on `docs/06-launch-checklist.md` is either checked off or has a clear "do this on cutover day" note.
- [ ] Security headers visible in the response headers when you `curl -I https://staging-site/`.
- [ ] Lighthouse audit on Home is clean enough to meet the targets in `docs/00-project-brief.md`.
- [ ] `grep -ri "TODO\|placeholder\|lorem" themes/lubben-vet/` returns zero hits.
- [ ] Cutover runbook is short, sequenced, and printable.
