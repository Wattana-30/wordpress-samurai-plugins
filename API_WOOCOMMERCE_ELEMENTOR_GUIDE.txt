================================================================================
  WOOCOMMERCE + ELEMENTOR API INTEGRATION GUIDE
  สำหรับสร้าง Custom Dashboard ด้วย WC + Elementor
================================================================================

## 1. WOOCOMMERCE REST API - ENDPOINTS ที่ใช้บ่อย

### 1.1 ดึงข้อมูล Orders ของผู้ใช้ปัจจุบัน
GET /wp-json/wc/v3/orders
  Parameters:
    - customer: <user_id>
    - per_page: 10
    - orderby: date
    - order: desc
  Response: Array ของ order objects

  Code Example (PHP):
  ```php
  $user_id = get_current_user_id();
  $orders = wc_get_orders(['customer_id' => $user_id, 'limit' => 10]);
  foreach($orders as $order) {
    echo 'Order #' . $order->get_id();
    echo 'Status: ' . $order->get_status();
    echo 'Total: ' . $order->get_total();
  }
  ```

### 1.2 ดึง Single Order Details
GET /wp-json/wc/v3/orders/<order_id>
  Contains:
    - id, order_number, date_created
    - status, total, subtotal
    - items[], shipping_address, billing_address
    - line_items[] (สินค้าในออเดอร์)
    - order_item_totals (ยอด tax, shipping, etc.)

### 1.3 ดึงข้อมูล Addresses ของผู้ใช้
  Code (PHP):
  ```php
  $user_id = get_current_user_id();
  $billing_address = get_user_meta($user_id, 'billing_address_1', true);
  $shipping_address = get_user_meta($user_id, 'shipping_address_1', true);
  $formatted_billing = WC()->countries->get_address_fields()
  ```

### 1.4 ดึง Account Details (Email, Phone, First Name)
  Code (PHP):
  ```php
  $user = wp_get_current_user();
  echo $user->user_email;
  echo $user->first_name;
  echo $user->display_name;
  echo get_user_meta($user->ID, 'billing_phone', true);
  ```

### 1.5 ดึง Payment Methods
  Code (PHP):
  ```php
  $payment_methods = get_user_meta(get_current_user_id(), 'woocommerce_payment_method', true);
  // หรือใช้ WC Template
  wc_get_template('myaccount/payment-methods.php');
  ```

================================================================================

## 2. ELEMENTOR API & INTEGRATION

### 2.1 Elementor Render ใน PHP
  Code:
  ```php
  // ถ้า post/page ถูก edit ด้วย Elementor
  echo \Elementor\Plugin::instance()->frontend->get_builder_content($post_id);
  ```

### 2.2 Elementor Dynamic Tags ใช้เพื่ออยากทำ dynamic content
  - {user.id} - UID
  - {user.email} - Email
  - {user.first_name} - ชื่อ
  - {user.meta_key} - Custom meta

### 2.3 Elementor Widget - Custom Development
  ต้องสร้าง class extend \Elementor\Widget_Base

================================================================================

## 3. SHORTCODES - CUSTOM HOOKS & FILTERS

### 3.1 สร้าง Shortcode พื้นฐาน
  ```php
  add_shortcode('my_dashboard', function() {
    if(!is_user_logged_in()) return '<p>Please login</p>';

    ob_start();
    // HTML content here
    return ob_get_clean();
  });
  ```

### 3.2 ใช้ WC Hooks/Filters สำหรับดึง Dynamic Data
  ```php
  do_action('woocommerce_after_my_account'); // Hook points
  apply_filters('woocommerce_my_account_my_orders_actions', $actions);
  ```

### 3.3 AJAX for Dynamic Content (ถ้าต้อง load async)
  ```php
  add_action('wp_ajax_get_order_details', 'get_order_details_callback');
  function get_order_details_callback() {
    check_ajax_referer('nonce_name');
    $order_id = $_POST['order_id'];
    $order = wc_get_order($order_id);
    wp_send_json_success(['data' => $order->get_data()]);
  }
  ```

================================================================================

## 4. ELEMENTOR + WOO INTEGRATION HOOKS

### 4.1 Elementor-specific Hooks
  - elementor/controls/controls_registered - Register custom controls
  - elementor/widgets/widgets_registered - Register widgets
  - elementor/frontend/before_render - Before widget render

### 4.2 WooCommerce Hooks
  - woocommerce_after_my_account
  - woocommerce_account_orders_columns
  - woocommerce_my_account_my_orders_actions
  - woocommerce_account_{endpoint} - For custom endpoints

### 4.3 Authentication
  ```php
  if(!is_user_logged_in()) {
    wp_safe_remote_post(wp_login_url()); // Redirect to login
  }
  ```

