/**
 * SAMURAI SIM — Destinations Display (เว็บ 1 - Landing)
 *
 * ใช้กับ: Code Snippets plugin (ติ๊ก "Run snippet everywhere")
 * ติดตั้งบน: เว็บ 1 (หน้า Landing — ไม่จำเป็นต้องมี WooCommerce)
 *
 * ส่วนประกอบ:
 *   [1] Settings page  → Settings → SIM Destinations
 *   [2] Fetch data จาก API ของเว็บ 2 + cache
 *   [3] Shortcode [pkg_destinations]
 *   [4] CSS + JS (tabs)
 *
 * ─────────────────────────────────────────────────
 *  วิธีใช้ใน Code Snippets:
 *    1. Snippets → Add New
 *    2. Title: "SAMURAI Destinations Display"
 *    3. วาง code นี้ทั้งหมด (ไม่ต้องเอา <?php ตรงด้านบน)
 *    4. Run snippet: เลือก "Run snippet everywhere"
 *    5. Save & Activate
 *
 *  หลังติดตั้ง:
 *    → ไป Settings → SIM Destinations
 *    → ตั้งค่า API URL ของเว็บ 2
 *    → ใส่ shortcode [pkg_destinations] ใน Elementor
 * ─────────────────────────────────────────────────
 */


// ============================================================
// 1. SETTINGS PAGE
// ============================================================
add_action( 'admin_menu', function() {
    add_options_page(
        'SIM Destinations',
        'SIM Destinations',
        'manage_options',
        'sim-destinations',
        'sim_destinations_settings_page'
    );
} );

