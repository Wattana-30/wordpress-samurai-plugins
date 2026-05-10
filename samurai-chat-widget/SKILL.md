# Samurai Chat Widget Development Skill

This file tracks the development, modifications, and architectural rules for the Samurai Chat Widget plugin.

## Project Overview
- **File:** `samurai_chat.php`
- **Version:** 4.5.0
- **Purpose:** Multi-functional chat widget for WordPress — FAQ, Promo Carousel, Location Directory
- **Shortcode:** `[samurai_chat]`
- **Admin page:** wp-admin → ⚔️ Samurai Chat

## Architecture

### Constants
| Constant | Option Key | Purpose |
|---|---|---|
| `SCW_BRAND` | `scw_brand_settings` | Brand config |
| `SCW_FAQ` | `scw_faq_items` | FAQ items |
| `SCW_PROMO` | `scw_promo_items` | Promo carousel |
| `SCW_LOCATION` | `scw_location_items` | Location directory |

### PHP Functions
| Function | Purpose |
|---|---|
| `scw_icon_list()` | Returns array of Material Symbol icon names |
| `scw_brand_default()` | Default brand config |
| `scw_faq_default()` | Default FAQ items (9 items) |
| `scw_promo_default()` | Default promo items (2 items) |
| `scw_loc_default()` | Default locations (3 items) |
| `scw_admin_page()` | Admin UI (line ~150–480) |
| `scw_render_widget()` | Shortcode frontend output (line ~485–946) |

### Admin Panel (4 Tabs)
- **แบรนด์** — name, color_primary, avatar_url, welcome_img, welcome_msg, line_url, cta_label, cta_url
- **FAQ** — icon, label, category, related[], question, answer (HTML), type (text/promo/location), btn_label, btn_url
- **โปรโมชั่น** — title, image_url, description, btn_label, btn_url, active
- **สาขา** — province, name, hours, phone, address, note, lat, lng, map_url

### Frontend Widget Components
| Component | Class prefix | Notes |
|---|---|---|
| Phone mockup | `.sw-ph` | Desktop only (hidden on ≤860px) |
| Status bar | `.sw-sb` | Shows live clock |
| Chat header | `.sw-ch` | Avatar + name + CTA |
| Chat history | `.sw-hist` | Scrollable message area |
| Rich menu | `.sw-rm` | Mobile only (grid of FAQ buttons) |
| Sidebar panel | `.sw-side` | Desktop only, 460px max |
| FAQ list | `.sw-ql` | Sidebar, with search |
| Location panel | `.sw-ll` | Sidebar, with chips filter |
| Bubbles | `.sw-msg` | `.sw-msg-a` (bot) / `.sw-msg-u` (user) |
| Promo carousel | `.sw-car` | Drag-enabled, horizontal scroll |
| Location cards | `.sw-lcw` | Compact, shows first 3 |
| Nav buttons | `.sw-nb` | Related FAQs |

### JavaScript (IIFE, scoped by `uid`)
- `uid` = `scw_` + random 8 chars (prevents multi-widget conflict)
- `doClick(fid)` — handles FAQ click, renders chat sequence
- `welcome(delay)` — renders welcome sticker + message
- `prHTML()` — renders promo carousel HTML
- `lcHTML()` — renders compact location cards (first 3, with "ดูทั้งหมด")
- `buildSidebarLoc()` — builds full location sidebar (chips, search, grouped)
- `navBtns(cid)` — related FAQ nav buttons (uses `related[]` or fallback)
- `enableXDrag(root)` — drag-scroll for `.sw-car` and `.sw-lchips`
- Analytics: pushes to `window.dataLayer` (GTM) and `window.gtag` (GA4)
- IntersectionObserver: triggers entrance animation + welcome on scroll into view

### Responsive Breakpoints
- `>860px` — Phone + Sidebar side-by-side; rich menu hidden
- `≤860px` — Phone only (full width); sidebar hidden; rich menu shown
- `≤440px` — Smaller phone, thinner border

### Icons & Fonts
- **Icons:** Material Symbols Rounded (Google Fonts CDN)
- **Frontend font:** Prompt (Google Fonts)
- **Admin font:** Segoe UI

