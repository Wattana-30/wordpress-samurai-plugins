/**
 * Plugin Name: Samurai Chat Widget
 * Description: Chat widget + Admin panel (FAQ, Promo, Location, Brand, CTA, Analytics) v4.5
 * Version: 4.5.0
 * Author: Samurai SIM
 * Usage: Add via Code Snippets, then place [samurai_chat] shortcode
 */
if (!defined('ABSPATH')) exit;

define('SCW_BRAND',    'scw_brand_settings');
define('SCW_FAQ',      'scw_faq_items');
define('SCW_PROMO',    'scw_promo_items');
define('SCW_LOCATION', 'scw_location_items');
define('SCW_VERSION',  '4.5.0');

function scw_icon_list() {
    return ['shopping_cart','shopping_bag','store','sell','payments','credit_card',
        'account_balance_wallet','receipt','redeem','local_offer','loyalty','savings',
        'flight','flight_takeoff','flight_land','local_airport','train','directions_car',
        'local_shipping','delivery_dining','two_wheeler','directions_bus',
        'sim_card','sim_card_download','wifi','network_cell','signal_cellular_alt',
        'smartphone','phone_android','devices','settings','build',
        'data_usage','bolt','power','battery_full','router',
        'chat','chat_bubble','forum','support_agent','headset_mic','mail',
        'notifications','campaign','send','inbox','contact_support',
        'location_on','place','map','near_me','store_mall_directory','home',
        'business','apartment','pin_drop',
        'info','help','quiz','live_help','checklist','task_alt','verified',
        'star','grade','thumb_up','favorite','celebration','emoji_events',
        'schedule','alarm','calendar_month','event',
        'person','group','manage_accounts','badge',
        'photo_camera','image','videocam','play_circle','qr_code_2'];
}