================================================================================

## 5. BEST PRACTICES

### 5.1 Security
  ✓ Always check nonce: check_ajax_referer('action_name', 'security')
  ✓ Always check permissions: current_user_can('manage_woocommerce')
  ✓ Always sanitize: sanitize_text_field(), absint()
  ✓ Always escape: esc_html(), esc_attr(), esc_url()

### 5.2 Performance
  ✓ Cache orders: wp_cache_get() / wp_cache_set()
  ✓ Limit results: 'limit' => 10 ในเวลา query
  ✓ Use transients: set_transient('key', $data, HOUR_IN_SECONDS)

### 5.3 Code Structure
  ✓ Separate concerns: Helpers, AJAX, Shortcodes
  ✓ Use object-oriented: Create classes for complex logic
  ✓ DRY: Don't repeat code

### 5.4 Testing
  ✓ Test with/without login
  ✓ Test on mobile (CSS media queries)
  ✓ Check console errors (F12)
  ✓ Verify all shortcodes render

================================================================================

## 6. COMMON WC FUNCTIONS REFERENCE

  wc_get_orders($args) - Get orders
  wc_get_order($order_id) - Get single order
  wc_get_order_statuses() - Get available statuses
  WC()->cart->get_cart() - Get cart items
  WC()->cart->get_total() - Get cart total
  WC()->countries->get_address_fields() - Get address fields
  wc_get_account_orders_actions($order) - Get order actions (view, download, etc)
  get_current_user_id() - Get logged-in user ID
  is_user_logged_in() - Check if user logged in
  wp_get_current_user() - Get user object

================================================================================

## 7. STRUCTURE FOR NEW DASHBOARD

Recommended file structure:
  - profile-main.php (main render shortcode [modern_dashboard])
    - Handles: Is user logged in?
    - Calls: Helper functions + Shortcodes
    - Enqueues: CSS, JS, jQuery

  - profile-helpers.php (helper functions)
    - get_user_orders()
    - get_user_addresses()
    - format_order_data()

  - profile-ajax.php (AJAX handlers)
    - get_order_details_callback()
    - update_address_callback()

  - profile-styles.css (all CSS)
  - profile-scripts.js (all JavaScript - Vanilla JS preferred)

================================================================================

## 8. EXAMPLE: Complete Order Fetching

```php
function get_user_dashboard_data() {
  if(!is_user_logged_in()) return [];

  $user_id = get_current_user_id();

  // Get orders
  $orders = wc_get_orders([
    'customer_id' => $user_id,
    'limit' => -1,
    'status' => ['pending', 'processing', 'on-hold', 'completed']
  ]);

  $order_count = count($orders);
  $processing = count(array_filter($orders, fn($o) =>
    in_array($o->get_status(), ['processing', 'pending'])
  ));

  // Get totals
  $cart_total = WC()->cart ? WC()->cart->get_total() : 0;

  return [
    'user' => [
      'id' => $user_id,
      'name' => wp_get_current_user()->display_name,
      'email' => wp_get_current_user()->user_email,
      'avatar' => get_avatar_url($user_id)
    ],
    'orders' => [
      'total' => $order_count,
      'processing' => $processing,
      'list' => $orders
    ],
    'cart' => [
      'total' => $cart_total,
      'items_count' => WC()->cart->get_cart_contents_count()
    ]
  ];
}
```

================================================================================

## 9. TROUBLESHOOTING

Problem: Content not showing
  Solution 1: Check if shortcode is registered (add_shortcode)
  Solution 2: Check if user is logged in
  Solution 3: Check console (F12) for JavaScript errors
  Solution 4: Verify jQuery loads (console: typeof jQuery)

Problem: Data not loading
  Solution 1: Verify API endpoints work (test in browser)
  Solution 2: Check nonce in AJAX
  Solution 3: Check user permissions
  Solution 4: Check WP_Query limit/page settings

Problem: Styling not showing
  Solution 1: Check if CSS file enqueued
  Solution 2: Clear cache
  Solution 3: Check CSS selectors match HTML structure
  Solution 4: Verify no conflicting CSS from theme/plugins

================================================================================

## 10. RESOURCES

Official Docs:
  - WooCommerce: https://woocommerce.com/documentation/
  - WC REST API: https://woocommerce.github.io/woocommerce-rest-api-docs/
  - Elementor: https://developers.elementor.com/

WP Functions:
  - WordPress Codex: https://developer.wordpress.org/
  - Hooks Database: https://adambrown.info/p/wp_hooks/

================================================================================
Created: 2026-05-09
Updated: Latest
================================================================================
