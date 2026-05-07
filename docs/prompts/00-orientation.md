# Prompt 00 — Orientation

> **How to use:** Paste the prompt below into a new Claude chat in Cursor. Make sure the project's `docs/` folder and `.cursor/rules/` are part of Cursor's context. Run this first whenever you start a new chat — it costs almost nothing and prevents Claude from drifting off the project's constraints.

---

## Prompt to paste

```
You're helping me build a custom WordPress theme called "lubben-vet" for Lubben
Veterinary Services LLC. Before we do anything:

1. Read these files in this order and confirm you've read them:
   - docs/00-project-brief.md
   - docs/01-information-architecture.md
   - docs/02-design-system.md
   - docs/03-content-migration.md
   - docs/04-gravity-forms-spec.md
   - docs/05-build-plan.md
   - .cursor/rules/wordpress.md
   - .cursor/rules/frontend.md
   - .cursor/rules/project.md

2. After reading, give me back a 4–6 sentence summary covering:
   - what we're building
   - what we're explicitly NOT building (especially: no Weave)
   - the constraints I care most about
   - the file you'd expect to touch first when we move to building

3. Then stop and wait for me to send the next prompt. Do not start writing
   theme files yet.

If anything in those docs contradicts itself or is ambiguous, flag it now in
your summary — don't paper over it.
```

---

## What you should see back

A short summary that names:

- The three pages (Home, About, Contact) plus the homepage's "Shop Our Online Pharmacy" CTA.
- That **Weave is out** and Gravity Forms is the only contact channel.
- Bluehost shared hosting, no build step, WCAG AA, PHP 8.1+.
- That `themes/lubben-vet/style.css` (and `theme.json`) is the natural first file.

If Claude's summary misses any of those, push back before moving to prompt 01.
