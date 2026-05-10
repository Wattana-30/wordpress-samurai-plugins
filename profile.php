/**
 * SAMURAI SIM - My Account Premium v3
 * New Design: Black Sidebar + Red Accent + White Content
 */

// =====================================================================
// 1. HELPER: Login Prompt
// =====================================================================
function get_modern_login_prompt_html() {
    ob_start(); ?>
    <div style="padding:60px 20px;text-align:center;background:#fff;border-radius:12px;border-top:4px solid #d32f2f;border:1px solid #eee;">
        <span class="dashicons dashicons-lock" style="font-size:48px;width:48px;height:48px;color:#d32f2f;margin-bottom:15px;"></span>
        <h2 style="font-size:22px;font-weight:800;margin-bottom:10px;color:#111;">กรุณาเข้าสู่ระบบ</h2>
        <p style="color:#888;font-size:14px;margin-bottom:25px;">คุณจำเป็นต้องเข้าสู่ระบบเพื่อเข้าถึงส่วนนี้</p>
        <button onclick="openAuthModal()" style="background:#d32f2f;color:#fff;padding:12px 35px;border-radius:8px;font-size:15px;border:none;cursor:pointer;font-weight:700;">เข้าสู่ระบบ / สมัครสมาชิก</button>
    </div>
    <script>document.addEventListener("DOMContentLoaded",function(){setTimeout(function(){if(typeof openAuthModal==='function'){openAuthModal();}},300);});</script>
    <?php return ob_get_clean();
}

// =====================================================================
// 2. HELPER: Order Rows
// =====================================================================
function get_modern_order_rows_html( $orders ) {
    $output = '';
    foreach ( $orders as $order ) {
        $status_class = 'status-' . $order->get_status();
        $status_name  = wc_get_order_status_name( $order->get_status() );
        $order_id     = $order->get_id();
        $item_list = array();
        foreach ( $order->get_items() as $item ) {
            $item_list[] = esc_html( $item->get_name() ) . ' <span style="color:#888;font-weight:700;background:#f3f4f6;padding:2px 6px;border-radius:4px;font-size:11px;margin-left:4px;">x' . $item->get_quantity() . '</span>';
        }
        $products_display = implode( '<br>', $item_list );
        $actions_html = '<div class="ss-icon-actions">';
        $actions_html .= '<button onclick="openOrderModal(' . $order_id . ')" class="ss-icon-btn" title="ดูรายละเอียด"><span class="dashicons dashicons-visibility"></span></button>';
        $actions = wc_get_account_orders_actions( $order );
        if ( ! empty( $actions ) ) {
            foreach ( $actions as $key => $action ) {
                if ( $key === 'view' ) continue;
                $action_name = esc_html($action['name']);
                $icon = (mb_strpos($action_name, 'ดาวน์โหลด') !== false || stripos($key, 'download') !== false) ? 'dashicons-download' : 'dashicons-printer';
                $actions_html .= '<a href="' . esc_url( $action['url'] ) . '" target="_blank" class="ss-icon-btn" title="' . $action_name . '"><span class="dashicons ' . $icon . '"></span></a>';
            }
        }
        $actions_html .= '</div>';
        $output .= '<tr>
            <td class="order-number">#' . esc_html($order->get_order_number()) . '</td>
            <td class="order-date">' . esc_html(wc_format_datetime( $order->get_date_created(), 'd M Y' )) . '</td>
            <td class="order-product">' . $products_display . '</td>
            <td class="order-status"><span class="ss-badge ' . esc_attr($status_class) . '">' . esc_html($status_name) . '</span></td>
            <td class="order-total">' . $order->get_formatted_order_total() . '</td>
            <td class="order-actions">' . $actions_html . '</td>
        </tr>';
    }
    return $output;
}