add_action( 'admin_init', function() {
    register_setting( 'sim_destinations', 'sim_destinations_api_url',  array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'sim_destinations', 'sim_destinations_target_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'sim_destinations', 'sim_destinations_cache_min', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'sim_destinations', 'sim_destinations_basic_user', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting( 'sim_destinations', 'sim_destinations_basic_pass', array( 'sanitize_callback' => 'sanitize_text_field' ) );
} );

function sim_destinations_settings_page() {
    // ล้าง cache
    if ( isset( $_GET['clear_cache'] ) && check_admin_referer( 'sim_dest_clear' ) ) {
        sim_destinations_clear_cache();
        echo '<div class="notice notice-success"><p>ล้าง cache แล้ว</p></div>';
    }

    $api_url    = get_option( 'sim_destinations_api_url', '' );
    $target_url = get_option( 'sim_destinations_target_url', '' );
    $cache_min  = get_option( 'sim_destinations_cache_min', 60 );
    $basic_user = get_option( 'sim_destinations_basic_user', '' );
    $basic_pass = get_option( 'sim_destinations_basic_pass', '' );
    ?>
    <div class="wrap">
        <h1>SIM Destinations Settings</h1>

        <form method="post" action="options.php">
            <?php settings_fields( 'sim_destinations' ); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="sim_destinations_api_url">API URL ของเว็บ 2 *</label>
                    </th>
                    <td>
                        <input type="url"
                               name="sim_destinations_api_url"
                               id="sim_destinations_api_url"
                               value="<?php echo esc_attr( $api_url ); ?>"
                               class="regular-text"
                               placeholder="https://test.samurai-sim.com/ecommerce"/>
                        <p class="description">
                            URL หลักของเว็บ 2 (ที่ติดตั้ง <code>site2-destinations-api.php</code>)<br>
                            <strong>ห้ามใส่ <code>/wp-json/...</code> ต่อท้าย</strong> ระบบจะเติมให้เอง<br>
                            <?php if ( $api_url ) : ?>
                                Endpoint จริง: <code><?php echo esc_html( trailingslashit( $api_url ) . 'wp-json/samurai/v1/destinations' ); ?></code>
                            <?php endif; ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="sim_destinations_target_url">หน้าแพ็กเกจ (target URL)</label>
                    </th>
                    <td>
                        <input type="url"
                               name="sim_destinations_target_url"
                               id="sim_destinations_target_url"
                               value="<?php echo esc_attr( $target_url ); ?>"
                               class="regular-text"
                               placeholder="https://test.samurai-sim.com/ecommerce/packages"/>
                        <p class="description">
                            URL ของหน้าที่มี <code>[pkg_filter]</code> เมื่อคลิกการ์ดประเทศ จะไปที่ URL นี้พร้อม <code>?country=slug</code>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="sim_destinations_cache_min">Cache (นาที)</label>
                    </th>
                    <td>
                        <input type="number"
                               name="sim_destinations_cache_min"
                               id="sim_destinations_cache_min"
                               value="<?php echo esc_attr( $cache_min ); ?>"
                               class="small-text" min="1" max="1440"/>
                        <p class="description">
                            ระบบจะเก็บข้อมูลไว้กี่นาทีก่อนเรียก API ใหม่ (default: 60 = 1 ชม.)
                        </p>
                    </td>
                </tr>

                <tr>
                    <th colspan="2"><h3 style="margin:20px 0 8px;">🔐 Basic Auth (ถ้า server มี password protection)</h3></th>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sim_destinations_basic_user">Username</label>
                    </th>
                    <td>
                        <input type="text"
                               name="sim_destinations_basic_user"
                               id="sim_destinations_basic_user"
                               value="<?php echo esc_attr( $basic_user ); ?>"
                               class="regular-text"
                               autocomplete="off"/>
                        <p class="description">
                            ถ้า server มี <strong>HTTP Basic Auth</strong> (ป๊อปอัปขอ user/pass ตอนเปิดเว็บ) ใส่ตรงนี้<br>
                            ถ้าไม่มี → เว้นว่างไว้
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="sim_destinations_basic_pass">Password</label>
                    </th>
                    <td>
                        <input type="password"
                               name="sim_destinations_basic_pass"
                               id="sim_destinations_basic_pass"
                               value="<?php echo esc_attr( $basic_pass ); ?>"
                               class="regular-text"
                               autocomplete="new-password"/>
                    </td>
                </tr>
            </table>

            <?php submit_button( 'บันทึก' ); ?>
        </form>

        <h2 style="margin-top:32px;">🔄 ล้าง Cache</h2>
        <p>กดปุ่มนี้ถ้าเพิ่งแก้ข้อมูลใน WooCommerce ของเว็บ 2 แล้วอยากเห็นผลทันที:</p>
        <p>
            <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'options-general.php?page=sim-destinations&clear_cache=1' ), 'sim_dest_clear' ) ); ?>"
               class="button">ล้าง Cache ตอนนี้</a>
        </p>

        <h2 style="margin-top:32px;">🧪 Test API</h2>
        <?php if ( $api_url ) : ?>
            <p>ลองเรียก API:</p>
            <p>
                <a href="<?php echo esc_url( trailingslashit( $api_url ) . 'wp-json/samurai/v1/destinations?type=country&limit=6' ); ?>"
                   target="_blank" class="button">เปิด /destinations?type=country</a>
                <a href="<?php echo esc_url( trailingslashit( $api_url ) . 'wp-json/samurai/v1/destinations?type=continent&limit=6' ); ?>"
                   target="_blank" class="button">เปิด /destinations?type=continent</a>
            </p>
            <p class="description">ควรเห็น JSON ที่มี <code>"success": true</code> และ array <code>data</code></p>
        <?php else : ?>
            <p style="color:#888;">กรอก API URL ก่อนถึงจะ test ได้</p>
        <?php endif; ?>

        <h2 style="margin-top:32px;">📋 วิธีใช้ Shortcode</h2>
        <p>วาง shortcode ในหน้าหรือ Elementor widget:</p>
        <pre style="background:#f5f5f5;padding:12px;border-radius:6px;display:inline-block;">[pkg_destinations]</pre>
        <p>หรือกำหนด options:</p>
        <pre style="background:#f5f5f5;padding:12px;border-radius:6px;display:inline-block;">[pkg_destinations limit="8" show_tabs="yes" default_tab="country"]</pre>
    </div>
    <?php
}