function scw_brand_default() {
    return ['name'=>'SAMURAI Official','avatar_url'=>'https://test.samurai-sim.com/wp-content/uploads/2026/03/Layer-1.png',
        'welcome_img'=>'https://test.samurai-sim.com/wp-content/uploads/2026/03/stk.png',
        'welcome_msg'=>'สวัสดีครับ ยินดีต้อนรับสู่ SAMURAI ครับ 🙏','color_primary'=>'#e60012',
        'line_url'=>'','cta_label'=>'แชทกับแอดมิน','cta_url'=>'','phone'=>''];
}
function scw_faq_default() {
    return [
        ['id'=>'q1','icon'=>'shopping_cart',      'label'=>'ซื้อได้ที่ไหน', 'question'=>'หาซื้อที่ไหนได้บ้าง?',    'answer'=>'สั่งซื้อออนไลน์ได้ 24 ชม. ทั้งเว็บไซต์หลัก และ LINE Official ครับ 👇','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q2','icon'=>'local_shipping',     'label'=>'จัดส่ง',         'question'=>'มีจัดส่งไหม? กี่วันถึง?', 'answer'=>'มีบริการจัดส่งด่วนทั่วประเทศ ปกติถึงมือภายใน <b>1-3 วันทำการ</b>ครับ','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q3','icon'=>'flight',             'label'=>'รับที่สนามบิน', 'question'=>'รับที่สนามบินได้ไหม?',   'answer'=>'ได้ครับ! รับที่เคาน์เตอร์ <b>สุวรรณภูมิ</b> หรือ <b>ดอนเมือง</b> ได้ทุกวัน ✈️','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q4','icon'=>'credit_card',        'label'=>'ชำระเงิน',       'question'=>'ชำระเงินยังไง?',          'answer'=>'รองรับทั้ง <b>PromptPay</b> และ <b>บัตรเครดิต</b> ปลอดภัยแน่นอนครับ 💳','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q5','icon'=>'signal_cellular_alt','label'=>'ตั้งค่าซิม',    'question'=>'วิธีตั้งค่าซิม?',         'answer'=>'เพียงใส่ซิมและ <b>เปิด Data Roaming</b> ก็ใช้งานได้ทันทีครับ 📶','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q6','icon'=>'bolt',               'label'=>'เน็ตหมด',        'question'=>'เน็ตหมดซื้อเพิ่ม?',      'answer'=>'ติดต่อแอดมินทาง LINE เพื่อขอซื้อ <b>Top-up</b> ได้ตลอดเวลาครับ ⚡','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q7','icon'=>'smartphone',         'label'=>'รองรับมือถือ',  'question'=>'รองรับมือถือไหม?',        'answer'=>'รองรับสมาร์ทโฟน <b>ทุกรุ่น (iOS/Android)</b> ที่ไม่ติดล็อกเครือข่ายครับ 📱','type'=>'text','btn_label'=>'','btn_url'=>''],
        ['id'=>'q8','icon'=>'location_on',        'label'=>'ค้นหาสาขา',     'question'=>'📍 ดูสาขาและจุดรับซิม',  'answer'=>'นี่คือจุดรับซิมทั้งหมดครับ กดที่การ์ดหรือปุ่ม <b>นำทาง</b> เพื่อเปิด Google Maps ได้เลย 🗺️','type'=>'location','btn_label'=>'','btn_url'=>''],
        ['id'=>'q9','icon'=>'local_offer',        'label'=>'โปรโมชั่น',      'question'=>'🎁 ดูโปรโมชั่นทั้งหมด', 'answer'=>'โปรโมชั่นพิเศษสำหรับคุณครับ 🔥','type'=>'promo','btn_label'=>'','btn_url'=>''],
    ];
}
function scw_promo_default() {
    return [
        ['id'=>'p1','title'=>'โปรญี่ปุ่น 8 วัน ฟรี! 2GB/วัน','image_url'=>'','description'=>'แพ็กเกจพิเศษ ราคาเริ่มต้น 299 บาท','btn_label'=>'ดูรายละเอียด','btn_url'=>'#','active'=>true],
        ['id'=>'p2','title'=>'eSIM ยุโรป 10 ประเทศ',          'image_url'=>'','description'=>'ครอบคลุม 10 ประเทศ ไม่ต้องเปลี่ยนซิม','btn_label'=>'สั่งซื้อเลย',  'btn_url'=>'#','active'=>true],
    ];
}
function scw_loc_default() {
    $img = 'http://www.bs-mobile.jp/wp-content/uploads/';
    return [
        ['id'=>'l1', 'province'=>'สมุทรปราการ','category'=>'Airport','name'=>'สนามบินสุวรรณภูมิ - บูธ SAMURAI WiFi','hours'=>'เปิด 24 ชม.','phone'=>'094-794-7722','address'=>'ชั้น 4 ฝั่งขาออก หลังเคาน์เตอร์เช็คอินแถว L',        'note'=>'','image_url'=>$img.'2025/06/4th-TH_SVB1.png',            'lat'=>'13.6900','lng'=>'100.7501','map_url'=>''],
        ['id'=>'l2', 'province'=>'สมุทรปราการ','category'=>'Airport','name'=>'สนามบินสุวรรณภูมิ - บูธ AIRPORTELs',  'hours'=>'เปิด 24 ชม.','phone'=>'02-026-6927', 'address'=>'ชั้น B (Airport Rail Link) ใกล้ SuperRich สีส้ม',        'note'=>'','image_url'=>$img.'2025/08/AIRPORTELs-SVB.png',          'lat'=>'13.6925','lng'=>'100.7505','map_url'=>''],
        ['id'=>'l3', 'province'=>'กรุงเทพฯ',   'category'=>'Airport','name'=>'สนามบินดอนเมือง',                       'hours'=>'เปิด 24 ชม.','phone'=>'02-026-6927', 'address'=>'บูธ AIRPORTELs ชั้น 1 ประตู 9 (Terminal 2 ภายในประเทศ)','note'=>'','image_url'=>$img.'2025/08/Don-muaeng-map.png',           'lat'=>'13.9129','lng'=>'100.6061','map_url'=>''],
        ['id'=>'l4', 'province'=>'เชียงใหม่',  'category'=>'Airport','name'=>'สนามบินเชียงใหม่',                      'hours'=>'06:00-23:59 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น 1 ใกล้ประตู 7 (ตรงข้ามไปรษณีย์ไทย)','note'=>'','image_url'=>$img.'2025/08/cnx_map.webp',                'lat'=>'18.7668','lng'=>'98.9624', 'map_url'=>''],
        ['id'=>'l5', 'province'=>'ภูเก็ต',     'category'=>'Airport','name'=>'สนามบินภูเก็ต',                         'hours'=>'06:00-23:59 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs อาคารระหว่างประเทศ ชั้น 1 ประตู 2',       'note'=>'','image_url'=>$img.'2025/08/HKT-Inter.png',               'lat'=>'8.1132', 'lng'=>'98.3169', 'map_url'=>''],
        ['id'=>'l6', 'province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'Terminal 21 Asok',                      'hours'=>'11:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น 1 โซนโตเกียว (ทางไปลานจอดรถ)',      'note'=>'','image_url'=>$img.'2025/08/Terminal-21-Asok-map.png',    'lat'=>'13.7383','lng'=>'100.5608','map_url'=>''],
        ['id'=>'l7', 'province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'Central World',                         'hours'=>'10:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น 1 โซน Groove (ตรงข้ามธ.กรุงเทพ)',   'note'=>'','image_url'=>$img.'2025/08/CTW-new-location.png',        'lat'=>'13.7464','lng'=>'100.5391','map_url'=>''],
        ['id'=>'l8', 'province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'MBK Center',                            'hours'=>'10:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น 6 โซน B (ติดร้าน S&P)',             'note'=>'','image_url'=>$img.'2025/08/MBK-map.png',                 'lat'=>'13.7447','lng'=>'100.5299','map_url'=>''],
        ['id'=>'l9', 'province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'Mixt จตุจักร',                          'hours'=>'จ-พฤ 10:00-20:00 / ศ-อา 10:00-21:00','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น 2 โซน B',   'note'=>'','image_url'=>$img.'2025/08/Mixt-map.png',                'lat'=>'13.8010','lng'=>'100.5512','map_url'=>''],
        ['id'=>'l10','province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'ICONSIAM',                               'hours'=>'10:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น B2 โซน Siam Takashimaya',          'note'=>'','image_url'=>$img.'2025/08/Iconsiam-map.png',            'lat'=>'13.7263','lng'=>'100.5103','map_url'=>''],
        ['id'=>'l11','province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'EmSphere',                               'hours'=>'10:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น B1 ล็อบบี้ B หน้าลิฟต์',            'note'=>'','image_url'=>$img.'2025/08/S__933949_EmSphere.jpg',      'lat'=>'13.7314','lng'=>'100.5682','map_url'=>''],
        ['id'=>'l12','province'=>'กรุงเทพฯ',   'category'=>'Mall',   'name'=>'Emporium',                               'hours'=>'10:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น B2 ใกล้บันไดเลื่อนกลาง',            'note'=>'','image_url'=>$img.'2025/08/S__933951_Emporium.jpg',      'lat'=>'13.7303','lng'=>'100.5693','map_url'=>''],
        ['id'=>'l13','province'=>'พัทยา',       'category'=>'Mall',   'name'=>'Terminal 21 Pattaya',                   'hours'=>'11:00-22:00 น.','phone'=>'02-026-6927','address'=>'บูธ AIRPORTELs ชั้น G โซนปารีส (ข้าง EVEANDBOY)',       'note'=>'','image_url'=>$img.'2025/08/Terminal_Pattaya_map.webp',   'lat'=>'12.9496','lng'=>'100.9121','map_url'=>''],
        ['id'=>'l14','province'=>'กรุงเทพฯ',   'category'=>'Office', 'name'=>'Bangkok SAMURAI สำนักงานใหญ่',          'hours'=>'09:00-18:00 น.','phone'=>'02-491-0000','address'=>'73/7 ซ.ร่วมฤดี 2 แขวงลุมพินี เขตปทุมวัน กทม. 10330',   'note'=>'','image_url'=>$img.'2025/08/Samurai-Office-map.png',      'lat'=>'13.7366','lng'=>'100.5506','map_url'=>''],
        ['id'=>'l15','province'=>'เชียงใหม่',  'category'=>'Agent',  'name'=>'เชียงใหม่ ยูยู ทราเวล',                'hours'=>'จ-ศ 09:00-17:00 / ส 09:00-12:00','phone'=>'053-282-762','address'=>'104/8 หมู่ 2 ต.ป่าแดด อ.เมือง จ.เชียงใหม่ 50100','note'=>'','image_url'=>$img.'2025/08/chiangmai-youyou-travel.png','lat'=>'18.7615','lng'=>'98.9830', 'map_url'=>''],
    ];
}

/* ── Admin Menu ──────────────────────────────── */
add_action('admin_menu', function() {
    add_menu_page('Samurai Chat Widget','⚔️ Samurai Chat','manage_options',
        'samurai-chat-widget','scw_admin_page','dashicons-format-chat',30);
});

/* ── Admin Save ──────────────────────────────── */
add_action('admin_post_scw_save', function() {
    if (!current_user_can('manage_options')) wp_die('Forbidden');
    check_admin_referer('scw_save_nonce');
    $tab = sanitize_text_field($_POST['scw_tab'] ?? 'brand');
    if ($tab === 'brand') {
        update_option(SCW_BRAND, [
            'name'          => sanitize_text_field($_POST['brand_name']        ?? ''),
            'avatar_url'    => esc_url_raw(        $_POST['brand_avatar']      ?? ''),
            'welcome_img'   => esc_url_raw(        $_POST['brand_welcome_img'] ?? ''),
            'welcome_msg'   => sanitize_text_field($_POST['brand_welcome_msg'] ?? ''),
            'color_primary' => sanitize_hex_color( $_POST['brand_color']       ?? '#e60012'),
            'line_url'      => esc_url_raw(        $_POST['brand_line_url']    ?? ''),
            'cta_label'     => sanitize_text_field($_POST['brand_cta_label']   ?? 'แชทกับแอดมิน'),
            'cta_url'       => esc_url_raw(        $_POST['brand_cta_url']     ?? ''),
            'phone'         => sanitize_text_field($_POST['brand_phone']       ?? ''),
        ]);
    }
    if ($tab === 'faq') {
        $rows = [];
        foreach (($_POST['faq_id'] ?? []) as $i => $id) {
            if (empty(trim($_POST['faq_question'][$i] ?? ''))) continue;
            $rows[] = [
                'id'        => sanitize_key($id ?: 'q'.($i+1)),
                'icon'      => sanitize_text_field($_POST['faq_icon'][$i]      ?? 'chat'),
                'label'     => sanitize_text_field($_POST['faq_label'][$i]     ?? ''),
                'category'  => sanitize_text_field($_POST['faq_category'][$i]  ?? ''),
                'related'   => array_values(array_filter(array_map('sanitize_key', preg_split('/[\s,]+/', $_POST['faq_related'][$i] ?? '')))),
                'question'  => sanitize_text_field($_POST['faq_question'][$i]  ?? ''),
                'answer'    => wp_kses_post(       $_POST['faq_answer'][$i]    ?? ''),
                'type'      => in_array($_POST['faq_type'][$i]??'text',['text','promo','location'])
                                ? $_POST['faq_type'][$i] : 'text',
                'btn_label' => sanitize_text_field($_POST['faq_btn_label'][$i] ?? ''),
                'btn_url'   => esc_url_raw(        $_POST['faq_btn_url'][$i]   ?? ''),
            ];
        }
        update_option(SCW_FAQ, $rows);
    }
    if ($tab === 'promo') {
        $rows = [];
        foreach (($_POST['promo_title'] ?? []) as $i => $title) {
            if (empty(trim($title))) continue;
            $rows[] = [
                'id'          => sanitize_key(        $_POST['promo_id'][$i]        ?? 'p'.($i+1)),
                'title'       => sanitize_text_field( $title),
                'image_url'   => esc_url_raw(          $_POST['promo_img'][$i]       ?? ''),
                'description' => sanitize_text_field( $_POST['promo_desc'][$i]      ?? ''),
                'btn_label'   => sanitize_text_field( $_POST['promo_btn_label'][$i] ?? 'ดูรายละเอียด'),
                'btn_url'     => esc_url_raw(          $_POST['promo_btn_url'][$i]   ?? '#'),
                'active'      => !empty($_POST['promo_active'][$i]),
            ];
        }
        update_option(SCW_PROMO, $rows);
    }
    if ($tab === 'location') {
        $rows = [];
        foreach (($_POST['loc_name'] ?? []) as $i => $name) {
            if (empty(trim($name))) continue;
            $rows[] = [
                'id'        => sanitize_key(        $_POST['loc_id'][$i]        ?? 'l'.($i+1)),
                'province'  => sanitize_text_field( $_POST['loc_province'][$i]  ?? 'อื่นๆ'),
                'category'  => sanitize_text_field( $_POST['loc_category'][$i]  ?? ''),
                'name'      => sanitize_text_field( $name),
                'hours'     => sanitize_text_field( $_POST['loc_hours'][$i]     ?? ''),
                'phone'     => sanitize_text_field( $_POST['loc_phone'][$i]     ?? ''),
                'address'   => sanitize_textarea_field($_POST['loc_address'][$i] ?? ''),
                'note'      => sanitize_text_field( $_POST['loc_note'][$i]      ?? ''),
                'image_url' => esc_url_raw(          $_POST['loc_image_url'][$i] ?? ''),
                'lat'       => sanitize_text_field( $_POST['loc_lat'][$i]       ?? ''),
                'lng'       => sanitize_text_field( $_POST['loc_lng'][$i]       ?? ''),
                'map_url'   => esc_url_raw(          $_POST['loc_map_url'][$i]   ?? ''),
            ];
        }
        update_option(SCW_LOCATION, $rows);
    }
    wp_redirect(admin_url('admin.php?page=samurai-chat-widget&tab='.$tab.'&saved=1'));
    exit;
});

/* ── Admin Page ──────────────────────────────── */
function scw_admin_page() {
    $tab    = sanitize_text_field($_GET['tab'] ?? 'brand');
    $saved  = !empty($_GET['saved']);
    $brand  = get_option(SCW_BRAND,    scw_brand_default());
    $faqs   = get_option(SCW_FAQ,      scw_faq_default());
    $promos = get_option(SCW_PROMO,    scw_promo_default());
    $locs   = get_option(SCW_LOCATION, scw_loc_default());
    $color  = esc_attr($brand['color_primary'] ?? '#e60012');
    $icons  = scw_icon_list();
    ?>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
    .scw-a{max-width:1000px;margin:30px auto;font-family:'Segoe UI',sans-serif;}
    .scw-a h1{margin:0;font-size:24px;font-weight:700;}
    .scw-a p.sub{margin:4px 0 0;opacity:.85;font-size:14px;}
    .scw-hdr{background:linear-gradient(135deg,<?php echo $color;?>,#ff5a5a);color:#fff;padding:24px 30px;border-radius:16px;margin-bottom:25px;display:flex;align-items:center;gap:15px;box-shadow:0 8px 24px <?php echo $color;?>44;}
    .scw-badge{background:rgba(255,255,255,.2);border:1px dashed rgba(255,255,255,.5);padding:6px 14px;border-radius:8px;font-size:13px;font-family:monospace;}
    .scw-tabs{display:flex;gap:5px;margin-bottom:22px;border-bottom:2px solid #eee;}
    .scw-tab{padding:11px 22px;border:none;border-radius:8px 8px 0 0;cursor:pointer;font-size:14px;font-weight:500;background:#f5f5f5;color:#666;text-decoration:none;display:inline-block;transition:.2s;}
    .scw-tab.active{background:<?php echo $color;?>;color:#fff;}
    .scw-card{background:#fff;border-radius:14px;border:1px solid #eee;padding:28px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,.04);}
    .scw-card h3{margin:0 0 18px;font-size:16px;color:#1a1a1a;border-bottom:2px solid #f5f5f5;padding-bottom:10px;}
    .g2{display:grid;grid-template-columns:1fr 1fr;gap:15px;}
    .sf{display:flex;flex-direction:column;gap:5px;margin-bottom:12px;}
    .sf label{font-size:11px;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.6px;}
    .sf input,.sf select,.sf textarea{border:1.5px solid #e5e5e5;border-radius:8px;padding:9px 12px;font-size:14px;font-family:inherit;transition:.2s;width:100%;}
    .sf input:focus,.sf textarea:focus,.sf select:focus{border-color:<?php echo $color;?>;outline:none;box-shadow:0 0 0 3px <?php echo $color;?>22;}
    .sf textarea{min-height:80px;resize:vertical;}
    .scw-row{background:#fafafa;border:1.5px solid #eee;border-radius:14px;padding:20px;margin-bottom:14px;}
    .scw-rh{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;}
    .scw-num{background:<?php echo $color;?>;color:#fff;width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;}
    .scw-del{background:#fff;border:1px solid #ffcccc;color:#c0392b;padding:5px 12px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;}
    .scw-add{background:#f0fff4;border:1.5px dashed #52c41a;color:#389e0d;padding:11px 18px;border-radius:10px;cursor:pointer;font-size:14px;font-weight:500;width:100%;margin-top:10px;}
    .scw-save{background:<?php echo $color;?>;color:#fff;border:none;padding:13px 35px;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;transition:.2s;box-shadow:0 4px 12px <?php echo $color;?>55;}
    .scw-save:hover{opacity:.88;transform:translateY(-1px);}
    .scw-ok{background:#f0fff4;border-left:4px solid #52c41a;padding:12px 18px;border-radius:0 8px 8px 0;margin-bottom:20px;color:#135200;font-size:14px;}
    .scw-tog{display:flex;align-items:center;gap:8px;cursor:pointer;}
    .scw-prev{background:#f5f5f5;border-radius:10px;padding:12px;font-size:12px;color:#888;text-align:center;margin-top:8px;}
    .scw-prev img{max-width:100%;max-height:80px;border-radius:6px;display:block;margin:6px auto;}
    /* Icon picker */
    .scw-itrig{display:flex;align-items:center;gap:10px;border:1.5px solid #e5e5e5;border-radius:8px;padding:8px 12px;cursor:pointer;background:#fff;min-height:42px;}
    .scw-itrig:hover{border-color:<?php echo $color;?>;}
    .scw-itrig .material-symbols-rounded{font-size:22px;color:<?php echo $color;?>;}
    .scw-iname{font-size:13px;color:#555;flex:1;}
    .scw-modal{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);z-index:99999;align-items:center;justify-content:center;}
    .scw-modal.open{display:flex;}
    .scw-mbox{background:#fff;border-radius:18px;padding:24px;width:90%;max-width:680px;max-height:80vh;display:flex;flex-direction:column;gap:16px;box-shadow:0 20px 60px rgba(0,0,0,.25);}
    .scw-mhd{display:flex;justify-content:space-between;align-items:center;}
    .scw-mhd h4{margin:0;font-size:16px;font-weight:700;}
    .scw-mcl{cursor:pointer;font-size:22px;color:#888;background:none;border:none;line-height:1;}
    .scw-msrch{border:1.5px solid #e5e5e5;border-radius:8px;padding:9px 14px;font-size:14px;font-family:inherit;width:100%;}
    .scw-msrch:focus{border-color:<?php echo $color;?>;outline:none;}
    .scw-mgrid{display:grid;grid-template-columns:repeat(auto-fill,minmax(68px,1fr));gap:8px;overflow-y:auto;max-height:420px;}
    .scw-iopt{display:flex;flex-direction:column;align-items:center;gap:4px;padding:10px 6px;border-radius:10px;cursor:pointer;border:2px solid transparent;background:#f9f9f9;}
    .scw-iopt:hover{background:#fff0f0;border-color:<?php echo $color;?>88;}
    .scw-iopt.sel{background:#fff0f0;border-color:<?php echo $color;?>;}
    .scw-iopt .material-symbols-rounded{font-size:26px;color:#333;}
    .scw-iopt.sel .material-symbols-rounded{color:<?php echo $color;?>;}
    .scw-ilbl{font-size:9px;color:#888;text-align:center;line-height:1.2;word-break:break-all;}
    /* Collapsible rows */
    .scw-row-body{padding-top:4px;}
    .scw-row.collapsed .scw-row-body{display:none;}
    .scw-fold{background:none;border:1px solid #e5e5e5;cursor:pointer;font-size:13px;color:#999;width:28px;height:28px;border-radius:6px;flex-shrink:0;transition:.15s;}
    .scw-fold:hover{background:#f0f0f0;color:#555;}
    .scw-row-title{font-size:13px;font-weight:600;color:#333;flex:1;margin:0 10px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;min-width:0;}
    .scw-mv{background:#fff;border:1px solid #ddd;color:#666;width:28px;height:28px;border-radius:6px;cursor:pointer;font-size:13px;padding:0;display:flex;align-items:center;justify-content:center;}
    .scw-mv:hover{background:#f5f5f5;border-color:#bbb;}
    /* Map picker button */
    .scw-mapbtn{background:#f0f8ff;border:1.5px solid #91caff;color:#1677ff;padding:8px 14px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;white-space:nowrap;flex-shrink:0;margin-bottom:0;}
    .scw-mapbtn:hover{background:#e0f0ff;}
    /* Map modal */
    #scwMapDiv{height:380px;border-radius:10px;overflow:hidden;border:1px solid #eee;}
    .scw-map-coords{font-family:monospace;font-size:12px;color:#555;background:#f5f5f5;border-radius:6px;padding:8px 12px;flex:1;}
    .scw-map-ok{background:#1677ff;color:#fff;border:none;padding:9px 20px;border-radius:8px;cursor:pointer;font-size:14px;font-weight:600;}
    .scw-map-ok:hover{background:#0958d9;}
    </style>

    <div class="scw-modal" id="scwModal">
        <div class="scw-mbox">
            <div class="scw-mhd"><h4>เลือกไอคอน (Material Symbols)</h4><button class="scw-mcl" onclick="scwModalClose()">✕</button></div>
            <input class="scw-msrch" id="scwMsrch" placeholder="ค้นหา เช่น flight, cart, phone..." oninput="scwFilter(this.value)">
            <div class="scw-mgrid" id="scwMgrid"></div>
        </div>
    </div>

    <div class="scw-modal" id="scwMapModal">
        <div class="scw-mbox" style="max-width:640px;">
            <div class="scw-mhd"><h4>📍 เลือกตำแหน่งบนแผนที่</h4><button class="scw-mcl" onclick="scwMapClose()">✕</button></div>
            <p style="margin:0;font-size:12px;color:#888;">คลิกบนแผนที่เพื่อเลือกตำแหน่ง จากนั้นกด "ใช้ตำแหน่งนี้"</p>
            <div id="scwMapDiv"></div>
            <div style="display:flex;gap:10px;align-items:center;">
                <span class="scw-map-coords" id="scwMapCoords">ยังไม่ได้เลือกตำแหน่ง</span>
                <button class="scw-map-ok" onclick="scwMapConfirm()">✓ ใช้ตำแหน่งนี้</button>
            </div>
        </div>
    </div>

    <div class="scw-a">
        <div class="scw-hdr">
            <span class="material-symbols-rounded" style="font-size:38px;">swords</span>
            <div><h1>Samurai Chat Widget</h1><p class="sub">จัดการเนื้อหาแชทวิดเจ็ตได้จากหน้านี้ — v4.2</p></div>
            <div style="margin-left:auto;text-align:center;">
                <div class="scw-badge">[samurai_chat]</div>
                <div style="font-size:11px;opacity:.7;margin-top:4px;">วาง Shortcode ในหน้าที่ต้องการ</div>
            </div>
        </div>
        <?php if ($saved): ?><div class="scw-ok">✅ บันทึกข้อมูลสำเร็จแล้วครับ!</div><?php endif; ?>
        <div class="scw-tabs">
            <?php
            $tabs = ['brand'=>'🎨 แบรนด์','faq'=>'💬 FAQ','promo'=>'🎁 โปรโมชั่น','location'=>'📍 สาขา'];
            foreach ($tabs as $slug => $label) {
                $cls = ($tab === $slug) ? 'scw-tab active' : 'scw-tab';
                echo '<a href="'.admin_url('admin.php?page=samurai-chat-widget&tab='.$slug).'" class="'.$cls.'">'.$label.'</a>';
            }
            ?>
        </div>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <?php wp_nonce_field('scw_save_nonce'); ?>
            <input type="hidden" name="action" value="scw_save">
            <input type="hidden" name="scw_tab" value="<?php echo esc_attr($tab); ?>">

<?php if ($tab === 'brand'): ?>
            <div class="scw-card"><h3>🎨 ตั้งค่าแบรนด์</h3>
                <div class="g2">
                    <div class="sf"><label>ชื่อแบรนด์</label><input type="text" name="brand_name" value="<?php echo esc_attr($brand['name']??''); ?>" placeholder="SAMURAI Official"></div>
                    <div class="sf"><label>สีหลัก</label><div style="display:flex;gap:8px;align-items:center;">
                        <input type="color" name="brand_color" value="<?php echo esc_attr($brand['color_primary']??'#e60012'); ?>" style="width:50px;height:42px;padding:2px;border-radius:8px;cursor:pointer;">
                        <input type="text" id="scwColorTxt" value="<?php echo esc_attr($brand['color_primary']??'#e60012'); ?>" style="flex:1;" readonly>
                    </div></div>
                </div>
                <div class="sf"><label>URL รูป Avatar</label><input type="url" name="brand_avatar" value="<?php echo esc_attr($brand['avatar_url']??''); ?>" placeholder="https://...">
                <?php if (!empty($brand['avatar_url'])): ?><div class="scw-prev"><img src="<?php echo esc_attr($brand['avatar_url']); ?>" style="border-radius:50%;width:60px;height:60px;object-fit:cover;"><div>Avatar ปัจจุบัน</div></div><?php endif; ?></div>
                <div class="sf"><label>URL รูปต้อนรับ (Sticker)</label><input type="url" name="brand_welcome_img" value="<?php echo esc_attr($brand['welcome_img']??''); ?>" placeholder="https://...">
                <?php if (!empty($brand['welcome_img'])): ?><div class="scw-prev"><img src="<?php echo esc_attr($brand['welcome_img']); ?>"><div>รูปต้อนรับปัจจุบัน</div></div><?php endif; ?></div>
                <div class="sf"><label>ข้อความต้อนรับ</label><input type="text" name="brand_welcome_msg" value="<?php echo esc_attr($brand['welcome_msg']??''); ?>" placeholder="สวัสดีครับ 🙏"></div>
                <div class="g2">
                    <div class="sf"><label>URL LINE / ติดต่อแอดมิน</label><input type="url" name="brand_line_url" value="<?php echo esc_attr($brand['line_url']??''); ?>" placeholder="https://lin.ee/... หรือ https://line.me/..."></div>
                    <div class="sf"><label>ชื่อปุ่ม CTA หลัก</label><input type="text" name="brand_cta_label" value="<?php echo esc_attr($brand['cta_label']??'แชทกับแอดมิน'); ?>" placeholder="แชทกับแอดมิน"></div>
                </div>
                <div class="sf"><label>URL ปุ่ม CTA หลัก</label><input type="url" name="brand_cta_url" value="<?php echo esc_attr($brand['cta_url']??''); ?>" placeholder="ปล่อยว่างเพื่อใช้ URL LINE"></div>
                <div class="sf"><label>เบอร์โทรศัพท์ (ปุ่มโทรบน chat header)</label><input type="tel" name="brand_phone" value="<?php echo esc_attr($brand['phone']??''); ?>" placeholder="เช่น 02-xxx-xxxx หรือ 08x-xxx-xxxx"></div>
            </div>

<?php elseif ($tab === 'faq'): ?>
            <div class="scw-card"><h3>💬 รายการคำถาม-คำตอบ</h3>
                <p style="color:#888;font-size:13px;margin:-10px 0 18px;">ประเภท <b>แสดงสาขา</b> = Location Cards | ประเภท <b>แสดงโปรโมชั่น</b> = Carousel</p>
                <div id="faq-wrap">
                <?php $faq_list = !empty($faqs) ? $faqs : scw_faq_default();
                foreach ($faq_list as $i => $faq):
                    $ci = esc_attr($faq['icon'] ?? 'chat');
                    $ft = esc_html(trim(($faq['label']??'').($faq['question']??'' ? ' — '.($faq['question']??'') : '')));
                ?>
                <div class="scw-row collapsed">
                    <div class="scw-rh">
                        <button type="button" class="scw-fold" onclick="scwFold(this)">▶</button>
                        <span class="scw-num"><?php echo $i+1; ?></span>
                        <span class="material-symbols-rounded" style="font-size:18px;color:<?php echo $color;?>;flex-shrink:0;"><?php echo $ci; ?></span>
                        <span class="scw-row-title"><?php echo $ft ?: 'คำถาม '.($i+1); ?></span>
                        <div style="display:flex;gap:5px;align-items:center;margin-left:auto;">
                            <button type="button" class="scw-mv" onclick="scwMove(this,-1)" title="เลื่อนขึ้น">↑</button>
                            <button type="button" class="scw-mv" onclick="scwMove(this,1)" title="เลื่อนลง">↓</button>
                            <button type="button" class="scw-del" onclick="this.closest('.scw-row').remove()">🗑 ลบ</button>
                        </div>
                    </div>
                    <div class="scw-row-body">
                        <input type="hidden" name="faq_id[]" value="<?php echo esc_attr($faq['id']??''); ?>">
                        <div class="g2">
                            <div class="sf"><label>ไอคอน</label>
                                <input type="hidden" name="faq_icon[]" value="<?php echo $ci; ?>" class="scw-ival">
                                <div class="scw-itrig" onclick="scwModalOpen(this)">
                                    <span class="material-symbols-rounded"><?php echo $ci; ?></span>
                                    <span class="scw-iname"><?php echo $ci; ?></span>
                                    <span style="color:#999;font-size:11px;">▼</span>
                                </div>
                            </div>
                            <div class="sf"><label>ชื่อย่อปุ่ม</label><input type="text" name="faq_label[]" value="<?php echo esc_attr($faq['label']??''); ?>" placeholder="เช่น ซื้อได้ที่ไหน" oninput="scwUpdFaqTitle(this)"></div>
                        </div>
                        <div class="g2">
                            <div class="sf"><label>หมวดหมู่</label><input type="text" name="faq_category[]" value="<?php echo esc_attr($faq['category']??''); ?>" placeholder="เช่น การสั่งซื้อ"></div>
                            <div class="sf"><label>FAQ ที่เกี่ยวข้อง (ID คั่นด้วย comma)</label><input type="text" name="faq_related[]" value="<?php echo esc_attr(implode(',', $faq['related']??[])); ?>" placeholder="q5,q6,q1"></div>
                        </div>
                        <div class="sf"><label>คำถาม</label><input type="text" name="faq_question[]" value="<?php echo esc_attr($faq['question']??''); ?>" placeholder="คำถาม..." oninput="scwUpdFaqTitle(this)"></div>
                        <div class="sf"><label>คำตอบ (HTML ได้)</label><textarea name="faq_answer[]"><?php echo esc_textarea($faq['answer']??''); ?></textarea></div>
                        <div class="g2">
                            <div class="sf"><label>ประเภทคำตอบ</label><select name="faq_type[]">
                                <option value="text"     <?php selected($faq['type']??'text','text'); ?>>ข้อความ</option>
                                <option value="promo"    <?php selected($faq['type']??'','promo'); ?>>แสดงโปรโมชั่น</option>
                                <option value="location" <?php selected($faq['type']??'','location'); ?>>แสดงสาขา</option>
                            </select></div>
                            <div class="sf"><label>ชื่อปุ่ม Link</label><input type="text" name="faq_btn_label[]" value="<?php echo esc_attr($faq['btn_label']??''); ?>" placeholder="ดูเพิ่มเติม"></div>
                        </div>
                        <div class="sf"><label>URL ปุ่ม</label><input type="url" name="faq_btn_url[]" value="<?php echo esc_attr($faq['btn_url']??''); ?>" placeholder="https://..."></div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
                <button type="button" class="scw-add" onclick="scwAddFaq()">＋ เพิ่มคำถามใหม่</button>
            </div>

<?php elseif ($tab === 'promo'): ?>
            <div class="scw-card"><h3>🎁 รายการโปรโมชั่น</h3>
                <p style="color:#888;font-size:13px;margin:-10px 0 18px;">โปรโมชั่นแสดงเป็น Carousel ในแชท เมื่อ FAQ มีประเภท "แสดงโปรโมชั่น"</p>
                <div id="promo-wrap">
                <?php $promo_list = !empty($promos) ? $promos : scw_promo_default();
                foreach ($promo_list as $i => $promo): ?>
                <div class="scw-row collapsed">
                    <div class="scw-rh">
                        <button type="button" class="scw-fold" onclick="scwFold(this)">▶</button>
                        <span class="scw-num"><?php echo $i+1; ?></span>
                        <span class="scw-row-title"><?php echo esc_html($promo['title']??'โปรโมชั่น '.($i+1)); ?></span>
                        <div style="display:flex;gap:5px;align-items:center;margin-left:auto;">
                            <input type="hidden" name="promo_active[]" value="<?php echo !empty($promo['active']) ? '1' : '0'; ?>" class="scw-pactive-val">
                            <label class="scw-tog"><input type="checkbox" value="1" <?php checked(!empty($promo['active'])); ?> onchange="this.closest('.scw-rh').querySelector('.scw-pactive-val').value=this.checked?'1':'0'"><span style="font-size:12px;color:#555;">เปิด</span></label>
                            <button type="button" class="scw-mv" onclick="scwMove(this,-1)" title="เลื่อนขึ้น">↑</button>
                            <button type="button" class="scw-mv" onclick="scwMove(this,1)" title="เลื่อนลง">↓</button>
                            <button type="button" class="scw-del" onclick="this.closest('.scw-row').remove()">🗑 ลบ</button>
                        </div>
                    </div>
                    <div class="scw-row-body">
                        <input type="hidden" name="promo_id[]" value="<?php echo esc_attr($promo['id']??''); ?>">
                        <div class="sf"><label>ชื่อโปรโมชั่น</label><input type="text" name="promo_title[]" value="<?php echo esc_attr($promo['title']??''); ?>" oninput="scwUpdPromoTitle(this)"></div>
                        <div class="sf"><label>URL รูปภาพ</label><input type="url" name="promo_img[]" value="<?php echo esc_attr($promo['image_url']??''); ?>" placeholder="https://...">
                        <?php if (!empty($promo['image_url'])): ?><div class="scw-prev"><img src="<?php echo esc_attr($promo['image_url']); ?>"></div><?php endif; ?></div>
                        <div class="sf"><label>คำอธิบาย</label><input type="text" name="promo_desc[]" value="<?php echo esc_attr($promo['description']??''); ?>"></div>
                        <div class="g2">
                            <div class="sf"><label>ชื่อปุ่ม</label><input type="text" name="promo_btn_label[]" value="<?php echo esc_attr($promo['btn_label']??'ดูรายละเอียด'); ?>"></div>
                            <div class="sf"><label>URL ปุ่ม</label><input type="url" name="promo_btn_url[]" value="<?php echo esc_attr($promo['btn_url']??''); ?>" placeholder="https://..."></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
                <button type="button" class="scw-add" onclick="scwAddPromo()">＋ เพิ่มโปรโมชั่นใหม่</button>
            </div>

<?php elseif ($tab === 'location'): ?>
            <div class="scw-card"><h3>📍 รายการสาขา/จุดจำหน่าย</h3>
                <div style="display:flex;gap:10px;align-items:center;margin-bottom:16px;flex-wrap:wrap;">
                    <button type="button" onclick="scwCsvTemplate()" style="background:#f6ffed;border:1.5px solid #b7eb8f;color:#389e0d;padding:8px 16px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;">⬇ ดาวน์โหลด Template CSV</button>
                    <label style="background:#e6f4ff;border:1.5px solid #91caff;color:#1677ff;padding:8px 16px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;">
                        ⬆ Import CSV
                        <input type="file" accept=".csv" style="display:none;" onchange="scwCsvImport(this)">
                    </label>
                    <span style="font-size:12px;color:#999;">คอลัมน์: province, category, name, hours, phone, address, note, image_url, lat, lng, map_url</span>
                </div>
                <div id="loc-wrap">
                <?php $loc_list = !empty($locs) ? $locs : scw_loc_default();
                foreach ($loc_list as $i => $loc):
                    $lt = esc_html(trim(($loc['name']??'').($loc['province']??'' ? ' — '.($loc['province']??'') : '')));
                ?>
                <div class="scw-row collapsed">
                    <div class="scw-rh">
                        <button type="button" class="scw-fold" onclick="scwFold(this)">▶</button>
                        <span class="scw-num"><?php echo $i+1; ?></span>
                        <span class="scw-row-title"><?php echo $lt ?: 'สาขา '.($i+1); ?></span>
                        <div style="display:flex;gap:5px;align-items:center;margin-left:auto;">
                            <button type="button" class="scw-mv" onclick="scwMove(this,-1)" title="เลื่อนขึ้น">↑</button>
                            <button type="button" class="scw-mv" onclick="scwMove(this,1)" title="เลื่อนลง">↓</button>
                            <button type="button" class="scw-del" onclick="this.closest('.scw-row').remove()">🗑 ลบ</button>
                        </div>
                    </div>
                    <div class="scw-row-body">
                        <input type="hidden" name="loc_id[]" value="<?php echo esc_attr($loc['id']??''); ?>">
                        <div class="g2">
                            <div class="sf"><label>จังหวัด / กลุ่ม</label><input type="text" name="loc_province[]" value="<?php echo esc_attr($loc['province']??''); ?>" placeholder="เช่น กรุงเทพฯ" oninput="scwUpdLocTitle(this)"></div>
                            <div class="sf"><label>ประเภท</label><select name="loc_category[]" style="width:100%;padding:9px 12px;border-radius:8px;border:1.5px solid #e5e7eb;font-size:13px;">
                                <option value="">— เลือกประเภท —</option>
                                <?php foreach(['Airport'=>'✈ Airport (สนามบิน)','Mall'=>'🏬 Mall (ห้าง)','Office'=>'🏢 Office (สำนักงาน)','Agent'=>'🏪 Agent (ตัวแทน)'] as $cv=>$cl): ?>
                                <option value="<?php echo $cv; ?>" <?php selected($loc['category']??'',$cv); ?>><?php echo $cl; ?></option>
                                <?php endforeach; ?>
                            </select></div>
                        </div>
                        <div class="sf"><label>ชื่อสาขา</label><input type="text" name="loc_name[]" value="<?php echo esc_attr($loc['name']??''); ?>" oninput="scwUpdLocTitle(this)"></div>
                        <div class="g2">
                            <div class="sf"><label>เวลาทำการ</label><input type="text" name="loc_hours[]" value="<?php echo esc_attr($loc['hours']??''); ?>" placeholder="09:00-18:00"></div>
                            <div class="sf"><label>URL Google Maps</label><input type="url" name="loc_map_url[]" value="<?php echo esc_attr($loc['map_url']??''); ?>" placeholder="https://maps.google.com/..."></div>
                        </div>
                        <div class="g2">
                            <div class="sf"><label>เบอร์โทร</label><input type="text" name="loc_phone[]" value="<?php echo esc_attr($loc['phone']??''); ?>" placeholder="02-xxx-xxxx"></div>
                            <div class="sf"><label>หมายเหตุ</label><input type="text" name="loc_note[]" value="<?php echo esc_attr($loc['note']??''); ?>" placeholder="เช่น รับซิมได้ที่ชั้น 2"></div>
                        </div>
                        <div class="sf"><label>URL รูปภาพสาขา</label><input type="url" name="loc_image_url[]" value="<?php echo esc_attr($loc['image_url']??''); ?>" placeholder="https://...">
                        <?php if (!empty($loc['image_url'])): ?><div class="scw-prev"><img src="<?php echo esc_attr($loc['image_url']); ?>"></div><?php endif; ?></div>
                        <div class="sf"><label>ที่อยู่เต็ม</label><textarea name="loc_address[]" placeholder="ที่อยู่สาขา..."><?php echo esc_textarea($loc['address']??''); ?></textarea></div>
                        <div style="display:flex;gap:10px;align-items:flex-end;margin-top:4px;">
                            <div class="sf" style="flex:1;margin:0;"><label>Latitude</label><input type="text" name="loc_lat[]" value="<?php echo esc_attr($loc['lat']??''); ?>" placeholder="13.7563"></div>
                            <div class="sf" style="flex:1;margin:0;"><label>Longitude</label><input type="text" name="loc_lng[]" value="<?php echo esc_attr($loc['lng']??''); ?>" placeholder="100.5018"></div>
                            <button type="button" class="scw-mapbtn" onclick="scwMapOpen(this.closest('.scw-row'))">📍 เลือกจากแผนที่</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
                <button type="button" class="scw-add" onclick="scwAddLoc()">＋ เพิ่มสาขาใหม่</button>
            </div>
<?php endif; ?>

            <div style="text-align:right;margin-top:10px;">
                <button type="submit" class="scw-save">💾 บันทึกการเปลี่ยนแปลง</button>
            </div>
        </form>
    </div>

    <script>
    const ICONS=<?php echo json_encode($icons); ?>;
    // Build icon grid
    (function(){
        const g=document.getElementById('scwMgrid');
        if(!g) return;
        ICONS.forEach(function(ic){
            const el=document.createElement('div');
            el.className='scw-iopt'; el.dataset.ic=ic;
            el.innerHTML='<span class="material-symbols-rounded">'+ic+'</span><span class="scw-ilbl">'+ic+'</span>';
            el.onclick=function(){scwPick(ic);};
            g.appendChild(el);
        });
    })();
    function scwFilter(q){
        document.querySelectorAll('.scw-iopt').forEach(function(el){
            el.style.display=(!q||el.dataset.ic.includes(q.toLowerCase()))?'':'none';
        });
    }
    // ── CSV Import ───────────────────────────────────
    function scwCsvTemplate(){
        const cols='province,category,name,hours,phone,address,note,image_url,lat,lng,map_url';
        const ex=[
            '﻿'+cols,
            'กรุงเทพฯ,Mall,Terminal 21 Asok,11:00-22:00 น.,02-026-6927,ชั้น 1 โซนโตเกียว,,https://example.com/img.jpg,13.7383,100.5608,',
            'เชียงใหม่,Airport,สนามบินเชียงใหม่,06:00-23:59 น.,02-026-6927,ชั้น 1 ประตู 7,,https://example.com/cnx.jpg,18.7668,98.9624,'
        ].join('\n');
        const a=document.createElement('a');
        a.href='data:text/csv;charset=utf-8,'+encodeURIComponent(ex);
        a.download='samurai-locations-template.csv';
        a.click();
    }
    function scwCsvImport(input){
        const file=input.files[0]; if(!file) return;
        const reader=new FileReader();
        reader.onload=function(e){
            const lines=e.target.result.replace(/\r/g,'').split('\n').filter(function(l){return l.trim();});
            if(!lines.length) return;
            // ข้าม header row
            const start=lines[0].toLowerCase().includes('province')||lines[0].toLowerCase().includes('จังหวัด')?1:0;
            const data=lines.slice(start);
            if(!data.length){alert('ไม่พบข้อมูลใน CSV');return;}
            let added=0;
            data.forEach(function(line){
                const c=scwParseCsvLine(line);
                if(c.length<2||!c[1].trim()) return;
                const loc={province:c[0]||'',category:c[1]||'',name:c[2]||'',hours:c[3]||'',phone:c[4]||'',address:c[5]||'',note:c[6]||'',image_url:c[7]||'',lat:c[8]||'',lng:c[9]||'',map_url:c[10]||''};
                scwAddLocData(loc); added++;
            });
            alert(added+' สาขาถูกเพิ่มเรียบร้อย กรุณากด "บันทึก" เพื่อบันทึกข้อมูล');
            input.value='';
        };
        reader.readAsText(file,'UTF-8');
    }
    function scwParseCsvLine(line){
        const result=[]; let cur='',inQ=false;
        for(let i=0;i<line.length;i++){
            const ch=line[i];
            if(ch==='"'){if(inQ&&line[i+1]==='"'){cur+='"';i++;}else inQ=!inQ;}
            else if(ch===','&&!inQ){result.push(cur.trim());cur='';}
            else cur+=ch;
        }
        result.push(cur.trim()); return result;
    }
    function scwAddLocData(loc){
        lC++;
        const w=document.getElementById('loc-wrap');
        const d=document.createElement('div'); d.className='scw-row collapsed';
        const title=(loc.name+(loc.province?' — '+loc.province:''))||'สาขาใหม่';
        d.innerHTML='<div class="scw-rh">'
            +'<button type="button" class="scw-fold" onclick="scwFold(this)">&#9658;</button>'
            +'<span class="scw-num">'+lC+'</span>'
            +'<span class="scw-row-title">'+title+'</span>'
            +'<div style="display:flex;gap:5px;align-items:center;margin-left:auto;">'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,-1)">&#8593;</button>'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,1)">&#8595;</button>'
            +'<button type="button" class="scw-del" onclick="this.closest(\'.scw-row\').remove()">&#128465; ลบ</button></div></div>'
            +'<div class="scw-row-body">'
            +'<input type="hidden" name="loc_id[]" value="">'
            +'<div class="g2">'
            +'<div class="sf"><label>จังหวัด / กลุ่ม</label><input type="text" name="loc_province[]" value="'+escHtml(loc.province)+'" oninput="scwUpdLocTitle(this)"></div>'
            +'<div class="sf"><label>ประเภท</label><select name="loc_category[]" style="width:100%;padding:9px 12px;border-radius:8px;border:1.5px solid #e5e7eb;font-size:13px;"><option value="">— เลือก —</option><option value="Airport"'+(loc.category==='Airport'?' selected':'')+'>✈ Airport</option><option value="Mall"'+(loc.category==='Mall'?' selected':'')+'>🏬 Mall</option><option value="Office"'+(loc.category==='Office'?' selected':'')+'>🏢 Office</option><option value="Agent"'+(loc.category==='Agent'?' selected':'')+'>🏪 Agent</option></select></div></div>'
            +'<div class="sf"><label>ชื่อสาขา</label><input type="text" name="loc_name[]" value="'+escHtml(loc.name)+'" oninput="scwUpdLocTitle(this)"></div>'
            +'<div class="g2">'
            +'<div class="sf"><label>เวลาทำการ</label><input type="text" name="loc_hours[]" value="'+escHtml(loc.hours)+'"></div>'
            +'<div class="sf"><label>URL Google Maps</label><input type="url" name="loc_map_url[]" value="'+escHtml(loc.map_url)+'"></div></div>'
            +'<div class="g2">'
            +'<div class="sf"><label>เบอร์โทร</label><input type="text" name="loc_phone[]" value="'+escHtml(loc.phone)+'"></div>'
            +'<div class="sf"><label>หมายเหตุ</label><input type="text" name="loc_note[]" value="'+escHtml(loc.note)+'"></div></div>'
            +'<div class="sf"><label>URL รูปภาพสาขา</label><input type="url" name="loc_image_url[]" value="'+escHtml(loc.image_url||'')+'"></div>'
            +'<div class="sf"><label>ที่อยู่เต็ม</label><textarea name="loc_address[]">'+escHtml(loc.address)+'</textarea></div>'
            +'<div style="display:flex;gap:10px;align-items:flex-end;margin-top:4px;">'
            +'<div class="sf" style="flex:1;margin:0;"><label>Latitude</label><input type="text" name="loc_lat[]" value="'+escHtml(loc.lat)+'"></div>'
            +'<div class="sf" style="flex:1;margin:0;"><label>Longitude</label><input type="text" name="loc_lng[]" value="'+escHtml(loc.lng)+'"></div>'
            +'<button type="button" class="scw-mapbtn" onclick="scwMapOpen(this.closest(\'.scw-row\'))">&#128205; เลือกจากแผนที่</button>'
            +'</div></div>';
        w.appendChild(d);
    }
    function escHtml(s){return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}

    // ── Fold / Move / Title update ──────────────────
    function scwFold(btn){
        const row=btn.closest('.scw-row');
        const collapsed=row.classList.toggle('collapsed');
        btn.textContent=collapsed?'▶':'▼';
    }
    function scwMove(btn,dir){
        const row=btn.closest('.scw-row'), wrap=row.parentElement;
        const rows=Array.from(wrap.querySelectorAll(':scope>.scw-row'));
        const idx=rows.indexOf(row), nIdx=idx+dir;
        if(nIdx<0||nIdx>=rows.length)return;
        if(dir===-1)wrap.insertBefore(row,rows[nIdx]);
        else wrap.insertBefore(rows[nIdx],row);
        wrap.querySelectorAll(':scope>.scw-row .scw-num').forEach(function(el,i){el.textContent=i+1;});
    }
    function scwUpdLocTitle(inp){
        const row=inp.closest('.scw-row');
        const n=row.querySelector('[name="loc_name[]"]').value;
        const p=row.querySelector('[name="loc_province[]"]').value;
        row.querySelector('.scw-row-title').textContent=(n+(p?' — '+p:''))||'สาขาใหม่';
    }
    function scwUpdFaqTitle(inp){
        const row=inp.closest('.scw-row');
        const l=row.querySelector('[name="faq_label[]"]').value;
        const q=row.querySelector('[name="faq_question[]"]').value;
        row.querySelector('.scw-row-title').textContent=(l+(q?' — '+q:''))||'คำถามใหม่';
    }
    function scwUpdPromoTitle(inp){
        inp.closest('.scw-row').querySelector('.scw-row-title').textContent=inp.value||'โปรโมชั่นใหม่';
    }
    // ── Map Picker ───────────────────────────────────
    let _mapM=null,_mapMk=null,_mapLat=null,_mapLng=null,_mapRow=null;
    function scwMapOpen(row){
        _mapRow=row;
        document.getElementById('scwMapModal').classList.add('open');
        setTimeout(function(){
            if(!_mapM){
                _mapM=L.map('scwMapDiv',{scrollWheelZoom:true});
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{attribution:'&copy; OpenStreetMap &copy; CartoDB',maxZoom:19}).addTo(_mapM);
                _mapM.setView([13.7563,100.5018],11);
                _mapM.on('click',function(e){
                    _mapLat=e.latlng.lat.toFixed(7); _mapLng=e.latlng.lng.toFixed(7);
                    if(_mapMk)_mapMk.setLatLng(e.latlng); else _mapMk=L.marker(e.latlng).addTo(_mapM);
                    document.getElementById('scwMapCoords').textContent='lat: '+_mapLat+',  lng: '+_mapLng;
                });
            } else { _mapM.invalidateSize(); }
            // pre-fill ถ้ามี lat/lng อยู่แล้ว
            const li=row.querySelector('[name="loc_lat[]"]'), lo=row.querySelector('[name="loc_lng[]"]');
            if(li&&lo&&li.value&&lo.value){
                const lt=parseFloat(li.value),ln=parseFloat(lo.value);
                if(!isNaN(lt)&&!isNaN(ln)){
                    _mapLat=lt.toFixed(7); _mapLng=ln.toFixed(7);
                    _mapM.setView([lt,ln],15);
                    if(_mapMk)_mapMk.setLatLng([lt,ln]); else _mapMk=L.marker([lt,ln]).addTo(_mapM);
                    document.getElementById('scwMapCoords').textContent='lat: '+_mapLat+',  lng: '+_mapLng;
                }
            }
        },80);
    }
    function scwMapClose(){document.getElementById('scwMapModal').classList.remove('open');_mapRow=null;_mapLat=null;_mapLng=null;}
    function scwMapConfirm(){
        if(!_mapRow||!_mapLat||!_mapLng){alert('กรุณากดเลือกตำแหน่งบนแผนที่ก่อน');return;}
        _mapRow.querySelector('[name="loc_lat[]"]').value=_mapLat;
        _mapRow.querySelector('[name="loc_lng[]"]').value=_mapLng;
        scwMapClose();
    }
    document.getElementById('scwMapModal').addEventListener('click',function(e){if(e.target===this)scwMapClose();});

    let _trig=null;
    function scwModalOpen(t){
        _trig=t;
        const cur=t.closest('.sf').querySelector('.scw-ival').value;
        document.querySelectorAll('.scw-iopt').forEach(function(el){el.classList.toggle('sel',el.dataset.ic===cur);});
        document.getElementById('scwMsrch').value=''; scwFilter('');
        document.getElementById('scwModal').classList.add('open');
        const s=document.querySelector('.scw-iopt.sel');
        if(s) setTimeout(function(){s.scrollIntoView({block:'center',behavior:'smooth'});},80);
    }
    function scwPick(ic){
        if(!_trig) return;
        const sf=_trig.closest('.sf');
        sf.querySelector('.scw-ival').value=ic;
        _trig.querySelector('.material-symbols-rounded').textContent=ic;
        _trig.querySelector('.scw-iname').textContent=ic;
        scwModalClose();
    }
    function scwModalClose(){document.getElementById('scwModal').classList.remove('open');_trig=null;}
    document.getElementById('scwModal').addEventListener('click',function(e){if(e.target===this)scwModalClose();});
    document.querySelector('input[type="color"]')&&document.querySelector('input[type="color"]').addEventListener('input',function(){document.getElementById('scwColorTxt').value=this.value;});

    let fC=<?php echo count($faq_list ?? scw_faq_default()); ?>;
    function scwAddFaq(){
        fC++;
        const w=document.getElementById('faq-wrap');
        const d=document.createElement('div'); d.className='scw-row';
        d.innerHTML='<div class="scw-rh">'
            +'<button type="button" class="scw-fold" onclick="scwFold(this)">▼</button>'
            +'<span class="scw-num">'+fC+'</span>'
            +'<span class="material-symbols-rounded" style="font-size:18px;color:<?php echo $color;?>;flex-shrink:0;">chat</span>'
            +'<span class="scw-row-title">คำถามใหม่</span>'
            +'<div style="display:flex;gap:5px;align-items:center;margin-left:auto;">'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,-1)">↑</button>'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,1)">↓</button>'
            +'<button type="button" class="scw-del" onclick="this.closest(\'.scw-row\').remove()">🗑 ลบ</button></div></div>'
            +'<div class="scw-row-body">'
            +'<input type="hidden" name="faq_id[]" value="">'
            +'<div class="g2"><div class="sf"><label>ไอคอน</label>'
            +'<input type="hidden" name="faq_icon[]" value="chat" class="scw-ival">'
            +'<div class="scw-itrig" onclick="scwModalOpen(this)">'
            +'<span class="material-symbols-rounded">chat</span><span class="scw-iname">chat</span>'
            +'<span style="color:#999;font-size:11px;">▼</span></div></div>'
            +'<div class="sf"><label>ชื่อย่อปุ่ม</label><input type="text" name="faq_label[]" placeholder="ชื่อปุ่ม" oninput="scwUpdFaqTitle(this)"></div></div>'
            +'<div class="g2"><div class="sf"><label>หมวดหมู่</label><input type="text" name="faq_category[]" placeholder="เช่น การสั่งซื้อ"></div>'
            +'<div class="sf"><label>FAQ ที่เกี่ยวข้อง</label><input type="text" name="faq_related[]" placeholder="q5,q6,q1"></div></div>'
            +'<div class="sf"><label>คำถาม</label><input type="text" name="faq_question[]" placeholder="คำถาม..." oninput="scwUpdFaqTitle(this)"></div>'
            +'<div class="sf"><label>คำตอบ</label><textarea name="faq_answer[]" placeholder="คำตอบ..."></textarea></div>'
            +'<div class="g2"><div class="sf"><label>ประเภท</label><select name="faq_type[]">'
            +'<option value="text">ข้อความ</option><option value="promo">แสดงโปรโมชั่น</option><option value="location">แสดงสาขา</option>'
            +'</select></div><div class="sf"><label>ชื่อปุ่ม Link</label><input type="text" name="faq_btn_label[]" placeholder="ดูเพิ่มเติม"></div></div>'
            +'<div class="sf"><label>URL ปุ่ม</label><input type="url" name="faq_btn_url[]" placeholder="https://..."></div></div>';
        w.appendChild(d); d.scrollIntoView({behavior:'smooth',block:'start'});
    }
    let pC=<?php echo count($promo_list ?? scw_promo_default()); ?>;
    function scwAddPromo(){
        pC++;
        const w=document.getElementById('promo-wrap');
        const d=document.createElement('div'); d.className='scw-row';
        d.innerHTML='<div class="scw-rh">'
            +'<button type="button" class="scw-fold" onclick="scwFold(this)">▼</button>'
            +'<span class="scw-num">'+pC+'</span>'
            +'<span class="scw-row-title">โปรโมชั่นใหม่</span>'
            +'<div style="display:flex;gap:5px;align-items:center;margin-left:auto;">'
            +'<input type="hidden" name="promo_active[]" value="1" class="scw-pactive-val">'
            +'<label class="scw-tog"><input type="checkbox" value="1" checked class="scw-pactive-check"><span style="font-size:12px;color:#555;">เปิด</span></label>'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,-1)">↑</button>'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,1)">↓</button>'
            +'<button type="button" class="scw-del" onclick="this.closest(\'.scw-row\').remove()">🗑 ลบ</button></div></div>'
            +'<div class="scw-row-body">'
            +'<input type="hidden" name="promo_id[]" value="">'
            +'<div class="sf"><label>ชื่อโปรโมชั่น</label><input type="text" name="promo_title[]" placeholder="ชื่อ..." oninput="scwUpdPromoTitle(this)"></div>'
            +'<div class="sf"><label>URL รูปภาพ</label><input type="url" name="promo_img[]" placeholder="https://..."></div>'
            +'<div class="sf"><label>คำอธิบาย</label><input type="text" name="promo_desc[]"></div>'
            +'<div class="g2"><div class="sf"><label>ชื่อปุ่ม</label><input type="text" name="promo_btn_label[]" value="ดูรายละเอียด"></div>'
            +'<div class="sf"><label>URL ปุ่ม</label><input type="url" name="promo_btn_url[]" placeholder="https://..."></div></div></div>';
        w.appendChild(d);
        d.querySelector('.scw-pactive-check').addEventListener('change',function(){d.querySelector('.scw-pactive-val').value=this.checked?'1':'0';});
        d.scrollIntoView({behavior:'smooth',block:'start'});
    }
    let lC=<?php echo count($loc_list ?? scw_loc_default()); ?>;
    function scwAddLoc(){
        lC++;
        const w=document.getElementById('loc-wrap');
        const d=document.createElement('div'); d.className='scw-row';
        d.innerHTML='<div class="scw-rh">'
            +'<button type="button" class="scw-fold" onclick="scwFold(this)">▼</button>'
            +'<span class="scw-num">'+lC+'</span>'
            +'<span class="scw-row-title">สาขาใหม่</span>'
            +'<div style="display:flex;gap:5px;align-items:center;margin-left:auto;">'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,-1)" title="เลื่อนขึ้น">↑</button>'
            +'<button type="button" class="scw-mv" onclick="scwMove(this,1)" title="เลื่อนลง">↓</button>'
            +'<button type="button" class="scw-del" onclick="this.closest(\'.scw-row\').remove()">🗑 ลบ</button></div></div>'
            +'<div class="scw-row-body">'
            +'<input type="hidden" name="loc_id[]" value="">'
            +'<div class="g2"><div class="sf"><label>จังหวัด / กลุ่ม</label><input type="text" name="loc_province[]" placeholder="กรุงเทพฯ" oninput="scwUpdLocTitle(this)"></div>'
            +'<div class="sf"><label>ชื่อสาขา</label><input type="text" name="loc_name[]" oninput="scwUpdLocTitle(this)"></div></div>'
            +'<div class="g2"><div class="sf"><label>เวลาทำการ</label><input type="text" name="loc_hours[]" placeholder="09:00-18:00"></div>'
            +'<div class="sf"><label>URL Google Maps</label><input type="url" name="loc_map_url[]"></div></div>'
            +'<div class="g2"><div class="sf"><label>เบอร์โทร</label><input type="text" name="loc_phone[]" placeholder="02-xxx-xxxx"></div>'
            +'<div class="sf"><label>หมายเหตุ</label><input type="text" name="loc_note[]" placeholder="เช่น รับซิมได้ที่ชั้น 2"></div></div>'
            +'<div class="sf"><label>ที่อยู่เต็ม</label><textarea name="loc_address[]" placeholder="ที่อยู่สาขา..."></textarea></div>'
            +'<div style="display:flex;gap:10px;align-items:flex-end;margin-top:4px;">'
            +'<div class="sf" style="flex:1;margin:0;"><label>Latitude</label><input type="text" name="loc_lat[]" placeholder="13.7563"></div>'
            +'<div class="sf" style="flex:1;margin:0;"><label>Longitude</label><input type="text" name="loc_lng[]" placeholder="100.5018"></div>'
            +'<button type="button" class="scw-mapbtn" onclick="scwMapOpen(this.closest(\'.scw-row\'))">📍 เลือกจากแผนที่</button>'
            +'</div></div>';
        w.appendChild(d); d.scrollIntoView({behavior:'smooth',block:'start'});
    }
    </script>
    <?php
}

/* ── Shortcode [samurai_chat] ────────────────── */
add_shortcode('samurai_chat', 'scw_render_widget');

function scw_render_widget() {
    $brand  = get_option(SCW_BRAND,    scw_brand_default());
    $faqs   = get_option(SCW_FAQ,      scw_faq_default());
    $promos = get_option(SCW_PROMO,    scw_promo_default());
    $locs   = get_option(SCW_LOCATION, scw_loc_default());
    $apromo = array_values(array_filter($promos, fn($p) => !empty($p['active'])));

    $col  = esc_attr($brand['color_primary'] ?? '#e60012');
    $name = esc_html($brand['name']           ?? 'SAMURAI Official');
    $av   = esc_url( $brand['avatar_url']     ?? '');
    $wi   = esc_url( $brand['welcome_img']    ?? '');
    $wm   = esc_js(  $brand['welcome_msg']    ?? 'สวัสดีครับ ยินดีต้อนรับครับ');
    $nm   = esc_js($name);
    $line = esc_url( $brand['line_url']       ?? '');
    $cta_label = esc_js($brand['cta_label']   ?? 'แชทกับแอดมิน');
    $cta_url = esc_url($brand['cta_url']      ?? '');
    if (!$cta_url && $line) $cta_url = $line;
    $phone = sanitize_text_field($brand['phone'] ?? '');
    $json_flags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    $jf   = wp_json_encode(array_values($faqs), $json_flags);
    $jp   = wp_json_encode($apromo, $json_flags);
    $jl   = wp_json_encode(array_values($locs), $json_flags);
    $uid  = 'scw_'.substr(md5(uniqid()),0,8);
    ob_start();
?>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet">
<?php static $scw_leaflet_loaded = false; if (!$scw_leaflet_loaded): $scw_leaflet_loaded = true; ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<?php endif; ?>
<style>
.sw,.sw *{box-sizing:border-box;}
.sw a,.sw-sheet a,.sw-sheet-ov a{text-decoration:none;}
.sw{--p:<?php echo $col;?>;--phone-w:340px;--phone-h:620px;--panel-h:620px;width:100%;max-width:1160px;margin:0 auto;font-family:'Prompt',sans-serif;padding:20px 16px 40px;opacity:0;transform:translateY(24px);transition:opacity .6s,transform .6s;}
.sw.vis{opacity:1;transform:translateY(0);}
.sw-out{display:flex;flex-direction:row;gap:40px;align-items:flex-start;justify-content:center;}
/* Phone */
.sw-ph{width:var(--phone-w);height:var(--phone-h);max-height:var(--phone-h);flex-shrink:0;background:#fff;border-radius:48px;border:11px solid #111;box-shadow:0 0 0 2px #2a2a2a,0 0 0 5px #d1d5db,0 30px 60px rgba(0,0,0,.22);position:relative;overflow:hidden;display:flex;flex-direction:column;}
.sw-ph::before{content:'';position:absolute;top:10px;left:50%;transform:translateX(-50%);width:90px;height:24px;background:#111;border-radius:20px;z-index:20;}
.sw-ph::after{content:'';position:absolute;top:100px;right:-13px;width:4px;height:60px;background:#1a1a1a;border-radius:0 3px 3px 0;box-shadow:0 80px 0 #1a1a1a,0 -70px 0 #1a1a1a,0 -95px 0 #1a1a1a;}
.sw-sb{background:var(--p);height:48px;display:flex;justify-content:space-between;align-items:flex-end;padding:0 22px 7px;font-size:12px;font-weight:600;color:#fff;flex-shrink:0;}
.sw-sbi{display:flex;gap:5px;align-items:center;}.sw-sbi svg{width:14px;height:14px;fill:#fff;}
.sw-ch{background:var(--p);padding:6px 18px 14px;display:flex;align-items:center;gap:10px;flex-shrink:0;}
.sw-av{width:36px;height:36px;border-radius:50%;border:2px solid rgba(255,255,255,.5);overflow:hidden;flex-shrink:0;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;}
.sw-av img{width:100%;height:100%;object-fit:cover;}
.sw-hn{font-size:14px;font-weight:600;color:#fff;}
.sw-hs{font-size:11px;color:rgba(255,255,255,.75);display:flex;align-items:center;gap:4px;margin-top:1px;}
.sw-dot{width:7px;height:7px;border-radius:50%;background:#4ade80;animation:swPls 2s infinite;}
@keyframes swPls{0%,100%{opacity:1}50%{opacity:.4}}
.sw-hist{flex:1;min-height:0;max-height:none;overflow-y:auto;overflow-x:hidden;padding:14px 12px;display:flex;flex-direction:column;gap:10px;background:#f7f8fb;scroll-behavior:smooth;}
.sw-hist::-webkit-scrollbar{width:3px;}.sw-hist::-webkit-scrollbar-thumb{background:rgba(0,0,0,.1);border-radius:10px;}
/* Rich menu (mobile only) */
.sw-rm{background:#fff;border-top:1px solid #eee;overflow:hidden;flex-shrink:0;position:relative;}
.sw-rm-track{display:flex;transition:transform .32s cubic-bezier(.4,0,.2,1);}
.sw-rm-page{display:grid;flex:0 0 100%;padding:6px;gap:4px;box-sizing:border-box;}
.sw-rm-dots{display:flex;justify-content:center;align-items:center;gap:5px;padding:2px 0 6px;}
.sw-rm-dot{width:5px;height:5px;border-radius:50%;background:#ddd;transition:all .2s;flex-shrink:0;}
.sw-rm-dot.active{background:var(--p);transform:scale(1.25);}
.sw-rm-flat{padding:6px;gap:4px;display:none;}
.sw-rbar{display:none;background:#fff;border-top:1px solid #eee;padding:5px 8px;flex-shrink:0;}
.sw-rbar label{display:flex;align-items:center;gap:6px;background:#f5f5f5;border-radius:10px;padding:6px 10px;width:100%;cursor:text;}
.sw-rbar label .material-symbols-rounded{font-size:15px;color:#bbb;flex-shrink:0;}
.sw-rbar label input{border:0;outline:0;background:transparent;font-family:'Prompt',sans-serif;font-size:12px;width:100%;color:#222;}
.sw-mi{background:#fafafa;border:1px solid #f0f0f0;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;padding:8px 4px;cursor:pointer;transition:.2s;min-height:60px;}
.sw-mi:hover{background:#fff0f0;border-color:var(--p);}
.sw-mi:active{transform:scale(.95);}
.sw-mi .material-symbols-rounded{font-size:22px;color:var(--p);}
.sw-ml{font-size:9.5px;font-weight:500;color:#444;text-align:center;line-height:1.2;}
/* Sidebar */
.sw-side{flex:1;max-width:460px;height:var(--panel-h);max-height:var(--panel-h);display:flex;flex-direction:column;background:#fff;border-radius:24px;border:1px solid #eee;box-shadow:0 8px 30px rgba(0,0,0,.06);overflow:hidden;align-self:flex-start;}
.sw-sh{padding:20px 22px 14px;border-bottom:1px solid #f5f5f5;display:flex;align-items:center;gap:10px;}
.sw-sh h3{margin:0 0 3px;font-size:17px;font-weight:600;color:#1a1a1a;flex:1;}
.sw-sh h3 span{color:var(--p);}
.sw-sh p{margin:0;font-size:12px;color:#999;}
.sw-back{background:var(--p);color:#fff;border:none;border-radius:8px;padding:6px 10px;cursor:pointer;font-family:'Prompt',sans-serif;font-size:12px;font-weight:600;display:flex;align-items:center;gap:4px;flex-shrink:0;}
.sw-panel{display:none;flex-direction:column;flex:1;min-height:0;overflow:hidden;}
.sw-panel.on{display:flex;}
.sw-ql{padding:14px;display:flex;flex-direction:column;gap:7px;overflow-y:auto;flex:1;min-height:0;}
.sw-qb{background:#fafafa;border:1.5px solid #f0f0f0;color:#222;padding:12px 15px;border-radius:13px;font-size:14px;font-weight:500;cursor:pointer;transition:all .2s;text-align:left;width:100%;font-family:'Prompt',sans-serif;display:flex;align-items:center;gap:10px;opacity:0;transform:translateX(12px);animation:swSl .4s ease forwards;}
@keyframes swSl{to{opacity:1;transform:translateX(0);}}
.sw-qb:hover{background:var(--p);color:#fff;border-color:var(--p);transform:translateX(4px);}
.sw-qb .material-symbols-rounded{font-size:20px;color:var(--p);flex-shrink:0;transition:.2s;}
.sw-qb:hover .material-symbols-rounded{color:#fff;}
.sw-qa{margin-left:auto;opacity:.3;font-size:16px;}
.sw-qb:hover .sw-qa{opacity:1;}

.sw-search{padding:12px 14px 0;border-bottom:1px solid #f7f7f7;}
.sw-search input{width:100%;border:1.5px solid #eee;border-radius:12px;padding:10px 13px;font-family:'Prompt',sans-serif;font-size:13px;outline:none;transition:.2s;}
.sw-search input:focus{border-color:var(--p);box-shadow:0 0 0 3px rgba(230,0,18,.08);}
.sw-qb.active{background:#333;color:#fff;border-color:#333;transform:translateX(4px);}
.sw-qb.active .material-symbols-rounded{color:var(--p);}
.sw-qb.active .sw-qa{opacity:1;color:#fff;}
.sw-empty{padding:20px;text-align:center;color:#999;font-size:12px;}
/* Sidebar location panel - scalable branch directory */
.sw-ll{padding:14px;display:flex;flex-direction:column;gap:12px;overflow-y:auto;flex:1;background:linear-gradient(180deg,#fff,#fff 60%,#fafafa);}
.sw-ll::-webkit-scrollbar{width:4px;}.sw-ll::-webkit-scrollbar-thumb{background:#ddd;border-radius:8px;}
.sw-loctabs{display:flex;border-bottom:2px solid #f1f1f1;flex-shrink:0;}
.sw-loctab{flex:1;border:0;background:transparent;font-family:'Prompt',sans-serif;font-size:12px;font-weight:600;color:#aaa;padding:10px 4px;cursor:pointer;border-bottom:2.5px solid transparent;margin-bottom:-2px;transition:.2s;display:flex;align-items:center;justify-content:center;gap:5px;}
.sw-loctab.active{color:var(--p);border-bottom-color:var(--p);}
.sw-loctab:hover:not(.active){color:#555;}
.sw-locmap{flex:1;min-height:0;border-radius:12px;overflow:hidden;}
.leaflet-popup-content-wrapper,.leaflet-popup-tip{font-family:'Prompt',sans-serif!important;}
.sw-ltools{position:sticky;top:0;z-index:5;background:rgba(255,255,255,.96);backdrop-filter:blur(10px);padding:2px 0 10px;border-bottom:1px solid #f3f3f3;}
.sw-lsum{display:flex;align-items:center;justify-content:space-between;margin:2px 0 10px;gap:10px;}
.sw-lsum strong{font-size:14px;color:#1f2937;display:flex;align-items:center;gap:6px;}
.sw-lsum span{font-size:11px;color:#777;background:#f5f5f5;border:1px solid #eee;border-radius:999px;padding:5px 9px;white-space:nowrap;}
.sw-lsearch{display:flex;align-items:center;gap:8px;background:#fff;border:1.5px solid #eee;border-radius:14px;padding:9px 12px;transition:.2s;}
.sw-lsearch:focus-within{border-color:var(--p);box-shadow:0 0 0 3px rgba(230,0,18,.08);}
.sw-lsearch .material-symbols-rounded{font-size:19px;color:#9ca3af;}
.sw-lsearch input{border:0;outline:0;background:transparent;font-family:'Prompt',sans-serif;font-size:12px;width:100%;color:#222;}
.sw-lchips{display:flex;gap:7px;overflow-x:auto;scrollbar-width:none;padding:10px 0 2px;-webkit-overflow-scrolling:touch;overscroll-behavior-x:contain;touch-action:pan-x;cursor:grab;}
.sw-lchips.dragging{cursor:grabbing;}
.sw-lchips::-webkit-scrollbar{display:none;}
.sw-lchip{border:1.5px solid #eee;background:#fff;color:#444;border-radius:999px;padding:7px 11px;font-family:'Prompt',sans-serif;font-size:11px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;white-space:nowrap;transition:.2s;}
.sw-lchip:hover{border-color:var(--p);color:var(--p);}
.sw-lchip.active{background:var(--p);border-color:var(--p);color:#fff;box-shadow:0 6px 14px rgba(230,0,18,.18);}
.sw-lchip b{font-size:10px;min-width:18px;height:18px;border-radius:999px;background:#f1f1f1;color:#555;display:inline-flex;align-items:center;justify-content:center;padding:0 5px;}
.sw-lchip.active b{background:#fff;color:var(--p);}
.sw-lgrp{border:1.5px solid #eee;border-radius:16px;background:#fff;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.025);}
.sw-lgh{width:100%;border:0;background:#fff;padding:12px 14px;font-family:'Prompt',sans-serif;display:flex;align-items:center;gap:10px;cursor:pointer;text-align:left;}
.sw-lgh:hover{background:#fff8f8;}
.sw-lgic{width:34px;height:34px;border-radius:50%;background:var(--p);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.sw-lgic .material-symbols-rounded{font-size:19px;}
.sw-lgt2{font-size:14px;font-weight:700;color:#1f2937;}
.sw-lgc{font-size:10px;color:#777;background:#f4f4f5;border-radius:999px;padding:3px 8px;margin-left:2px;white-space:nowrap;}
.sw-lchev{margin-left:auto;color:#777;transition:.2s;}
.sw-lgrp.closed .sw-lchev{transform:rotate(-90deg);}
.sw-lbody{padding:0 10px 10px;display:flex;flex-direction:column;gap:7px;}
.sw-lgrp.closed .sw-lbody{display:none;}
.sw-lrow{display:grid;grid-template-columns:38px minmax(0,1fr) auto;gap:10px;align-items:center;background:#fafafa;border:1px solid #f0f0f0;border-radius:13px;padding:10px 10px;text-decoration:none;transition:.2s;}
.sw-lrow:hover{border-color:var(--p);background:#fff;box-shadow:0 3px 10px rgba(0,0,0,.05);transform:translateX(2px);}
.sw-lri{width:38px;height:38px;border-radius:50%;background:var(--p);display:flex;align-items:center;justify-content:center;box-shadow:0 5px 12px rgba(230,0,18,.18);}
.sw-lri .material-symbols-rounded{font-size:20px;color:#fff;}
.sw-lrn{font-size:13px;font-weight:700;color:#151515;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.sw-lrm{display:flex;flex-wrap:wrap;gap:5px 10px;margin-top:3px;font-size:10.5px;color:#777;line-height:1.35;}
.sw-lrm span{display:inline-flex;align-items:center;gap:3px;min-width:0;}
.sw-lrm .material-symbols-rounded{font-size:13px;color:#9ca3af;}
.sw-lgo{background:var(--p);color:#fff;border-radius:10px;padding:8px 11px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:4px;white-space:nowrap;}
.sw-lgo .material-symbols-rounded{font-size:15px;color:#fff;}
.sw-lmore{border:1px dashed #ddd;background:#fff;border-radius:12px;padding:9px;text-align:center;font-family:'Prompt',sans-serif;font-size:11px;color:#777;cursor:pointer;}
.sw-lmore:hover{color:var(--p);border-color:var(--p);background:#fff8f8;}
.sw-lnone{padding:24px 12px;text-align:center;color:#999;font-size:12px;border:1px dashed #eee;border-radius:14px;background:#fff;}
/* Location cards in chat - compact for many branches */
.sw-lcw{display:flex;flex-direction:column;gap:7px;width:100%;}
.sw-lhint{font-size:10.5px;font-weight:600;color:#888;margin:2px 0 2px 2px;}
.sw-lcc{display:grid;grid-template-columns:34px minmax(0,1fr) auto;align-items:center;gap:9px;background:#fff;border:1.5px solid #eee;border-radius:13px;padding:9px 10px;text-decoration:none;transition:.2s;}
.sw-lcc:hover{border-color:var(--p);box-shadow:0 3px 10px rgba(0,0,0,.08);}
.sw-lcc-ic{width:34px;height:34px;border-radius:50%;background:var(--p);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.sw-lcc-ic .material-symbols-rounded{font-size:18px;color:#fff;}
.sw-lcc-inf{min-width:0;}
.sw-lcc-n{font-size:12px;font-weight:700;color:#1a1a1a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.sw-lcc-h{font-size:10px;color:#888;display:flex;align-items:center;gap:3px;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.sw-lcc-addr{font-size:9.5px;color:#999;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.sw-lcc-ct{font-size:10px;font-weight:700;color:#fff;background:var(--p);border-radius:9px;padding:7px 9px;display:flex;align-items:center;gap:2px;flex-shrink:0;}
.sw-lcc-ct .material-symbols-rounded{font-size:13px;color:#fff;}
.sw-lall{border:none;background:transparent;color:#777;font-family:'Prompt',sans-serif;font-size:11px;padding:6px 2px 0;cursor:pointer;text-align:center;}
.sw-lall:hover{color:var(--p);}
.sw-open{background:#16a34a;color:#fff;border-radius:20px;font-size:9px;font-weight:700;padding:2px 6px;display:inline-flex;align-items:center;gap:1px;margin-left:4px;vertical-align:middle;flex-shrink:0;}
.sw-closed{background:#ef4444;color:#fff;border-radius:20px;font-size:9px;font-weight:700;padding:2px 6px;display:inline-flex;align-items:center;gap:1px;margin-left:4px;vertical-align:middle;flex-shrink:0;}
.sw-lcall{width:34px;height:34px;border-radius:50%;background:#16a34a;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-decoration:none!important;}
.sw-lcall .material-symbols-rounded{font-size:16px;color:#fff!important;}
.sw-lri-img{width:38px;height:38px;border-radius:10px;object-fit:cover;flex-shrink:0;}
.sw-lcc-img{width:34px;height:34px;border-radius:8px;object-fit:cover;flex-shrink:0;}
/* Bubbles */
.sw-msg{display:flex;width:100%;animation:swFd .35s ease forwards;opacity:0;}
@keyframes swFd{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
.sw-bav{width:30px;height:30px;border-radius:50%;margin-right:8px;flex-shrink:0;border:1px solid #eee;overflow:hidden;background:#fff;display:flex;align-items:center;justify-content:center;}
.sw-bav img{width:100%;height:100%;object-fit:cover;}
.sw-bsp{width:0;margin-right:38px;flex-shrink:0;}
.sw-msg-u .sw-bav{margin-right:0;margin-left:8px;background:<?php echo $col;?>33;border-color:<?php echo $col;?>44;}
.sw-cnt{display:flex;align-items:flex-end;max-width:86%;min-width:0;}
.sw-cnt.wr{width:calc(100% - 38px)!important;max-width:calc(100% - 38px)!important;min-width:0;}
.sw-bbl{padding:9px 13px;font-size:13px;line-height:1.45;word-wrap:break-word;}
.sw-msg-a .sw-bbl{background:#fff;color:#333;border-radius:14px 14px 14px 3px;border:1px solid #eee;box-shadow:0 1px 3px rgba(0,0,0,.04);}
.sw-msg-u{justify-content:flex-end;}
.sw-msg-u .sw-cnt{flex-direction:row-reverse;}
.sw-msg-u .sw-bbl{background:var(--p);color:#fff;border-radius:14px 14px 3px 14px;}
.sw-mt{font-size:9px;color:#c0c0c0;margin:0 5px;display:flex;flex-direction:column;margin-bottom:2px;white-space:nowrap;}
.sw-bbl.rich{background:transparent!important;box-shadow:none!important;padding:0!important;border:none!important;width:100%;min-width:0;overflow:visible;}
/* Nav buttons in chat */
.sw-nb{display:flex;flex-wrap:wrap;gap:7px;margin-top:10px;}
.sw-nbb{background:#fff;border:1.5px solid var(--p);color:var(--p);border-radius:20px;padding:7px 14px;font-size:12px;font-weight:600;cursor:pointer;font-family:'Prompt',sans-serif;display:flex;align-items:center;gap:5px;transition:.2s;white-space:nowrap;}
.sw-nbb:hover{background:var(--p);color:#fff;}
.sw-nbb .material-symbols-rounded{font-size:14px;}
/* Promo carousel */
.sw-car{display:flex;gap:8px;overflow-x:auto;overflow-y:hidden;padding:4px 2px 12px;scrollbar-width:thin;width:100%;max-width:100%;min-width:0;-webkit-overflow-scrolling:touch;overscroll-behavior-x:contain;touch-action:pan-x;cursor:grab;user-select:none;}
.sw-car.dragging{cursor:grabbing;scroll-behavior:auto;}
.sw-car::-webkit-scrollbar{height:5px;}
.sw-car::-webkit-scrollbar-thumb{background:rgba(0,0,0,.16);border-radius:999px;}
.sw-car::-webkit-scrollbar-track{background:transparent;}
.sw-pcard{flex:0 0 150px;max-width:150px;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #eee;box-shadow:0 2px 8px rgba(0,0,0,.05);display:flex;flex-direction:column;}
.sw-pcard img{width:100%;height:80px;object-fit:cover;display:block;}
.sw-pph{width:100%;height:80px;background:linear-gradient(135deg,#fff0f0,#ffe5e5);display:flex;align-items:center;justify-content:center;}
.sw-pph .material-symbols-rounded{font-size:32px;color:var(--p);}
.sw-pb{padding:9px;display:flex;flex-direction:column;flex-grow:1;}
.sw-pt{font-size:11px;font-weight:600;margin-bottom:3px;color:#1a1a1a;}
.sw-pd{font-size:10px;color:#777;margin-bottom:8px;line-height:1.35;flex-grow:1;}
.sw-pcb{display:block;text-align:center;padding:6px;border-radius:7px;text-decoration:none;font-size:10px;font-weight:600;background:var(--p);color:#fff;}
/* Typing */
.sw-typ{display:flex;gap:4px;padding:10px 14px!important;align-items:center;}
.sw-d{width:5px;height:5px;background:#d0d0d0;border-radius:50%;animation:swB 1.4s infinite ease-in-out both;}
.sw-d:nth-child(2){animation-delay:.2s}.sw-d:nth-child(3){animation-delay:.4s}
@keyframes swB{0%,80%,100%{transform:scale(0)}40%{transform:scale(1)}}
.sw-ib{display:inline-block;margin-top:9px;background:var(--p);color:#fff!important;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;}
/* Responsive */
@media(min-width:861px){.sw-rm{display:none!important;}.sw-rbar{display:none!important;}}
@media(max-width:860px){.sw{--phone-w:min(400px,calc(100vw - 32px));--phone-h:min(620px,calc(100dvh - 48px));}.sw-out{flex-direction:column;align-items:center;gap:0;}.sw-ph{width:var(--phone-w);height:var(--phone-h);max-height:var(--phone-h);border-radius:40px;}.sw-side{display:none!important;}.sw-rbar{display:flex!important;}.sw-rm{display:block!important;}}
@media(max-width:440px){.sw{--phone-w:calc(100vw - 28px);--phone-h:min(600px,calc(100dvh - 36px));}.sw-ph{border-radius:30px;border-width:9px;}.sw-mi .material-symbols-rounded{font-size:19px;}.sw-ml{font-size:9px;}}
/* Mobile Bottom Sheet */
.sw-sheet-ov{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:99990;touch-action:none;}
.sw-sheet-ov.open{display:block;}
.sw-sheet{position:fixed;bottom:0;left:0;right:0;background:#fff;border-radius:24px 24px 0 0;z-index:99991;max-height:88dvh;display:flex;flex-direction:column;transform:translateY(100%);transition:transform .38s cubic-bezier(.32,0,.67,0);}
.sw-sheet.open{transform:translateY(0);}
.sw-sheet-drag{width:40px;height:4px;background:#e0e0e0;border-radius:99px;margin:12px auto 0;flex-shrink:0;cursor:grab;}
.sw-sheet-hd{padding:10px 18px 0;flex-shrink:0;}
.sw-sheet-hd h4{margin:0 0 10px;font-size:15px;font-weight:700;font-family:'Prompt',sans-serif;color:#1a1a1a;display:flex;align-items:center;gap:6px;}
.sw-sheet-srch{display:flex;align-items:center;gap:8px;background:#f5f5f5;border-radius:12px;padding:9px 12px;}
.sw-sheet-srch .material-symbols-rounded{font-size:18px;color:#9ca3af;flex-shrink:0;}
.sw-sheet-srch input{border:0;outline:0;background:transparent;font-family:'Prompt',sans-serif;font-size:13px;width:100%;color:#222;}
.sw-sheet-chips{display:flex;gap:6px;overflow-x:auto;scrollbar-width:none;padding:10px 0 12px;border-bottom:1px solid #f3f3f3;}
.sw-sheet-chips::-webkit-scrollbar{display:none;}
.sw-sheet-body{flex:1;overflow-y:auto;padding:14px 18px 32px;overscroll-behavior:contain;display:flex;flex-direction:column;gap:7px;}
.sw-sheet-gtitle{font-size:11px;font-weight:700;color:#bbb;letter-spacing:.4px;margin-top:10px;font-family:'Prompt',sans-serif;display:flex;align-items:center;gap:4px;}
.sw-sheet-gtitle:first-child{margin-top:0;}
.sw-sheet-none{text-align:center;color:#aaa;font-size:13px;font-family:'Prompt',sans-serif;padding:30px 0;}
/* Category chips */
.sw-fchips{display:flex;gap:6px;overflow-x:auto;scrollbar-width:none;padding:10px 14px 0;-webkit-overflow-scrolling:touch;}
.sw-fchips::-webkit-scrollbar{display:none;}
.sw-fchip{border:1.5px solid #eee;background:#fff;color:#555;border-radius:999px;padding:6px 12px;font-family:'Prompt',sans-serif;font-size:11px;font-weight:600;cursor:pointer;white-space:nowrap;transition:.2s;flex-shrink:0;}
.sw-fchip:hover{border-color:var(--p);color:var(--p);}
.sw-fchip.active{background:var(--p);border-color:var(--p);color:#fff;}
/* Reset button */
.sw-reset{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);color:#fff;border-radius:8px;padding:5px 7px;cursor:pointer;display:flex;align-items:center;transition:.2s;}
.sw-reset:hover{background:rgba(255,255,255,.3);}
.sw-reset .material-symbols-rounded{font-size:18px;}
</style>
<div class="sw" id="<?php echo $uid;?>">
    <div class="sw-out">
        <div class="sw-ph">
            <div class="sw-sb">
                <span id="<?php echo $uid;?>_clk">09:41</span>
                <div class="sw-sbi">
                    <svg viewBox="0 0 20 16"><rect x="0" y="10" width="3" height="6"/><rect x="4.5" y="7" width="3" height="9"/><rect x="9" y="4" width="3" height="12"/><rect x="13.5" y="1" width="3" height="15"/></svg>
                    <svg viewBox="0 0 20 16"><path d="M10 13a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm-4.5-4.5a6.4 6.4 0 019 0l-1.5 1.5a4.4 4.4 0 00-6 0L4.5 8.5zm-3-3a10.5 10.5 0 0115 0l-1.5 1.5a8.4 8.4 0 00-12 0L1.5 5z"/></svg>
                    <svg viewBox="0 0 24 12"><rect x="0" y="1" width="20" height="10" rx="2" stroke="#fff" stroke-width="1.5" fill="none"/><rect x="20" y="4" width="3" height="4" rx="1" fill="#fff"/><rect x="1.5" y="2.5" width="16" height="7" rx="1" fill="#fff"/></svg>
                </div>
            </div>
            <div class="sw-ch">
                <div class="sw-av">
                    <?php if($av):?><img src="<?php echo $av;?>" alt="<?php echo $name;?>">
                    <?php else:?><span class="material-symbols-rounded" style="color:#fff;font-size:20px;">support_agent</span><?php endif;?>
                </div>
                <div><div class="sw-hn"><?php echo $name;?></div><div class="sw-hs"><div class="sw-dot"></div>ออนไลน์</div></div>
                <div style="margin-left:auto;display:flex;align-items:center;gap:6px;">
                    <button class="sw-reset" onclick="<?php echo $uid;?>_reset()" title="เริ่มการสนทนาใหม่"><span class="material-symbols-rounded">refresh</span></button>
                    <?php if($phone):?><a href="tel:<?php echo esc_attr($phone);?>" onclick="window.dataLayer&&window.dataLayer.push({event:'samurai_chat_call_click',source:'header'});" style="color:#fff;opacity:.9;text-decoration:none;" title="โทร <?php echo esc_attr($phone);?>"><span class="material-symbols-rounded" style="font-size:22px;">call</span></a>
                    <?php elseif($cta_url):?><a href="<?php echo $cta_url;?>" target="_blank" onclick="window.dataLayer&&window.dataLayer.push({event:'samurai_chat_cta_click',source:'header'});" style="color:#fff;opacity:.9;text-decoration:none;"><span class="material-symbols-rounded" style="font-size:22px;">call</span></a>
                    <?php else:?><span class="material-symbols-rounded" style="color:#fff;opacity:.8;font-size:22px;">call</span><?php endif;?>
                </div>
            </div>
            <div class="sw-hist" id="<?php echo $uid;?>_h"></div>
            <div class="sw-rbar"><label><span class="material-symbols-rounded">search</span><input type="search" id="<?php echo $uid;?>_rs" placeholder="ค้นหาเมนู..."></label></div>
            <div class="sw-rm" id="<?php echo $uid;?>_rm"></div>
        </div>
        <div class="sw-side">
            <div class="sw-sh">
                <div style="flex:1;">
                    <h3 id="<?php echo $uid;?>_st">คำถาม<span>ที่พบบ่อย</span></h3>
                    <p id="<?php echo $uid;?>_ss">แตะเพื่อดูคำตอบในแชทได้เลยครับ</p>
                </div>
                <button class="sw-back" id="<?php echo $uid;?>_bk" style="display:none;" onclick="<?php echo $uid;?>_back()">
                    <span class="material-symbols-rounded">arrow_back</span>กลับ
                </button>
            </div>
            <div class="sw-panel on" id="<?php echo $uid;?>_pf">
                <div class="sw-search"><input id="<?php echo $uid;?>_qs" type="search" placeholder="ค้นหา FAQ เช่น eSIM, สนามบิน, จัดส่ง"></div>
                <div class="sw-fchips" id="<?php echo $uid;?>_fc"></div>
                <div class="sw-ql" id="<?php echo $uid;?>_ql"></div>
            </div>
            <div class="sw-panel" id="<?php echo $uid;?>_pl">
                <div class="sw-ll" id="<?php echo $uid;?>_ll"></div>
            </div>
        </div>
    </div>
</div>
<script>
(function(){
var U='<?php echo $uid;?>';
var AV='<?php echo $av;?>';
var WI='<?php echo $wi;?>';
var WM='<?php echo $wm;?>';
var BN='<?php echo $nm;?>';
var CTA_URL='<?php echo esc_js($cta_url);?>';
var CTA_LABEL='<?php echo $cta_label;?>';
var COL='<?php echo $col;?>';
var FQ=<?php echo $jf;?>;
var PR=<?php echo $jp;?>;
var LO=<?php echo $jl;?>;
var H=document.getElementById(U+'_h');
var QL=document.getElementById(U+'_ql');
var RM=document.getElementById(U+'_rm');
var LL=document.getElementById(U+'_ll');
var TY=false;
function tick(){var d=new Date(),e=document.getElementById(U+'_clk');if(e)e.textContent=d.getHours()+':'+d.getMinutes().toString().padStart(2,'0');}
tick();setInterval(tick,10000);
function now(){var d=new Date();return d.getHours()+':'+d.getMinutes().toString().padStart(2,'0');}
function esc(s){return String(s==null?'':s).replace(/[&<>"']/g,function(m){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m];});}
function attr(s){return esc(s).replace(/`/g,'&#096;');}
function track(ev,data){data=data||{};data.event=ev;if(window.dataLayer)window.dataLayer.push(data);if(typeof window.gtag==='function')window.gtag('event',ev,data);}
function enableXDrag(root){
    (root||document).querySelectorAll('.sw-car,.sw-lchips').forEach(function(el){
        if(el.dataset.dragReady)return; el.dataset.dragReady='1';
        var down=false,startX=0,startLeft=0,moved=false;
        function x(e){return e.touches?e.touches[0].clientX:e.clientX;}
        el.addEventListener('pointerdown',function(e){
            if(e.button!==undefined&&e.button!==0)return;
            down=true;moved=false;startX=x(e);startLeft=el.scrollLeft;el.classList.add('dragging');
        });
        el.addEventListener('pointermove',function(e){
            if(!down)return;
            var dx=x(e)-startX;
            if(Math.abs(dx)>3){moved=true;e.preventDefault();el.scrollLeft=startLeft-dx;}
        });
        ['pointerup','pointercancel','pointerleave'].forEach(function(ev){el.addEventListener(ev,function(){down=false;el.classList.remove('dragging');});});
        el.addEventListener('click',function(e){if(moved){e.preventDefault();e.stopPropagation();moved=false;}},true);
    });
}
function sc(){H.scrollTo({top:H.scrollHeight,behavior:'smooth'});}
function add(h){H.insertAdjacentHTML('beforeend',h);enableXDrag(H);sc();}
function ic(n,s,c){return '<span class="material-symbols-rounded" style="font-size:'+(s||18)+'px;color:'+(c||'currentColor')+';vertical-align:middle;">'+n+'</span>';}
function avh(){return AV?'<img src="'+AV+'" alt="'+BN+'">':(ic('support_agent',16,'#aaa'));}
function abbl(ct,rich){
    if(rich) return '<div class="sw-msg sw-msg-a"><div class="sw-bsp"></div><div class="sw-cnt wr"><div class="sw-bbl rich">'+ct+'</div><div class="sw-mt"><span>'+now()+'</span></div></div></div>';
    return '<div class="sw-msg sw-msg-a"><div class="sw-bav">'+avh()+'</div><div class="sw-cnt"><div class="sw-bbl">'+ct+'</div><div class="sw-mt"><span>'+now()+'</span></div></div></div>';
}
function ubbl(t){return '<div class="sw-msg sw-msg-u"><div class="sw-cnt"><div class="sw-bbl">'+t+'</div><div class="sw-mt"><span>read</span><span>'+now()+'</span></div></div><div class="sw-bav">'+ic('person',16,'white')+'</div></div>';}
function typh(){return '<div class="sw-msg sw-msg-a" id="'+U+'_ty"><div class="sw-bav">'+avh()+'</div><div class="sw-cnt"><div class="sw-bbl sw-typ"><div class="sw-d"></div><div class="sw-d"></div><div class="sw-d"></div></div></div></div>';}
function rmty(){var t=document.getElementById(U+'_ty');if(t)t.remove();}
function navBtns(cid){
    var cur=FQ.find(function(f){return f.id===cid;});
    var ids=(cur&&Array.isArray(cur.related))?cur.related:[];
    var oth=ids.map(function(id){return FQ.find(function(f){return f.id===id;});}).filter(Boolean);
    if(!oth.length) oth=FQ.filter(function(f){return f.id!==cid;}).slice(0,3);
    oth=oth.slice(0,3);
    if(!oth.length) return '';
    var h='<div class="sw-nb">';
    oth.forEach(function(f){h+='<button class="sw-nbb" data-scw-faq-id="'+attr(f.id)+'">'+ic(f.icon||'chat',14,'currentColor')+' '+esc(f.label||f.question)+'</button>';});
    return h+'</div>';
}
function prHTML(){
    if(!PR.length) return '<p style="color:#888;font-size:12px;margin:0;">ยังไม่มีโปรโมชั่นครับ</p>';
    var h='<div class="sw-car">';
    PR.forEach(function(p){
        var img=p.image_url?'<img src="'+attr(p.image_url)+'" loading="lazy" alt="'+attr(p.title||'โปรโมชั่น')+'">'
            :'<div class="sw-pph">'+ic('redeem',28)+'</div>';
        h+='<div class="sw-pcard">'+img+'<div class="sw-pb"><div class="sw-pt">'+esc(p.title)+'</div><div class="sw-pd">'+esc(p.description||'')+'</div>'+(p.btn_url?'<a href="'+attr(p.btn_url)+'" target="_blank" class="sw-pcb" data-scw-track="promo" data-scw-id="'+attr(p.id||'')+'" data-scw-title="'+attr(p.title||'')+'">'+esc(p.btn_label||'ดู')+'</a>':'')+'</div></div>';
    });
    return h+'</div>';
}
function locUrl(l){
    if(l.map_url&&(l.map_url.indexOf('/place/')>-1||l.map_url.indexOf('place_id')>-1))return l.map_url;
    if(l.name&&l.lat&&l.lng)return 'https://maps.google.com/?q='+encodeURIComponent(l.name)+'&ll='+l.lat+','+l.lng;
    if(l.name)return 'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(l.name);
    return l.map_url||('https://www.google.com/maps/search/?api=1&query='+encodeURIComponent((l.lat||'')+','+(l.lng||'')));
}
function locIcon(str){var s=(str||'').toLowerCase();if(s==='airport'||s.indexOf('สนามบิน')>-1||s.indexOf('airport')>-1)return 'flight';if(s==='mall'||s.indexOf('ห้าง')>-1||s.indexOf('mall')>-1)return 'shopping_bag';if(s==='office'||s.indexOf('สำนักงาน')>-1||s.indexOf('office')>-1)return 'business';if(s==='agent'||s.indexOf('ตัวแทน')>-1||s.indexOf('travel')>-1||s.indexOf('ทราเวล')>-1)return 'store';return 'location_on';}
function locText(l){return [l.name,l.province,l.hours,l.address,l.note,l.phone].join(' ').toLowerCase();}
function isOpenNow(h){
    if(!h)return null;
    var s=(h||'').toLowerCase();
    if(s.indexOf('24')>-1)return true;
    if(s.indexOf('ปิด')>-1&&s.indexOf('เปิด')===-1)return false;
    var m=s.match(/(\d{1,2}):(\d{2})\s*[-–]\s*(\d{1,2}):(\d{2})/);
    if(!m)return null;
    var now=new Date(),cur=now.getHours()*60+now.getMinutes();
    var op=parseInt(m[1])*60+parseInt(m[2]),cl=parseInt(m[3])*60+parseInt(m[4]);
    if(cl<=op)cl+=24*60;
    return cur>=op&&cur<cl;
}
function openBadge(h){var s=isOpenNow(h);if(s===null)return '';return s?'<span class="sw-open">เปิดอยู่</span>':'<span class="sw-closed">ปิดแล้ว</span>';}
function lcHTML(){
    if(!LO.length) return '<p style="color:#888;font-size:12px;margin:0;">ยังไม่มีข้อมูลสาขาครับ</p>';
    var list=LO.slice(0,3);
    var h='<div class="sw-lcw"><div class="sw-lhint">แนะนำสาขาใกล้คุณ</div>';
    list.forEach(function(l){
        var url=locUrl(l), addr=l.address||l.note||'';
        h+='<div class="sw-lcc" onclick="window.open(\''+attr(url)+'\',\'_blank\')" style="cursor:pointer;" data-scw-track="location" data-scw-id="'+attr(l.id||'')+'" data-scw-title="'+attr(l.name||'')+'">'
          +(l.image_url?'<img src="'+attr(l.image_url)+'" class="sw-lcc-img" loading="lazy" alt="'+attr(l.name||'')+'">'
                      :'<div class="sw-lcc-ic">'+ic(locIcon(l.category),18,'#fff')+'</div>')
          +'<div class="sw-lcc-inf"><div class="sw-lcc-n">'+esc(l.name)+openBadge(l.hours)+'</div>'
          +'<div class="sw-lcc-h">'+ic('schedule',11,'#aaa')+' '+esc(l.hours||'')+'</div>'
          +(addr?'<div class="sw-lcc-addr">'+ic('place',10,'#aaa')+' '+esc(addr)+'</div>':'')+'</div>'
          +(l.phone?'<a href="tel:'+attr(l.phone)+'" class="sw-lcall" onclick="event.stopPropagation()" title="โทร '+esc(l.phone)+'">'+ic('call',16,'#fff')+'</a>'
                  :'<div class="sw-lcc-ct">'+ic('navigation',13)+' นำทาง</div>')
          +'</div>';
    });
    if(LO.length>3) h+='<button type="button" class="sw-lall" data-scw-show-locations="1">ดูสาขาทั้งหมด ('+LO.length+' สาขา) ›</button>';
    return h+'</div>';
}
var _mapInst={},_mapLayers={};
function _mapAddMarkers(mapId,locs){
    var layer=_mapLayers[mapId]; if(!layer)return;
    layer.clearLayers();
    var svgPin='<svg xmlns="http://www.w3.org/2000/svg" width="28" height="36" viewBox="0 0 28 36"><path d="M14 0C6.27 0 0 6.27 0 14c0 10.5 14 22 14 22S28 24.5 28 14C28 6.27 21.73 0 14 0z" fill="'+COL+'"/><circle cx="14" cy="14" r="6" fill="#fff"/></svg>';
    var icon=L.divIcon({html:svgPin,className:'',iconSize:[28,36],iconAnchor:[14,36],popupAnchor:[0,-34]});
    var bounds=[];
    locs.forEach(function(l){
        if(!l.lat||!l.lng)return;
        var lat=parseFloat(l.lat),lng=parseFloat(l.lng);
        if(isNaN(lat)||isNaN(lng))return;
        var url=locUrl(l);
        var popup='<div style="font-family:Prompt,sans-serif;font-size:12px;min-width:140px;"><strong style="font-size:13px;color:#1f2937;display:block;margin-bottom:4px;">'+esc(l.name)+'</strong>'+(l.hours?'<span style="color:#777;font-size:11px;">'+esc(l.hours)+'</span><br>':'')+'<a href="'+attr(url)+'" target="_blank" style="display:inline-block;margin-top:6px;padding:4px 12px;background:'+COL+';color:#fff;border-radius:999px;font-size:11px;font-weight:600;text-decoration:none;">นำทาง</a></div>';
        L.marker([lat,lng],{icon:icon}).addTo(layer).bindPopup(popup);
        bounds.push([lat,lng]);
    });
    var m=_mapInst[mapId];
    if(bounds.length===1)m.setView(bounds[0],15);
    else if(bounds.length>1)m.fitBounds(bounds,{padding:[30,30]});
    else m.setView([13.7563,100.5018],11);
}
function initLocMap(el,mapId,locs){
    if(!el)return;
    var pts=locs||LO;
    if(_mapInst[mapId]){_mapInst[mapId].invalidateSize();_mapAddMarkers(mapId,pts);return;}
    if(typeof L==='undefined'){setTimeout(function(){initLocMap(el,mapId,pts);},300);return;}
    var m=L.map(el,{zoomControl:true,scrollWheelZoom:false});
    _mapInst[mapId]=m;
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{attribution:'&copy; OpenStreetMap &copy; CartoDB',maxZoom:19}).addTo(m);
    _mapLayers[mapId]=L.layerGroup().addTo(m);
    _mapAddMarkers(mapId,pts);
}
function buildSidebarLoc(){
    if(!LL||LL.dataset.built) return; LL.dataset.built='1';
    var groups={};
    LO.forEach(function(l){var pv=l.province||'อื่นๆ';(groups[pv]=groups[pv]||[]).push(l);});
    var keys=Object.keys(groups);
    var chips='<button type="button" class="sw-lchip active" data-lfilter="all">ทั้งหมด <b>'+LO.length+'</b></button>';
    keys.forEach(function(k){chips+='<button type="button" class="sw-lchip" data-lfilter="'+attr(k)+'">'+esc(k)+' <b>'+groups[k].length+'</b></button>';});
    var hTools='<div class="sw-ltools"><div class="sw-lsum"><strong>'+ic('location_on',16,'var(--p)')+' ค้นหาสาขา</strong><span>'+LO.length+' สาขา</span></div>'
        +'<label class="sw-lsearch">'+ic('search',19)+'<input type="search" id="'+U+'_ls" placeholder="ค้นหาสาขา เช่น สุวรรณภูมิ, ลาดพร้าว, เชียงใหม่..."></label>'
        +'<div class="sw-lchips">'+chips+'</div></div>';
    var h='<div id="'+U+'_lbody" style="display:flex;flex-direction:column;gap:12px;">';
    keys.forEach(function(pv){
        h+='<section class="sw-lgrp" data-group="'+attr(pv)+'"><button type="button" class="sw-lgh">'
          +'<span class="sw-lgic">'+ic(locIcon(pv),19,'#fff')+'</span><span class="sw-lgt2">'+esc(pv)+'</span><span class="sw-lgc">'+groups[pv].length+' สาขา</span><span class="sw-lchev">'+ic('expand_more',18,'#777')+'</span></button><div class="sw-lbody">';
        groups[pv].forEach(function(l,i){
            var url=locUrl(l), addr=l.address||l.note||'';
            h+='<div class="sw-lrow" onclick="window.open(\''+attr(url)+'\',\'_blank\')" style="cursor:pointer;" data-loc-row="1" data-group="'+attr(pv)+'" data-search="'+attr(locText(l))+'" data-scw-track="location" data-scw-id="'+attr(l.id||'')+'" data-scw-title="'+attr(l.name||'')+'">'
              +(l.image_url?'<img src="'+attr(l.image_url)+'" class="sw-lri-img" loading="lazy" alt="'+attr(l.name||'')+'">'
                           :'<div class="sw-lri">'+ic(locIcon(l.category||pv),20,'#fff')+'</div>')
              +'<div style="min-width:0;"><div class="sw-lrn">'+esc(l.name)+openBadge(l.hours)+'</div>'
              +'<div class="sw-lrm"><span>'+ic('schedule',13,'#9ca3af')+esc(l.hours||'-')+'</span>'+(addr?'<span>'+ic('place',13,'#9ca3af')+esc(addr)+'</span>':'')+'</div></div>'
              +'<div style="display:flex;gap:6px;align-items:center;flex-shrink:0;">'
              +(l.phone?'<a href="tel:'+attr(l.phone)+'" class="sw-lcall" onclick="event.stopPropagation()" title="โทร '+esc(l.phone)+'">'+ic('call',15,'#fff')+'</a>':'')
              +'<span class="sw-lgo">'+ic('navigation',15,'#fff')+'นำทาง</span></div></div>';
        });
        h+='</div></section>';
    });
    h+='</div><div class="sw-lnone" id="'+U+'_lnone" style="display:none;">ไม่พบสาขาที่ค้นหา</div>';
    LL.innerHTML=hTools
      +'<div class="sw-loctabs"><button type="button" class="sw-loctab active" data-loctab="list">'+ic('list',15)+' รายการ</button><button type="button" class="sw-loctab" data-loctab="map">'+ic('map',15)+' แผนที่</button></div>'
      +'<div id="'+U+'_lllist" style="display:flex;flex-direction:column;flex:1;overflow-y:auto;min-height:0;">'+h+'</div>'
      +'<div id="'+U+'_llmap" class="sw-locmap" style="display:none;"></div>';
    LL.style.overflow='hidden';
    enableXDrag(LL);
    var activeFilter='all', search='';
    function llFiltered(){return activeFilter==='all'?LO:LO.filter(function(l){return (l.province||'อื่นๆ')===activeFilter;});}
    LL.querySelectorAll('.sw-loctab').forEach(function(tab){tab.addEventListener('click',function(){
        var t=this.dataset.loctab;
        LL.querySelectorAll('.sw-loctab').forEach(function(x){x.classList.toggle('active',x===tab);});
        var llList=document.getElementById(U+'_lllist'),llMap=document.getElementById(U+'_llmap');
        if(t==='map'){llList.style.display='none';llMap.style.display='flex';requestAnimationFrame(function(){initLocMap(llMap,U+'_llmap',llFiltered());});}
        else{llList.style.display='flex';llMap.style.display='none';}
    });});
    function applyLocFilter(){
        var visibleGroups=0, visibleRows=0;
        LL.querySelectorAll('.sw-lgrp').forEach(function(g){
            var group=g.dataset.group, gv=0;
            g.querySelectorAll('[data-loc-row]').forEach(function(r){
                var okFilter=(activeFilter==='all'||r.dataset.group===activeFilter);
                var okSearch=(!search||r.dataset.search.indexOf(search)>-1);
                var ok=okFilter&&okSearch;
                r.style.display=ok?'grid':'none'; if(ok){gv++;visibleRows++;}
            });
            g.style.display=gv?'block':'none'; if(gv)visibleGroups++;
            var c=g.querySelector('.sw-lgc'); if(c)c.textContent=gv+' สาขา';
        });
        var none=document.getElementById(U+'_lnone'); if(none) none.style.display=visibleRows?'none':'block';
    }
    LL.querySelectorAll('.sw-lchip').forEach(function(ch){ch.addEventListener('click',function(){
        activeFilter=this.dataset.lfilter||'all';
        LL.querySelectorAll('.sw-lchip').forEach(function(x){x.classList.toggle('active',x===ch);});
        applyLocFilter();
        var llMap=document.getElementById(U+'_llmap');
        if(llMap&&llMap.style.display!=='none')_mapAddMarkers(U+'_llmap',llFiltered());
    });});
    var ls=document.getElementById(U+'_ls'); if(ls){ls.addEventListener('input',function(){search=this.value.trim().toLowerCase();applyLocFilter();});}
    LL.querySelectorAll('.sw-lgh').forEach(function(btn){btn.addEventListener('click',function(){this.closest('.sw-lgrp').classList.toggle('closed');});});
}
function showLocPanel(){
    buildSidebarLoc();
    document.getElementById(U+'_pf').classList.remove('on');
    document.getElementById(U+'_pl').classList.add('on');
    var t=document.getElementById(U+'_st'); if(t) t.innerHTML='<span style="color:var(--p)">สาขา</span>ทั้งหมด <small style="font-size:11px;color:#777;font-weight:500;margin-left:6px;">'+LO.length+' สาขา</small>';
    var s=document.getElementById(U+'_ss'); if(s) s.textContent='ค้นหา / เลือกกลุ่มสาขา แล้วกดนำทางเพื่อเปิด Google Maps';
    var b=document.getElementById(U+'_bk'); if(b) b.style.display='flex';
}
window[U+'_back']=function(){
    document.getElementById(U+'_pl').classList.remove('on');
    document.getElementById(U+'_pf').classList.add('on');
    var t=document.getElementById(U+'_st'); if(t) t.innerHTML='คำถาม<span style="color:var(--p)">ที่พบบ่อย</span>';
    var s=document.getElementById(U+'_ss'); if(s) s.textContent='แตะเพื่อดูคำตอบในแชทได้เลยครับ';
    var b=document.getElementById(U+'_bk'); if(b) b.style.display='none';
};
function buildSheet(){
    if(document.getElementById(U+'_bsov'))return;
    var bsOv=document.createElement('div');
    bsOv.id=U+'_bsov'; bsOv.className='sw-sheet-ov';
    var bsEl=document.createElement('div');
    bsEl.id=U+'_bsel'; bsEl.className='sw-sheet';
    bsEl.style.setProperty('--p',COL);
    var groups={};
    LO.forEach(function(l){var pv=l.province||'อื่นๆ';(groups[pv]=groups[pv]||[]).push(l);});
    var keys=Object.keys(groups);
    var chipsH='<button class="sw-lchip active" data-bsf="all">ทั้งหมด <b>'+LO.length+'</b></button>';
    keys.forEach(function(k){chipsH+='<button class="sw-lchip" data-bsf="'+attr(k)+'">'+esc(k)+' <b>'+groups[k].length+'</b></button>';});
    bsEl.innerHTML='<div class="sw-sheet-drag"></div>'
      +'<div class="sw-sheet-hd"><h4>'+ic('location_on',17,'var(--p)')+' ค้นหาสาขา <small style="font-weight:400;font-size:11px;color:#999;margin-left:4px;">'+LO.length+' สาขา</small></h4>'
      +'<div class="sw-sheet-srch">'+ic('search',18)+'<input type="search" id="'+U+'_bss" placeholder="เช่น สุวรรณภูมิ, เชียงใหม่..."></div>'
      +'<div class="sw-sheet-chips" id="'+U+'_bsc" style="border-bottom:0;">'+chipsH+'</div>'
      +'<div class="sw-loctabs" style="margin:0 -18px;padding:0 18px;"><button type="button" class="sw-loctab active" data-bstab="list">'+ic('list',15)+' รายการ</button><button type="button" class="sw-loctab" data-bstab="map">'+ic('map',15)+' แผนที่</button></div></div>'
      +'<div class="sw-sheet-body" id="'+U+'_bsb"></div>'
      +'<div id="'+U+'_bsmap" style="display:none;flex:1;min-height:55dvh;overflow:hidden;border-radius:0 0 24px 24px;"></div>';
    bsOv.appendChild(bsEl);
    document.body.appendChild(bsOv);
    var bsBody=document.getElementById(U+'_bsb');
    var rowsH='';
    keys.forEach(function(pv){
        rowsH+='<div class="sw-sheet-gtitle" data-bsgrptitle="'+attr(pv)+'">'+ic(locIcon(pv),14,'#bbb')+esc(pv)+'</div>';
        groups[pv].forEach(function(l){
            var url=locUrl(l), addr=l.address||l.note||'';
            rowsH+='<div class="sw-lcc" onclick="window.open(\''+attr(url)+'\',\'_blank\')" style="cursor:pointer;" data-bsrow="1" data-bsgrp="'+attr(pv)+'" data-bssearch="'+attr(locText(l))+'" data-scw-track="location" data-scw-id="'+attr(l.id||'')+'" data-scw-title="'+attr(l.name||'')+'">'
              +(l.image_url?'<img src="'+attr(l.image_url)+'" class="sw-lcc-img" loading="lazy" alt="'+attr(l.name||'')+'">'
                           :'<div class="sw-lcc-ic">'+ic(locIcon(l.category||pv),18,'#fff')+'</div>')
              +'<div class="sw-lcc-inf"><div class="sw-lcc-n">'+esc(l.name)+openBadge(l.hours)+'</div>'
              +'<div class="sw-lcc-h">'+ic('schedule',11,'#aaa')+' '+esc(l.hours||'')+'</div>'
              +(addr?'<div class="sw-lcc-addr">'+ic('place',10,'#aaa')+' '+esc(addr)+'</div>':'')+'</div>'
              +(l.phone?'<a href="tel:'+attr(l.phone)+'" class="sw-lcall" onclick="event.stopPropagation()" title="โทร '+esc(l.phone)+'">'+ic('call',15,'#fff')+'</a>'
                      :'<div class="sw-lcc-ct">'+ic('navigation',13)+' นำทาง</div>')
              +'</div>';
        });
    });
    bsBody.innerHTML=rowsH+'<div class="sw-sheet-none" id="'+U+'_bsnone" style="display:none;">ไม่พบสาขาที่ค้นหา</div>';
    var activeFilter='all',searchQ='';
    function bsFiltered(){return activeFilter==='all'?LO:LO.filter(function(l){return (l.province||'อื่นๆ')===activeFilter;});}
    function applyBsFilter(){
        var shown=0,grpVis={};
        bsOv.querySelectorAll('[data-bsrow]').forEach(function(r){
            var ok=(activeFilter==='all'||r.dataset.bsgrp===activeFilter)&&(!searchQ||r.dataset.bssearch.indexOf(searchQ)>-1);
            r.style.display=ok?'grid':'none'; if(ok){shown++;grpVis[r.dataset.bsgrp]=true;}
        });
        bsOv.querySelectorAll('[data-bsgrptitle]').forEach(function(g){g.style.display=grpVis[g.dataset.bsgrptitle]?'flex':'none';});
        var none=document.getElementById(U+'_bsnone'); if(none)none.style.display=shown?'none':'block';
    }
    var bsc=document.getElementById(U+'_bsc');
    if(bsc)bsc.querySelectorAll('.sw-lchip').forEach(function(ch){ch.addEventListener('click',function(){
        activeFilter=this.dataset.bsf||'all';
        bsc.querySelectorAll('.sw-lchip').forEach(function(x){x.classList.toggle('active',x===ch);});
        applyBsFilter();
        var bsMap=document.getElementById(U+'_bsmap');
        if(bsMap&&bsMap.style.display!=='none')_mapAddMarkers(U+'_bsmap',bsFiltered());
    });});
    var bss=document.getElementById(U+'_bss');
    if(bss)bss.addEventListener('input',function(){searchQ=this.value.trim().toLowerCase();applyBsFilter();});
    enableXDrag(bsOv);
    var drag=bsEl.querySelector('.sw-sheet-drag'),startY=0,isDragging=false;
    if(drag){
        drag.addEventListener('touchstart',function(e){startY=e.touches[0].clientY;isDragging=true;},{passive:true});
        window.addEventListener('touchmove',function(e){if(!isDragging)return;var dy=e.touches[0].clientY-startY;if(dy>0){bsEl.style.transition='none';bsEl.style.transform='translateY('+dy+'px)';}},{passive:true});
        window.addEventListener('touchend',function(e){if(!isDragging)return;isDragging=false;var dy=e.changedTouches[0].clientY-startY;bsEl.style.transition='';bsEl.style.transform='';if(dy>80)closeSheet();});
    }
    bsEl.querySelectorAll('[data-bstab]').forEach(function(tab){tab.addEventListener('click',function(){
        var t=this.dataset.bstab;
        bsEl.querySelectorAll('[data-bstab]').forEach(function(x){x.classList.toggle('active',x===tab);});
        var bsBody=document.getElementById(U+'_bsb'),bsMap=document.getElementById(U+'_bsmap');
        if(t==='map'){bsBody.style.display='none';bsMap.style.display='flex';requestAnimationFrame(function(){initLocMap(bsMap,U+'_bsmap',bsFiltered());});}
        else{bsBody.style.display='';bsMap.style.display='none';}
    });});
    bsOv.addEventListener('click',function(e){if(e.target===bsOv)closeSheet();});
}
function openSheet(){
    buildSheet();
    requestAnimationFrame(function(){
        var ov=document.getElementById(U+'_bsov'),sh=document.getElementById(U+'_bsel');
        if(!ov||!sh)return;
        ov.classList.add('open');
        requestAnimationFrame(function(){sh.classList.add('open');});
    });
    document.body.style.overflow='hidden';
}
function closeSheet(){
    var ov=document.getElementById(U+'_bsov'),sh=document.getElementById(U+'_bsel');
    if(!sh)return;
    sh.classList.remove('open'); document.body.style.overflow='';
    setTimeout(function(){if(ov)ov.classList.remove('open');},380);
}
function doClick(fid){
    if(TY) return;
    var faq=null;
    for(var i=0;i<FQ.length;i++){if(FQ[i].id===fid){faq=FQ[i];break;}}
    if(!faq) return;
    TY=true;
    setActive(fid);
    track('samurai_chat_faq_click',{faq_id:faq.id,faq_label:faq.label||faq.question,faq_type:faq.type||'text'});
    if(faq.type==='location') showLocPanel();
    H.innerHTML=''; welcome(false); add(ubbl(esc(faq.question)));
    setTimeout(function(){
        add(typh());
        var msgs=[];
        if(faq.type==='promo'){if(faq.answer)msgs.push({t:faq.answer,r:false});msgs.push({t:prHTML(),r:true});}
        else if(faq.type==='location'){if(faq.answer)msgs.push({t:faq.answer,r:false});msgs.push({t:lcHTML(),r:true});}
        else{var tx=faq.answer||'';if(faq.btn_label&&faq.btn_url)tx+=' <a href="'+attr(faq.btn_url)+'" target="_blank" class="sw-ib">'+esc(faq.btn_label)+'</a>'; if(CTA_URL)tx+=' <a href="'+attr(CTA_URL)+'" target="_blank" class="sw-ib" data-scw-track="cta" data-scw-source="answer" data-scw-id="'+attr(faq.id)+'">'+esc(CTA_LABEL||'แชทกับแอดมิน')+'</a>';msgs.push({t:tx,r:false});}
        setTimeout(function(){
            rmty();
            msgs.forEach(function(m,i){
                setTimeout(function(){
                    add(abbl(m.t,m.r));
                    if(i===msgs.length-1){var nb=navBtns(faq.id);if(nb)add(abbl(nb,false));TY=false;}
                },i*650);
            });
        },950);
    },350);
}
window[U+'_click']=doClick;
function welcome(delay){
    var t=now(), av=avh();
    var m1=WI?'<div class="sw-msg sw-msg-a"><div class="sw-bav">'+av+'</div><div class="sw-cnt wr"><div class="sw-bbl rich"><img src="'+WI+'" style="width:160px;max-width:100%;border-radius:10px;display:block;"></div><div class="sw-mt"><span>'+t+'</span></div></div></div>':'';
    var cta=CTA_URL?' <a href="'+attr(CTA_URL)+'" target="_blank" class="sw-ib" data-scw-track="cta" data-scw-source="welcome">'+esc(CTA_LABEL||'แชทกับแอดมิน')+'</a>':'';
    var m2='<div class="sw-msg sw-msg-a" style="margin-top:-4px;"><div class="sw-bsp"></div><div class="sw-cnt"><div class="sw-bbl" style="border-top-left-radius:3px;">'+WM+cta+'</div><div class="sw-mt"><span>'+t+'</span></div></div></div>';
    if(delay){if(m1)add(m1);setTimeout(function(){add(m2);},m1?500:0);}
    else{if(m1)H.insertAdjacentHTML('beforeend',m1);H.insertAdjacentHTML('beforeend',m2);}
}
var miItems=[];
FQ.forEach(function(faq,i){
    var ico=faq.icon||'chat';
    var btn=document.createElement('button');
    btn.className='sw-qb'; btn.style.animationDelay=(i*.08)+'s'; btn.dataset.fid=faq.id; btn.dataset.cat=faq.category||''; btn.dataset.search=[faq.label,faq.question,faq.answer,faq.category].join(' ').toLowerCase();
    btn.innerHTML='<span class="material-symbols-rounded">'+esc(ico)+'</span><span style="flex:1;"><span>'+esc(faq.label||faq.question)+'</span>'+(faq.category?'<small style="display:block;color:inherit;opacity:.55;font-size:10px;margin-top:1px;">'+esc(faq.category)+'</small>':'')+'</span><span class="sw-qa">&#x203A;</span>';
    btn.addEventListener('click',function(){doClick(faq.id);});
    QL.appendChild(btn);
    var mi=document.createElement('div'); mi.className='sw-mi'; mi.dataset.fid=faq.id; mi.dataset.search=[faq.label,faq.question,faq.category].join(' ').toLowerCase();
    mi.innerHTML='<span class="material-symbols-rounded">'+esc(ico)+'</span><span class="sw-ml">'+esc(faq.label||'')+'</span>';
    mi.addEventListener('click',function(){doClick(faq.id);});
    miItems.push(mi);
});
(function(){
    var cols=4,rows=2,perPage=cols*rows;
    var pages=Math.ceil(miItems.length/perPage)||1;
    var track=document.createElement('div'); track.className='sw-rm-track'; track.id=U+'_rmt';
    for(var p=0;p<pages;p++){
        var pg=document.createElement('div'); pg.className='sw-rm-page';
        pg.style.gridTemplateColumns='repeat('+cols+',1fr)';
        for(var j=p*perPage,end=Math.min((p+1)*perPage,miItems.length);j<end;j++) pg.appendChild(miItems[j]);
        track.appendChild(pg);
    }
    RM.appendChild(track);
    var dotsEl=null;
    if(pages>1){
        dotsEl=document.createElement('div'); dotsEl.className='sw-rm-dots';
        for(var d=0;d<pages;d++){var dt=document.createElement('div');dt.className='sw-rm-dot'+(d===0?' active':'');dotsEl.appendChild(dt);}
        RM.appendChild(dotsEl);
    }
    var cur=0;
    function goPage(n){
        cur=Math.max(0,Math.min(pages-1,n));
        track.style.transform='translateX(-'+(cur*100)+'%)';
        if(dotsEl)dotsEl.querySelectorAll('.sw-rm-dot').forEach(function(d,i){d.classList.toggle('active',i===cur);});
    }
    var sx=0,dragging=false;
    track.addEventListener('touchstart',function(e){sx=e.touches[0].clientX;dragging=true;},{passive:true});
    track.addEventListener('touchmove',function(e){if(!dragging)return;track.style.transition='none';track.style.transform='translateX(calc(-'+(cur*100)+'% + '+(e.touches[0].clientX-sx)+'px))';},{passive:true});
    track.addEventListener('touchend',function(e){if(!dragging)return;dragging=false;track.style.transition='';var dx=e.changedTouches[0].clientX-sx;if(Math.abs(dx)>40)goPage(cur+(dx<0?1:-1));else goPage(cur);});
    var psx=0,pd=false,pmv=false;
    track.addEventListener('pointerdown',function(e){if(e.button!==0)return;psx=e.clientX;pd=true;pmv=false;track.setPointerCapture(e.pointerId);});
    track.addEventListener('pointermove',function(e){if(!pd)return;var dx=e.clientX-psx;if(Math.abs(dx)>5){pmv=true;track.style.transition='none';track.style.transform='translateX(calc(-'+(cur*100)+'% + '+dx+'px))';}});
    track.addEventListener('pointerup',function(e){if(!pd)return;pd=false;track.style.transition='';if(pmv){var dx=e.clientX-psx;if(Math.abs(dx)>40)goPage(cur+(dx<0?1:-1));else goPage(cur);}});
})();
function setActive(fid){
    document.querySelectorAll('#'+U+'_ql .sw-qb,#'+U+'_rm .sw-mi').forEach(function(el){el.classList.toggle('active',el.dataset.fid===fid);});
}
var QS=document.getElementById(U+'_qs');
var FC=document.getElementById(U+'_fc');
var activeChip='all';
function applyFaqFilter(){
    var q=QS?QS.value.trim().toLowerCase():'', shown=0;
    document.querySelectorAll('#'+U+'_ql .sw-qb').forEach(function(btn){
        var ok=(activeChip==='all'||btn.dataset.cat===activeChip)&&(!q||btn.dataset.search.indexOf(q)>-1);
        btn.style.display=ok?'flex':'none'; if(ok)shown++;
    });
    var old=document.getElementById(U+'_empty'); if(old)old.remove();
    if(!shown)QL.insertAdjacentHTML('beforeend','<div class="sw-empty" id="'+U+'_empty">ไม่พบคำถามที่ค้นหา</div>');
}
if(QS)QS.addEventListener('input',applyFaqFilter);
var RS=document.getElementById(U+'_rs');
if(RS)RS.addEventListener('input',function(){
    var q=this.value.trim().toLowerCase();
    var track=document.getElementById(U+'_rmt');
    var dots=RM.querySelector('.sw-rm-dots');
    var flat=document.getElementById(U+'_rmf');
    if(q){
        if(track)track.style.display='none';
        if(dots)dots.style.display='none';
        if(!flat){flat=document.createElement('div');flat.id=U+'_rmf';flat.className='sw-rm-flat';flat.style.gridTemplateColumns='repeat(4,1fr)';RM.appendChild(flat);}
        flat.style.display='grid';flat.innerHTML='';
        miItems.forEach(function(mi){if(mi.dataset.search.indexOf(q)>-1){var cl=mi.cloneNode(true);cl.addEventListener('click',function(){doClick(mi.dataset.fid);});flat.appendChild(cl);}});
    } else {
        if(track)track.style.display='';
        if(dots)dots.style.display='';
        if(flat)flat.style.display='none';
    }
});
if(FC){
    var cats=[]; FQ.forEach(function(f){if(f.category&&cats.indexOf(f.category)===-1)cats.push(f.category);});
    if(cats.length>=1){
        var ch='<button class="sw-fchip active" data-fcat="all">ทั้งหมด</button>';
        cats.forEach(function(c){ch+='<button class="sw-fchip" data-fcat="'+attr(c)+'">'+esc(c)+'</button>';});
        FC.innerHTML=ch;
        FC.querySelectorAll('.sw-fchip').forEach(function(el){el.addEventListener('click',function(){
            activeChip=this.dataset.fcat;
            FC.querySelectorAll('.sw-fchip').forEach(function(x){x.classList.toggle('active',x===el);});
            applyFaqFilter();
        });});
    }
}
window[U+'_reset']=function(){
    H.innerHTML=''; TY=false;
    document.querySelectorAll('#'+U+'_ql .sw-qb,#'+U+'_rm .sw-mi').forEach(function(el){el.classList.remove('active');});
    document.getElementById(U+'_pl').classList.remove('on');
    document.getElementById(U+'_pf').classList.add('on');
    var t=document.getElementById(U+'_st'); if(t)t.innerHTML='คำถาม<span style="color:var(--p)">ที่พบบ่อย</span>';
    var s=document.getElementById(U+'_ss'); if(s)s.textContent='แตะเพื่อดูคำตอบในแชทได้เลยครับ';
    var b=document.getElementById(U+'_bk'); if(b)b.style.display='none';
    activeChip='all';
    if(FC)FC.querySelectorAll('.sw-fchip').forEach(function(el){el.classList.toggle('active',el.dataset.fcat==='all');});
    if(QS)QS.value='';
    applyFaqFilter();
    welcome(true);
};
window[U+'_track']=track;
document.getElementById(U).addEventListener('click',function(e){
    var qb=e.target.closest&&e.target.closest('[data-scw-faq-id]');
    if(qb){doClick(qb.dataset.scwFaqId);return;}
    var sl=e.target.closest&&e.target.closest('[data-scw-show-locations]');
    if(sl){
        if(window.innerWidth>860){showLocPanel();}
        else{openSheet();}
        return;
    }
    var a=e.target.closest&&e.target.closest('[data-scw-track]');
    if(!a) return;
    var kind=a.dataset.scwTrack;
    if(kind==='promo') track('samurai_chat_promo_click',{promo_id:a.dataset.scwId||'',promo_title:a.dataset.scwTitle||''});
    else if(kind==='location') track('samurai_chat_location_click',{location_id:a.dataset.scwId||'',location_name:a.dataset.scwTitle||''});
    else if(kind==='cta') track('samurai_chat_cta_click',{source:a.dataset.scwSource||'',item_id:a.dataset.scwId||''});
});
var started=false;
var obs=new IntersectionObserver(function(en){en.forEach(function(e){if(e.isIntersecting&&!started){started=true;document.getElementById(U).classList.add('vis');setTimeout(function(){welcome(true);},450);}});},{threshold:.08});
obs.observe(document.getElementById(U));
})();
</script>
<?php
    return ob_get_clean();
}