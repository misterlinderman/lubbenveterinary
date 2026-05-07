# 04 — Gravity Forms Specification

The single contact/appointment form is the only client-contact mechanism on the new site. It replaces both the legacy contact page and the Weave integrations from the original proposal. **It must work reliably on the first try** — every form failure is a lost lead for a small practice.

> **Confirm at intake** with Michaela: who should receive each inquiry type? Defaults below are placeholders.

---

## Form: "Request an Appointment / Contact Us"

**Form ID (after import):** 1
**Slug:** `appointment-contact`
**Title shown to users:** *Request an Appointment*
**Description shown to users:** *We'll get back to you within one business day. For after-hours emergencies, please call 402-234-1054.*

### Fields

| # | Type | Label | Required | Conditional? | Notes |
|---|---|---|---|---|---|
| 1 | Radio | "What's this about?" | yes | no | Drives conditional routing. Options: **Appointment request**, **General question**, **Billing or records**, **Emergency** (with note) |
| 2 | Name (first/last) | "Your name" | yes | no | |
| 3 | Phone | "Phone number" | yes | no | Use Gravity Forms phone field, US format. Best contact method for this practice's clientele. |
| 4 | Email | "Email address" | yes | no | |
| 5 | Radio | "What kind of patient?" | yes | shown if #1 = Appointment request | Options: **Small animal (dog, cat, etc.)**, **Large animal (cattle, equine, etc.)**, **Other** |
| 6 | Single line | "Patient name & species" | yes | shown if #1 = Appointment request | "Bella — golden retriever" |
| 7 | Date | "Preferred date" | no | shown if #1 = Appointment request | Min: today |
| 8 | Radio | "Preferred time" | no | shown if #1 = Appointment request | Morning / Midday / Afternoon / No preference |
| 9 | Checkbox | "Need a mobile/farm visit?" | no | shown if #1 = Appointment request and #5 = Large animal | Single checkbox: "Yes, I'd like Dr. Lubben to come to me" |
| 10 | Paragraph | "Anything we should know?" | no | always | 4 rows |
| 11 | HTML | Emergency notice | n/a | shown if #1 = Emergency | Inline message: *"For an active animal emergency, please call 402-234-1054 right now — the office line reaches Dr. Lubben directly after hours. This form is not monitored 24/7."* — and we still let them submit, but the notice is loud. |
| 12 | Honeypot | (built-in GF anti-spam) | — | — | Enabled in form settings |
| 13 | Save & Continue | disabled | — | — | Single-page form, no progress save |

### Submit button

Label: **Send Request**. Uses theme's primary button styling — Gravity Forms 2.5+ inherits theme styles when "Form Styling" is set to "None"; we leave it on None and style via theme CSS targeting `.gform_wrapper`.

### Validation messages

Use Gravity Forms defaults; override globally in theme CSS to match `--color-accent` for errors and use the theme's body font.

---

## Conditional notification routing

This is the routing logic the client asked for. Configure under *Form Settings → Notifications*. Each notification's "Send To Email" can be overridden per-rule using the conditional logic block.

> **Sender:** Use a **From Email** at the practice's domain (e.g. `noreply@lubbenveterinary.com`) to keep deliverability healthy. **Reply-To** is set to `{Email:4}` so a reply goes back to the requester. The "From Name" is `Lubben Veterinary Website`.

### Notification 1 — Appointment requests

- **Trigger:** Form is submitted
- **Conditional logic:** Send if `What's this about?` is `Appointment request`
- **Send to:** Michaela (placeholder: `michaela@lubbenveterinary.com`) + a CC to Dr. Lubben if `Need a mobile/farm visit?` is checked.
- **Subject:** `[Appointment] {Name (Prefix):2.2} {Name (Last):2.6} — {Patient name & species:6}`
- **Message body:** include all submitted fields, formatted, plus the source page URL (`{embed_url}`) and timestamp.

### Notification 2 — General questions

