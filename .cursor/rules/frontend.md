# Frontend rules (Lubben Vet)

## Stack

- **No bundler at launch:** hand-authored CSS in `assets/css/` (tokens + theme). Vanilla JS only if needed; **no jQuery** dependency in theme code.
- Design tokens live in `theme.json` and `assets/css/tokens.css` — keep them in sync (see `docs/02-design-system.md`).
- Fonts: self-hosted under `assets/fonts/` (no Google Fonts CDN in production).

## Accessibility (WCAG 2.1 AA floor)

- Semantic landmarks: `header`, `main`, `nav`, `footer`; one `h1` per page; logical heading order.
- Visible **focus styles** on all interactive elements; respect `prefers-reduced-motion`.
- Images: meaningful `alt` text; decorative images `alt=""`.
- Forms: labels associated with controls, inline error text, no placeholder-only labels.

## HTML / CSS

- Valid, semantic HTML5. Prefer native elements (`button`, `a`, `details`) over div soup.
- Use design tokens (custom properties) — avoid magic numbers except in token definitions.
- Mobile-first layout; touch targets adequately sized.

## Third-party

- Do not rely on GF’s default theme styles — they are disabled; style forms with theme CSS to match the design system.
- External links (e.g. pharmacy): `target="_blank"` with `rel="noopener noreferrer"` where appropriate.
