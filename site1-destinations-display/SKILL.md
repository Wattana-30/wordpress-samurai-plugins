# Site 1 — Destinations Display Skill

ไฟล์นี้ track การพัฒนาและแก้ไข `destinations_display.php`

## Project Overview
- **File:** `destinations_display.php`
- **ติดตั้งบน:** เว็บ 1 (Landing site) ผ่าน Code Snippets plugin ("Run snippet everywhere")
- **Purpose:** ดึงข้อมูลประเทศ/ทวีปจาก API ของเว็บ 2 แสดงเป็น shortcode
- **Shortcode:** `[pkg_destinations]`
- **Settings page:** Settings → SIM Destinations

## Architecture

### PHP Functions
| Function | Purpose |
|---|---|
| `sim_destinations_settings_page()` | Admin settings UI (API URL, target URL, cache, Basic Auth) |
| `sim_destinations_fetch($type, $limit)` | ดึงข้อมูลจาก Site 2 API + cache transient |
| `pkg_destinations_shortcode($atts)` | Shortcode handler — render section + tabs + grid |
| `pkg_destinations_card($c)` | Render การ์ดแต่ละประเทศ/ทวีป |
| `sim_destinations_clear_cache()` | ลบ transient ทั้งหมด (DELETE LIKE `_transient_sim_dest_%`) |
| `sim_destinations_assets()` | Output CSS + JS ใน `wp_head` |

### WordPress Options (Settings)
| Option Key | ค่า default | ความหมาย |
|---|---|---|
| `sim_destinations_api_url` | '' | URL หลักของ Site 2 (ไม่ต้องมี `/wp-json`) |
| `sim_destinations_target_url` | '' | URL หน้า `[pkg_filter]` บน Site 2 (คลิกการ์ดไปที่นี่) |
| `sim_destinations_cache_min` | 60 | Cache lifetime (นาที) ใช้ WordPress Transients |
| `sim_destinations_basic_user` | '' | HTTP Basic Auth username (ถ้า server มี password) |
| `sim_destinations_basic_pass` | '' | HTTP Basic Auth password |

### API
- **Endpoint:** `{api_url}/wp-json/samurai/v1/destinations`
- **Parameters:** `?type=country|continent&limit=N`
- **Response:** `{ "success": true, "data": [...] }`
- **Data fields ต่อ item:** `name`, `slug`, `count`, `min_price`, `currency`, `url`, `flag`, `flag_2x`
- เมื่อมี `target_url` ตั้งไว้ → override `url` ของแต่ละ item เป็น `{target_url}?country={slug}`

### Cache
- ใช้ WordPress Transients
- Cache key: `sim_dest_{md5(api_url|type|limit)}`
- ล้าง cache ได้จาก: Settings page ปุ่ม "ล้าง Cache" หรือเมื่อบันทึก Settings ใหม่
- Hook: `update_option_sim_destinations_api_url` / `update_option_sim_destinations_target_url` → trigger `sim_destinations_clear_cache()`

### Shortcode Attributes
| Attribute | Default | ความหมาย |
|---|---|---|
| `limit` | 6 | จำนวนการ์ดสูงสุด |
| `show_tabs` | 'yes' | แสดง tab ประเทศ/ทวีป |
| `default_tab` | 'country' | tab เริ่มต้น |
| `title` | 'ปลายทาง<em>ยอดนิยม</em>' | หัวข้อ (รองรับ HTML) |
| `subtitle` | '...' | คำอธิบาย |
| `show_more` | 'yes' | แสดงปุ่ม "ดูประเทศอื่นๆ" |
| `more_url` | '' | URL ปุ่ม (fallback → target_url จาก Settings) |

