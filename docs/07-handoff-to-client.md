# 07 — Handoff to Michaela

Plain-language reference for day-to-day site management. This stays with the practice after launch.

---

## At a glance

| | |
|---|---|
| **Public site** | https://lubbenveterinary.com |
| **Admin** | https://lubbenveterinary.com/wp-admin |
| **Phone** | 402-234-1054 |
| **After-hours emergencies** | Same number — reaches Dr. Lubben |
| **Online pharmacy** | https://lubbenveterinary.myvetstoreonline.pharmacy |
| **Address** | 1276 Sand Hill Circle, Suite 1, Louisville, NE 68037 |

---

## Logging in

- **Your username:** *(set at intake)*
- **Password reset:** use *Lost your password?* on the login page.

If you are locked out: Bluehost can reset access at the hosting level; the developer can help as well.

---

## Editing a page

1. Log in.
2. Click **Pages** (left sidebar).
3. Open **Home**, **About**, or **Contact**.
4. Edit text and blocks in the main editor.
5. Click **Update** (top right). Changes go live immediately.

**Revisions:** In the editor’s right panel, **Revisions** lets you restore an older version.

---

## Homepage hero image

The large photo at the top of the home page is **not** inside the page editor.

1. Go to **Appearance → Customize**.
2. Open **Lubben Vet**.
3. Under **Homepage hero image**, choose or upload an image.
4. Click **Publish**.

---

## Hours, phone, and address (important)

**Office hours, the main phone number, and the street address** are stored in the **theme code** so the **same** information appears everywhere at once:

- Footer (**Hours** column)
- Home page (**Visit us**)
- Contact page (**Hours** block)

They are **not** tied to the text you type in **Pages → Contact**. Changing hours or the public phone number means **emailing the developer** (a small code change), unless you later add a “site settings” plugin.

The **Contact** page editor is still the right place for any **intro paragraphs** or other content in the main body above those sections.

---

## Swapping a photo in a page

1. Click the image in the editor.
2. Click **Replace** in the toolbar.
3. Upload a new file or pick from **Media Library**.
4. Add **alt text** in the right panel (short description of the image).
5. **Update** the page.

WordPress creates smaller sizes automatically; a phone photo is usually fine to upload.

---

## Navigation menus

Header and footer links come from WordPress menus:

1. **Appearance → Menus**.
2. Choose **Primary** or **Footer**, or create a menu and assign it to that location.
3. Save.

Do **not** change **Settings → Permalinks** — that can break old bookmarked URLs that we redirect from the previous site.

---

## Contact form (Gravity Forms)

Submitted messages are **emailed** and **saved** in WordPress.

**View entries**

1. In the left sidebar, open **Forms** (Gravity Forms).
2. Click **Entries** for **Request an Appointment / Contact Us** (or the live title of form 1).

**Export:** From the entries screen you can export to CSV if needed.

**Spam / delivery:** If email didn’t arrive but the entry appears here, it is almost always **email delivery** (SMTP). Tell the developer.

This form is a **general inquiry** channel — not a HIPAA portal. Avoid pasting detailed medical history; use it to ask for a callback or appointment.

---

## Who gets which email

| Inquiry type | Recipient(s) |
|---|---|
| Appointment request | Michaela — plus Dr. Lubben (BCC) if “mobile/farm visit” is checked |
| General question | Michaela |
| Billing or records | Billing inbox *(confirm at intake — may be Michaela)* |
| Emergency | Dr. Lubben + Michaela |

Routing is set in the form’s **Notifications**. Changes go through the developer.

---

## Things to leave as they are

- **Settings → Permalinks**
- **Appearance → Themes** — keep **Lubben Vet** active
- **Plugins** — keep active (especially **Gravity Forms** and your **SMTP** plugin). Updating plugins from the dashboard is fine; don’t delete or deactivate unless the developer says so.

---

## When something looks wrong

1. **Hard refresh** or try an **incognito/private** window — caching often causes “old” pages.
2. **Form email missing?** Check **Forms → Entries** first.
3. Still stuck? Email the developer with the page URL, phone vs computer, and a screenshot if possible.

---

## Backups

Use the host’s backup tools (e.g. **Backup Now** in the Bluehost dashboard). Automatic backups are usually on by default.

---

## Training video (launch day)

Short recording (e.g. Loom): updating the **homepage hero** in the Customizer, **replacing a photo** on a page, and **opening form entries**.

**Recording link:** *(paste URL here)*

---

*Printable PDF — ask the developer if you want a copy.*