// =====================================================================
// 3. AJAX: Order Details
// =====================================================================
add_action( 'wp_ajax_get_order_details', 'get_order_details_ajax' );
function get_order_details_ajax() {
    check_ajax_referer( 'modern_order_nonce', 'security' );
    $order_id = isset($_POST['order_id']) ? intval( $_POST['order_id'] ) : 0;
    if ( ! $order_id ) wp_send_json_error( 'ไม่พบรหัสออเดอร์' );
    $order = wc_get_order( $order_id );
    if ( ! $order ) wp_send_json_error( 'ไม่พบข้อมูลออเดอร์ในระบบ' );
    if ( ! current_user_can('administrator') && $order->get_customer_id() !== get_current_user_id() ) wp_send_json_error( 'คุณไม่มีสิทธิ์เข้าถึงออเดอร์นี้' );
    try {
        ob_start(); ?>
        <div class="custom-modal-order-wrap">
            <div class="modal-action-buttons">
                <button onclick="window.print()" class="modal-btn-print"><span class="dashicons dashicons-printer"></span> พิมพ์หน้านี้</button>
                <?php $actions = wc_get_account_orders_actions( $order );
                if ( ! empty( $actions ) ) { foreach ( $actions as $key => $action ) { if ( $key === 'view' ) continue; $action_name = esc_html($action['name']); $icon_class = (mb_strpos($action_name, 'ดาวน์โหลด') !== false || stripos($key, 'download') !== false) ? 'dashicons-download' : 'dashicons-printer'; echo '<a href="' . esc_url( $action['url'] ) . '" target="_blank" class="modal-btn-action"><span class="dashicons ' . $icon_class . '"></span> ' . $action_name . '</a>'; } } ?>
            </div>
            <div class="order-header-info">
                <h2>รายละเอียดคำสั่งซื้อ (Order Report)</h2>
                <p><strong>หมายเลขคำสั่งซื้อ:</strong> #<?php echo $order->get_order_number(); ?> &nbsp;|&nbsp; <strong>วันที่:</strong> <?php echo wc_format_datetime( $order->get_date_created() ); ?> &nbsp;|&nbsp; <strong>สถานะ:</strong> <span style="color:#d32f2f;font-weight:bold;"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span></p>
            </div>
            <div class="table-responsive">
                <table class="modern-order-table desktop-only-table">
                    <thead><tr><th>รายการสินค้า (Item)</th><th style="text-align:right;width:30%;">ยอดรวม (Total)</th></tr></thead>
                    <tbody><?php foreach( $order->get_items() as $item_id => $item ) : ?><tr><td><?php echo esc_html( $item->get_name() ); ?> <strong>x <?php echo $item->get_quantity(); ?></strong></td><td style="text-align:right;"><?php echo $order->get_formatted_line_subtotal( $item ); ?></td></tr><?php endforeach; ?></tbody>
                    <tfoot><?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?><tr><td style="text-align:right;font-weight:bold;"><?php echo wp_kses_post( $total['label'] ); ?></td><td style="text-align:right;font-weight:bold;"><?php echo wp_kses_post( $total['value'] ); ?></td></tr><?php endforeach; ?></tfoot>
                </table>
            </div>
            <div class="address-container">
                <div class="address-box"><h3>ที่อยู่ในใบเสร็จ (BILLING ADDRESS)</h3><address><?php echo wp_kses_post( $order->get_formatted_billing_address( 'ไม่มีข้อมูล' ) ); ?></address><?php if ( $order->get_billing_phone() ) echo '<p><strong>โทร:</strong> ' . esc_html( $order->get_billing_phone() ) . '</p>'; ?><?php if ( $order->get_billing_email() ) echo '<p><strong>อีเมล:</strong> ' . esc_html( $order->get_billing_email() ) . '</p>'; ?></div>
                <?php if ( $order->needs_shipping_address() ) : ?><div class="address-box"><h3>ที่อยู่จัดส่ง (SHIPPING ADDRESS)</h3><address><?php echo wp_kses_post( $order->get_formatted_shipping_address( 'ไม่มีข้อมูล' ) ); ?></address></div><?php endif; ?>
            </div>
            <div class="report-footer"><p>เอกสารฉบับนี้ถูกสร้างขึ้นโดยระบบอัตโนมัติ - SAMURAI SIM</p></div>
        </div>
        <?php $html = ob_get_clean(); wp_send_json_success( $html );
    } catch ( Exception $e ) { wp_send_json_error( 'เกิดข้อผิดพลาด: ' . $e->getMessage() ); }
    wp_die();
}

// =====================================================================
// 4. SHORTCODES
// =====================================================================

// Profile Card (Sidebar version - ไม่ใช้แล้ว แต่เก็บไว้ compatibility)
add_shortcode('modern_profile_card', function() {
    ob_start();
    if ( ! is_user_logged_in() ) { ?>
        <div class="ss-profile-wrap">
            <div class="ss-profile-left">
                <div class="ss-avatar-placeholder"><span class="dashicons dashicons-admin-users"></span></div>
                <div class="ss-profile-info"><h4>ผู้เยี่ยมชม</h4><span>ยังไม่ได้เข้าสู่ระบบ</span></div>
            </div>
            <button onclick="openAuthModal()" class="ss-login-btn">เข้าสู่ระบบ <span class="dashicons dashicons-arrow-right-alt"></span></button>
        </div>
    <?php } else {
        $user = wp_get_current_user();
        $logout_url = wp_logout_url( wc_get_page_permalink( 'myaccount' ) ); ?>
        <div class="ss-profile-wrap">
            <div class="ss-profile-left">
                <div class="ss-avatar"><?php echo get_avatar($user->ID, 80); ?></div>
                <div class="ss-profile-info"><h4><?php echo esc_html($user->display_name); ?></h4><span><?php echo esc_html($user->user_email); ?></span></div>
            </div>
            <a href="<?php echo esc_url($logout_url); ?>" class="ss-logout-btn">ออกจากระบบ <span class="dashicons dashicons-arrow-right-alt"></span></a>
        </div>
    <?php } ?>
    <?php return ob_get_clean();
});