// ============================================================
// 2. FETCH DATA FROM SITE 2
// ============================================================
function sim_destinations_fetch( $type = 'country', $limit = 6 ) {
    $api_url   = get_option( 'sim_destinations_api_url', '' );
    if ( ! $api_url ) return array( 'error' => 'API URL ยังไม่ได้ตั้งค่า กรุณาไปที่ Settings → SIM Destinations' );

    $cache_min = max( 1, (int) get_option( 'sim_destinations_cache_min', 60 ) );
    $cache_key = 'sim_dest_' . md5( $api_url . '|' . $type . '|' . $limit );
    $cached    = get_transient( $cache_key );

    if ( $cached !== false ) return $cached;

    // เรียก API
    $endpoint = trailingslashit( $api_url ) . 'wp-json/samurai/v1/destinations';
    $url      = add_query_arg( array(
        'type'  => $type,
        'limit' => $limit,
    ), $endpoint );

    // Headers — ส่ง User-Agent กัน server บางตัวบล็อก empty UA + ส่ง origin
    $headers = array(
        'Accept'     => 'application/json',
        'User-Agent' => 'SAMURAI-Destinations/1.0 (' . home_url() . ')',
    );

    // ถ้ามี basic auth (server-level password) ตั้งใน Settings ใส่ตรงนี้
    $basic_user = get_option( 'sim_destinations_basic_user', '' );
    $basic_pass = get_option( 'sim_destinations_basic_pass', '' );
    if ( $basic_user && $basic_pass ) {
        $headers['Authorization'] = 'Basic ' . base64_encode( $basic_user . ':' . $basic_pass );
    }

    $response = wp_remote_get( $url, array(
        'timeout'     => 10,
        'headers'     => $headers,
        'redirection' => 5,
        'sslverify'   => false, // กรณี cert ภายในไม่ valid
    ) );

    if ( is_wp_error( $response ) ) {
        return array( 'error' => 'เชื่อมต่อ API ไม่ได้: ' . $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );

    // ถ้า 401 — น่าจะติด basic auth บน server
    if ( $code === 401 ) {
        return array(
            'error' => 'API คืนค่า HTTP 401 — server มี Basic Auth ป้องกันอยู่ กรุณากรอก username/password ใน Settings (ช่อง Basic Auth User/Pass)',
            'http_code' => 401,
        );
    }

    if ( $code !== 200 ) {
        $body_preview = substr( wp_remote_retrieve_body( $response ), 0, 200 );
        return array( 'error' => 'API คืนค่า HTTP ' . $code . ' — ' . $body_preview );
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( ! $data || empty( $data['success'] ) ) {
        return array( 'error' => 'API response ไม่ถูกต้อง' );
    }

    // override target URL ถ้ามีการตั้งใน Settings
    $custom_target = get_option( 'sim_destinations_target_url', '' );
    if ( $custom_target && ! empty( $data['data'] ) ) {
        foreach ( $data['data'] as &$item ) {
            $item['url'] = trailingslashit( $custom_target ) . '?country=' . $item['slug'];
        }
        unset( $item );
    }

    set_transient( $cache_key, $data, $cache_min * MINUTE_IN_SECONDS );

    return $data;
}


// ============================================================
// 3. SHORTCODE [pkg_destinations]
// ============================================================
add_shortcode( 'pkg_destinations', 'pkg_destinations_shortcode' );

function pkg_destinations_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'limit'       => 6,
        'show_tabs'   => 'yes',
        'default_tab' => 'country',
        'title'       => 'ปลายทาง<em>ยอดนิยม</em>',
        'subtitle'    => 'เชื่อมต่ออินเทอร์เน็ตทั่วโลกด้วย eSIM และ SIM ราคาสุดคุ้ม พร้อมใช้งานทันที',
        'show_more'   => 'yes',
        'more_url'    => '',
    ), $atts, 'pkg_destinations' );

    $limit = max( 1, (int) $atts['limit'] );

    // ดึงข้อมูล
    $countries_data  = sim_destinations_fetch( 'country', $limit );
    $continents_data = $atts['show_tabs'] === 'yes' ? sim_destinations_fetch( 'continent', $limit ) : array( 'data' => array() );

    // ถ้ามี error
    if ( ! empty( $countries_data['error'] ) ) {
        if ( current_user_can( 'manage_options' ) ) {
            return '<div style="padding:20px;background:#fef0f0;border:1px solid #f5c2c2;border-radius:8px;color:#c33;">
                <strong>SIM Destinations:</strong> ' . esc_html( $countries_data['error'] ) . '<br>
                <small>ข้อความนี้เห็นเฉพาะ admin — ไป <a href="' . esc_url( admin_url( 'options-general.php?page=sim-destinations' ) ) . '">Settings → SIM Destinations</a> เพื่อตั้งค่า</small>
            </div>';
        }
        return '';
    }

    $countries  = $countries_data['data']  ?? array();
    $continents = $continents_data['data'] ?? array();

    // ปุ่มดูเพิ่ม
    $more_url = ! empty( $atts['more_url'] )
        ? esc_url( $atts['more_url'] )
        : esc_url( get_option( 'sim_destinations_target_url', '#' ) );

    $uid = 'pkgd_' . wp_generate_password( 6, false, false );

    ob_start();
    ?>
    <section class="pkgd-section" id="<?php echo esc_attr( $uid ); ?>">
        <div class="pkgd-header">
            <h2 class="pkgd-title"><?php echo wp_kses_post( $atts['title'] ); ?></h2>
            <?php if ( ! empty( $atts['subtitle'] ) ) : ?>
                <p class="pkgd-subtitle"><?php echo esc_html( $atts['subtitle'] ); ?></p>
            <?php endif; ?>

            <?php if ( $atts['show_tabs'] === 'yes' ) : ?>
                <div class="pkgd-tabs">
                    <button type="button" class="pkgd-tab <?php echo $atts['default_tab'] === 'country' ? 'is-active' : ''; ?>" data-tab="country">
                        ประเทศ
                    </button>
                    <button type="button" class="pkgd-tab <?php echo $atts['default_tab'] === 'continent' ? 'is-active' : ''; ?>" data-tab="continent">
                        ทวีป
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Country panel -->
        <div class="pkgd-panel <?php echo $atts['default_tab'] === 'country' ? 'is-active' : ''; ?>" data-panel="country">
            <?php if ( ! empty( $countries ) ) : ?>
                <div class="pkgd-grid">
                    <?php foreach ( $countries as $c ) echo pkg_destinations_card( $c ); ?>
                </div>
            <?php else : ?>
                <p class="pkgd-empty">ยังไม่มีข้อมูลประเทศ</p>
            <?php endif; ?>
        </div>

        <!-- Continent panel -->
        <?php if ( $atts['show_tabs'] === 'yes' ) : ?>
            <div class="pkgd-panel <?php echo $atts['default_tab'] === 'continent' ? 'is-active' : ''; ?>" data-panel="continent">
                <?php if ( ! empty( $continents ) ) : ?>
                    <div class="pkgd-grid">
                        <?php foreach ( $continents as $c ) echo pkg_destinations_card( $c ); ?>
                    </div>
                <?php else : ?>
                    <p class="pkgd-empty">ยังไม่มีข้อมูลทวีป</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $atts['show_more'] === 'yes' && $more_url !== '#' ) : ?>
            <div class="pkgd-cta">
                <a href="<?php echo $more_url; ?>" class="pkgd-cta-btn">ดูประเทศอื่นๆ</a>
            </div>
        <?php endif; ?>
    </section>
    <?php
    return ob_get_clean();
}


