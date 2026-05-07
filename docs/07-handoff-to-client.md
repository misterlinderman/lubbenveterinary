# 07 — Handoff to Michaela

A short, plain-language reference for the practice's day-to-day site management. This is the document we leave with the client.

---

## Logging in

- **Login URL:** https://lubbenveterinary.com/wp-admin
- **Your username:** *(set at intake)*
- **Password reset:** the *Lost your password?* link on the login page sends a reset email.

If you ever get locked out: Bluehost has a host-level password reset, and the developer can also help.

## Editing a page

1. Log in.
2. Top-left, click **Pages**.
3. Click the page you want to edit (Home, About, or Contact).
4. Use the editor to change text, swap images, or rearrange sections.
5. Click **Update** in the top right when you're done. Changes appear on the live site immediately.

If you make a mistake, don't panic — every change is saved as a revision. From the editor's right-side panel, click **Revisions** to roll back to any earlier version.

## Swapping a photo

1. Click the photo in the editor.
2. In the toolbar that appears, click **Replace**.
3. Upload a new image or pick one from the **Media Library**.
4. Add **alt text** in the right-side panel — a short description of what's in the photo (this matters for accessibility and search).
5. **Update** to save.

A note on image size: WordPress automatically generates the right sizes. Upload at the largest size you have (a phone camera photo is fine). The system trims down for you.

## Updating office hours

Hours live in **two places** on the site, and updating them in one place updates both:

1. **Pages → Contact → "Hours" section** — change the text here.
2. The footer hours block reads from the same theme setting, so editing in Contact updates the footer too.

If you also want to update the hours that show on the homepage's *Visit us* section, edit that section on the Home page directly.

## Reviewing form submissions

Every contact form submission is saved in WordPress in addition to being emailed.

1. Go to **Forms** in the left sidebar.
2. Click **Entries** on *Request an Appointment*.
3. Browse, search, or export entries to CSV.

If a submission didn't land in your email but shows up here, that's an email-delivery issue — let the developer know and we'll check the SMTP setup.

## Who gets which email

| Inquiry type | Recipient(s) |
|---|---|
| Appointment request | Michaela (you) — plus Dr. Lubben if it's a mobile/farm visit |
| General question | Michaela |
| Billing or records | *(confirm at intake — usually Michaela)* |
| Emergency | Dr. Lubben + Michaela |

You can change these by emailing the developer; we'll update the form's notification rules.

## Things you shouldn't change unless you mean to

These are safe to leave alone forever:

- **Settings → Permalinks** — page URLs. Changing this breaks the legacy redirects from the old site.
- **Appearance → Themes** — the active theme is "Lubben Vet". Switching to another theme will hide all the design work.
- **Plugins** — leave installed plugins active. Updates are fine and recommended; deactivating Gravity Forms takes the contact form down.

## When something looks wrong

1. Try logging out and reloading in a private/incognito window — most "the site looks weird" issues are caching-related and resolve themselves within an hour.
2. If a form notification didn't arrive, check **Forms → Entries** to see if the submission landed in the system. If it did, it's an email-delivery issue. If it didn't, send the developer a screenshot.
3. For anything else, email the developer with as much detail as you can — what page, what device (phone or computer), what you saw vs. what you expected.

## Backups

Automatic daily backups are configured at the host level. We also recommend a manual backup before any large content update — there's a *Backup Now* button in the Bluehost dashboard.

---

*This handoff is also available as a printable PDF — ask the developer.*
