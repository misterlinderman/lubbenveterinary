# 05 — Build Plan

The build is broken into seven sequential prompts, each in `docs/prompts/`. Each prompt:

- States its goal in one sentence.
- Names the files it expects Claude (in Cursor) to create or edit.
- Includes acceptance criteria (a manual check you can do after).
- Cites the docs Claude needs to read first.

The prompts are written **for you to paste into a Claude chat in Cursor**, with the relevant project files open in the editor so Claude can read them via Cursor's context. They assume you have the `.cursor/rules/` files in place — those provide the persistent guardrails (PHP standards, no build step, accessibility floor, etc.).

## The sequence

| # | Prompt | Builds |
|---|---|---|
| 00 | `00-orientation.md` | Loads project context. Output: a one-paragraph summary back to you so you know Claude has it. **Always run this first in a new chat.** |
| 01 | `01-theme-scaffold.md` | `style.css`, `theme.json`, `functions.php`, `index.php`, `assets/css/tokens.css`, `assets/css/theme.css`, `screenshot.png` placeholder |
| 02 | `02-template-hierarchy.md` | `header.php`, `footer.php`, `front-page.php`, `page.php`, `404.php`, `searchform.php`, template parts in `template-parts/` |
| 03 | `03-page-templates.md` | Page templates for About and Contact, plus the homepage section parts |
| 04 | `04-functions-and-hooks.md` | `inc/setup.php`, `inc/enqueue.php`, `inc/redirects.php`, `inc/seo.php`, `inc/nav-menus.php` |
| 05 | `05-gravity-forms-integration.md` | `inc/gravity-forms-helpers.php`, form-targeted CSS, instructions for importing the form |
| 06 | `06-content-population.md` | WP-CLI commands and/or page content blocks to populate Home/About/Contact with the migrated content |
| 07 | `07-launch-prep.md` | DNS handoff plan, redirects verification, SMTP config, Lighthouse pass, smoke tests |

## Working rules for the sequence

1. **Run prompts in order.** Later prompts assume earlier ones completed and the listed files exist.
2. **Review every diff.** Cursor's diff view is the friend you have. Do not bulk-accept.
3. **Don't let Claude install plugins.** Plugins live on the live site, not in the repo. The only plugin reference Claude touches is the JSON export of the Gravity Form.
4. **If a prompt opens a question** ("we don't yet have Michaela's email address — placeholder?"), answer it before letting Claude proceed. Placeholders that ship to production are bugs.
5. **One prompt per chat session, ideally.** Long chats drift. A fresh chat with the orientation prompt reloads the right context cheaply.

## Phase mapping (to the proposal)

| Proposal phase | Prompts |
|---|---|
| Phase 1 — Discovery, content & design | This entire `docs/` folder, plus `00`–`02` |
| Phase 2 — WordPress build, integrations & launch | `03`–`07`, plus the launch checklist |

## Estimated effort

The proposal budgeted ~15 hours total. The prompt sequence is sized to fit that budget assuming the docs in this folder are accurate and the content is on hand at intake. Realistic per-prompt time, with review:

| Prompt | Solo build estimate |
|---|---|
| 00 | 5 min |
| 01 | 60 min |
| 02 | 90 min |
| 03 | 90 min |
| 04 | 60 min |
| 05 | 60 min |
| 06 | 90 min |
| 07 | 60 min + DNS wait |

Anything that overruns by more than 50% is a signal to stop and reconsider scope, not to grind through.