// Dashboard - NEW DESIGN
add_shortcode('modern_dashboard', function() {
    if ( ! is_user_logged_in() ) return get_modern_login_prompt_html();
    $user = wp_get_current_user();
    $logout_url = wp_logout_url( wc_get_page_permalink( 'myaccount' ) );
    $all_orders = wc_get_orders(['customer_id' => get_current_user_id(), 'limit' => -1]);
    $total_orders = count($all_orders);
    $processing = count(array_filter($all_orders, fn($o) => in_array($o->get_status(), ['processing','on-hold','pending'])));
    $cart_total = WC()->cart ? WC()->cart->get_cart_total() : '฿0';
    ob_start(); ?>

    <div class="ss-dashboard">

        <!-- SIDEBAR -->
        <div class="ss-sidebar">
            <div class="ss-sidebar-header">
                <div class="ss-sidebar-avatar"><?php echo get_avatar($user->ID, 100); ?></div>
                <div class="ss-sidebar-name"><?php echo esc_html($user->display_name); ?></div>
                <div class="ss-sidebar-email"><?php echo esc_html($user->user_email); ?></div>
            </div>
            <nav class="ss-sidebar-nav">
                <div class="ss-nav-item active" data-tab="tab-home">
                    <span class="dashicons dashicons-layout"></span> Dashboard
                </div>
                <div class="ss-nav-item" data-tab="tab-orders">
                    <span class="dashicons dashicons-cart"></span> คำสั่งซื้อ
                </div>
                <div class="ss-nav-item" data-tab="tab-addresses">
                    <span class="dashicons dashicons-location"></span> ที่อยู่
                </div>
                <div class="ss-nav-item" data-tab="tab-account">
                    <span class="dashicons dashicons-admin-users"></span> ข้อมูลบัญชี
                </div>
                <div class="ss-nav-item" data-tab="tab-payment">
                    <span class="dashicons dashicons-credit-card"></span> การชำระเงิน
                </div>
            </nav>
            <div class="ss-sidebar-footer">
                <a href="<?php echo esc_url($logout_url); ?>" class="ss-sidebar-logout">
                    <span class="dashicons dashicons-exit"></span> ออกจากระบบ
                </a>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="ss-main">

            <!-- TAB: HOME -->
            <div id="tab-home" class="ss-tab active">

                <!-- Hero -->
                <div class="ss-hero">
                    <div>
                        <div class="ss-hero-title">สวัสดีคุณ <?php echo esc_html($user->display_name); ?> 👋</div>
                        <div class="ss-hero-sub">ยินดีต้อนรับกลับสู่ SAMURAI SIM จัดการ eSIM ของคุณได้ที่นี่</div>
                    </div>
                    <div class="ss-member-badge">SAMURAI MEMBER</div>
                </div>

                <!-- Stats -->
                <div class="ss-stats">
                    <div class="ss-stat">
                        <div class="ss-stat-num red"><?php echo $total_orders; ?></div>
                        <div class="ss-stat-label">คำสั่งซื้อทั้งหมด</div>
                    </div>
                    <div class="ss-stat">
                        <div class="ss-stat-num"><?php echo $processing; ?></div>
                        <div class="ss-stat-label">กำลังดำเนินการ</div>
                    </div>
                    <div class="ss-stat">
                        <div class="ss-stat-num red"><?php echo $cart_total; ?></div>
                        <div class="ss-stat-label">ยอดในตะกร้า</div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="ss-quick">
                    <div class="ss-quick-card" data-tab="tab-orders">
                        <span class="dashicons dashicons-cart ss-quick-icon"></span>
                        <span class="ss-quick-label">คำสั่งซื้อล่าสุด</span>
                    </div>
                    <div class="ss-quick-card" data-tab="tab-addresses">
                        <span class="dashicons dashicons-location ss-quick-icon"></span>
                        <span class="ss-quick-label">แก้ไขที่อยู่</span>
                    </div>
                    <div class="ss-quick-card" data-tab="tab-account">
                        <span class="dashicons dashicons-lock ss-quick-icon"></span>
                        <span class="ss-quick-label">เปลี่ยนรหัสผ่าน</span>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="ss-card">
                    <div class="ss-card-title">คำสั่งซื้อล่าสุด</div>
                    <?php echo do_shortcode('[custom_recent_orders]'); ?>
                    <div style="text-align:center;margin-top:20px;">
                        <button data-tab="tab-orders" class="ss-view-all-btn">ดูคำสั่งซื้อทั้งหมด →</button>
                    </div>
                </div>
            </div>

            <!-- TAB: ORDERS -->
            <div id="tab-orders" class="ss-tab" style="display:none;">
                <div class="ss-card">
                    <div class="ss-card-title">ประวัติคำสั่งซื้อทั้งหมด</div>
                    <?php echo do_shortcode('[modern_orders limit=10]'); ?>
                </div>
            </div>

            <!-- TAB: ADDRESSES -->
            <div id="tab-addresses" class="ss-tab" style="display:none;">
                <div class="ss-card">
                    <div class="ss-card-title">ที่อยู่ของฉัน</div>
                    <?php echo do_shortcode('[modern_addresses]'); ?>
                </div>
            </div>

            <!-- TAB: ACCOUNT -->
            <div id="tab-account" class="ss-tab" style="display:none;">
                <div class="ss-card">
                    <div class="ss-card-title">ข้อมูลบัญชี</div>
                    <?php echo do_shortcode('[modern_account_details]'); ?>
                </div>
            </div>

            <!-- TAB: PAYMENT -->
            <div id="tab-payment" class="ss-tab" style="display:none;">
                <div class="ss-card">
                    <div class="ss-card-title">ช่องทางการชำระเงิน</div>
                    <?php echo do_shortcode('[modern_payment_methods]'); ?>
                </div>
            </div>

        </div>
    </div>

    <?php return ob_get_clean();
});

