# Design System Inspired by Bagisto POS

## 1. Visual Theme & Atmosphere

The Bagisto POS design system embodies a clean, professional retail interface optimized for fast transactions and product discovery. The aesthetic balances minimal, functional design with approachable warmth—neutral backgrounds and clear typography support quick scanning of inventory and pricing, while green and slate accents provide confident action points. The interface prioritizes clarity over decoration, using ample whitespace, structured grids, and direct visual feedback to create a trustworthy, efficient commerce experience for both cashiers and customers. The color palette is anchored in deep charcoals and crisp whites, punctuated by verdant success states and muted secondary actions that guide users through workflows with natural visual hierarchy.

**Key Characteristics**
- Clean, minimal aesthetic with strong focus on usability and transaction speed
- Neutral-first palette with strategic green and slate accents for action states
- Generous whitespace supporting visual breathing room and reduced cognitive load
- Clear hierarchy enabling rapid product scanning and price comparison
- Accessible contrast ratios and readable typography throughout all density levels
- Modern, professional tone suited for retail environments and both web and POS terminals

## 2. Color Palette & Roles

### Primary
- **Deep Charcoal** (`#111827`): Primary text, headings, and UI elements; establishes strong visual foundation and readability
- **Black** (`#000000`): Maximum contrast text, critical UI boundaries, and strong emphasis states

### Accent Colors
- **Slate** (`#475569`): Secondary UI elements, supporting text, and muted interactive states
- **Medium Gray** (`#6B7280`): Tertiary text and subtle UI separations
- **Dark Gray** (`#1F2937`): Enhanced contrast for disabled or secondary content

### Interactive
- **Slate Button** (`#475569`): Secondary action buttons, neutral CTAs; background with white text
- **Success Green** (`#16A34A`): Positive actions, "Proceed" buttons, confirmations; indicates safe, forward-moving operations
- **Error Red** (`#DC2626`): Destructive actions, validation errors, critical warnings

### Neutral Scale
- **Light Border** (`#E5E7EB`): Primary border color for inputs, dividers, cards; creates subtle structure
- **Very Light Gray** (`#F3F4F6`): Input backgrounds, subtle surface differentiation
- **Off-White** (`#FAFAFA`): Secondary surface backgrounds for cards and containers
- **White** (`#FFFFFF`): Primary surface for cards, modals, and contained content
- **Light Gray** (`#A3A3A3`): Placeholder text, disabled content, muted labels
- **Zinc** (`#71717A`): Tertiary labels and secondary helper text

### Surface & Borders
- **Card Background** (`#FFFFFF`): Primary container for product cards, order summaries, and content modules
- **Input Surface** (`#F3F4F6`): Search and form field backgrounds; subtle distinction from white
- **Border Stroke** (`#E5E7EB`): Consistent border color for inputs, dividers, and card edges; 1px weight

### Semantic / Status
- **Success** (`#16A34A`): Positive confirmations, successful transactions, "Proceed" CTA; conveys forward motion
- **Danger** (`#DC2626`): Errors, destructive actions, critical warnings; red spectrum for immediate recognition
- **Warning** (`#F83015`): High-priority alerts and cautionary states; brighter red for attention-grabbing

## 3. Typography Rules

### Font Family
**Primary Font:** `ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`

Clean, system-native sans-serif stack ensuring excellent rendering across all retail and web environments. No serif or specialty fonts; legibility and speed are paramount.

### Hierarchy

| Role | Font | Size | Weight | Line Height | Letter Spacing | Notes |
|------|------|------|--------|-------------|----------------|-------|
| Display / H1 | ui-sans-serif | 24px | 600 | 32px | 0px | Large headings, page titles |
| Heading / H2 | ui-sans-serif | 20px | 600 | 28px | 0px | Section headings, category labels |
| Heading / H3 | ui-sans-serif | 18px | 600 | 26px | 0px | Subsection titles, card titles |
| Body Large | ui-sans-serif | 16px | 400 | 24px | 0px | Primary body text, product names |
| Body Regular | ui-sans-serif | 16px | 400 | 20px | 0px | Standard paragraph text, descriptions |
| Button / Link | ui-sans-serif | 16px | 600 | 20px | 0px | Interactive elements, CTAs |
| Label | ui-sans-serif | 14px | 500 | 20px | 0px | Form labels, metadata, helper text |
| Caption / Small | ui-sans-serif | 12px | 400 | 18px | 0px | Fine print, timestamps, tertiary info |
| Code / Monospace | `Monaco, Courier New, monospace` | 14px | 400 | 20px | 0px | Pricing displays, SKUs |

