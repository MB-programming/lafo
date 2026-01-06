<?php
/**
 * Theme Settings Panel
 *
 * @package EduPress
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Theme Settings Menu
 */
function edupress_add_theme_settings_menu() {
    add_menu_page(
        __('إعدادات EduPress', 'edupress'),
        __('إعدادات الثيم', 'edupress'),
        'manage_options',
        'edupress-settings',
        'edupress_settings_page',
        'dashicons-admin-settings',
        59
    );
}
add_action('admin_menu', 'edupress_add_theme_settings_menu');

/**
 * Register Settings
 */
function edupress_register_settings() {
    // General Settings
    register_setting('edupress_general_settings', 'edupress_logo');
    register_setting('edupress_general_settings', 'edupress_favicon');
    register_setting('edupress_general_settings', 'edupress_site_description');
    register_setting('edupress_general_settings', 'edupress_copyright_text');
    register_setting('edupress_general_settings', 'edupress_use_elementor_header');
    register_setting('edupress_general_settings', 'edupress_use_elementor_footer');
    register_setting('edupress_general_settings', 'edupress_elementor_header_id');
    register_setting('edupress_general_settings', 'edupress_elementor_footer_id');

    // Contact Settings
    register_setting('edupress_contact_settings', 'edupress_phone');
    register_setting('edupress_contact_settings', 'edupress_email');
    register_setting('edupress_contact_settings', 'edupress_address');
    register_setting('edupress_contact_settings', 'edupress_whatsapp');

    // Social Media Settings
    register_setting('edupress_social_settings', 'edupress_facebook');
    register_setting('edupress_social_settings', 'edupress_twitter');
    register_setting('edupress_social_settings', 'edupress_instagram');
    register_setting('edupress_social_settings', 'edupress_linkedin');
    register_setting('edupress_social_settings', 'edupress_youtube');

    // Colors Settings
    register_setting('edupress_colors_settings', 'edupress_primary_color');
    register_setting('edupress_colors_settings', 'edupress_secondary_color');
    register_setting('edupress_colors_settings', 'edupress_text_color');

    // WooCommerce Integration
    register_setting('edupress_woo_settings', 'edupress_use_woo_currency');
    register_setting('edupress_woo_settings', 'edupress_use_woo_payment');
}
add_action('admin_init', 'edupress_register_settings');

/**
 * Settings Page HTML
 */