add_shortcode('custom_recent_orders', function() {
    if ( ! is_user_logged_in() ) return get_modern_login_prompt_html();
    $orders = wc_get_orders(['customer_id' => get_current_user_id(), 'limit' => 3]);
    if ( empty( $orders ) ) return '<p style="color:#888;padding:20px 0;">ยังไม่มีคำสั่งซื้อ</p>';
    ob_start(); ?>
    <div class="ss-table-wrap"><table class="ss-table">
        <thead><tr><th>ออเดอร์</th><th>วันที่</th><th>สินค้า</th><th>สถานะ</th><th>ยอดรวม</th><th>จัดการ</th></tr></thead>
        <tbody><?php echo get_modern_order_rows_html($orders); ?></tbody>
    </table></div>
    <?php return ob_get_clean();
});

add_shortcode('modern_orders', function($atts) {
    if ( ! is_user_logged_in() ) return get_modern_login_prompt_html();
    $atts = shortcode_atts(['limit' => 10], $atts);
    $current_page = isset($_GET['order_page']) ? max(1, intval($_GET['order_page'])) : 1;
    $results = wc_get_orders(['customer_id' => get_current_user_id(), 'limit' => intval($atts['limit']), 'page' => $current_page, 'paginate' => true, 'order' => 'DESC']);
    if ( empty( $results->orders ) ) return '<p style="color:#888;padding:20px 0;">ยังไม่มีประวัติการสั่งซื้อ</p>';
    ob_start(); ?>
    <div class="ss-table-wrap"><table class="ss-table">
        <thead><tr><th>ออเดอร์</th><th>วันที่</th><th>สินค้า</th><th>สถานะ</th><th>ยอดรวม</th><th>จัดการ</th></tr></thead>
        <tbody><?php echo get_modern_order_rows_html($results->orders); ?></tbody>
    </table>
    <?php if ( $results->max_num_pages > 1 ) : ?>
        <div class="ss-pagination"><?php echo paginate_links(['base' => add_query_arg('order_page', '%#%'), 'current' => $current_page, 'total' => $results->max_num_pages, 'type' => 'list']); ?></div>
    <?php endif; ?></div>
    <?php return ob_get_clean();
});

add_shortcode('modern_addresses', function() {
    if ( ! is_user_logged_in() ) return get_modern_login_prompt_html();
    ob_start(); echo '<div class="ss-wc-wrap">'; global $wp;
    $action = isset( $wp->query_vars['edit-address'] ) ? $wp->query_vars['edit-address'] : '';
    if ( ! empty( $action ) ) wc_get_template( 'myaccount/form-edit-address.php', array( 'load_address' => $action, 'address' => WC()->countries->get_address_fields( get_user_meta( get_current_user_id(), $action . '_country', true ), $action . '_' ) ) );
    else wc_get_template( 'myaccount/my-address.php', array( 'customer_id' => get_current_user_id() ) );
    echo '</div>'; return ob_get_clean();
});

add_shortcode('modern_account_details', function() {
    if ( ! is_user_logged_in() ) return get_modern_login_prompt_html();
    ob_start(); echo '<div class="ss-wc-wrap">'; wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => wp_get_current_user() ) ); echo '</div>'; return ob_get_clean();
});

add_shortcode('modern_payment_methods', function() {
    if ( ! is_user_logged_in() ) return get_modern_login_prompt_html();
    ob_start(); echo '<div class="ss-wc-wrap">'; wc_get_template( 'myaccount/payment-methods.php' ); echo '</div>'; return ob_get_clean();
});

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('dashicons');
    wp_enqueue_script('jquery');
});