### Principles
- **Speed over decoration:** Single font family eliminates rendering complexity; system fonts load instantly for POS terminals
- **Weight contrast:** Only 400 (normal) and 600 (semibold) weights reduce decision fatigue and ensure clear hierarchy
- **Generous line height:** 1.25–1.6 multiplier aids readability at small sizes and on retail displays
- **Vertical rhythm:** All sizes align to 4px grid; line height multiples maintain baseline alignment
- **High contrast:** Dark text on light surfaces; always meet WCAG AA standards for accessibility

## 4. Component Stylings

### Buttons

#### Primary Button (Green — Proceed / Positive Action)
- **Background:** `#16A34A`
- **Text Color:** `#FFFFFF`
- **Font Size:** `16px`
- **Font Weight:** `600`
- **Padding:** `12px 12px`
- **Border Radius:** `8px`
- **Border:** None (0px)
- **Height:** `48px`
- **Line Height:** `20px`
- **Hover State:** Background `#15803D`, text remains white, subtle lift (shadow: `0px 2px 8px rgba(0, 0, 0, 0.15)`)
- **Active State:** Background `#166534`, pressed visual effect
- **Disabled State:** Background `#D1D5DB`, text `#9CA3AF`, cursor not-allowed

#### Secondary Button (Slate — Neutral Action)
- **Background:** `#475569`
- **Text Color:** `#FFFFFF`
- **Font Size:** `16px`
- **Font Weight:** `600`
- **Padding:** `12px 12px`
- **Border Radius:** `8px`
- **Border:** None (0px)
- **Height:** `48px`
- **Line Height:** `20px`
- **Hover State:** Background `#334155`, text remains white
- **Active State:** Background `#1E293B`, pressed effect
- **Disabled State:** Background `#E5E7EB`, text `#9CA3AF`

#### Outline Button (Slate Border — Tertiary Action)
- **Background:** `#FFFFFF`
- **Text Color:** `#475569`
- **Font Size:** `16px`
- **Font Weight:** `600`
- **Padding:** `12px 12px`
- **Border Radius:** `8px`
- **Border:** `2px solid #475569`
- **Height:** `48px`
- **Line Height:** `20px`
- **Hover State:** Background `#F3F4F6`, border color `#334155`, text `#334155`
- **Active State:** Background `#E5E7EB`, text `#1E293B`

#### Ghost Button (No Background)
- **Background:** `transparent`
- **Text Color:** `#475569`
- **Font Size:** `16px`
- **Font Weight:** `400`
- **Padding:** `0px`
- **Border Radius:** `0px`
- **Border:** None (0px)
- **Height:** `44px`
- **Line Height:** `24px`
- **Hover State:** Background `rgba(71, 85, 105, 0.08)`, text `#334155`
- **Active State:** Text `#1E293B`

### Cards & Containers

#### Product Card
- **Background:** `#FFFFFF`
- **Border:** `1px solid #E5E7EB`
- **Border Radius:** `8px`
- **Padding:** `0px` (image flush), `12px` (content section)
- **Box Shadow:** `0px 1px 3px rgba(0, 0, 0, 0.1)`
- **Image Area:** Rounded top `8px 8px 0px 0px`, aspect ratio 1:1
- **Title Font:** `16px` weight `600`, color `#111827`
- **Price Font:** `16px` weight `600`, color `#111827`
- **Hover State:** Box shadow `0px 4px 12px rgba(0, 0, 0, 0.15)`, slight lift

#### Order Summary Card
- **Background:** `#FFFFFF`
- **Border:** `1px solid #E5E7EB`
- **Border Radius:** `8px`
- **Padding:** `16px`
- **Box Shadow:** None (flat)
- **Line Items:** Each row `16px` height, padding `8px 0px`
- **Total Row:** Font weight `600`, border-top `1px solid #E5E7EB`, padding-top `12px`

