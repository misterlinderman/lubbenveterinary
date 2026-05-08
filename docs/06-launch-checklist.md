# 06 — Launch Checklist

Run this top-to-bottom on launch day. Anything unchecked is a launch blocker.

---

## 48 hours before launch

- [ ] **Repo sanity script** — from the site root, run `wp eval-file wp-content/themes/lubben-vet/bin/verify-launch-checklist.php` (legacy 301 map, key theme paths, `blog_public`). Fix any reported `FAIL` before go-live.
- [ ] **TTL lowered** on the existing DNS for lubbenveterinary.com to 300 seconds (5 min). This shrinks the propagation window when we cut over.
- [ ] **Bluehost site reachable** via temporary URL or `hosts` file entry — the full site renders, all three pages load, the form submits a test entry, and the test entry triggers all four conditional notifications correctly.
- [ ] **SMTP plugin configured** (WP Mail SMTP or equivalent) and a test email from WP Mail SMTP's *Send a Test Email* tool reaches an external inbox. **Without this, Gravity Forms notifications will not deliver reliably from Bluehost.**
- [ ] **Notification routing verified** — submit one of each category (Appointment, General, Billing, Emergency) and confirm the right inbox receives each. Use real (or staged) recipient addresses.
- [ ] **Form JSON exported** to `themes/lubben-vet/inc/gravity-forms/contact-form.json` and committed.
- [ ] **Lighthouse mobile** ≥ 90 Performance, ≥ 95 Accessibility, ≥ 95 Best Practices, ≥ 95 SEO on Home, About, Contact.
- [ ] **Manual accessibility pass** — keyboard-only navigation works through nav, hero, all CTAs, and the form. Focus is always visible. Screen reader announces page landmarks (header / main / footer) and form labels.
- [ ] **Mobile manual test** on a real phone — not just devtools. Tap targets feel right, the form scrolls cleanly, the appointment button stays accessible.
- [ ] **Cross-browser smoke test** — Chrome, Safari, Firefox on desktop; Safari on iOS; Chrome on Android.
- [ ] **404 page** renders correctly for an unknown URL.
- [ ] **Legacy redirects** — visit each of these and confirm they 301-redirect to the new home:
  - [ ] `/welcome.html` → `/`
  - [ ] `/index.html` → `/`
  - [ ] `/ourpractice.html` → `/about/#practice`
  - [ ] `/drlubben.html` → `/about/#dr-lubben`
  - [ ] `/ourstaff.html` → `/about/#our-staff`
  - [ ] `/page1.html` → `/contact/#hours`
  - [ ] `/contact.html` → `/contact/`
- [ ] **Search engines** — `robots.txt` allows crawling. `wp-sitemap.xml` reachable. (We can leave search engines closed until cutover if we want a quiet preview window.)
- [ ] **Backup taken** of the legacy site files (FTP download) and any DNS zone file — kept in `archive/` outside this repo for reference.

## Day-of cutover

- [ ] **Final content sync** — anything Michaela updated on the staging Bluehost site is the latest version. No drift between repo and live.
- [ ] **DNS cutover** — update A record (and AAAA if applicable) at the registrar to point to Bluehost. CNAME for `www` to the apex.
- [ ] **Watch propagation** — `dig +short lubbenveterinary.com` from a few resolvers (1.1.1.1, 8.8.8.8, your local) until they all return the new IP. Usually 5–30 minutes with a 300s TTL.
- [ ] **HTTPS / SSL** — Bluehost auto-provisions Let's Encrypt once DNS resolves. Confirm `https://lubbenveterinary.com` loads green and `http://` 301-redirects to `https://`.
- [ ] **Set `WP_HOME` and `WP_SITEURL`** to the production URL (`https://lubbenveterinary.com`). Verify no mixed content warnings.
- [ ] **Submit one final live test form** under the appointment category to confirm production routing.
- [ ] **Remove "noindex"** if the staging site had it set (Settings → Reading → Search Engine Visibility unchecked).
- [ ] **Walk Michaela through** updating the homepage hero, swapping a staff photo, and viewing form entries. Record a 5-min Loom and link it in `07-handoff-to-client.md`.

## 24 hours after launch

- [ ] **Restore DNS TTL** to a normal value (3600 or 14400 seconds).
- [ ] **Search Console & analytics** — if applicable, submit the sitemap to Google Search Console. (Per the proposal, no SEO campaign work is included; this is the no-cost minimum.)
- [ ] **Form sanity check** — confirm at least one inbound form submission has been received correctly, or send a final pinhole test if traffic has been low.
- [ ] **Snapshot for the archive** — full backup of the new site (UpdraftPlus or Bluehost's native backup) saved off-server.

---

## Rollback plan

If anything is wrong after DNS cutover and cannot be fixed forward within an hour:

1. Revert the A/AAAA records at the registrar to the legacy host's IP.
2. With the lowered TTL, propagation back is fast (~5–30 min).
3. The legacy Plesk site reappears — the only customer-facing damage is one short window of the new site being broken.

Keep the legacy hosting account active for at least **30 days** after launch so this rollback path stays open.
