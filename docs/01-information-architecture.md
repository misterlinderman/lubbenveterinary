# 01 — Information Architecture

## Sitemap

The site is intentionally small. Three pages and a 404. Everything else is a section of one of the three.

```
/                           Home
├── /about/                  About the practice + Dr. Lubben + staff
└── /contact/                Hours, address, map, contact/appointment form
```

Optional fourth page (decide during design phase 1):

```
└── /services/               Services overview (only if content warrants its own page;
                             otherwise, services live as a section on Home)
```

We default to **no `/services/` page** at launch and instead put a 4-tile services section on the homepage. If that section starts to bulge during content review, we promote it.

## URL strategy & legacy redirects

The legacy site is on Parallels Plesk Sitebuilder and uses `.html` URLs. We'll 301-redirect each legacy URL to its new home so search equity transfers and any printed materials with old URLs still work.

| Legacy URL | New URL | Notes |
|---|---|---|
| `/welcome.html` | `/` | Homepage |
| `/index.html` | `/` | Homepage (defensive) |
| `/ourpractice.html` | `/about/#practice` | Anchor to Practice section |
| `/drlubben.html` | `/about/#dr-lubben` | Anchor to Dr. Lubben bio |
| `/ourstaff.html` | `/about/#our-staff` | Anchor to Staff section |
| `/page1.html` | `/contact/#hours` | Office hours live on Contact |
| `/contact.html` | `/contact/` | Contact page |

These redirects ship in the theme's `inc/redirects.php` via a `template_redirect` hook (one place to maintain, no plugin needed). See prompt `04-functions-and-hooks.md`.

## Page-by-page outline

### Home (`/`)

Sections, top to bottom:

1. **Header / nav** — logo or wordmark, primary nav (About, Contact), prominent phone link, "Request an Appointment" button (anchors to contact form).
2. **Hero** — short headline, mission line, two buttons: *Request an Appointment* (→ `/contact/#appointment-form`) and *Call 402-234-1054* (`tel:` link). Single warm hero image.
3. **About teaser** — 2–3 sentences pulled from the About page intro, with a "Meet Dr. Lubben" link.
4. **Services overview** — 4 tiles: Small Animal Care, Large Animal & Mobile Service, Surgery & Advanced Medicine, After-Hours Emergencies. Each tile: headline and one-line description.
5. **Online pharmacy CTA** — full-width band promoting "Shop Our Online Pharmacy" → `https://lubbenveterinary.myvetstoreonline.pharmacy` (opens in new tab, `rel="noopener"`).
6. **Visit us** — address, hours summary, embedded map (lazy-loaded), CTA back to contact form.
7. **Footer** — address, phone, hours, mission line, copyright.

### About (`/about/`)

1. **Page header** with section tagline.
2. **Our Practice** (anchor: `#practice`) — the existing "formed in 2016 / Cass County / mixed animal / 26 years" copy, lightly tightened.
3. **Dr. Lubben** (anchor: `#dr-lubben`) — bio with portrait. Existing copy is good; trim slightly and add a pull quote if the design wants one.
4. **Our Staff** (anchor: `#our-staff`) — Michaela, Candy, LeAnn. Photos if available; otherwise text-only cards with role and short bio (collect during intake).
5. **Closing CTA** — "Have questions? Get in touch." → contact form.

### Contact (`/contact/`)

1. **Page header.**
2. **Hours** (anchor: `#hours`) — Monday–Friday 7am–6pm; Saturday 8am–12pm; Sunday closed. **After-hours emergencies:** call 402-234-1054 (the office line routes to Dr. Lubben).
3. **Visit / map** — address, embedded map.
4. **Appointment / contact form** (anchor: `#appointment-form`) — Gravity Forms form #1, see `04-gravity-forms-spec.md`.

### 404

Friendly 404 with the mission line, a "go home" button, and the office phone.

## Navigation

- **Primary nav (header):** Home, About, Contact, *Request an Appointment* (button-styled).
- **Footer nav:** Home, About, Contact, Online Pharmacy (external).
- Mobile: hamburger that expands a full-width menu; the appointment button stays visible in the header at all sizes.

## Anchor targets

Anchor IDs above (`#practice`, `#dr-lubben`, `#our-staff`, `#hours`, `#appointment-form`) are part of the public URL contract — legacy redirects depend on them, and we'll likely link to them from emails. Don't rename without updating `inc/redirects.php`.