#### Category Pill / Badge
- **Background:** `#F3F4F6`
- **Text Color:** `#475569`
- **Font Size:** `14px`
- **Font Weight:** `500`
- **Padding:** `6px 12px`
- **Border Radius:** `9999px`
- **Border:** `2px solid #475569` (active state)
- **Active State:** Background `#475569`, text `#FFFFFF`

### Inputs & Forms

#### Text Input (Search)
- **Background:** `#F3F4F6`
- **Text Color:** `#111827`
- **Placeholder Color:** `#A3A3A3`
- **Font Size:** `16px`
- **Font Weight:** `400`
- **Padding:** `12px 14px`
- **Border Radius:** `6px`
- **Border:** `1px solid #E5E7EB` (default), `2px solid #475569` (focus)
- **Height:** `48px`
- **Line Height:** `20px`
- **Focus State:** Border `2px solid #475569`, outline none, shadow `0px 0px 0px 3px rgba(71, 85, 105, 0.1)`
- **Error State:** Border `2px solid #DC2626`, background `#FEF2F2`

#### Text Input (Form Field)
- **Background:** `#F3F4F6`
- **Text Color:** `#1F2937`
- **Font Size:** `16px`
- **Font Weight:** `400`
- **Padding:** `12px 14px`
- **Border Radius:** `6px`
- **Border:** `1px solid #E5E7EB`
- **Height:** `48px`
- **Width:** `100%`
- **Line Height:** `20px`
- **Focus State:** Border `2px solid #475569`, shadow `0px 0px 0px 3px rgba(71, 85, 105, 0.1)`

### Navigation

#### Sidebar Navigation
- **Background:** `rgba(0, 0, 0, 0)` (transparent to page background)
- **Width:** `80px`
- **Height:** `560px` (scrollable)
- **Border Right:** `1px solid #E5E7EB` with inset shadow `rgba(0, 0, 0, 0.1) 0px -1px 0px 0px inset`

#### Navigation Item (Icon + Label)
- **Container:** `80px` width, `80px` height
- **Background:** `#F3F4F6` (inactive), `#E5E7EB` (hover)
- **Text Color:** `#475569`
- **Font Size:** `16px`
- **Font Weight:** `400`
- **Border Radius:** `8px`
- **Hover State:** Background `#E5E7EB`, text `#334155`
- **Active State:** Background `#475569`, text `#FFFFFF`, border `2px solid #475569`

#### Navigation Item (Inactive)
- **Background:** `transparent`
- **Text Color:** `#A3A3A3`
- **Border Radius:** `8px`
- **Hover State:** Background `#F3F4F6`, text `#475569`

### Top Header Bar

#### Search Bar Container
- **Background:** `#FFFFFF`
- **Border:** `1px solid #E5E7EB`
- **Padding:** `8px 12px`
- **Border Radius:** `6px`
- **Display:** Flex, gap `8px`

#### Category Navigation (Horizontal Scroll)
- **Background:** `#FFFFFF`
- **Items:** Each category link styled as pill with `6px 12px` padding, `9999px` border radius
- **Text Color:** `#475569`
- **Font Weight:** `500`
- **Font Size:** `14px`
- **Active Category:** Background `#475569`, text `#FFFFFF`

## 5. Layout Principles

### Spacing System
**Base Unit:** `4px`

**Spacing Scale:**
- `4px` — Micro gaps, tight component spacing
- `8px` — Minimal padding, inline spacing
- `12px` — Standard padding for inputs, buttons, small containers
- `16px` — Primary padding for cards, sections
- `24px` — Medium section spacing
- `32px` — Large spacing between major sections
- `40px` — Extra large margins for layout breathing room
- `112px` — Maximum padding for edge buffers and oversized containers

**Usage Context:**
- Inputs and form fields: `12px 14px` (vertical horizontal)
- Button padding: `12px 12px`
- Card padding: `12px` (product cards), `16px` (order summary)
- Gap between grid items: `16px`
- Margin between sections: `24px` to `32px`

### Grid & Container
- **Max Width:** `1440px` (desktop), full width on tablet/mobile
- **Column Strategy:** 4-column product grid on desktop (each card `280px` nominal width); 2-column on tablet; 1-column on mobile
- **Section Pattern:** Full-width container with internal padding `40px` horizontal, `32px` vertical
- **Sidebar Width:** Fixed `80px` (navigation), content area flex-1
- **Header Height:** `64px` fixed top, z-index `100`

