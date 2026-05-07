# 03 — Content Migration

This is the inventory of what's on the legacy site (lubbenveterinary.com) and what we're doing with it. Raw extracts live in `docs/content/legacy-pages.md` for reference; this document is the **decisions log**.

---

## Source pages on the legacy site

| Legacy page | Status | Destination |
|---|---|---|
| `welcome.html` (Home) | Keep mission line, drop dead store links, keep "stop in and meet our wonderful staff" warmth | `/` (Home) |
| `ourpractice.html` | Keep, lightly tighten | `/about/#practice` |
| `drlubben.html` | Keep, lightly tighten | `/about/#dr-lubben` |
| `ourstaff.html` | **Expand** — currently just three names; collect roles + short bios + photos at intake | `/about/#our-staff` |
| `page1.html` (Office Hours) | Keep verbatim, add Sunday closed + after-hours line | `/contact/#hours` |
| `contact.html` | Replace with form-driven contact page | `/contact/` |

---

## Content to keep verbatim

These strings carry the practice's voice. Do not rewrite without Michaela's sign-off.

- **Mission line:** *"Providing quality veterinary care to all of God's creatures great and small."*
- **Welcome warmth:** *"Feel free to stop in and meet our wonderful staff and visit our new office south of Louisville near the water tower."*
- **Address:** 1276 Sand Hill Circle, Suite 1, Louisville, NE 68037
- **Phone:** 402-234-1054
- **Hours:** Monday–Friday 7am–6pm; Saturday 8am–12pm

## Content to remove

- **MyEquineStoreOnline link** (`http://lubbenveterinary.myequinestoreonline.com`) — dead.
- **MyPharmStoreOnline link** (`http://lubbenveterinary.mypharmstoreonline.com`) — dead.
- The "Click below to open one of our new online stores available for your shopping needs." preamble — replaced with a single, clearly framed CTA.

## Content to elevate

- **The active online pharmacy** at `https://lubbenveterinary.myvetstoreonline.pharmacy` becomes a full-width call-to-action band on the homepage with the headline *Shop Our Online Pharmacy* and short supporting copy.

## Content to draft fresh

These pieces have no clean source on the legacy site and need to be written during Phase 1. Drafts live in `docs/content/drafts/` and Michaela approves before they go into the theme.

1. **Hero headline (Home).** ~6 words. Working draft: *"Caring for the animals of southeast Nebraska."* Subhead is the mission line.
2. **Services tile copy** (4 tiles × ~12 words each):
   - *Small Animal Care* — exams, vaccinations, dental, wellness for dogs and cats.
   - *Large Animal & Mobile Service* — farm and home calls across Cass, Sarpy, Otoe, and Saunders counties.
   - *Surgery & Advanced Medicine* — performed in our Louisville clinic.
   - *After-Hours Emergencies* — call 402-234-1054 day or night.
3. **Staff bios** for Michaela, Candy, and LeAnn — collect at intake (role, years with practice, one personal sentence).
4. **About page intro** — one short paragraph above the existing copy that frames the page for first-time visitors.
5. **404 page copy** — short, warm, and helpful.

---

## Photography

The legacy site has no usable images. We need, at minimum:

- 1 hero photo (clinic exterior preferred; alternatively, Dr. Lubben with an animal patient).
- 1 portrait of Dr. Lubben.
- 3 staff portraits (Michaela, Candy, LeAnn) — informal headshots are fine.
- 1 wide shot of the practice's exterior with the water-tower landmark visible (matches the existing site's *"south of Louisville near the water tower"* line).

If photos aren't ready by build time, ship with tasteful stock that doesn't lie about the practice (no stock images of staff that aren't actually staff). Replace before launch.

---

## SEO metadata

Per page, set in WordPress directly (no SEO plugin required at launch — we'll provide a fallback `wp_head` filter for `<title>` and `<meta description>`).

| Page | `<title>` | Meta description |
|---|---|---|
| Home | "Lubben Veterinary Services — Louisville, NE" | "Mixed animal veterinary care for southeast Nebraska. Small animal, large animal mobile service, surgery, and after-hours emergencies. Louisville, NE." |
| About | "About Lubben Veterinary Services — Dr. Scott Lubben, DVM" | "Dr. Scott Lubben, DVM, has served Cass, Sarpy, Otoe, and Saunders counties for over 30 years. Meet our practice and staff." |
| Contact | "Contact & Hours — Lubben Veterinary Services" | "Hours, address, and how to reach us. Request an appointment online or call 402-234-1054." |

If we add an SEO plugin later, these become the seed values.