### CSS Classes
| Class | Component |
|---|---|
| `.pkgd-section` | Container หลัก (max-width:1200px) |
| `.pkgd-header` | หัวข้อ + subtitle + tabs |
| `.pkgd-title` | `<h2>` หัวข้อ, `em` → สีแดง `#cc0000` |
| `.pkgd-subtitle` | คำอธิบาย |
| `.pkgd-tabs` | กล่อง tabs (pill shape) |
| `.pkgd-tab` | ปุ่ม tab, `.is-active` → พื้นหลังแดง |
| `.pkgd-panel` | content ต่อ tab, `.is-active` → แสดง |
| `.pkgd-grid` | CSS Grid 3 cols (2 cols ≤900px, 1 col ≤540px) |
| `.pkgd-card` | การ์ดประเทศ (anchor) |
| `.pkgd-card-flag` | รูปธงกลม 56px, `.pkgd-card-flag-emoji` → ไม่มีรูป |
| `.pkgd-card-body` | ชื่อ + ราคา |
| `.pkgd-card-name` | ชื่อประเทศ |
| `.pkgd-card-price` | ราคาเริ่มต้น หรือจำนวนแพ็กเกจ |
| `.pkgd-card-arrow` | ลูกศร → (SVG วงกลม) |
| `.pkgd-cta` | wrapper ปุ่มดูเพิ่ม |
| `.pkgd-cta-btn` | ปุ่ม "ดูประเทศอื่นๆ" (pill สีแดง) |
| `.pkgd-empty` | ข้อความเมื่อไม่มีข้อมูล |

### JavaScript
- IIFE scoped, ไม่มี UID (ใช้ `data-tab` / `data-panel` attribute)
- Tab click → toggle `.is-active` บน tabs + panels ที่ตรงกัน
- ใช้ `DOMContentLoaded` ถ้า document ยังไม่โหลด

### Responsive Breakpoints
- `>900px` — 3 columns, horizontal card (flag | name+price | arrow)
- `≤900px` — 2 columns, gap 12px
- `≤600px` — **1 column, card style เหมือน PC** (horizontal flag+name+price+arrow)
  - 4 รายการแรก: `.pkgd-grid` (1 col list)
  - ทุกประเทศแบ่ง `array_chunk($countries, 4)` → แต่ละ `.pkgd-col-group` มี 4 ประเทศ
  - `.pkgd-scroll` = flex-row horizontal carousel, scroll-snap-type: x mandatory
  - `.pkgd-col-group` = flex column 50% width, snap ทีละ 1 col, เห็น 2 col พร้อมกัน
  - edge-to-edge: margin-left/right -14px, padding-left 14px, padding-right 24px (hint)
  - Desktop: `.pkgd-col-group { display: contents }` → flatten เป็น grid 3-col ปกติ

### Security
- Settings: `check_admin_referer('sim_dest_clear')` สำหรับ clear cache
- Input: `sanitize_callback` ใน `register_setting`
- Output: `esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`
- API error: แสดงรายละเอียด error เฉพาะ `current_user_can('manage_options')`