### Whitespace Philosophy
Ample whitespace reduces cognitive load and accelerates scanning in fast-paced retail environments. Minimum `16px` gap between product cards; `24px+` between major section blocks. All text blocks padded with at least `12px` breathing room on interior edges. Use whitespace to group related information rather than heavy borders; subtle shadows (`0px 1px 3px rgba(0, 0, 0, 0.1)`) replace thick dividers.

### Border Radius Scale
- `0px` — No radius; used for full-width containers, navigation bars
- `4px` — Minimal rounding for images, very subtle UI accents
- `6px` — Input fields and small form elements
- `8px` — Buttons, cards, medium containers
- `9999px` — Full-rounded pills for category badges, circular avatars

## 6. Depth & Elevation

| Level | Treatment | Use |
|-------|-----------|-----|
| Flat (L0) | No shadow; `box-shadow: none` | Navigation sidebar, header bar, lightweight containers |
| Subtle (L1) | `0px 1px 3px rgba(0, 0, 0, 0.1)` | Product cards, form fields (default state) |
| Raised (L2) | `0px 2px 8px rgba(0, 0, 0, 0.15)` | Hover state on buttons, elevated cards |
| Floating (L3) | `0px 4px 12px rgba(0, 0, 0, 0.15)` | Modals, dropdowns, prominent cards on hover |
| Deep (L4) | `0px 2px 16px rgba(34, 22, 22, 0.08)` | Custom high-emphasis modals, full-screen overlays |

**Shadow Philosophy:**
Shadows create subtle elevation and focus without dominating the interface. All shadows use black with low opacity (`0.08–0.15`) to maintain the clean, professional aesthetic. Inset shadows (`rgba(0, 0, 0, 0.1) -1px 0px 0px 0px inset`) mark navigation boundaries without visual weight. Shadows intensify on interaction (hover, focus) to provide tactile feedback without explicit state changes. The signature deep shadow (`rgba(34, 22, 22, 0.08) 0px 2px 16px 0px`) is reserved for premium, high-attention modals and overlays.

## 7. Do's and Don'ts

### Do
- Use `#16A34A` green exclusively for positive, forward-moving actions ("Proceed," "Confirm," "Add to Cart")
- Apply `#475569` slate for secondary and neutral CTAs that do not imply approval or risk
- Maintain minimum `48px` height for all touchable buttons and interactive elements (accessibility standard for retail terminals)
- Group related information in `#FFFFFF` cards with subtle `1px #E5E7EB` borders and light shadows
- Use `12px 14px` padding consistently in all input and form fields for visual rhythm
- Implement `8px` border radius on buttons and cards for modern, approachable appearance
- Provide clear focus states on interactive elements with `2px solid #475569` borders and soft shadow rings
- Stack product cards in responsive 4-column grid on desktop, collapsing to 2 or 1 column on smaller screens
- Use placeholders and helper text in `#A3A3A3` gray for non-critical information
- Include hover state elevation (`0px 2px 8px rgba(0, 0, 0, 0.15)`) on interactive cards to signal clickability

### Don't
- Mix semantic colors (success green and error red in the same button state)
- Use text smaller than `14px` for primary content; reserve `12px` for captions only
- Apply shadows darker than `rgba(0, 0, 0, 0.15)` outside of the deep modal context
- Place interactive elements without minimum `48px` touch targets in POS environments
- Use more than two font weights in a single interface; stick to `400` (normal) and `600` (semibold)
- Hide critical information under multiple layers; pricing and product availability must be immediately visible
- Apply rounded corners (`> 8px`) to buttons or cards; consistency demands `6–8px` scale
- Add decorative borders or dividers; whitespace and subtle shadows are preferred
- Display product images with aspect ratios other than 1:1 on grid; maintain visual consistency
- Combine multiple accent colors (slate + green + red) in a single interface section; separate by functional zone

## 8. Responsive Behavior

### Breakpoints

| Name | Width | Key Changes |
|------|-------|-------------|
| Mobile | `0px – 640px` | 1-column product grid, full-width cards, collapsed navigation (drawer), search input full width, font size reduced by 1 step |
| Tablet | `641px – 1024px` | 2-column product grid, sidebar navigation narrows to icon-only (80px), padding reduced to `24px`, section spacing `16px` |
| Desktop | `1025px+` | 4-column product grid, full sidebar navigation (140px), standard `40px` padding, full spacing scale |
| Large Desktop | `1440px+` | Max width constrained to `1440px`, centered container, lateral padding increased to `60px` |