## Development Rules
1. **Read SKILL.md first** before any modification.
2. **Surgical Edits:** Use `Edit` (replace) to keep structure intact.
3. **Component Integrity:** Keep Admin PHP, Frontend CSS, and Frontend JS clearly separated.
4. **Icons:** All new icons must use Material Symbols Rounded names.
5. **Logging:** Every modification must be recorded in the [Change Log](#change-log) section below.
6. **uid scoping:** JS vars/functions must use `U` (the uid) to avoid cross-widget conflicts.
7. **Security:** Admin save always uses `sanitize_*` / `esc_*` / `wp_kses_post` / `check_admin_referer`.

## Change Log

### [2026-05-10] Initialization
- Created dedicated folder `samurai-chat-widget`.
- Initialized `SKILL.md` for tracking changes.

### [2026-05-10] Full Architecture Audit
- Read full `samurai_chat.php` (946 lines).
- Documented all functions, components, JS helpers, CSS classes, and breakpoints in SKILL.md.

### [2026-05-10] UX Improvement A — Category Chips + Reset Button
**Category Chips (Sidebar FAQ panel)**
- Added CSS: `.sw-fchips`, `.sw-fchip`, `.sw-fchip.active` / `.sw-fchip:hover`
- Added HTML: `<div class="sw-fchips" id="{uid}_fc">` between search and `.sw-ql`
- Added `btn.dataset.cat` on each FAQ button (uses existing `category` field)
- JS: `FC`, `activeChip`, `applyFaqFilter()` — replaces old inline search listener
- Chips auto-hide if no FAQ has a `category` value (chips appear only when `cats.length >= 1`)
- Chip filter + search box work together (AND logic)

### [2026-05-10] Global No-Underline Rule
- Added `.sw a, .sw-sheet a, .sw-sheet-ov a{text-decoration:none;}` ครอบทุก link ใน widget + bottom sheet

### [2026-05-10] Mobile Location — Bottom Sheet
- Added CSS: `.sw-sheet-ov`, `.sw-sheet`, `.sw-sheet-drag`, `.sw-sheet-hd`, `.sw-sheet-srch`, `.sw-sheet-chips`, `.sw-sheet-body`, `.sw-sheet-gtitle`, `.sw-sheet-none`
- Added JS var `COL` (brand primary color) passed to sheet via CSS custom property `--p`
- Added `buildSheet()` — creates overlay + sheet appended to `<body>` (avoids transform stacking-context issues), builds location rows grouped by province, chip filter + search, drag-to-close on drag bar, backdrop click to close
- Added `openSheet()` / `closeSheet()` — animate slide-up/down
- Updated `[data-scw-show-locations]` handler: `>860px` → `showLocPanel()` (desktop sidebar), else → `openSheet()` (mobile bottom sheet)
- Removed `lcAllHTML()` (replaced by bottom sheet)

### [2026-05-10] Rich Menu — Max Height + Search Bar
- `.sw-rm` redesigned as overflow-hidden slider container (not grid). New children: `.sw-rm-track` (flex slider), `.sw-rm-page` (4-col grid per page), `.sw-rm-dots` + `.sw-rm-dot` (pagination dots), `.sw-rm-flat` (search results grid)
- Paged layout: 4 cols × 2 rows = 8 items/page. Pages calculated from `miItems.length`. Dots appear only if >1 page
- Touch swipe + pointer drag to change page (threshold 40px). Live `translateX` during drag, snaps on release
- Search (`RS` listener): hides slider+dots, shows `.sw-rm-flat` flat grid filtered from `miItems`. Clearing search restores slider
- `miItems[]` array collects all `.sw-mi` elements before building pages (no longer appended directly to RM)
- Added `.sw-rbar` search bar between hist and rm in PHP HTML — hidden desktop, flex on ≤860px

**Reset Button (Chat header)**
- Added CSS: `.sw-reset`, `.sw-reset:hover`
- Added HTML: `refresh` icon button wrapped with the call icon in a flex div (margin-left:auto on wrapper)
- JS: `window[U+'_reset']` — clears chat, resets TY flag, active states, sidebar panel, chip filter, search input, then re-runs `welcome(true)`

### [2026-05-10] Interactive Map — List/Map Tab Toggle in Sidebar + Bottom Sheet

**Leaflet loading (PHP)**
- Added `static $scw_leaflet_loaded` guard to load Leaflet CSS/JS CDN exactly once per page (avoids duplicate loading when multiple shortcodes used)
- Leaflet 1.9.4 from unpkg CDN; CartoDB light tiles

**CSS**
- Added `.sw-loctabs`, `.sw-loctab`, `.sw-loctab.active`, `.sw-loctab:hover:not(.active)` — tab bar shared by both sidebar and bottom sheet
- Added `.sw-locmap` — flex:1 map container for sidebar (border-radius:12px, overflow:hidden)
- Added Leaflet popup font-family override for Prompt

**JS**
- `var _mapInst={}` — registry prevents re-initializing maps already created (uses mapId key)
- `initLocMap(el, mapId)` — initializes Leaflet map with custom SVG pin (brand color `COL`), CartoDB tiles, all LO markers with name/hours/navigate popup; retries if `L` not yet loaded; calls `invalidateSize()` on revisit
- `requestAnimationFrame` used before `initLocMap` so container has layout before Leaflet reads dimensions

**Sidebar (`buildSidebarLoc()`)**
- `LL.innerHTML` now wraps content: tabs bar → `#lllist` (list, flex:1, overflow-y:auto) → `#llmap` (.sw-locmap, hidden)
- `LL.style.overflow='hidden'` overrides .sw-ll scroll so only inner list div scrolls
- Tab click: toggles active class, shows/hides `#lllist` / `#llmap`, triggers `initLocMap`

**Bottom Sheet (`buildSheet()`)**
- Added `.sw-loctabs` div inside `.sw-sheet-hd` after chips; uses `data-bstab` attribute
- Added `#bsmap` div (`flex:1; min-height:200px`) after `.sw-sheet-body`
- Tab click: shows/hides `#bsb` / `#bsmap`, triggers `initLocMap(bsMap, U+'_bsmap')`
- `#bsmap` ใช้ `min-height:55dvh` (ปรับตามขนาดจอ) แทน fixed 200px เพื่อให้แผนที่สูงพอใช้งาน

### [2026-05-10] Map Marker Filter ตาม Chip หมวดหมู่
- Refactor `initLocMap` — แยก marker logic ออกเป็น `_mapAddMarkers(mapId, locs[])` พร้อม `_mapLayers{}` (LayerGroup per map)
- `initLocMap(el, mapId, locs)` รับ locs array ที่ filtered แล้ว; ถ้า map มีอยู่แล้ว → `invalidateSize()` + `_mapAddMarkers` แทน re-init
- `llFiltered()` / `bsFiltered()` — helper คืน `LO` ที่กรองตาม `activeFilter` (province) ของแต่ละ context
- Sidebar chip click: เรียก `_mapAddMarkers(U+'_llmap', llFiltered())` ถ้า map tab กำลังแสดงอยู่
- Bottom sheet chip click: เรียก `_mapAddMarkers(U+'_bsmap', bsFiltered())` ถ้า map tab กำลังแสดงอยู่
- Tab click (map): ส่ง `filteredLocs()` ให้ `initLocMap` เสมอ ไม่ใช่ `LO` ทั้งหมด

### [2026-05-10] Admin — Collapsible Rows + Sort + Map Picker
- Leaflet 1.9.4 โหลดในหน้า admin ด้วย (ไม่มี static guard เพราะ admin render ครั้งเดียว)
- **CSS:** `.scw-row-body`, `.scw-row.collapsed .scw-row-body{display:none}`, `.scw-fold`, `.scw-row-title`, `.scw-mv`, `.scw-mapbtn`, `.scw-map-coords`, `.scw-map-ok`
- **Map modal:** `#scwMapModal` + `#scwMapDiv` (Leaflet, CartoDB tiles, click-to-pin)
- **ทุก tab (FAQ/Promo/Location):** rows เริ่มต้น `collapsed`, header แสดงชื่อ/label, ปุ่ม ▶/▼ fold, ↑↓ sort
- **Location tab:** ปุ่ม "📍 เลือกจากแผนที่" เปิด modal → คลิก map → set lat/lng; pre-fill pin ถ้ามีค่าอยู่แล้ว
- **JS:** `scwFold`, `scwMove`, `scwUpdLocTitle`, `scwUpdFaqTitle`, `scwUpdPromoTitle`, `scwMapOpen`, `scwMapClose`, `scwMapConfirm`
- `scwAddLoc/Faq/Promo` อัปเดตให้ใช้ structure ใหม่ (collapsed + row-body wrapper)
- **CSV Import (Location tab):** ปุ่ม "⬇ Download Template" + "⬆ Import CSV" — `scwCsvTemplate()` สร้าง CSV template พร้อม BOM (UTF-8), `scwCsvImport()` parse file + สร้าง row อัตโนมัติ, `scwParseCsvLine()` handle quoted fields, `escHtml()` sanitize ก่อนใส่ DOM
- คอลัมน์ CSV: province, name, hours, phone, address, note, lat, lng, map_url — header row ข้ามอัตโนมัติ

### [2026-05-10] เพิ่ม 15 สาขาใน scw_loc_default()
- แทนที่ 3 สาขาเดิม ด้วย 15 สาขาจากข้อมูลจริง
- กรุงเทพฯ 9 แห่ง (ดอนเมือง, Terminal21 Asok, CentralWorld, MBK, ICONSIAM, สำนักงานใหญ่, EmSphere, Emporium, Mixt จตุจักร)
- สมุทรปราการ 2 แห่ง (สุวรรณภูมิ บูธ SAMURAI WiFi + AIRPORTELs)
- เชียงใหม่ 2 แห่ง (สนามบิน + YouYou Travel), ชลบุรี 1 แห่ง (Terminal21 Pattaya), ภูเก็ต 1 แห่ง (สนามบินภูเก็ต)

### [2026-05-10] Open/Closed Badge + Call Button + Brand Phone

**Brand Phone Field**
- เพิ่ม `phone` ใน `scw_brand_default()`, admin save, admin Brand tab (input type="tel"), และ PHP render (`$phone`)
- Chat header: ถ้ามี `$phone` → ปุ่ม call ใช้ `tel:` link, else fallback เป็น `$cta_url` (เดิม)

**CSS**
- `.sw-open` — badge เขียวกลม "เปิดอยู่"
- `.sw-closed` — badge แดงกลม "ปิดแล้ว"
- `.sw-lcall` — ปุ่มโทรวงกลมสีเขียว (34px)

**JS**
- `isOpenNow(h)` — parse เวลา "HH:MM-HH:MM" หรือ "24 ชม." → return true/false/null
- `openBadge(h)` — return HTML badge string (null = ไม่แสดง)

**Location Cards (ทุก context)**
- `lcHTML()`, `buildSidebarLoc()` row, `buildSheet()` row: เปลี่ยน `<a>` เป็น `<div onclick="window.open(url,'_blank')">`
- เพิ่ม `openBadge(l.hours)` ในชื่อสาขา (`.sw-lcc-n` / `.sw-lrn`)
- ถ้ามี `l.phone` → แสดง `.sw-lcall` (green circle call button) พร้อม `event.stopPropagation()`
- ถ้าไม่มี phone → แสดง navigate button ตามเดิม (เฉพาะ compact cards)
- sidebar rows: แสดงทั้ง call button + navigate button เรียงแนวนอน

### [2026-05-10] Location Data v2 — Category + Image + ข้อมูลจริง

**`scw_loc_default()`**
- ข้อมูล 15 สาขาอัปเดตจาก `SAMURAI_LOCATIONS` จริง พร้อม category, image_url, phone, address ครบ
- Province ใช้ชื่อไทย: สมุทรปราการ, กรุงเทพฯ, เชียงใหม่, ภูเก็ต, พัทยา
- Category: Airport / Mall / Office / Agent

**Admin Location tab**
- เพิ่ม dropdown "ประเภท" (Airport/Mall/Office/Agent) ต่อ row
- เพิ่ม "URL รูปภาพสาขา" (`loc_image_url[]`) + preview

**Admin Save**
- บันทึก `category` และ `image_url` ใหม่

**CSV template/import**
- คอลัมน์ใหม่: province, **category**, name, hours, phone, address, note, **image_url**, lat, lng, map_url
- `scwAddLocData()` รองรับ category + image_url

**CSS** `.sw-lri-img` (38px rounded square) + `.sw-lcc-img` (34px rounded square)

**JS `locIcon(str)`**
- รองรับ category codes: Airport→flight, Mall→shopping_bag, Office→business, Agent→store

**Frontend cards (ทุก context)**
- ถ้ามี `image_url` → แสดงรูปสาขาแทน icon circle (lazy loaded)
- ใช้ `l.category` แทน province สำหรับไอคอนต่อ row

### [2026-05-10] Fix locUrl() — แสดงชื่อสถานที่แทนพิกัดใน Google Maps
- ปัญหาเดิม: URL แบบ `?q=13.91,100.60` → Maps ขึ้นแค่พิกัด ไม่แสดงชื่อสถานที่
- Logic ใหม่: ถ้ามีชื่อ + พิกัด → `?q=ชื่อสาขา&ll=lat,lng` (Maps แสดงชื่อ + pin ตรงพิกัด)
- ถ้า `map_url` มี `/place/` หรือ `place_id` → ใช้ link นั้นตรงๆ (Google Place URL)
- ถ้ามีแค่ชื่อ → ค้นหาด้วยชื่อ (`/maps/search/?api=1&query=NAME`)
- Fallback → coordinate URL เดิม

### [2026-05-10] Sidebar Layout — ย้าย Search+Chips ขึ้น, Tabs ลงล่าง
- แยก `hTools` (search + chips) ออกจาก `h` (location list rows)
- `LL.innerHTML` ลำดับใหม่: `hTools` → `.sw-loctabs` → `#lllist` → `#llmap`
- ผล: search + chip filter อยู่บนสุดเสมอ, tabs อยู่กลาง, content อยู่ล่าง
