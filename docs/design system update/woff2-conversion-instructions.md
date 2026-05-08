# Converting Local OTF/TTF Fonts to WOFF2

## Task

Convert a designated set of local font files (`.otf` and `.ttf`) into WOFF2 web fonts using the `woff2_compress` command-line tool, then generate the corresponding `@font-face` CSS rules.

## Prerequisites

Verify `woff2_compress` is installed:

```bash
which woff2_compress
```

If it's missing, install it:

- **macOS:** `brew install woff2`
- **Ubuntu/Debian:** `sudo apt-get install woff2`
- **From source:** Build from [github.com/google/woff2](https://github.com/google/woff2)

## Project Structure

Assume (or create) the following structure:

```
project/
├── fonts/
│   ├── source/          # original .otf / .ttf files go here
│   └── web/             # output .woff2 files will be written here
└── styles/
    └── fonts.css        # generated @font-face rules
```

If `fonts/source/` doesn't exist yet, create the directories and prompt me to drop the source files in before continuing.

## Conversion Steps

### 1. List the source fonts

```bash
ls fonts/source/*.{otf,ttf} 2>/dev/null
```

Confirm with me which files should be converted before proceeding. Do **not** assume all files in the directory should be processed — some may be variants (italic, bold, etc.) that need specific handling in the CSS.

### 2. Convert each font

For each source file, run:

```bash
woff2_compress fonts/source/<filename>.ttf
```

`woff2_compress` writes the output next to the source file with a `.woff2` extension. Move the result into `fonts/web/`:

```bash
mv fonts/source/<filename>.woff2 fonts/web/
```

Or do it as a one-liner loop for the whole batch:

```bash
for f in fonts/source/*.{otf,ttf}; do
  [ -e "$f" ] || continue
  woff2_compress "$f"
  mv "${f%.*}.woff2" fonts/web/
done
```

### 3. Verify output

```bash
ls -lh fonts/web/
```

Confirm each expected `.woff2` file exists and the size looks reasonable (typically 20–60% of the original).

## Generating the CSS

Create or append to `styles/fonts.css` with one `@font-face` block per converted file. Use this template:

```css
@font-face {
  font-family: 'FAMILY_NAME';
  src: url('/fonts/web/FILENAME.woff2') format('woff2');
  font-weight: WEIGHT;
  font-style: STYLE;
  font-display: swap;
}
```

### Filling in the values

- **`font-family`** — the human-readable family name (e.g., `'Inter'`, `'Source Serif Pro'`). Use the same string for all weights/styles in a family so the browser can pick the right file.
- **`font-weight`** — infer from the filename:
  - `Thin` → 100, `ExtraLight` → 200, `Light` → 300
  - `Regular` / no suffix → 400
  - `Medium` → 500, `SemiBold` → 600, `Bold` → 700
  - `ExtraBold` → 800, `Black` → 900
- **`font-style`** — `italic` if the filename contains `Italic` or `Oblique`, otherwise `normal`.
- **`font-display: swap`** — keep this as the default. It shows fallback text immediately while the webfont loads.

If you're unsure how to map a filename to weight/style, ask me before guessing.

### Example output

For source files `Inter-Regular.ttf` and `Inter-Bold.ttf`:

```css
@font-face {
  font-family: 'Inter';
  src: url('/fonts/web/Inter-Regular.woff2') format('woff2');
  font-weight: 400;
  font-style: normal;
  font-display: swap;
}

@font-face {
  font-family: 'Inter';
  src: url('/fonts/web/Inter-Bold.woff2') format('woff2');
  font-weight: 700;
  font-style: normal;
  font-display: swap;
}
```

## Final checks

After conversion and CSS generation:

1. Report the list of files converted, with original vs. WOFF2 sizes.
2. Show the full contents of `styles/fonts.css` so I can review the `@font-face` rules.
3. Flag any source files that were skipped or that you were uncertain about.

## Notes

- **Do not** ship `.ttf` or `.woff` fallbacks alongside the `.woff2` files. WOFF2 has full modern browser support — extra formats just bloat the CSS.
- **Do not** delete the original source files in `fonts/source/`. Keep them for future re-conversion or subsetting.
- If a source font is very large (>200KB after conversion), mention it — subsetting with `pyftsubset` may be worth considering as a follow-up.