// ============================================================
// 4. CARD RENDERER
// ============================================================
function pkg_destinations_card( $c ) {
    $name      = esc_html( $c['name'] ?? '' );
    $slug      = esc_attr( $c['slug'] ?? '' );
    $count     = (int) ( $c['count'] ?? 0 );
    $min_price = (int) ( $c['min_price'] ?? 0 );
    $currency  = esc_html( $c['currency'] ?? 'THB' );
    $url       = esc_url( $c['url'] ?? '#' );
    $flag      = ! empty( $c['flag'] )    ? esc_url( $c['flag'] )    : '';
    $flag_2x   = ! empty( $c['flag_2x'] ) ? esc_url( $c['flag_2x'] ) : '';

    ob_start();
    ?>
    <a href="<?php echo $url; ?>" class="pkgd-card" data-slug="<?php echo $slug; ?>">
        <?php if ( $flag ) : ?>
            <div class="pkgd-card-flag">
                <img src="<?php echo $flag; ?>"
                     <?php echo $flag_2x ? 'srcset="' . $flag_2x . ' 2x"' : ''; ?>
                     alt="<?php echo esc_attr( $c['name'] ); ?>"
                     loading="lazy"/>
            </div>
        <?php else : ?>
            <div class="pkgd-card-flag pkgd-card-flag-emoji">🌍</div>
        <?php endif; ?>

        <div class="pkgd-card-body">
            <div class="pkgd-card-name"><?php echo $name; ?></div>
            <?php if ( $min_price > 0 ) : ?>
                <div class="pkgd-card-price">
                    ราคาเริ่มต้น <strong><?php echo number_format( $min_price ); ?> <?php echo $currency; ?></strong>
                </div>
            <?php elseif ( $count > 0 ) : ?>
                <div class="pkgd-card-price"><?php echo $count; ?> แพ็กเกจ</div>
            <?php endif; ?>
        </div>

        <div class="pkgd-card-arrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 6 15 12 9 18"/></svg>
        </div>
    </a>
    <?php
    return ob_get_clean();
}


// ============================================================
// 5. CACHE INVALIDATION HELPER
// ============================================================
function sim_destinations_clear_cache() {
    global $wpdb;
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_sim_dest_%' OR option_name LIKE '_transient_timeout_sim_dest_%'" );
}


// ============================================================
// 6. CSS + JS
// ============================================================
add_action( 'wp_head', 'sim_destinations_assets' );

