# Design Tokens Setup (Tailwind Config)

**GitHub Issue:** [#1](https://github.com/ar-elfahmi/kasir-warkop-kos/issues/1)

## What to build
Add all design tokens from DESIGN.md to tailwind.config.js: color palette, font family (system-ui stack replacing Figtree), spacing scale, border radius, box shadows, typography rules. Extend Tailwind theme with all specified values.

## Acceptance criteria
- [ ] tailwind.config.js extends theme with all DESIGN.md colors (deep charcoal #111827, black #000000, slate #475569, success green #16A34A, error red #DC2626, neutral scale, etc.)
- [ ] Font family set to `ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif` (remove Figtree)
- [ ] Spacing scale matches 4px base unit: 4, 8, 12, 16, 24, 32, 40, 112
- [ ] Border radius scale configured: 0, 4, 6, 8, 9999
- [ ] Box shadow levels (L0-L4) per DESIGN.md depth & elevation section
- [ ] Typography: font sizes, weights (400, 600), line heights per DESIGN.md typography rules

## Blocked by
None - can start immediately

## Type
AFK