// =====================================================================
// 5. CSS + JS + MODALS
// =====================================================================
add_action('wp_footer', 'add_modern_modal_system');
function add_modern_modal_system() { ?>
<style>
/* ===== DASHBOARD LAYOUT ===== */
.ss-dashboard { display:flex; min-height:500px; background:#f4f4f4; border-radius:16px; overflow:hidden; font-family:sans-serif; }

/* ===== SIDEBAR ===== */
.ss-sidebar { width:220px; min-width:220px; background:#111; display:flex; flex-direction:column; }
.ss-sidebar-header { background:#d32f2f; padding:24px 16px; text-align:center; }
.ss-sidebar-header .avatar { border-radius:50%; overflow:hidden; }
.ss-sidebar-header img { width:60px !important; height:60px !important; border-radius:50% !important; object-fit:cover !important; border:2px solid rgba(255,255,255,0.3) !important; margin-bottom:10px !important; }
.ss-sidebar-name { font-size:14px; font-weight:700; color:#fff; margin-bottom:2px; }
.ss-sidebar-email { font-size:11px; color:rgba(255,255,255,0.65); word-break:break-all; }
.ss-sidebar-nav { flex:1; padding:12px 0; pointer-events:all !important; position:relative; z-index:100; }
.ss-nav-item { display:flex; align-items:center; gap:10px; padding:12px 18px; font-size:13px; color:rgba(255,255,255,0.55); cursor:pointer !important; border-left:3px solid transparent; transition:all 0.15s; pointer-events:all !important; position:relative; z-index:100; user-select:none; }
.ss-nav-item .dashicons { font-size:16px; width:16px; height:16px; }
.ss-nav-item.active { color:#fff !important; background:rgba(255,255,255,0.08); border-left-color:#d32f2f; }
.ss-nav-item:hover:not(.active) { color:#fff; background:rgba(255,255,255,0.05); }
.ss-sidebar-footer { padding:14px 18px; border-top:1px solid rgba(255,255,255,0.08); }
.ss-sidebar-logout { display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.45); font-size:13px; text-decoration:none !important; transition:color 0.15s; }
.ss-sidebar-logout:hover { color:#fff !important; }
.ss-sidebar-logout .dashicons { font-size:16px; width:16px; height:16px; }

/* ===== MAIN AREA ===== */
.ss-main { flex:1; padding:24px; overflow:auto; }
.ss-tab { display:block; }

/* ===== HERO ===== */
.ss-hero { background:#fff; border-radius:12px; padding:24px; margin-bottom:16px; display:flex; align-items:center; justify-content:space-between; border-left:4px solid #d32f2f; }
.ss-hero-title { font-size:20px; font-weight:800; color:#111; margin-bottom:4px; }
.ss-hero-sub { font-size:13px; color:#888; }
.ss-member-badge { background:#d32f2f; color:#fff; padding:7px 16px; border-radius:20px; font-size:11px; font-weight:700; letter-spacing:0.5px; white-space:nowrap; }

/* ===== STATS ===== */
.ss-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:16px; }
.ss-stat { background:#fff; border-radius:10px; padding:16px; text-align:center; }
.ss-stat-num { font-size:26px; font-weight:800; color:#111; line-height:1; }
.ss-stat-num.red { color:#d32f2f; }
.ss-stat-label { font-size:11px; color:#999; margin-top:5px; text-transform:uppercase; letter-spacing:0.5px; }

/* ===== QUICK LINKS ===== */
.ss-quick { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:16px; }
.ss-quick-card { background:#fff; border-radius:10px; padding:18px 12px; cursor:pointer !important; text-align:center; border:1.5px solid transparent; transition:all 0.15s; pointer-events:all !important; position:relative; z-index:10; }
.ss-quick-card:hover { border-color:#d32f2f; background:#fff5f5; }
.ss-quick-icon { font-size:24px !important; width:24px !important; height:24px !important; color:#d32f2f; display:block; margin:0 auto 8px; }
.ss-quick-label { font-size:12px; font-weight:600; color:#333; }

/* ===== CARD ===== */
.ss-card { background:#fff; border-radius:12px; padding:22px; margin-bottom:16px; }
.ss-card-title { font-size:15px; font-weight:800; color:#111; margin-bottom:16px; padding-left:12px; border-left:4px solid #d32f2f; }

/* ===== TABLE ===== */
.ss-table-wrap { overflow-x:auto; }
.ss-table { width:100%; border-collapse:collapse; font-size:14px; color:#333; }
.ss-table th { padding:12px 14px; text-align:left; background:#f9f9f9; border-bottom:1px solid #eee; color:#111; font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:0.3px; }
.ss-table td { padding:13px 14px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
.ss-table tbody tr:last-child td { border-bottom:none; }
.ss-table tbody tr:hover td { background:#fafafa; }

/* ===== BADGES ===== */
.ss-badge { padding:4px 10px; border-radius:12px; font-size:11px; font-weight:700; display:inline-block; white-space:nowrap; }
.ss-badge.status-completed,.ss-badge.status-processing { background:#e6f4ea; color:#1a7c3e; }
.ss-badge.status-cancelled,.ss-badge.status-failed { background:#f3f4f6; color:#666; }
.ss-badge.status-on-hold,.ss-badge.status-pending { background:#fff8e6; color:#b45309; }

/* ===== ICON ACTIONS ===== */
.ss-icon-actions { display:flex; gap:10px; align-items:center; }
.ss-icon-btn { color:#bbb !important; background:transparent !important; border:none !important; padding:0 !important; cursor:pointer; text-decoration:none !important; box-shadow:none !important; display:inline-flex; transition:color 0.15s; }
.ss-icon-btn:hover { color:#111 !important; }
.ss-icon-btn .dashicons { font-size:18px; width:18px; height:18px; }

/* ===== VIEW ALL BTN ===== */
.ss-view-all-btn { padding:10px 28px; border-radius:8px; border:2px solid #111; background:transparent; color:#111; font-weight:700; font-size:13px; cursor:pointer; transition:all 0.2s; }
.ss-view-all-btn:hover { background:#111; color:#fff; }

/* ===== PAGINATION ===== */
.ss-pagination { margin-top:20px; }
.ss-pagination .page-numbers { padding:6px 12px; border:1px solid #ddd; border-radius:6px; margin:0 2px; font-size:13px; color:#333; text-decoration:none; }
.ss-pagination .page-numbers.current { background:#d32f2f; color:#fff; border-color:#d32f2f; }

/* ===== WC WRAP ===== */
.ss-wc-wrap { background:#fff; border-radius:12px; padding:24px; }

/* ===== LINE LOGIN ===== */
.line-login-divider { display:flex; align-items:center; gap:12px; margin:18px 0 14px; }
.line-login-divider hr { flex:1; border:none; border-top:1px solid #e5e7eb; margin:0; }
.line-login-divider span { color:#9ca3af; font-size:12px; white-space:nowrap; }
.line-login-wrap { padding:0 0 5px; }
.line-login-wrap a { display:flex !important; align-items:center !important; justify-content:center !important; gap:10px !important; width:100% !important; padding:13px !important; background:#06C755 !important; color:#fff !important; border-radius:8px !important; font-size:15px !important; font-weight:700 !important; text-decoration:none !important; border:none !important; cursor:pointer !important; box-sizing:border-box !important; }
.line-login-wrap a:hover { background:#05a848 !important; }

/* ===== MOBILE ===== */
@media (max-width:768px) {
    .ss-dashboard { flex-direction:column; border-radius:0; }
    .ss-sidebar { width:100%; flex-direction:column; }
    .ss-sidebar-nav { display:flex; overflow-x:auto; padding:8px 0; }
    .ss-nav-item { min-width:100px; flex-direction:column; gap:4px; text-align:center; border-left:none; border-bottom:3px solid transparent; padding:10px 12px; font-size:11px; justify-content:center; }
    .ss-nav-item.active { border-bottom-color:#d32f2f; border-left:none; background:rgba(255,255,255,0.08); }
    .ss-main { padding:14px; }
    .ss-stats { grid-template-columns:repeat(3,1fr); gap:8px; }
    .ss-stat-num { font-size:18px; }
    .ss-quick { grid-template-columns:repeat(3,1fr); gap:8px; }
    .ss-hero { flex-direction:column; gap:12px; align-items:flex-start; }
    .ss-table th,.ss-table td { padding:10px 8px; font-size:12px; }
    .ss-table thead { display:none; }
    .ss-table,.ss-table tbody,.ss-table tr,.ss-table td { display:block !important; width:100% !important; }
    .ss-table tbody tr { position:relative; border:1px solid #eee; border-radius:10px; padding:14px; padding-bottom:46px; margin-bottom:12px; }
    .ss-table td { border:none !important; padding:0 0 4px !important; }
    .ss-table td.order-number { font-size:15px !important; font-weight:800 !important; color:#111 !important; padding-right:80px !important; }
    .ss-table td.order-date { font-size:12px !important; color:#999 !important; margin-bottom:8px !important; }
    .ss-table td.order-status { position:absolute !important; top:14px !important; right:14px !important; width:auto !important; }
    .ss-table td.order-product { font-size:13px !important; padding-bottom:10px !important; border-bottom:1px solid #f5f5f5 !important; margin-bottom:8px !important; }
    .ss-table td.order-total { position:absolute !important; bottom:14px !important; left:14px !important; font-size:15px !important; font-weight:800 !important; width:auto !important; }
    .ss-table td.order-actions { position:absolute !important; bottom:14px !important; right:14px !important; width:auto !important; }
}
</style>

<!-- Dashboard Tab Navigation Script (always load) -->
<script>
function ssDashTab(el,tabId){
    document.querySelectorAll('.ss-nav-item').forEach(function(i){i.classList.remove('active');});
    if(el)el.classList.add('active');
    document.querySelectorAll('.ss-tab').forEach(function(t){t.style.display='none';});
    var t=document.getElementById(tabId);
    if(t)t.style.display='block';
    window.scrollTo({top:0,behavior:'smooth'});
}
document.addEventListener('DOMContentLoaded',function(){
    document.addEventListener('click',function(e){
        var navEl=e.target.closest('.ss-nav-item[data-tab]');
        if(navEl){
            e.preventDefault();e.stopPropagation();
            ssDashTab(navEl,navEl.dataset.tab);
        }
        var quickEl=e.target.closest('.ss-quick-card[data-tab]');
        if(quickEl){
            e.preventDefault();e.stopPropagation();
            var tabId=quickEl.dataset.tab;
            var navElement=document.querySelector('.ss-nav-item[data-tab="'+tabId+'"]');
            if(navElement)ssDashTab(navElement,tabId);
        }
        var btnEl=e.target.closest('.ss-view-all-btn[data-tab]');
        if(btnEl){
            e.preventDefault();e.stopPropagation();
            var tabId=btnEl.dataset.tab;
            var navElement=document.querySelector('.ss-nav-item[data-tab="'+tabId+'"]');
            if(navElement)ssDashTab(navElement,tabId);
        }
    });
});
</script>

<?php if ( ! is_user_logged_in() ) :
    $enable_registration = get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes';
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
    $site_name = get_bloginfo( 'name' ); ?>

<div id="modern-auth-modal" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.75);backdrop-filter:blur(5px);overflow-y:auto;">
    <div style="background:#fff;margin:3% auto;width:92%;max-width:440px;max-height:94vh;overflow-y:auto;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,0.3);position:relative;">
        <span onclick="closeAuthModal()" style="position:absolute;top:12px;right:16px;font-size:26px;cursor:pointer;color:#aaa;z-index:10;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50;transition:all 0.2s;">&times;</span>
        <div style="text-align:center;padding:30px 28px 20px;background:#fff5f5;border-bottom:1px solid #f0f0f0;border-radius:20px 20px 0 0;">
            <?php if ( $logo_url ) : ?><img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_name); ?>" style="max-height:48px;margin-bottom:14px;display:inline-block;object-fit:contain;"><?php else : ?><h2 style="font-size:20px;font-weight:800;margin-bottom:5px;"><?php echo esc_html($site_name); ?></h2><?php endif; ?>
            <h3 id="auth-welcome-text" style="font-size:20px;font-weight:800;color:#1f2937;margin:0 0 4px;">ยินดีต้อนรับกลับมา 👋</h3>
            <p id="auth-welcome-sub" style="color:#9ca3af;font-size:13px;margin:0;">เข้าสู่ระบบเพื่อจัดการบัญชีและคำสั่งซื้อของคุณ</p>
        </div>
        <?php if ( $enable_registration ) : ?>
        <div style="display:flex;background:#f9fafb;border-bottom:1px solid #eee;">
            <button id="tab-btn-login" onclick="switchAuthTab('login')" style="flex:1;padding:13px 0;border:none;background:transparent;font-size:15px;font-weight:700;color:#d32f2f;cursor:pointer;border-bottom:3px solid #d32f2f;outline:none;">เข้าสู่ระบบ</button>
            <button id="tab-btn-register" onclick="switchAuthTab('register')" style="flex:1;padding:13px 0;border:none;background:transparent;font-size:15px;font-weight:700;color:#9ca3af;cursor:pointer;border-bottom:3px solid transparent;outline:none;">ลงทะเบียน</button>
        </div>
        <?php endif; ?>
        <div class="auth-modal-body" style="padding:22px 28px 28px;">
            <div id="auth-main-panel">
                <div class="woocommerce"><?php wc_get_template( 'myaccount/form-login.php' ); ?></div>
                <div class="line-login-divider"><hr><span>หรือเข้าสู่ระบบด้วย</span><hr></div>
                <div class="line-login-wrap">
                    <?php $line_login_url = home_url('/linelogin');
                    echo '<a href="' . esc_url($line_login_url) . '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg> เข้าสู่ระบบด้วย LINE</a>'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-modal-body h2 { display:none !important; }
#modern-auth-modal .u-columns { display:flex; flex-direction:column; width:100%; margin:0; }
#modern-auth-modal .u-column1,#modern-auth-modal .u-column2 { width:100% !important; float:none !important; padding:0 !important; }
#modern-auth-modal .u-column2 { display:none; }
#modern-auth-modal.show-register .u-column1 { display:none; }
#modern-auth-modal.show-register .u-column2 { display:block; }
#modern-auth-modal form { border:none !important; padding:0 !important; margin:0 !important; }
#modern-auth-modal .woocommerce-form-row { margin-bottom:14px; }
#modern-auth-modal label { font-size:13px !important; font-weight:600 !important; color:#374151 !important; margin-bottom:5px !important; display:block; }
#modern-auth-modal input[type="text"],#modern-auth-modal input[type="password"],#modern-auth-modal input[type="email"] { width:100% !important; padding:12px 14px !important; border:1.5px solid #e5e7eb !important; border-radius:10px !important; box-sizing:border-box !important; font-size:15px !important; background:#fafafa !important; outline:none !important; }
#modern-auth-modal input:focus { border-color:#d32f2f !important; box-shadow:0 0 0 3px rgba(211,47,47,0.1) !important; background:#fff !important; }
#modern-auth-modal button[type="submit"] { width:100% !important; padding:13px !important; border-radius:10px !important; background:#d32f2f !important; color:#fff !important; font-size:16px !important; font-weight:700 !important; border:none !important; margin-top:14px !important; cursor:pointer !important; box-shadow:0 4px 12px rgba(211,47,47,0.3) !important; }
#modern-auth-modal button[type="submit"]:hover { background:#b71c1c !important; }
#modern-auth-modal .woocommerce-LostPassword a { color:#d32f2f !important; font-size:13px !important; text-decoration:none !important; cursor:pointer !important; }
</style>
<script>
function openAuthModal(){document.getElementById('modern-auth-modal').style.display='block';}
function closeAuthModal(){document.getElementById('modern-auth-modal').style.display='none';}
function switchAuthTab(tab){
    const modal=document.getElementById('modern-auth-modal'),l=document.getElementById('tab-btn-login'),r=document.getElementById('tab-btn-register'),wt=document.getElementById('auth-welcome-text'),ws=document.getElementById('auth-welcome-sub');
    if(!l||!r)return;
    if(tab==='register'){modal.classList.add('show-register');r.style.color='#d32f2f';r.style.borderBottomColor='#d32f2f';l.style.color='#9ca3af';l.style.borderBottomColor='transparent';if(wt)wt.innerText='ยินดีต้อนรับ 👋';if(ws)ws.innerText='สมัครสมาชิกใหม่เพื่อรับสิทธิพิเศษ';}
    else{modal.classList.remove('show-register');l.style.color='#d32f2f';l.style.borderBottomColor='#d32f2f';r.style.color='#9ca3af';r.style.borderBottomColor='transparent';if(wt)wt.innerText='ยินดีต้อนรับกลับมา 👋';if(ws)ws.innerText='เข้าสู่ระบบเพื่อจัดการบัญชีและคำสั่งซื้อของคุณ';}
}
window.onclick=function(e){if(e.target==document.getElementById('modern-auth-modal'))closeAuthModal();}
</script>
<?php return; endif;

$ajax_nonce = wp_create_nonce("modern_order_nonce"); ?>

<div id="modern-order-modal" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.7);backdrop-filter:blur(3px);overflow-y:auto;">
    <div style="background:#fff;margin:5% auto 50px;padding:40px;width:90%;max-width:800px;position:relative;font-family:sans-serif;color:#000;border-radius:8px;">
        <span onclick="closeOrderModal()" style="position:absolute;top:10px;right:20px;font-size:36px;cursor:pointer;color:#888;">&times;</span>
        <div id="modal-body-content"></div>
    </div>
</div>
<style>
.modal-action-buttons{display:flex;justify-content:flex-end;gap:10px;margin-bottom:25px;border-bottom:1px solid #ddd;padding-bottom:15px;}
.modal-btn-print{background:#fff;color:#333;border:1px solid #ddd;padding:8px 16px;cursor:pointer;border-radius:4px;font-weight:bold;}
.modal-btn-action{background:#333;color:#fff !important;text-decoration:none !important;padding:8px 16px;border-radius:4px;font-weight:bold;}
.order-header-info{text-align:center;margin-bottom:30px;border-bottom:2px solid #000;padding-bottom:20px;}
.address-container{display:flex;flex-wrap:wrap;gap:20px;margin-top:20px;}
.address-box{flex:1;min-width:250px;padding:20px;border:1px solid #000;}
@media print{body *{visibility:hidden;}#modern-order-modal,#modern-order-modal *{visibility:visible;}#modern-order-modal{position:absolute;left:0;top:0;width:100%;margin:0;background:#fff;}.modern-modal-close,.modal-action-buttons{display:none !important;}}
</style>
<script>
function openOrderModal(orderId){
    const c=document.getElementById('modal-body-content');
    document.getElementById('modern-order-modal').style.display='block';
    c.innerHTML='<div style="text-align:center;padding:50px;"><span class="dashicons dashicons-update" style="font-size:40px;width:40px;height:40px;animation:spin 2s linear infinite;color:#000;"></span></div>';
    jQuery.ajax({url:'<?php echo admin_url("admin-ajax.php"); ?>',type:'POST',data:{action:'get_order_details',order_id:orderId,security:'<?php echo $ajax_nonce; ?>'},success:function(res){if(res.success){c.innerHTML=res.data;}else{c.innerHTML='<div style="text-align:center;color:#d32f2f;padding:30px;">❌ '+res.data+'</div>';}},error:function(){c.innerHTML='<div style="text-align:center;color:#d32f2f;padding:30px;"><h3>⚠️ Error 500</h3></div>';}});
}
function closeOrderModal(){document.getElementById('modern-order-modal').style.display='none';document.getElementById('modal-body-content').innerHTML='';}
window.onclick=function(e){if(e.target==document.getElementById('modern-order-modal'))closeOrderModal();}
document.head.insertAdjacentHTML('beforeend','<style>@keyframes spin{100%{transform:rotate(360deg);}}</style>');
</script>
<?php }