function sim_destinations_assets() {
    ?>
<style>
.pkgd-section {
    font-family: 'Noto Sans Thai', sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

/* Header */
.pkgd-header { text-align: center; margin-bottom: 32px; }
.pkgd-title {
    font-size: 36px;
    font-weight: 800;
    color: #111;
    margin: 0 0 12px;
    line-height: 1.2;
}
.pkgd-title em {
    color: #cc0000;
    font-style: normal;
}
.pkgd-subtitle {
    font-size: 15px;
    color: #666;
    margin: 0 auto 24px;
    max-width: 640px;
    line-height: 1.6;
}

/* Tabs */
.pkgd-tabs {
    display: inline-flex;
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 40px;
    padding: 4px;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.pkgd-tab {
    padding: 10px 28px;
    border: none;
    background: transparent;
    border-radius: 40px;
    font-size: 14px;
    font-weight: 600;
    color: #666;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
}
.pkgd-tab:hover { color: #cc0000; }
.pkgd-tab.is-active {
    background: #cc0000;
    color: #fff;
    box-shadow: 0 2px 8px rgba(204,0,0,.25);
}

/* Panels */
.pkgd-panel { display: none; }
.pkgd-panel.is-active { display: block; animation: pkgd-fade .25s ease; }
@keyframes pkgd-fade {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Grid */
.pkgd-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 36px;
}
@media (max-width: 900px) { .pkgd-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 540px) { .pkgd-grid { grid-template-columns: 1fr; } }

/* Card */
.pkgd-card {
    display: flex;
    align-items: center;
    gap: 16px;
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 16px;
    padding: 18px 20px;
    text-decoration: none !important;
    color: inherit;
    transition: all .25s cubic-bezier(.4, 0, .2, 1);
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.pkgd-card:hover {
    border-color: #cc0000;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(204,0,0,.12);
}
.pkgd-card:hover .pkgd-card-arrow { color: #cc0000; transform: translateX(2px); }
.pkgd-card:hover .pkgd-card-name { color: #cc0000; }

.pkgd-card-flag {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    overflow: hidden;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.12), 0 0 0 1px rgba(0,0,0,.04);
    position: relative;
}
.pkgd-card-flag img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.pkgd-card-flag-emoji {
    font-size: 32px;
    background: #f7f7f7;
}

.pkgd-card-body {
    flex: 1;
    min-width: 0;
}
.pkgd-card-name {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 4px;
    transition: color .2s;
}
.pkgd-card-price {
    font-size: 13px;
    color: #888;
}
.pkgd-card-price strong {
    color: #1a1a1a;
    font-weight: 600;
}

.pkgd-card-arrow {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    transition: all .2s;
}
.pkgd-card-arrow svg { width: 14px; height: 14px; }

/* CTA */
.pkgd-cta { text-align: center; }
.pkgd-cta-btn {
    display: inline-block;
    padding: 14px 40px;
    background: #cc0000;
    color: #fff !important;
    border-radius: 40px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(204,0,0,.25);
}
.pkgd-cta-btn:hover {
    background: #a80000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(204,0,0,.35);
}

/* Empty */
.pkgd-empty {
    text-align: center;
    color: #aaa;
    padding: 40px 20px;
    font-size: 14px;
}

@media (max-width: 600px) {
    .pkgd-section { padding: 40px 16px; }
    .pkgd-title { font-size: 26px; }
    .pkgd-card { padding: 14px 16px; gap: 12px; }
    .pkgd-card-flag { width: 48px; height: 48px; }
    .pkgd-card-name { font-size: 16px; }
}
</style>

<script>
(function() {
    function init() {
        document.querySelectorAll('.pkgd-section').forEach(function(section) {
            var tabs   = section.querySelectorAll('.pkgd-tab');
            var panels = section.querySelectorAll('.pkgd-panel');

            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    var target = this.getAttribute('data-tab');
                    tabs.forEach(function(t)   { t.classList.remove('is-active'); });
                    panels.forEach(function(p) { p.classList.remove('is-active'); });
                    this.classList.add('is-active');
                    var panel = section.querySelector('.pkgd-panel[data-panel="' + target + '"]');
                    if (panel) panel.classList.add('is-active');
                });
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else { init(); }
})();
</script>
    <?php
}


// ============================================================
// 7. ล้าง cache เมื่อแก้ Settings
// ============================================================
add_action( 'update_option_sim_destinations_api_url',    'sim_destinations_clear_cache' );
add_action( 'update_option_sim_destinations_target_url', 'sim_destinations_clear_cache' );