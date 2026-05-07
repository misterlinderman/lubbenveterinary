# Lubben Veterinary Services — WordPress Build

Repository for the Lubben Veterinary Services website rebuild (PROP-2026-001).

This repo is rooted at the WordPress `wp-content/` directory. It contains the custom theme (`lubben-vet`), project documentation, and a phased prompt sequence designed for use in Cursor with Claude as the in-IDE pair.

> **Hosting:** Bluehost shared hosting under the developer's account.
> **Domain:** lubbenveterinary.com (DNS handoff at launch — no domain change).
> **CMS:** WordPress (latest stable).
> **Forms:** Gravity Forms (license provided by developer).
> **No Weave integrations** — the client opted out. All client contact flows through Gravity Forms with conditional routing.

---

## Repo layout

```
wp-content/
├── README.md                       ← this file
├── .cursor/
│   └── rules/                      ← Cursor rules pinned to every Claude turn
├── docs/
│   ├── 00-project-brief.md         ← what we're building & why
│   ├── 01-information-architecture.md
│   ├── 02-design-system.md
│   ├── 03-content-migration.md     ← lift from legacy site, cleaned up
│   ├── 04-gravity-forms-spec.md    ← form fields, routing rules, notifications
│   ├── 05-build-plan.md            ← phased plan, mapped to prompts/
│   ├── 06-launch-checklist.md      ← DNS handoff, smoke tests, rollback
│   ├── 07-handoff-to-client.md     ← what Michaela needs to know post-launch
│   ├── content/                    ← raw + cleaned source copy from legacy site
│   └── prompts/                    ← numbered Cursor prompts, run in order
├── themes/
│   └── lubben-vet/                 ← custom theme (this is the deliverable)
└── plugins/                        ← (intentionally empty in repo; see below)
```

### A note on plugins

We do **not** check Gravity Forms or any other third-party plugin source into this repo. Plugins are installed on the Bluehost site directly (or via Composer/wpackagist if we add that later). What lives in this repo for forms is the **specification** (`docs/04-gravity-forms-spec.md`) plus an exported form JSON we'll commit to `themes/lubben-vet/inc/gravity-forms/` once the form is built — that exported JSON is the source of truth and is re-importable.

---

## How to work this repo in Cursor

This project is structured to be driven by a numbered prompt sequence. Each prompt in `docs/prompts/` is a self-contained step that produces or modifies specific files. Run them in order:

1. Open this repo in Cursor.
2. Open `docs/prompts/00-orientation.md` and paste the contents into a new Claude chat. That prompt loads context.
3. Work through `01-…`, `02-…`, etc., in order. Each prompt names the files it expects to create or edit.
4. After each prompt, review the diff before accepting.

The `.cursor/rules/` files pin project-wide constraints (PHP coding standards, no-build-step JS/CSS, accessibility floor) so Claude doesn't have to be re-told every turn.

---

## Local development

You don't strictly need a local WP install to make most theme edits, but for anything beyond template HTML you'll want one. Recommended:

- **Local by Flywheel** (LocalWP) — this project is developed with Local; open the site whose `wp-content/` is this repo (or symlink the tracked paths into a Local site).
- Install **Gravity Forms** on that local site (use the developer license).
- Import `themes/lubben-vet/inc/gravity-forms/contact-form.json` once it exists.

## Deployment to Bluehost

After each **confirmed** development phase, deploy to Bluehost production via **FTP** (upload changed theme files and any coordinated doc assets as needed). Do not push half-finished phases to production. Full cutover steps live in `docs/06-launch-checklist.md`.

---

## Status

| Phase | Status |
|---|---|
| Repo foundation (docs, Cursor rules, theme scaffold) | complete |
| Discovery & content gathering | in progress |
| Design direction approval | pending |
| Theme build | not started (start with `docs/prompts/01-theme-scaffold.md`) |
| Gravity Forms build | not started |
| DNS handoff & launch | not started |

Update this table as we go.