### Touch Targets
- **Minimum height:** `48px` for all buttons, links, and interactive elements (retail environment standard)
- **Minimum width:** `44px` for icon-only buttons
- **Minimum tap zone:** `48px × 48px` square, centered on interactive element
- **Spacing between targets:** Minimum `8px` horizontal/vertical clearance to prevent accidental taps
- **Product card clickable area:** Entire card is interactive; minimum `280px` width to avoid mis-taps

### Collapsing Strategy
- **Mobile (`< 641px`):** Hide category navigation pills entirely; use dropdown menu. Sidebar navigation becomes offscreen drawer with hamburger toggle. Product cards expand to full width with `12px` padding. Header search bar takes full available width. Remove all "nice-to-have" secondary UI elements.
- **Tablet (`641px – 1024px`):** Reduce sidebar to icon-only (80px width); labels appear on hover/focus. Product grid collapses to 2 columns with `12px` gap. Category pills reappear but with reduced font size (`14px`). Reduce section padding to `24px`.
- **Desktop (`1025px+`):** Full navigation with 140px sidebar. 4-column grid. All typography at full scale. Standard spacing. Horizontal scrolling for category navigation.

## 9. Agent Prompt Guide

### Quick Color Reference
- **Primary CTA (Proceed/Positive):** Success Green (`#16A34A`)
- **Secondary CTA (Neutral):** Slate (`#475569`)
- **Tertiary CTA (Outline):** Slate with white background and `2px` border (`#475569`)
- **Error/Danger:** Error Red (`#DC2626`) for validation and destructive actions
- **Background (Page):** Off-White (`#FAFAFA`) or White (`#FFFFFF`)
- **Background (Inputs):** Very Light Gray (`#F3F4F6`)
- **Heading Text:** Deep Charcoal (`#111827`)
- **Body Text:** Deep Charcoal (`#111827`)
- **Secondary Text:** Slate (`#475569`)
- **Tertiary/Muted Text:** Light Gray (`#A3A3A3`)
- **Borders:** Light Border (`#E5E7EB`)
- **Success Indicator:** Success Green (`#16A34A`)

### Iteration Guide

1. **Always use system fonts** (`ui-sans-serif` stack) for instant rendering on POS terminals; no custom web fonts or serif alternatives.

2. **Button sizing is fixed at `48px` height** with `12px` padding (top/bottom/left/right); this ensures accessibility in fast-paced retail environments. Hover states add shadow elevation only; do not change button height on interaction.

3. **Cards are white (`#FFFFFF`) with `1px #E5E7EB` borders** and subtle shadow (`0px 1px 3px rgba(0, 0, 0, 0.1)`). Product card images are flush-top with `8px` border radius; content sections below have `12px` padding.

4. **Input fields are `48px` tall, `12px 14px` padding, `6px` border radius, `#F3F4F6` background**. Focus state adds `2px solid #475569` border and soft shadow ring. Error state changes background to `#FEF2F2` and border to `2px solid #DC2626`.

5. **Green (`#16A34A`) is reserved for positive, forward-moving actions only** ("Proceed," "Confirm," "Add"). Slate (`#475569`) is the default secondary color for all neutral CTAs. Red (`#DC2626+`) is error/danger only.

6. **Typography weights are restricted to `400` and `600` only**. Headers and CTAs use `600`; body and secondary UI use `400`. No intermediate weights.

7. **Sidebar navigation is fixed `80px` width** with `1px right border` and inset shadow. Each item is `80px × 80px` with icon + label. Active state: `#475569` background + white text. Inactive: transparent with `#475569` text.

8. **Product grid is 4 columns on desktop** (`280px` nominal width per card + `16px` gap), 2 columns on tablet, 1 column on mobile. All cards maintain 1:1 image aspect ratio.

9. **Section padding is `40px` horizontal and `32px` vertical**; reduce to `24px` on tablet, `12px` on mobile. Max content width is `1440px`, centered on large screens.

10. **Whitespace and subtle shadows replace heavy dividers**. Minimum `16px` gap between cards; `24px+` between major sections. Use `rgba(0, 0, 0, 0.1)` inset shadows for navigation/header boundaries only.