<?php
/**
 * SAMURAI SIM - Ultimate Dashboard v6 (Final Consolidated)
 * One file, One shortcode, Premium Modern Experience.
 * Typography: Noto Sans Thai (Google CDN)
 * Icons: Material Symbols Outlined (Google CDN)
 * Supported Plugin: WP LINE Login by shipweb
 * Shortcode: [samurai_dashboard]
 */

// =====================================================
// 1. AJAX HANDLER: ORDER DETAILS (MODAL CONTENT)
// =====================================================
add_action( 'wp_ajax_samurai_get_order_details', 'samurai_get_order_details_ajax' );
add_action( 'wp_ajax_nopriv_samurai_get_order_details', 'samurai_get_order_details_ajax' );
function samurai_get_order_details_ajax() {
    if ( ! is_user_logged_in() ) {
        wp_send_json_error( 'กรุณาเข้าสู่ระบบก่อนดูข้อมูล' );
    }
    
    check_ajax_referer( 'samurai_nonce', 'security' );
    $order_id = isset($_POST['order_id']) ? intval( $_POST['order_id'] ) : 0;
    if ( ! $order_id ) wp_send_json_error( 'ไม่พบรหัสออเดอร์' );
    
    $order = wc_get_order( $order_id );
    if ( ! $order ) wp_send_json_error( 'ไม่พบข้อมูลออเดอร์ในระบบ' );
    
    // Security: Only owner or admin can view
    if ( ! current_user_can('administrator') && $order->get_customer_id() !== get_current_user_id() ) {
        wp_send_json_error( 'คุณไม่มีสิทธิ์เข้าถึงข้อมูลของออเดอร์นี้' );
    }

    $status        = $order->get_status();
    $status_name   = wc_get_order_status_name( $status );
    $status_colors = [
        'completed'  => ['bg'=>'#d1fae5','color'=>'#065f46'],
        'processing' => ['bg'=>'#fef3c7','color'=>'#92400e'],
        'on-hold'    => ['bg'=>'#fef3c7','color'=>'#92400e'],
        'pending'    => ['bg'=>'#e0f2fe','color'=>'#0369a1'],
        'cancelled'  => ['bg'=>'#fee2e2','color'=>'#991b1b'],
        'failed'     => ['bg'=>'#fee2e2','color'=>'#991b1b'],
    ];
    $sc = $status_colors[$status] ?? ['bg'=>'#f3f4f6','color'=>'#374151'];

    ob_start(); ?>
    <div class="inv2-wrap">

        <!-- HEADER -->
        <div class="inv2-header">
            <div class="inv2-header-info">
                <span class="inv2-badge" style="background:<?php echo $sc['bg'];?>;color:<?php echo $sc['color'];?>;"><?php echo esc_html($status_name);?></span>
                <h2>ออเดอร์ #<?php echo esc_html($order->get_order_number());?></h2>
                <p>📅 <?php echo wc_format_datetime($order->get_date_created(), 'd M Y · H:i');?> น.</p>
            </div>
        </div>

        <!-- ITEMS -->
        <div class="inv2-items">
            <?php foreach($order->get_items() as $item):
                $product   = $item->get_product();
                $thumb_url = $product ? get_the_post_thumbnail_url($product->get_id(), 'thumbnail') : '';
                if (!$thumb_url && $product) $thumb_url = wc_placeholder_img_src('thumbnail');
            ?>
            <div class="inv2-item">
                <div class="inv2-item-img">
                    <?php if($thumb_url): ?>
                        <img src="<?php echo esc_url($thumb_url);?>" alt="<?php echo esc_attr($item->get_name());?>">
                    <?php else: ?>
                        <div class="inv2-img-placeholder">📦</div>
                    <?php endif; ?>
                </div>
                <div class="inv2-item-info">
                    <div class="inv2-item-name"><?php echo esc_html($item->get_name());?></div>
                    <div class="inv2-item-qty">จำนวน: <?php echo $item->get_quantity();?> ชิ้น</div>
                </div>
                <div class="inv2-item-price"><?php echo $order->get_formatted_line_subtotal($item);?></div>
            </div>
            <?php endforeach;?>
        </div>

        <!-- TOTALS -->
        <div class="inv2-totals">
            <?php foreach($order->get_order_item_totals() as $key => $total):
                $is_grand = ($key === 'order_total');
            ?>
            <div class="inv2-total-row <?php echo $is_grand ? 'inv2-grand' : '';?>">
                <span><?php echo wp_kses_post($total['label']);?></span>
                <span><?php echo wp_kses_post($total['value']);?></span>
            </div>
            <?php endforeach;?>
        </div>

        <!-- ADDRESSES -->
        <?php
        $billing  = $order->get_formatted_billing_address();
        $shipping = $order->get_formatted_shipping_address();
        // ลบ "-" บรรทัดว่างออก
        $billing  = preg_replace('/^-\s*$/m', '', $billing);
        $shipping = preg_replace('/^-\s*$/m', '', $shipping);
        if ($billing || ($shipping && $order->needs_shipping_address())): ?>
        <div class="inv2-addresses">
            <?php if($billing): ?>
            <div class="inv2-addr">
                <div class="inv2-addr-label">📍 ที่อยู่ใบเสร็จ</div>
                <address><?php echo wp_kses_post($billing);?></address>
                <?php if($order->get_billing_phone()) echo '<div class="inv2-contact">📞 '.esc_html($order->get_billing_phone()).'</div>'; ?>
            </div>
            <?php endif; ?>
            <?php if($shipping && $order->needs_shipping_address()): ?>
            <div class="inv2-addr">
                <div class="inv2-addr-label">🚚 ที่อยู่จัดส่ง</div>
                <address><?php echo wp_kses_post($shipping);?></address>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- FOOTER ACTIONS -->
        <div class="inv2-footer">
            <button onclick="window.print()" class="inv2-btn-outline">
                <span class="dashicons dashicons-printer"></span> พิมพ์
            </button>
            <?php
            $actions = wc_get_account_orders_actions($order);
            foreach($actions as $key => $action) {
                if($key === 'view') continue;
                echo '<a href="'.esc_url($action['url']).'" class="inv2-btn-primary">'.esc_html($action['name']).'</a>';
            } ?>
        </div>
    </div>

    <style>
    .inv2-wrap { font-family:inherit; }

    /* HEADER */
    .inv2-header { padding:24px 28px 20px; background:#111; border-radius:16px 16px 0 0; }
    .inv2-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; margin-bottom:8px; }
    .inv2-header h2 { color:#fff; font-size:22px; font-weight:800; margin:0 0 4px; }
    .inv2-header p { color:rgba(255,255,255,0.55); font-size:13px; margin:0; }

    /* ITEMS */
    .inv2-items { padding:20px 28px; display:flex; flex-direction:column; gap:12px; border-bottom:1px solid #f3f4f6; }
    .inv2-item { display:flex; align-items:center; gap:14px; padding:14px; background:#f9fafb; border-radius:12px; }
    .inv2-item-img { width:60px; height:60px; flex-shrink:0; border-radius:8px; overflow:hidden; background:#eee; }
    .inv2-item-img img { width:100%; height:100%; object-fit:cover; }
    .inv2-img-placeholder { width:60px; height:60px; display:flex; align-items:center; justify-content:center; font-size:28px; background:#f0f0f0; border-radius:8px; }
    .inv2-item-info { flex:1; }
    .inv2-item-name { font-size:14px; font-weight:700; color:#111; margin-bottom:4px; }
    .inv2-item-qty { font-size:12px; color:#9ca3af; }
    .inv2-item-price { font-size:15px; font-weight:800; color:#111; white-space:nowrap; }

    /* TOTALS */
    .inv2-totals { padding:16px 28px; display:flex; flex-direction:column; gap:8px; border-bottom:1px solid #f3f4f6; }
    .inv2-total-row { display:flex; justify-content:space-between; font-size:13px; color:#6b7280; }
    .inv2-total-row span:last-child { font-weight:600; color:#374151; }
    .inv2-grand { background:#fff5f5; border-radius:10px; padding:12px 16px; margin-top:4px; }
    .inv2-grand span { font-size:16px; font-weight:800 !important; color:#d32f2f !important; }

    /* ADDRESSES */
    .inv2-addresses { display:grid; grid-template-columns:1fr 1fr; gap:12px; padding:20px 28px; border-bottom:1px solid #f3f4f6; }
    .inv2-addr-label { font-size:11px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
    .inv2-addr address { font-style:normal; font-size:13px; color:#374151; line-height:1.7; }
    .inv2-addr address br + br { display:none; }
    .inv2-contact { font-size:12px; color:#6b7280; margin-top:6px; }

    /* FOOTER */
    .inv2-footer { padding:16px 28px; display:flex; gap:10px; justify-content:flex-end; align-items:center; background:#f9fafb; border-radius:0 0 16px 16px; }
    .inv2-btn-outline { display:flex; align-items:center; gap:6px; background:#fff; border:1.5px solid #e5e7eb; color:#374151; padding:9px 16px; border-radius:8px; cursor:pointer; font-weight:700; font-size:13px; transition:all 0.2s; }
    .inv2-btn-outline:hover { background:#111; color:#fff; border-color:#111; }
    .inv2-btn-outline .dashicons { font-size:16px; width:16px; height:16px; }
    .inv2-btn-primary { background:#d32f2f; color:#fff !important; padding:9px 16px; border-radius:8px; text-decoration:none !important; font-weight:700; font-size:13px; }
    .inv2-btn-primary:hover { background:#b71c1c !important; }

    @media (max-width:600px) {
        .inv2-header { border-radius:0; padding:20px; }
        .inv2-items,.inv2-totals,.inv2-addresses,.inv2-footer { padding:16px 20px; }
        .inv2-addresses { grid-template-columns:1fr; }
        .inv2-item-img,.inv2-img-placeholder { width:48px; height:48px; }
    }
    @media print {
        body * { visibility:hidden; }
        .sm-modal-content,.sm-modal-content * { visibility:visible; }
        .sm-modal-content { position:fixed; inset:0; box-shadow:none; border-radius:0; }
        .sm-close,.inv2-footer { display:none !important; }
    }
    </style>
    <?php
    $html = ob_get_clean();
    wp_send_json_success( $html );
    wp_die();
}

// =====================================================
// 2. MAIN DASHBOARD SHORTCODE
// =====================================================
add_shortcode('samurai_dashboard', function() {
    if ( ! is_user_logged_in() ) {
        return samurai_auth_ui();
    }

    $user = wp_get_current_user();
    $user_id = $user->ID;

    // --- LINE INTEGRATION (wplinelogin-master by shipweb) ---
    // sll_lineid = LINE User ID | sll_lineprofile = array { pictureUrl, displayName }
    $line_id      = get_user_meta($user_id, 'sll_lineid', true);
    $line_profile = get_user_meta($user_id, 'sll_lineprofile', true);
    $is_line      = !empty($line_id);
    $line_avatar  = !empty($line_profile['pictureUrl']) ? $line_profile['pictureUrl'] : '';

    $avatar_html = $line_avatar
        ? '<img src="'.esc_url($line_avatar).'" class="avatar" style="object-fit:cover;width:100%;height:100%;border-radius:50%;">'
        : get_avatar($user_id, 100);

    $orders = wc_get_orders(['customer_id' => $user_id, 'limit' => -1]);
    $processing = count(array_filter($orders, fn($o) => in_array($o->get_status(), ['processing','on-hold','pending'])));
    $cart_total = WC()->cart ? WC()->cart->get_cart_total() : '฿0';
    $nonce = wp_create_nonce("samurai_nonce");

    ob_start(); ?>
    <div class="samurai-app">
        <!-- GLOBAL HEADER & SIDEBAR -->
        <aside class="sm-sidebar">
            <div class="sm-profile-section">
                <div class="sm-avatar"><?php echo $avatar_html; ?></div>
                <div class="sm-user-info">
                    <h3><?php echo esc_html($user->display_name); ?></h3>
                    <div class="sm-login-method <?php echo $is_line ? 'is-line' : 'is-default'; ?>">
                        <?php if($is_line): ?>
                            <svg viewBox="0 0 24 24" fill="currentColor" width="12" style="margin-right:4px; vertical-align:middle;"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
                            ล็อกอินผ่าน LINE
                        <?php else: ?>
                            <span class="mi" style="font-size:12px;margin-right:4px; vertical-align:middle;">person</span>
                            บัญชีปกติ
                        <?php endif; ?>
                    </div>
                    <p style="opacity:0.7; font-size:11px; margin-top:5px;"><?php echo esc_html($user->user_email); ?></p>
                </div>
                <a href="<?php echo wp_logout_url(get_permalink()); ?>" class="sm-mobile-logout" title="ออกจากระบบ">
                    <span class="mi">logout</span>
                </a>
            </div>

            <nav class="sm-nav">
                <div class="sm-nav-item active" data-tab="home"><span class="mi">grid_view</span> หน้าแรก</div>
                <div class="sm-nav-item" data-tab="orders"><span class="mi">shopping_bag</span> คำสั่งซื้อ</div>
                <div class="sm-nav-item" data-tab="address"><span class="mi">location_on</span> ที่อยู่</div>
                <div class="sm-nav-item" data-tab="account"><span class="mi">person</span> บัญชี</div>
                <div class="sm-nav-item" data-tab="payment"><span class="mi">payments</span> การชำระเงิน</div>
                <hr>
                <a href="<?php echo wp_logout_url(get_permalink()); ?>" class="sm-nav-item logout"><span class="mi">logout</span> ออกจากระบบ</a>
            </nav>
        </aside>

        <!-- CONTENT -->
        <main class="sm-main">
            <!-- TAB: HOME -->
            <section id="tab-home" class="sm-section active">
                <div class="sm-stats-row">
                    <div class="sm-mini-card">
                        <div class="sm-mini-icon red"><span class="mi">list_alt</span></div>
                        <div class="sm-mini-info">
                            <span class="val"><?php echo count($orders); ?></span>
                            <span class="label">ออเดอร์ทั้งหมด</span>
                        </div>
                    </div>
                    <div class="sm-mini-card">
                        <div class="sm-mini-icon black"><span class="mi">shopping_cart</span></div>
                        <div class="sm-mini-info">
                            <span class="val"><?php echo $cart_total; ?></span>
                            <span class="label">ยอดในตะกร้า</span>
                        </div>
                    </div>
                </div>

                <div class="sm-card">
                    <div class="sm-card-header">
                        <h3>รายการล่าสุด</h3>
                        <button class="sm-link-btn" onclick="document.querySelector('[data-tab=orders]').click()">ดูทั้งหมด ></button>
                    </div>
                    <?php samurai_render_orders_table(array_slice($orders, 0, 3)); ?>
                </div>
            </section>

            <!-- Other tabs -->
            <section id="tab-orders" class="sm-section">
                <div class="sm-card">
                    <div class="sm-card-header"><h3>ประวัติคำสั่งซื้อทั้งหมด</h3></div>
                    <?php samurai_render_orders_table($orders); ?>
                </div>
            </section>
            <section id="tab-address" class="sm-section">
                <div class="sm-card">
                    <div class="sm-card-header"><h3>จัดการที่อยู่</h3></div>
                    <div class="sm-wc-embed"><?php wc_get_template('myaccount/my-address.php', ['customer_id' => $user_id]); ?></div>
                </div>
            </section>
            <section id="tab-account" class="sm-section">
                <div class="sm-card">
                    <div class="sm-card-header"><h3>ข้อมูลส่วนตัวและรหัสผ่าน</h3></div>
                    <div class="sm-wc-embed"><?php wc_get_template('myaccount/form-edit-account.php', ['user' => $user]); ?></div>
                </div>
            </section>
            <section id="tab-payment" class="sm-section">
                <div class="sm-card">
                    <div class="sm-card-header"><h3>ช่องทางการชำระเงิน</h3></div>
                    <div class="sm-wc-embed"><?php wc_get_template('myaccount/payment-methods.php'); ?></div>
                </div>
            </section>
        </main>
    </div>

    <!-- ORDER MODAL -->
    <div id="samurai-modal" class="sm-modal">
        <div class="sm-modal-overlay" onclick="closeSamuraiModal()"></div>
        <div class="sm-modal-content">
            <span class="sm-close" onclick="closeSamuraiModal()">&times;</span>
            <div id="sm-modal-load"></div>
        </div>
    </div>

    <style>
    :root { --sm-red: #d32f2f; --sm-dark: #111; --sm-gray: #666; --sm-light: #f4f4f4; --sm-white: #fff; --sm-border: #eee; --sm-font: 'Noto Sans Thai', sans-serif; }
    
    /* Material Icons */
    .mi { font-family: 'Material Symbols Outlined'; font-weight: normal; font-style: normal; font-size: 24px; line-height: 1; letter-spacing: normal; text-transform: none; display: inline-block; white-space: nowrap; word-wrap: normal; direction: ltr; -webkit-font-feature-settings: 'liga'; -webkit-font-smoothing: antialiased; }

    .samurai-app { display: flex; background: #f9fafb; border-radius: 20px; overflow: hidden; min-height: 700px; font-family: var(--sm-font); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    
    /* Sidebar & Profile Section */
    .sm-sidebar { width: 260px; background: #fff; display: flex; flex-direction: column; padding: 0; border-right: 1px solid #eee; z-index: 10; }
    .sm-profile-section { padding: 40px 20px; text-align: center; border-bottom: 1px solid #f5f5f5; }
    .sm-avatar { width: 80px; height: 80px; margin: 0 auto 15px; border-radius: 50%; border: 3px solid var(--sm-red); box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; }
    .sm-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .sm-user-info h3 { font-size: 18px; margin: 0; font-weight: 800; color: #111; line-height: 1.2; }
    
    .sm-login-method { display: inline-flex; align-items: center; background: #f0f0f0; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; color: #666; margin-top: 8px; text-transform: uppercase; }
    .sm-login-method.is-line { background: #06C755; color: #fff; }
    .sm-login-method svg, .sm-login-method .mi { margin-right: 5px; }
    .sm-mobile-logout { display: none; }

    /* Navigation */
    .sm-nav { flex: 1; padding: 15px 0; }
    .sm-nav-item { display: flex; align-items: center; gap: 12px; padding: 14px 25px; color: #555; cursor: pointer; transition: all 0.2s; font-size: 14px; font-weight: 500; text-decoration: none !important; }
    .sm-nav-item .mi { color: #888; font-size: 22px; }
    .sm-nav-item:hover { background: #fff5f5; color: var(--sm-red); }
    .sm-nav-item:hover .mi { color: var(--sm-red); }
    .sm-nav-item.active { background: var(--sm-red); color: #fff !important; }
    .sm-nav-item.active .mi { color: #fff !important; }
    .sm-nav hr { border: none; border-top: 1px solid #f0f0f0; margin: 15px 25px; }
    .sm-nav-item.logout { margin-top: auto; color: #999; }

    /* Content Area */
    .sm-main { flex: 1; padding: 40px; overflow-y: auto; height: 85vh; background: #f9fafb; }
    .sm-section { display: none; animation: fadeIn 0.4s; }
    .sm-section.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .sm-card { background: #fff; border-radius: 15px; padding: 30px; margin-bottom: 20px; border: 1px solid var(--sm-border); box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .sm-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #f0f0f0; }
    .sm-card-header h3 { font-size: 17px; margin: 0; font-weight: 800; color: #111; }
    .sm-link-btn { background: none; border: none; color: var(--sm-red); cursor: pointer; font-weight: 700; font-size: 13px; }

    /* Order Status / Mini Cards */
    .sm-stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .sm-mini-card { background: #fff; padding: 25px; border-radius: 15px; display: flex; align-items: center; gap: 15px; border: 1px solid #eee; }
    .sm-mini-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .sm-mini-icon.red { background: #fff5f5; color: var(--sm-red); }
    .sm-mini-icon.black { background: #f5f5f5; color: #111; }
    .sm-mini-info .val { display: block; font-size: 24px; font-weight: 800; color: #111; line-height: 1; }
    .sm-mini-info .label { font-size: 12px; color: #888; font-weight: 600; }

    /* Tables */
    .sm-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .sm-table th { text-align: left; padding: 16px; background: #f8f9fa; color: #333; font-weight: 800; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #eee; }
    .sm-table td { padding: 16px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; color: #444; }
    .sm-status { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .sm-status.status-completed { background: #e8f5e9; color: #2e7d32; }
    .sm-status.status-processing { background: #fff3e0; color: #ef6c00; }
    .sm-action-btn { background: #f0f0f0; border: none; padding: 8px 12px; border-radius: 8px; font-weight: 700; font-size: 12px; color: #555; cursor: pointer; transition: all 0.2s; }
    .sm-action-btn:hover { background: var(--sm-red); color: #fff; }

    /* Modal Styling */
    .sm-modal { display: none; position: fixed; inset: 0; z-index: 999999; align-items: center; justify-content: center; padding: 20px; }
    .sm-modal.open { display: flex; }
    .sm-modal-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); }
    .sm-modal-content { position: relative; background: #fff; width: 100%; max-width: 720px; max-height: 90vh; overflow-y: auto; border-radius: 16px; box-shadow: 0 25px 60px rgba(0,0,0,0.3); animation: modalIn 0.25s ease; }
    @keyframes modalIn { from { opacity:0; transform: translateY(20px) scale(0.97); } to { opacity:1; transform: translateY(0) scale(1); } }
    .sm-close { position: absolute; top: 14px; right: 16px; width: 32px; height: 32px; background: #f3f4f6; border: none; border-radius: 50%; font-size: 20px; line-height: 1; cursor: pointer; color: #666; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.15s; }
    .sm-close:hover { background: #d32f2f; color: #fff; }

    .sm-modal-header { background: linear-gradient(135deg, #111 0%, #333 100%); color: #fff; padding: 28px 32px; display: flex; justify-content: space-between; align-items: flex-start; border-radius: 16px 16px 0 0; }
    .sm-modal-header h2 { margin: 0 0 4px; font-size: 22px; font-weight: 800; }
    .sm-modal-header p { margin: 0; font-size: 13px; opacity: 0.7; }
    .sm-order-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; font-size: 14px; }
    .sm-order-table th { background: #f9fafb; padding: 12px 14px; text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; border-bottom: 2px solid #e5e7eb; }
    .sm-order-table td { padding: 14px; border-bottom: 1px solid #f3f4f6; color: #374151; }
    .sm-order-table tfoot th, .sm-order-table tfoot td { padding: 10px 14px; border-bottom: none; border-top: 1px solid #e5e7eb; font-weight: 700; color: #111; }
    .sm-address-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 8px; }
    .sm-address-card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px 20px; }
    .sm-address-card h4 { margin: 0 0 8px; font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; }
    .sm-modal-footer { padding: 20px 32px; background: #f9fafb; border-top: 1px solid #e5e7eb; border-radius: 0 0 16px 16px; display: flex; gap: 10px; justify-content: flex-end; }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .samurai-app { flex-direction: column; border-radius: 0; box-shadow: none; background: #f8f9fa; padding-bottom: 0; }
        .sm-sidebar { width: 100%; border-right: none; background: var(--sm-red); }
        .sm-profile-section { background: var(--sm-red); color: #fff; padding: 30px 20px; display: flex; align-items: center; text-align: left; gap: 15px; border-bottom: none; }
        .sm-avatar { width: 65px; height: 65px; margin: 0; border-color: rgba(255,255,255,0.4); }
        .sm-user-info { display: flex; flex-direction: column; align-items: flex-start; }
        .sm-user-info h3 { font-size: 18px; color: #fff !important; margin: 0; line-height: 1.2; }
        .sm-user-info p { color: rgba(255,255,255,0.8); font-size: 11px; margin: 2px 0 0; }
        .sm-login-method { margin-top: 6px; background: rgba(0,0,0,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.2); }
        .sm-login-method.is-line { background: #06C755; border: none; }
        
        .sm-nav { position: sticky; top: 0; width: 100%; background: #fff; display: flex; overflow-x: auto; padding: 0; border-bottom: 1px solid #eee; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .sm-nav::-webkit-scrollbar { display: none; }
        .sm-nav-item { flex: 0 0 auto; padding: 15px 20px !important; border-bottom: 3px solid transparent; flex-direction: row; gap: 6px; font-size: 14px; color: #555; }
        .sm-nav-item .mi { font-size: 20px; color: #777; }
        .sm-nav-item.active { background: #fff; color: var(--sm-red) !important; border-bottom-color: var(--sm-red); box-shadow: none; }
        .sm-nav-item.active .mi { color: var(--sm-red) !important; }
        .sm-nav hr, .sm-nav-item.logout { display: none; }
        .sm-mobile-logout { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.2); color: #fff; text-decoration: none !important; margin-left: auto; flex-shrink: 0; transition: background 0.2s; }
        .sm-mobile-logout:hover { background: rgba(255,255,255,0.35); }
        .sm-mobile-logout .mi { font-size: 22px; }

        .sm-main { padding: 12px; height: auto; margin-top: 0; position: relative; z-index: 5; }
        .sm-stats-row { gap: 10px; margin-bottom: 12px; }
        .sm-mini-card { padding: 15px; border-radius: 12px; display: flex; align-items: center; gap: 10px; }
        .sm-mini-icon { width: 30px; height: 30px; border-radius: 8px; font-size: 18px; }
        .sm-mini-info .val { font-size: 16px; }
        .sm-mini-info .label { font-size: 10px; }

        .sm-table thead { display: none; }
        .sm-table tbody tr { display: block; background: #fff; border: 1px solid #f0f0f0; border-radius: 10px; margin-bottom: 10px; padding: 12px; }
        .sm-table td { display: flex; justify-content: space-between; align-items: center; padding: 6px 0 !important; border-bottom: 1px solid #f9f9f9 !important; }
        .sm-table td::before { content: attr(data-label); font-weight: 700; color: #888; font-size: 11px; }
        .sm-action-btn { width: 100%; background: var(--sm-red); color: #fff; border: none; padding: 10px; margin-top: 8px; border-radius: 8px; }
        .sm-modal-content { margin: 0; width: 100%; height: 100%; border-radius: 0; }
    }

    @keyframes spin { 100% { transform: rotate(360deg); } }

    /* Auth Styling */
    .sm-auth-container { background: #f9fafb; min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 15px; border-radius: 20px; font-family: var(--sm-font); }
    .sm-auth-box { background: #fff; width: 100%; max-width: 420px; padding: 30px; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.08); position: relative; }
    .sm-auth-header { text-align: center; margin-bottom: 20px; }
    .sm-auth-header img { max-height: 40px; margin-bottom: 10px; }
    .sm-auth-header h2 { font-size: 20px; font-weight: 800; margin: 0 0 3px; color: #111; }
    .sm-auth-header p { color: #999; font-size: 12px; margin: 0; }
    .sm-auth-tabs { display: flex; border-bottom: 2px solid #f0f0f0; margin-bottom: 20px; }
    .sm-auth-tab { flex: 1; background: none; border: none; padding: 10px; font-weight: 700; color: #999; cursor: pointer; border-bottom: 3px solid transparent; transition: 0.2s; font-family: inherit; font-size: 14px; }
    .sm-auth-tab.active { color: #d32f2f; border-bottom-color: #d32f2f; }
    .sm-auth-box .woocommerce h2 { display: none !important; }
    .sm-auth-box .u-columns { display: block !important; margin: 0 !important; width: 100% !important; }
    .sm-auth-box .u-column1, .sm-auth-box .u-column2 { width: 100% !important; float: none !important; padding: 0 !important; margin: 0 !important; }
    .sm-auth-box.show-login .u-column2 { display: none !important; }
    .sm-auth-box.show-reg .u-column1 { display: none !important; }
    .sm-auth-box.no-reg .u-column2 { display: none !important; }
    .sm-auth-divider { display: flex; align-items: center; gap: 10px; color: #eee; margin: 20px 0; }
    .sm-auth-divider::before, .sm-auth-divider::after { content: ''; flex: 1; height: 1px; background: #eee; }
    .sm-auth-divider span { color: #ccc; font-size: 11px; }
    .sm-line-btn { display: flex; align-items: center; justify-content: center; gap: 8px; background: #06C755; color: #fff !important; padding: 12px; border-radius: 10px; text-decoration: none !important; font-weight: 700; transition: 0.3s; box-sizing: border-box; font-size: 14px; }
    .sm-line-btn:hover { background: #05a848; transform: translateY(-1px); }
    .sm-auth-box input[type="text"], .sm-auth-box input[type="password"], .sm-auth-box input[type="email"] { width: 100% !important; padding: 10px 14px !important; border-radius: 8px !important; border: 1.5px solid #eee !important; background: #fafafa !important; box-sizing: border-box !important; font-size: 14px !important; outline: none !important; }
    .sm-auth-box button[type="submit"] { width: 100% !important; padding: 12px !important; border-radius: 8px !important; background: #111 !important; color: #fff !important; font-weight: 800 !important; border: none !important; margin-top: 5px !important; cursor: pointer !important; transition: 0.2s; font-size: 15px; }
    .sm-auth-box button[type="submit"]:hover { background: #d32f2f !important; }
    .sm-auth-box label { font-weight: 700 !important; font-size: 12px !important; color: #444 !important; margin-bottom: 4px !important; display: block; }
    .sm-auth-box .woocommerce-LostPassword { text-align: center; margin-top: 12px; font-size: 12px; }
    .sm-auth-box .woocommerce-LostPassword a { color: #d32f2f !important; text-decoration: none !important; }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        document.querySelectorAll('.sm-nav-item[data-tab]').forEach(btn => {
            btn.addEventListener('click', function() {
                const tab = this.dataset.tab;
                document.querySelectorAll('.sm-nav-item').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.sm-section').forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('tab-' + tab).classList.add('active');
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        });

        // AJAX Modal
        window.openOrderModal = function(id) {
            const modal = document.getElementById('samurai-modal');
            const load = document.getElementById('sm-modal-load');
            if (!modal || !load) return;
            modal.classList.add('open');
            load.innerHTML = '<div style="text-align:center;padding:100px;"><span class="mi" style="animation:spin 2s linear infinite;font-size:48px;color:var(--sm-red);">sync</span><p style="margin-top:15px;color:#888;">กำลังโหลดข้อมูล...</p></div>';
            
            const formData = new FormData();
            formData.append('action', 'samurai_get_order_details');
            formData.append('order_id', id);
            formData.append('security', '<?php echo $nonce; ?>');
            fetch('<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(res => {
                    if(res.success) load.innerHTML = res.data;
                    else load.innerHTML = '<div style="padding:50px;text-align:center;color:#d32f2f;">❌ ' + res.data + '</div>';
                })
                .catch(() => { load.innerHTML = '<div style="padding:50px;text-align:center;color:#d32f2f;">❌ เกิดข้อผิดพลาด กรุณาลองใหม่</div>'; });
        };
        window.closeSamuraiModal = function() { document.getElementById('samurai-modal').classList.remove('open'); };
        document.addEventListener('keydown', function(e) { if(e.key === 'Escape') closeSamuraiModal(); });
    });

    function switchAuth(type) {
        const box = document.getElementById('sm-auth-box');
        const title = document.getElementById('auth-title');
        const sub = document.getElementById('auth-subtitle');
        const lTab = document.getElementById('btn-tab-login');
        const rTab = document.getElementById('btn-tab-reg');
        if(type === 'login') {
            box.classList.remove('show-reg'); box.classList.add('show-login');
            lTab.classList.add('active'); rTab.classList.remove('active');
            title.innerText = 'ยินดีต้อนรับกลับมา';
            sub.innerText = 'เข้าสู่ระบบเพื่อจัดการ eSIM ของคุณ';
        } else {
            box.classList.remove('show-login'); box.classList.add('show-reg');
            rTab.classList.add('active'); lTab.classList.remove('active');
            title.innerText = 'เริ่มใช้งาน SAMURAI SIM';
            sub.innerText = 'สมัครสมาชิกเพื่อรับสิทธิพิเศษและจัดการ eSIM';
        }
    }
    </script>
    <?php
    return ob_get_clean();
});

// =====================================================
// 3. AUTH UI (แสดงเมื่อยังไม่ได้ล็อกอิน)
// =====================================================
function samurai_auth_ui() {
    $enable_reg  = get_option('woocommerce_enable_myaccount_registration') === 'yes';
    $logo_id     = get_theme_mod('custom_logo');
    $logo_url    = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    $site_name   = get_bloginfo('name');
    $line_url    = home_url('/linelogin');

    ob_start(); ?>

    <!-- AUTH PROMPT CARD -->
    <div style="font-family:'Noto Sans Thai',sans-serif;min-height:400px;display:flex;align-items:center;justify-content:center;background:#f9fafb;border-radius:20px;padding:40px;text-align:center;">
        <div>
            <div style="font-size:56px;margin-bottom:20px;">🔐</div>
            <h2 style="font-size:22px;font-weight:800;color:#111;margin:0 0 10px;">กรุณาเข้าสู่ระบบก่อน</h2>
            <p style="color:#888;font-size:14px;margin:0 0 28px;">เข้าสู่ระบบเพื่อดูข้อมูล eSIM และคำสั่งซื้อของคุณ</p>
            <button onclick="openAuthModal()" style="background:#d32f2f;color:#fff;padding:13px 35px;border-radius:10px;font-size:15px;font-weight:800;border:none;cursor:pointer;">เข้าสู่ระบบ / สมัครสมาชิก</button>
        </div>
    </div>

    <!-- AUTH MODAL POPUP -->
    <div id="modern-auth-modal" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.75);backdrop-filter:blur(5px);overflow-y:auto;">
        <div style="background:#fff;margin:3% auto;width:92%;max-width:440px;max-height:94vh;overflow-y:auto;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,0.3);position:relative;">
            <span onclick="closeAuthModal()" style="position:absolute;top:12px;right:16px;font-size:26px;cursor:pointer;color:#aaa;z-index:10;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">&times;</span>

            <!-- HEADER -->
            <div style="text-align:center;padding:30px 28px 20px;background:#fff5f5;border-bottom:1px solid #f0f0f0;border-radius:20px 20px 0 0;">
                <?php if($logo_url): ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_name); ?>" style="max-height:48px;margin-bottom:14px;display:inline-block;object-fit:contain;">
                <?php else: ?>
                    <h2 style="font-size:20px;font-weight:800;margin-bottom:5px;"><?php echo esc_html($site_name); ?></h2>
                <?php endif; ?>
                <h3 id="auth-welcome-text" style="font-size:20px;font-weight:800;color:#1f2937;margin:0 0 4px;">ยินดีต้อนรับกลับมา 👋</h3>
                <p id="auth-welcome-sub" style="color:#9ca3af;font-size:13px;margin:0;">เข้าสู่ระบบเพื่อจัดการบัญชีและคำสั่งซื้อของคุณ</p>
            </div>

            <!-- TABS -->
            <?php if($enable_reg): ?>
            <div style="display:flex;background:#f9fafb;border-bottom:1px solid #eee;">
                <button id="tab-btn-login" onclick="switchAuthTab('login')" style="flex:1;padding:13px 0;border:none;background:transparent;font-size:15px;font-weight:700;color:#d32f2f;cursor:pointer;border-bottom:3px solid #d32f2f;outline:none;font-family:inherit;">เข้าสู่ระบบ</button>
                <button id="tab-btn-register" onclick="switchAuthTab('register')" style="flex:1;padding:13px 0;border:none;background:transparent;font-size:15px;font-weight:700;color:#9ca3af;cursor:pointer;border-bottom:3px solid transparent;outline:none;font-family:inherit;">ลงทะเบียน</button>
            </div>
            <?php endif; ?>

            <!-- FORM BODY -->
            <div style="padding:22px 28px 28px;">
                <div class="woocommerce"><?php wc_get_template('myaccount/form-login.php'); ?></div>

                <!-- LINE LOGIN -->
                <div style="display:flex;align-items:center;gap:12px;margin:18px 0 14px;">
                    <hr style="flex:1;border:none;border-top:1px solid #e5e7eb;margin:0;">
                    <span style="color:#9ca3af;font-size:12px;white-space:nowrap;">หรือเข้าสู่ระบบด้วย</span>
                    <hr style="flex:1;border:none;border-top:1px solid #e5e7eb;margin:0;">
                </div>
                <a href="<?php echo esc_url($line_url); ?>" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:13px;background:#06C755;color:#fff;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;box-sizing:border-box;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
                    เข้าสู่ระบบด้วย LINE
                </a>
            </div>
        </div>
    </div>

    <style>
    #modern-auth-modal .woocommerce h2 { display:none !important; }
    #modern-auth-modal .u-columns { display:flex; flex-direction:column; width:100%; margin:0; }
    #modern-auth-modal .u-column1, #modern-auth-modal .u-column2 { width:100% !important; float:none !important; padding:0 !important; }
    #modern-auth-modal .u-column2 { display:none; }
    #modern-auth-modal.show-register .u-column1 { display:none; }
    #modern-auth-modal.show-register .u-column2 { display:block; }
    #modern-auth-modal form { border:none !important; padding:0 !important; margin:0 !important; }
    #modern-auth-modal .woocommerce-form-row { margin-bottom:14px !important; padding-top:0 !important; position:relative !important; }
    #modern-auth-modal label { position:static !important; transform:none !important; font-size:12px !important; font-weight:700 !important; color:#374151 !important; margin-bottom:6px !important; display:block !important; top:auto !important; left:auto !important; opacity:1 !important; pointer-events:auto !important; }
    #modern-auth-modal input[type="text"], #modern-auth-modal input[type="password"], #modern-auth-modal input[type="email"] { width:100% !important; padding:12px 14px !important; padding-top:12px !important; border:1.5px solid #e5e7eb !important; border-radius:10px !important; box-sizing:border-box !important; font-size:15px !important; background:#fafafa !important; outline:none !important; position:static !important; transform:none !important; }
    #modern-auth-modal input:focus { border-color:#d32f2f !important; box-shadow:0 0 0 3px rgba(211,47,47,0.1) !important; }
    #modern-auth-modal button[type="submit"] { width:100% !important; padding:13px !important; border-radius:10px !important; background:#d32f2f !important; color:#fff !important; font-size:16px !important; font-weight:700 !important; border:none !important; margin-top:14px !important; cursor:pointer !important; font-family:inherit !important; }
    #modern-auth-modal button[type="submit"]:hover { background:#b71c1c !important; }
    #modern-auth-modal .woocommerce-LostPassword a { color:#d32f2f !important; font-size:13px !important; text-decoration:none !important; }
    </style>
    <script>
    function openAuthModal() { document.getElementById('modern-auth-modal').style.display = 'block'; document.body.style.overflow = 'hidden'; }
    function closeAuthModal() { document.getElementById('modern-auth-modal').style.display = 'none'; document.body.style.overflow = ''; }
    function switchAuthTab(tab) {
        const modal = document.getElementById('modern-auth-modal');
        const lBtn = document.getElementById('tab-btn-login');
        const rBtn = document.getElementById('tab-btn-register');
        const wt   = document.getElementById('auth-welcome-text');
        const ws   = document.getElementById('auth-welcome-sub');
        if (tab === 'register') {
            modal.classList.add('show-register');
            if(rBtn){ rBtn.style.color='#d32f2f'; rBtn.style.borderBottomColor='#d32f2f'; }
            if(lBtn){ lBtn.style.color='#9ca3af'; lBtn.style.borderBottomColor='transparent'; }
            if(wt) wt.innerText = 'ยินดีต้อนรับ 👋';
            if(ws) ws.innerText = 'สมัครสมาชิกใหม่เพื่อรับสิทธิพิเศษ';
        } else {
            modal.classList.remove('show-register');
            if(lBtn){ lBtn.style.color='#d32f2f'; lBtn.style.borderBottomColor='#d32f2f'; }
            if(rBtn){ rBtn.style.color='#9ca3af'; rBtn.style.borderBottomColor='transparent'; }
            if(wt) wt.innerText = 'ยินดีต้อนรับกลับมา 👋';
            if(ws) ws.innerText = 'เข้าสู่ระบบเพื่อจัดการบัญชีและคำสั่งซื้อของคุณ';
        }
    }
    window.addEventListener('click', function(e) { if(e.target === document.getElementById('modern-auth-modal')) closeAuthModal(); });
    document.addEventListener('keydown', function(e) { if(e.key === 'Escape') closeAuthModal(); });
    // Auto-open modal เมื่อมาจาก checkout
    if (new URLSearchParams(window.location.search).get('from_checkout') === '1') {
        document.addEventListener('DOMContentLoaded', function() { setTimeout(openAuthModal, 300); });
    }
    </script>
    <?php
    return ob_get_clean();
}

// =====================================================
// 4. HELPER: RENDER ORDERS TABLE
// =====================================================
function samurai_render_orders_table($orders) {
    if ( empty( $orders ) ) { echo '<p style="color:#999;text-align:center;padding:40px;">ไม่พบประวัติการสั่งซื้อ</p>'; return; }
    ?>
    <div class="sm-table-container">
        <table class="sm-table">
            <thead><tr><th>ออเดอร์</th><th>วันที่</th><th>สินค้า</th><th>สถานะ</th><th>ยอดรวม</th><th>จัดการ</th></tr></thead>
            <tbody>
                <?php foreach ( $orders as $order ) : ?>
                <tr>
                    <td data-label="ออเดอร์"><strong>#<?php echo $order->get_order_number(); ?></strong></td>
                    <td data-label="วันที่"><?php echo wc_format_datetime( $order->get_date_created(), 'd M Y' ); ?></td>
                    <td data-label="สินค้า" style="max-width:200px;"><?php 
                        foreach($order->get_items() as $item) {
                            echo esc_html($item->get_name()) . ' <small style="color:#999;">x' . $item->get_quantity() . '</small><br>';
                        }
                    ?></td>
                    <td data-label="สถานะ"><span class="sm-status status-<?php echo $order->get_status(); ?>"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span></td>
                    <td data-label="ยอดรวม"><?php echo $order->get_formatted_order_total(); ?></td>
                    <td data-label="จัดการ">
                        <button onclick="openOrderModal(<?php echo $order->get_id(); ?>)" class="sm-action-btn" title="ดูรายละเอียด"><span class="mi" style="font-size:18px;vertical-align:middle;margin-right:4px;">visibility</span> ดูรายละเอียด</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

// =====================================================
// 5. FORCE LOGIN — ADD TO CART + CHECKOUT
// =====================================================

// Block add to cart for guests (PHP fallback)
add_filter('woocommerce_add_to_cart_validation', function($valid, $product_id, $qty) {
    if ( ! is_user_logged_in() ) {
        wc_add_notice( 'กรุณาเข้าสู่ระบบก่อนเพิ่มสินค้าลงตะกร้า', 'error' );
        return false;
    }
    return $valid;
}, 10, 3);

// Block checkout for guests (backup)
add_action('template_redirect', function() {
    if ( ! is_checkout() || is_user_logged_in() || is_wc_endpoint_url() ) return;
    $back_to = add_query_arg('from_checkout', '1', wc_get_page_permalink('myaccount'));
    wp_safe_redirect( $back_to );
    exit;
});

// After login → redirect back to previous page
add_filter('woocommerce_login_redirect', function($redirect) {
    $from = isset($_REQUEST['redirect']) ? esc_url_raw($_REQUEST['redirect']) : '';
    if ( $from ) return $from;
    return $redirect;
}, 10, 1);

// Inject auth modal on ALL pages for guests (for add-to-cart interception)
add_action('wp_footer', function() {
    if ( is_user_logged_in() ) return;

    $logo_id   = get_theme_mod('custom_logo');
    $logo_url  = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    $site_name = get_bloginfo('name');
    $enable_reg = get_option('woocommerce_enable_myaccount_registration') === 'yes';
    $line_url  = home_url('/linelogin');
    $current_url = (is_ssl() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>
    <?php if ( ! is_account_page() ) : // ไม่ render ซ้ำในหน้า myaccount ?>
    <div id="modern-auth-modal" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.75);backdrop-filter:blur(5px);overflow-y:auto;">
        <div style="background:#fff;margin:3% auto;width:92%;max-width:440px;max-height:94vh;overflow-y:auto;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,0.3);position:relative;">
            <span onclick="closeAuthModal()" style="position:absolute;top:12px;right:16px;font-size:26px;cursor:pointer;color:#aaa;z-index:10;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">&times;</span>
            <div style="text-align:center;padding:30px 28px 20px;background:#fff5f5;border-bottom:1px solid #f0f0f0;border-radius:20px 20px 0 0;">
                <?php if($logo_url): ?><img src="<?php echo esc_url($logo_url); ?>" alt="" style="max-height:48px;margin-bottom:14px;display:inline-block;object-fit:contain;"><?php else: ?><h2 style="font-size:20px;font-weight:800;margin-bottom:5px;"><?php echo esc_html($site_name); ?></h2><?php endif; ?>
                <h3 id="auth-welcome-text" style="font-size:20px;font-weight:800;color:#1f2937;margin:0 0 4px;">ยินดีต้อนรับกลับมา 👋</h3>
                <p id="auth-welcome-sub" style="color:#9ca3af;font-size:13px;margin:0;">เข้าสู่ระบบเพื่อเพิ่มสินค้าและสั่งซื้อ</p>
            </div>
            <?php if($enable_reg): ?>
            <div style="display:flex;background:#f9fafb;border-bottom:1px solid #eee;">
                <button id="tab-btn-login" onclick="switchAuthTab('login')" style="flex:1;padding:13px 0;border:none;background:transparent;font-size:15px;font-weight:700;color:#d32f2f;cursor:pointer;border-bottom:3px solid #d32f2f;outline:none;font-family:inherit;">เข้าสู่ระบบ</button>
                <button id="tab-btn-register" onclick="switchAuthTab('register')" style="flex:1;padding:13px 0;border:none;background:transparent;font-size:15px;font-weight:700;color:#9ca3af;cursor:pointer;border-bottom:3px solid transparent;outline:none;font-family:inherit;">ลงทะเบียน</button>
            </div>
            <?php endif; ?>
            <div style="padding:22px 28px 28px;">
                <div class="woocommerce"><?php wc_get_template('myaccount/form-login.php', ['redirect' => $current_url]); ?></div>
                <div style="display:flex;align-items:center;gap:12px;margin:18px 0 14px;">
                    <hr style="flex:1;border:none;border-top:1px solid #e5e7eb;margin:0;">
                    <span style="color:#9ca3af;font-size:12px;white-space:nowrap;">หรือเข้าสู่ระบบด้วย</span>
                    <hr style="flex:1;border:none;border-top:1px solid #e5e7eb;margin:0;">
                </div>
                <a href="<?php echo esc_url($line_url); ?>" style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:13px;background:#06C755;color:#fff;border-radius:8px;font-size:15px;font-weight:700;text-decoration:none;box-sizing:border-box;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/></svg>
                    เข้าสู่ระบบด้วย LINE
                </a>
            </div>
        </div>
    </div>
    <style>
    #modern-auth-modal .woocommerce h2 { display:none !important; }
    #modern-auth-modal .u-columns { display:flex; flex-direction:column; width:100%; margin:0; }
    #modern-auth-modal .u-column1, #modern-auth-modal .u-column2 { width:100% !important; float:none !important; padding:0 !important; }
    #modern-auth-modal .u-column2 { display:none; }
    #modern-auth-modal.show-register .u-column1 { display:none; }
    #modern-auth-modal.show-register .u-column2 { display:block; }
    #modern-auth-modal form { border:none !important; padding:0 !important; margin:0 !important; }
    #modern-auth-modal .woocommerce-form-row { margin-bottom:14px !important; padding-top:0 !important; position:relative !important; }
    #modern-auth-modal label { position:static !important; transform:none !important; font-size:12px !important; font-weight:700 !important; color:#374151 !important; margin-bottom:6px !important; display:block !important; }
    #modern-auth-modal input[type="text"], #modern-auth-modal input[type="password"], #modern-auth-modal input[type="email"] { width:100% !important; padding:12px 14px !important; border:1.5px solid #e5e7eb !important; border-radius:10px !important; box-sizing:border-box !important; font-size:15px !important; background:#fafafa !important; outline:none !important; position:static !important; transform:none !important; }
    #modern-auth-modal input:focus { border-color:#d32f2f !important; box-shadow:0 0 0 3px rgba(211,47,47,0.1) !important; }
    #modern-auth-modal button[type="submit"] { width:100% !important; padding:13px !important; border-radius:10px !important; background:#d32f2f !important; color:#fff !important; font-size:16px !important; font-weight:700 !important; border:none !important; margin-top:14px !important; cursor:pointer !important; font-family:inherit !important; }
    #modern-auth-modal button[type="submit"]:hover { background:#b71c1c !important; }
    #modern-auth-modal .woocommerce-LostPassword a { color:#d32f2f !important; font-size:13px !important; text-decoration:none !important; }
    </style>
    <script>
    function openAuthModal()  { document.getElementById('modern-auth-modal').style.display='block'; document.body.style.overflow='hidden'; }
    function closeAuthModal() { document.getElementById('modern-auth-modal').style.display='none';  document.body.style.overflow=''; }
    function switchAuthTab(tab) {
        const modal=document.getElementById('modern-auth-modal'),l=document.getElementById('tab-btn-login'),r=document.getElementById('tab-btn-register'),wt=document.getElementById('auth-welcome-text'),ws=document.getElementById('auth-welcome-sub');
        if(tab==='register'){ modal.classList.add('show-register'); if(r){r.style.color='#d32f2f';r.style.borderBottomColor='#d32f2f';} if(l){l.style.color='#9ca3af';l.style.borderBottomColor='transparent';} if(wt)wt.innerText='ยินดีต้อนรับ 👋'; if(ws)ws.innerText='สมัครสมาชิกใหม่เพื่อรับสิทธิพิเศษ'; }
        else { modal.classList.remove('show-register'); if(l){l.style.color='#d32f2f';l.style.borderBottomColor='#d32f2f';} if(r){r.style.color='#9ca3af';r.style.borderBottomColor='transparent';} if(wt)wt.innerText='ยินดีต้อนรับกลับมา 👋'; if(ws)ws.innerText='เข้าสู่ระบบเพื่อเพิ่มสินค้าและสั่งซื้อ'; }
    }
    window.addEventListener('click', function(e){ if(e.target===document.getElementById('modern-auth-modal')) closeAuthModal(); });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeAuthModal(); });

    // Intercept Add to Cart clicks for guests
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.add_to_cart_button, .single_add_to_cart_button');
        if (btn) {
            e.preventDefault();
            e.stopImmediatePropagation();
            openAuthModal();
        }
    }, true);

    // Auto-open modal if redirected from checkout
    if (new URLSearchParams(window.location.search).get('from_checkout') === '1') {
        document.addEventListener('DOMContentLoaded', function(){ setTimeout(openAuthModal, 300); });
    }
    </script>
    <?php endif; ?>
    <?php
});

// =====================================================
// 6. ENQUEUE SCRIPTS, FONTS & ICONS
// =====================================================

// Enqueue scripts, Fonts & Icons
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('google-fonts-noto', 'https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;700;800&display=swap', [], null);
    wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200', [], null);
    wp_enqueue_script('jquery');
});
