# Prompt 05 — Gravity Forms integration

> **Goal:** Build the Gravity Form per spec, style it to match the theme, drop it onto the Contact page, and capture its export to the repo. By the end of this prompt, the only contact channel on the site is wired up and routing email correctly.
>
> **Files Claude should create:**
>
> - `themes/lubben-vet/inc/gravity-forms-helpers.php`
> - `themes/lubben-vet/inc/gravity-forms/contact-form.json` (after manual export)
> - And updates to `assets/css/theme.css` for form styling
> - And manual configuration steps in WP admin

---

## Prompt to paste

```
Prompt 05 of the build plan.

Goal: Style and integrate the Gravity Form. Note that this prompt has TWO
parts — Claude can do part A directly, but part B needs me to do the
clicking inside WP admin. Walk me through both.

Read first:
- docs/04-gravity-forms-spec.md (the full form spec — fields, conditional
  logic, notification routing, confirmations).
- The existing theme files. You should already know we don't load jQuery
  unless we have to.

Part A — what you build:

1. themes/lubben-vet/inc/gravity-forms-helpers.php
   - Bail early if Gravity Forms isn't active (check class_exists('GFForms')).
   - Hook into 'gform_pre_render' (and 'gform_pre_validation',
     'gform_pre_submission_filter', 'gform_admin_pre_render') to apply any
     dynamic field tweaks. For now, leave this as a stub function with
     comments — we'll only add tweaks if needed.
   - Hook into 'gform_disable_form_theme_css' returning true so Gravity
     Forms doesn't ship its own theme CSS that fights ours.
   - Hook into 'gform_field_content' to add appropriate classes to certain
     fields (e.g., the emergency notice gets a `lubben-form__notice` class
     so we can style it loud).
   - Provide a small function lubben_vet_render_contact_form() that wraps
     gravity_form(1, false, false, false, null, true) — used by the contact
     page template.

2. Update page-templates/page-contact.php so the #appointment-form section
   calls lubben_vet_render_contact_form() instead of the placeholder
   comment from prompt 03.

3. Add CSS to assets/css/theme.css under a "Gravity Forms — contact form"
   section heading. Style:
   - The form container .gform_wrapper (full width, max-width 720, vertical
     padding using the spacing scale)
   - .gfield labels (use --color-text, font weight 600, margin-bottom 4px)
   - inputs and textareas (1px border --color-border, focus state swaps to
     --color-primary with a 2px outline-offset focus ring per the design
     system)
   - radio and checkbox custom styling that's still keyboard accessible
     (don't reinvent the input — style it via :focus-visible and adjacent
     siblings)
   - the submit button using the theme's primary button styles
   - the .gform_validation_errors / .gfield_error states using --color-accent
   - the conditional emergency notice (.lubben-form__notice) with a clear
     visual treatment — accent border-left, accent-tinted background, larger
     text. This is the most important UI element on the page when shown.
   - The "form submitted" confirmation message styled to match the rest of
     the page.

Constraints:
- We are NOT enabling Gravity Forms' built-in CSS theme. We disable it via
  the filter above and ship our own. This keeps the form consistent with
  the rest of the site.
- No JS dependencies on jQuery from our side. Gravity Forms itself ships
  with jQuery for its conditional logic — that's their footprint, not ours,
  and we accept it.
- All CSS uses the design tokens. No hard-coded hex values in form styles.

Part B — what I do in WP admin (give me a checklist):

1. Install and activate Gravity Forms.
2. Create the form per docs/04-gravity-forms-spec.md, exact field by field
   in the order shown. Tell me which Gravity Forms native field type to use
   for each row of the spec table — be explicit because GF has overlapping
   options.
3. Set up conditional logic for fields 5–9 and 11.
4. Set up the five notifications with conditional logic per the spec.
5. Set up the two confirmations with conditional logic per the spec.
6. Enable honeypot in form settings; disable Save & Continue.
7. Set entry retention to 365 days.
8. Embed the form on the Contact page — but actually, we already render it
   via the template (lubben_vet_render_contact_form). Confirm the form ID
   we created is 1; if not, tell me where to update the ID in the helper.
9. Test each conditional notification with a real submission for each
   "What's this about?" option. Verify the right inboxes get the right
   subject lines and bodies.
10. Forms → Import/Export → Export Forms → export form 1 → save the JSON
    to themes/lubben-vet/inc/gravity-forms/contact-form.json.
11. Commit the JSON.

When done, tell me how to confirm Gravity Forms isn't loading its theme CSS
(I should see no .gform-theme--orbital class on the form wrapper, etc.).
```

---

## Acceptance criteria

- [ ] The Contact page renders the form, styled to match the rest of the site (no Gravity Forms default theme bleeding through).
- [ ] Field conditional logic works: switching the "What's this about?" radio shows/hides the right downstream fields.
- [ ] Submitting one of each category triggers the correct notification recipients with the correct subject lines.
- [ ] The Emergency category shows the loud notice in the form and the loud confirmation after submit.
- [ ] `themes/lubben-vet/inc/gravity-forms/contact-form.json` exists in the repo and is the live form's export.
- [ ] **WP Mail SMTP** is installed and configured (Gmail, SendGrid, or whatever the practice's actual mail provider is) — this is on the launch checklist but pin it now.