- **Trigger:** Form is submitted
- **Conditional logic:** Send if `What's this about?` is `General question`
- **Send to:** Michaela (front-desk inbox).
- **Subject:** `[General] Question from {Name (First):2.3} {Name (Last):2.6}`

### Notification 3 — Billing or records

- **Trigger:** Form is submitted
- **Conditional logic:** Send if `What's this about?` is `Billing or records`
- **Send to:** Whoever handles billing (placeholder: `billing@lubbenveterinary.com` — confirm with Michaela; this may simply be Michaela's inbox).
- **Subject:** `[Billing/Records] {Name (First):2.3} {Name (Last):2.6}`

### Notification 4 — Emergency-flagged submission

- **Trigger:** Form is submitted
- **Conditional logic:** Send if `What's this about?` is `Emergency`
- **Send to:** Dr. Lubben directly + Michaela (placeholder for both addresses confirmed at intake).
- **Subject:** `🚨 [EMERGENCY via website] {Name (First):2.3} {Name (Last):2.6} — {Phone:3}`
- **Message body:** lead with phone number, name, and the message, in that order, so it's actionable on a phone notification preview.
- **Note in body:** This is a website-form emergency. The submitter was also instructed to call 402-234-1054.

### Notification 5 — Confirmation to the submitter

- **Trigger:** Form is submitted
- **Conditional logic:** none (always send, except when Emergency — see below)
- **Send to:** `{Email:4}` (the submitter)
- **Subject:** `We received your message — Lubben Veterinary Services`
- **Message body:** Plain-text-friendly thank-you. Include: their name, what they asked about, hours, the after-hours phone, and a note that they'll hear back within one business day. **Do not** echo the entire submission back — just the summary.
- For Emergency category, **suppress this confirmation** and instead show on the page (via confirmation, see below) a louder reminder to call.

---

## Confirmation (post-submit page state)

Configure under *Form Settings → Confirmations*. Two confirmations using conditional logic:

- **Default confirmation** (any non-emergency): Inline message — *"Thanks, {Name (First):2.3} — we got your message and will be in touch within one business day. Office hours are Monday–Friday 7am–6pm and Saturday 8am–12pm."*
- **Emergency confirmation**: Inline message in `--color-accent` — *"We received your message. **For an active emergency, please call 402-234-1054 right now** — the office line reaches Dr. Lubben directly after hours."*

---

## Spam protection

- **Honeypot:** enabled (form setting).
- **Anti-spam token:** Gravity Forms 2.5+ sets this automatically; leave on.
- **No reCAPTCHA at launch.** We'll add hCaptcha or Cloudflare Turnstile only if spam volume warrants it post-launch — these have privacy and accessibility tradeoffs we'd rather not import into a low-traffic practice site.

## Storage & retention

- Entries are stored in the WordPress database via Gravity Forms.
- **Retention:** entries auto-purged after 365 days (configure in Forms → Settings → Personal Data → Retention).
- This is not a HIPAA/PHI vehicle. We tell submitters, in the form description, that this is a general inquiry channel — animal medical history shouldn't be pasted into the form.

## Email deliverability

Use an SMTP plugin (e.g., **WP Mail SMTP**) configured to send via the practice's actual mail provider, not Bluehost's PHP mail. Without this, conditional notifications will silently land in spam folders or never deliver. **This is a launch blocker** — see `06-launch-checklist.md`.

---

## Export & version control

After the form is built and tested in the staging environment:

1. *Forms → Import/Export → Export Forms* — export form #1.
2. Save the resulting JSON to `themes/lubben-vet/inc/gravity-forms/contact-form.json`.
3. Commit. This file is the source of truth — if the form is ever deleted or corrupted on the live site, it is re-importable from the repo in under a minute.
4. Whenever Michaela asks for a form change, make the change in the WP admin, re-export, and replace the JSON in the repo with the new version. Don't hand-edit the JSON.

A short helper in `inc/gravity-forms-helpers.php` styles the form to match the theme — it's CSS-only and doesn't touch form behavior.