## Development Rules
1. **Read SKILL.md first** ก่อนแก้ไขทุกครั้ง
2. **Surgical Edits:** ใช้ `Edit` (replace) ห้าม rewrite ทั้งไฟล์
3. **Log ทุก change** ใน [Change Log](#change-log) ด้านล่าง
4. **Security:** ห้าม output variable โดยตรงโดยไม่ escape
5. **Cache:** แก้ข้อมูล API / Settings → ล้าง cache เสมอ

## Change Log

### [2026-05-10] Mobile Final v2 — 2-col Group Carousel (array_chunk แทน array_slice)
- เปลี่ยนโครงสร้างทั้งหมด: ยกเลิก main/extra split, ใช้ `array_chunk($countries, 4)` แทน
- PHP: render `.pkgd-scroll` > `.pkgd-col-group` (each group = 4 items, 1 column)
- Desktop CSS: `.pkgd-col-group { display: contents }` → flatten เป็น grid item ปกติ
- Mobile CSS: `.pkgd-scroll` = flex-row scroll, `.pkgd-col-group` = flex-col 50% snap
- ผลลัพธ์: desktop = 3-col grid flat, mobile = เห็น 2 col (4 แถว) → scroll ขวาเห็น col ถัดไป

### [2026-05-10] Mobile Final — 2 Cards per View Carousel (ยกเลิก swipe hint, ใช้ layout เรียบง่าย)
- ยกเลิก `.pkgd-slider-container` และ `.pkgd-swipe-hint` (animated arrow) ออกทั้งหมด
- PHP: ใช้ `array_slice($countries, 0, 4)` → `$c_main` (1-col grid) + `array_slice($countries, 4)` → `$c_extra` (carousel)
- CSS `.pkgd-grid-extra` บน ≤600px:
  - `flex: 0 0 calc(50% - 5px)` — เห็น 2 การ์ดต่อ view พร้อมกัน
  - `scroll-snap-type: x mandatory` + `scroll-snap-align: start` (scroll ทีละ 1 การ์ด)
  - `padding-right: 24px` hint ว่ายังมีการ์ดถัดไป
  - การ์ดย่อ: flag 38px, name 13px nowrap, price 11px nowrap
- ผลลัพธ์: เรียบง่าย ไม่มี animation พิเศษ ผู้ใช้ scroll แนวนอนเห็นทีละ 2 ประเทศ

### [2026-05-10] Mobile UI Fix — Destinations Slider & Swipe Hint
- ปัญหา: เมื่อจำนวนประเทศเกิน 4 รายการ การแสดงผลใน Grid แนวตั้งทำให้หน้ายาวเกินไป และรายการที่ 5+ ดูไม่ชัดเจนว่าเป็น Slider
- แก้ไข (PHP): เพิ่ม `.pkgd-slider-container` หุ้มรายการที่ 5+ และเพิ่ม `.pkgd-swipe-hint` (SVG Arrow + Text)
- แก้ไข (CSS):
    - เพิ่ม Animation ให้ลูกศรเลื่อน (pkgd-swipe) เพื่อดึงดูดสายตาให้ผู้ใช้รู้ว่าเลื่อนได้
    - ปรับขนาดการ์ดใน Slider ให้กว้างขึ้น (75vw) เพื่อลดปัญหาตัวอักษรตัดบรรทัด (เช่น THB ตกบรรทัด)
    - เพิ่ม Box Shadow และ Border ให้การ์ดใน Slider ดูเด่นขึ้นบนพื้นหลังสีเทา
    - ปรับขอบ (Margin) ของ Slider ให้ชิดขอบจอพอดี (Edge-to-edge scrolling)
- ผลลัพธ์: ผู้ใช้จะเห็น 4 ประเทศแรกแบบเต็มจอ และเห็น "คำใบ้" (Hint) ให้เลื่อนขวาเพื่อดูประเทศที่เหลือ

### [2026-05-10] Mobile Redesign — 4 แถวแนวตั้ง + สไลด์แนวนอนสำหรับส่วนที่เหลือ (Initial)

### [2026-05-10] Mobile — Attempt ก่อนหน้า (ยกเลิก)
- ปัญหา: มือถือ 1 คอลัมน์ → 6 การ์ดสูงเกินไป
- แก้: เมื่อ count > 4 → เพิ่ม class `pkgd-scroll` บน `.pkgd-grid`
- `pkgd-scroll` บน ≤540px: flex-direction:row, overflow-x:auto, scroll-snap, hide scrollbar
- การ์ดกว้าง 58vw (max 220px) เห็น ~1.5-1.7 การ์ดต่อหน้าจอ → ผู้ใช้รู้ว่า scroll ได้
- padding ขยาย margin ออก edge เพื่อให้ scroll ถึงขอบ
- ≤4 การ์ด → แสดง 1 คอลัมน์ปกติ (ไม่ scroll)

### [2026-05-10] Initialization
- อ่านไฟล์ต้นฉบับ `E:\Claude\wordpress\Site1 destinations display.php`
- สร้างโฟลเดอร์ `site1-destinations-display\`
- Copy ไฟล์เป็น `destinations_display.php`
- เขียน `SKILL.md` เอกสาร architecture ครบถ้วน