function edupress_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('إعدادات EduPress Theme', 'edupress'); ?></h1>

        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="#general" class="nav-tab nav-tab-active"><?php _e('عام', 'edupress'); ?></a>
            <a href="#contact" class="nav-tab"><?php _e('معلومات الاتصال', 'edupress'); ?></a>
            <a href="#social" class="nav-tab"><?php _e('السوشيال ميديا', 'edupress'); ?></a>
            <a href="#colors" class="nav-tab"><?php _e('الألوان', 'edupress'); ?></a>
            <a href="#elementor" class="nav-tab"><?php _e('Elementor', 'edupress'); ?></a>
            <a href="#woocommerce" class="nav-tab"><?php _e('WooCommerce', 'edupress'); ?></a>
        </h2>

        <!-- General Tab -->
        <div id="general" class="tab-content active">
            <form method="post" action="options.php">
                <?php settings_fields('edupress_general_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('وصف الموقع', 'edupress'); ?></th>
                        <td>
                            <textarea name="edupress_site_description" rows="3" class="large-text"><?php echo esc_textarea(get_option('edupress_site_description', 'منصة تعليمية متخصصة')); ?></textarea>
                            <p class="description"><?php _e('يظهر في الهيرو والميتا', 'edupress'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('نص حقوق النشر', 'edupress'); ?></th>
                        <td>
                            <input type="text" name="edupress_copyright_text" value="<?php echo esc_attr(get_option('edupress_copyright_text', 'جميع الحقوق محفوظة')); ?>" class="regular-text">
                            <p class="description"><?php _e('يظهر في الفوتر', 'edupress'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>

        <!-- Contact Tab -->
        <div id="contact" class="tab-content">
            <form method="post" action="options.php">
                <?php settings_fields('edupress_contact_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('رقم الهاتف', 'edupress'); ?></th>
                        <td>
                            <input type="text" name="edupress_phone" value="<?php echo esc_attr(get_option('edupress_phone', '+966 50 123 4567')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('البريد الإلكتروني', 'edupress'); ?></th>
                        <td>
                            <input type="email" name="edupress_email" value="<?php echo esc_attr(get_option('edupress_email', 'info@edupress.com')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('العنوان', 'edupress'); ?></th>
                        <td>
                            <input type="text" name="edupress_address" value="<?php echo esc_attr(get_option('edupress_address', 'الرياض، السعودية')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('واتساب', 'edupress'); ?></th>
                        <td>
                            <input type="text" name="edupress_whatsapp" value="<?php echo esc_attr(get_option('edupress_whatsapp', '+966501234567')); ?>" class="regular-text">
                            <p class="description"><?php _e('بدون + أو مسافات (مثال: 966501234567)', 'edupress'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>

        <!-- Social Tab -->
        <div id="social" class="tab-content">
            <form method="post" action="options.php">
                <?php settings_fields('edupress_social_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Facebook', 'edupress'); ?></th>
                        <td>
                            <input type="url" name="edupress_facebook" value="<?php echo esc_url(get_option('edupress_facebook')); ?>" class="regular-text" placeholder="https://facebook.com/...">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('Twitter', 'edupress'); ?></th>
                        <td>
                            <input type="url" name="edupress_twitter" value="<?php echo esc_url(get_option('edupress_twitter')); ?>" class="regular-text" placeholder="https://twitter.com/...">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('Instagram', 'edupress'); ?></th>
                        <td>
                            <input type="url" name="edupress_instagram" value="<?php echo esc_url(get_option('edupress_instagram')); ?>" class="regular-text" placeholder="https://instagram.com/...">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('LinkedIn', 'edupress'); ?></th>
                        <td>
                            <input type="url" name="edupress_linkedin" value="<?php echo esc_url(get_option('edupress_linkedin')); ?>" class="regular-text" placeholder="https://linkedin.com/...">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('YouTube', 'edupress'); ?></th>
                        <td>
                            <input type="url" name="edupress_youtube" value="<?php echo esc_url(get_option('edupress_youtube')); ?>" class="regular-text" placeholder="https://youtube.com/...">
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>

        <!-- Colors Tab -->
        <div id="colors" class="tab-content">
            <form method="post" action="options.php">
                <?php settings_fields('edupress_colors_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('اللون الرئيسي', 'edupress'); ?></th>
                        <td>
                            <input type="color" name="edupress_primary_color" value="<?php echo esc_attr(get_option('edupress_primary_color', '#2563eb')); ?>">
                            <p class="description"><?php _e('اللون الأساسي للثيم (افتراضي: #2563eb)', 'edupress'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('اللون الثانوي', 'edupress'); ?></th>
                        <td>
                            <input type="color" name="edupress_secondary_color" value="<?php echo esc_attr(get_option('edupress_secondary_color', '#f59e0b')); ?>">
                            <p class="description"><?php _e('اللون الثانوي (افتراضي: #f59e0b)', 'edupress'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('لون النص', 'edupress'); ?></th>
                        <td>
                            <input type="color" name="edupress_text_color" value="<?php echo esc_attr(get_option('edupress_text_color', '#1e293b')); ?>">
                            <p class="description"><?php _e('لون النص الأساسي (افتراضي: #1e293b)', 'edupress'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>

        <!-- Elementor Tab -->
        <div id="elementor" class="tab-content">
            <form method="post" action="options.php">
                <?php settings_fields('edupress_general_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('استخدام Elementor للهيدر', 'edupress'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="edupress_use_elementor_header" value="1" <?php checked(get_option('edupress_use_elementor_header'), 1); ?>>
                                <?php _e('تفعيل', 'edupress'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('قالب Elementor للهيدر', 'edupress'); ?></th>
                        <td>
                            <?php
                            $templates = get_posts(array(
                                'post_type' => 'elementor_library',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => '_elementor_template_type',
                                        'value' => array('header', 'section'),
                                        'compare' => 'IN'
                                    )
                                )
                            ));
                            ?>
                            <select name="edupress_elementor_header_id" class="regular-text">
                                <option value=""><?php _e('-- اختر قالب --', 'edupress'); ?></option>
                                <?php foreach ($templates as $template) : ?>
                                    <option value="<?php echo $template->ID; ?>" <?php selected(get_option('edupress_elementor_header_id'), $template->ID); ?>>
                                        <?php echo esc_html($template->post_title); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php _e('أنشئ قالب Header في Elementor أولاً', 'edupress'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('استخدام Elementor للفوتر', 'edupress'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="edupress_use_elementor_footer" value="1" <?php checked(get_option('edupress_use_elementor_footer'), 1); ?>>
                                <?php _e('تفعيل', 'edupress'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('قالب Elementor للفوتر', 'edupress'); ?></th>
                        <td>
                            <?php
                            $footer_templates = get_posts(array(
                                'post_type' => 'elementor_library',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => '_elementor_template_type',
                                        'value' => array('footer', 'section'),
                                        'compare' => 'IN'
                                    )
                                )
                            ));
                            ?>
                            <select name="edupress_elementor_footer_id" class="regular-text">
                                <option value=""><?php _e('-- اختر قالب --', 'edupress'); ?></option>
                                <?php foreach ($footer_templates as $template) : ?>
                                    <option value="<?php echo $template->ID; ?>" <?php selected(get_option('edupress_elementor_footer_id'), $template->ID); ?>>
                                        <?php echo esc_html($template->post_title); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description"><?php _e('أنشئ قالب Footer في Elementor أولاً', 'edupress'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>

        <!-- WooCommerce Tab -->
        <div id="woocommerce" class="tab-content">
            <form method="post" action="options.php">
                <?php settings_fields('edupress_woo_settings'); ?>

                <?php if (edupress_is_woocommerce_active()) : ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e('استخدام عملة WooCommerce', 'edupress'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="edupress_use_woo_currency" value="1" <?php checked(get_option('edupress_use_woo_currency', 1), 1); ?>>
                                    <?php _e('استخدام إعدادات العملة من WooCommerce', 'edupress'); ?>
                                </label>
                                <p class="description">
                                    <?php
                                    $currency = get_woocommerce_currency();
                                    $symbol = get_woocommerce_currency_symbol();
                                    echo sprintf(__('العملة الحالية في WooCommerce: %s (%s)', 'edupress'), $currency, $symbol);
                                    ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e('استخدام بوابات الدفع', 'edupress'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="edupress_use_woo_payment" value="1" <?php checked(get_option('edupress_use_woo_payment', 1), 1); ?>>
                                    <?php _e('استخدام بوابات الدفع من WooCommerce', 'edupress'); ?>
                                </label>
                                <p class="description">
                                    <?php
                                    $gateways = WC()->payment_gateways->get_available_payment_gateways();
                                    if (!empty($gateways)) {
                                        echo __('البوابات المفعّلة: ', 'edupress');
                                        $gateway_names = array();
                                        foreach ($gateways as $gateway) {
                                            $gateway_names[] = $gateway->get_title();
                                        }
                                        echo implode(', ', $gateway_names);
                                    } else {
                                        echo __('لا توجد بوابات دفع مفعّلة', 'edupress');
                                    }
                                    ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="<?php echo admin_url('admin.php?page=wc-settings'); ?>" class="button button-secondary">
                                    <i class="dashicons dashicons-admin-generic"></i> <?php _e('إعدادات WooCommerce', 'edupress'); ?>
                                </a>
                                <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=general'); ?>" class="button button-secondary">
                                    <i class="dashicons dashicons-money"></i> <?php _e('إعدادات العملة', 'edupress'); ?>
                                </a>
                                <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout'); ?>" class="button button-secondary">
                                    <i class="dashicons dashicons-cart"></i> <?php _e('بوابات الدفع', 'edupress'); ?>
                                </a>
                            </td>
                        </tr>
                    </table>
                <?php else : ?>
                    <div class="notice notice-warning">
                        <p><?php _e('WooCommerce غير مثبت أو غير مفعّل.', 'edupress'); ?></p>
                        <p><a href="<?php echo admin_url('plugin-install.php?s=woocommerce&tab=search&type=term'); ?>" class="button button-primary"><?php _e('تثبيت WooCommerce', 'edupress'); ?></a></p>
                    </div>
                <?php endif; ?>

                <?php submit_button(); ?>
            </form>
        </div>
    </div>

    <style>
        .nav-tab-wrapper { margin-bottom: 20px; }
        .tab-content { display: none; background: #fff; padding: 20px; }
        .tab-content.active { display: block; }
    </style>

    <script>
    jQuery(document).ready(function($) {
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');

            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');

            $('.tab-content').removeClass('active');
            $(target).addClass('active');
        });
    });
    </script>
    <?php
}

/**
 * Output Custom Colors CSS
 */
function edupress_custom_colors_css() {
    $primary = get_option('edupress_primary_color', '#2563eb');
    $secondary = get_option('edupress_secondary_color', '#f59e0b');
    $text = get_option('edupress_text_color', '#1e293b');

    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary); ?>;
            --primary-dark: <?php echo esc_attr(edupress_darken_color($primary, 20)); ?>;
            --primary-light: <?php echo esc_attr(edupress_lighten_color($primary, 20)); ?>;
            --secondary-color: <?php echo esc_attr($secondary); ?>;
            --secondary-dark: <?php echo esc_attr(edupress_darken_color($secondary, 20)); ?>;
            --dark: <?php echo esc_attr($text); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'edupress_custom_colors_css');

/**
 * Darken Color
 */
function edupress_darken_color($hex, $percent) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r - ($r * $percent / 100)));
    $g = max(0, min(255, $g - ($g * $percent / 100)));
    $b = max(0, min(255, $b - ($b * $percent / 100)));

    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}

/**
 * Lighten Color
 */
function edupress_lighten_color($hex, $percent) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r + ((255 - $r) * $percent / 100)));
    $g = max(0, min(255, $g + ((255 - $g) * $percent / 100)));
    $b = max(0, min(255, $b + ((255 - $b) * $percent / 100)));

    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}
