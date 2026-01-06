<?php
/**
 * EduPress Shortcodes System
 *
 * @package EduPress
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// ==========================================
// 1. MY ACCOUNT SHORTCODES
// ==========================================

/**
 * [edupress_my_account] - Display user dashboard
 */
function edupress_my_account_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '<p class="notice">' . __('يرجى تسجيل الدخول أولاً.', 'edupress') . ' <a href="' . wp_login_url(get_permalink()) . '">' . __('تسجيل الدخول', 'edupress') . '</a></p>';
    }

    $current_user = wp_get_current_user();
    $enrolled_courses = edupress_get_user_courses(get_current_user_id());

    ob_start();
    ?>
    <div class="edupress-my-account">
        <h2>مرحباً، <?php echo esc_html($current_user->display_name); ?>!</h2>
        <div class="account-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 2rem 0;">
            <div class="stat-card" style="background: #e7f5ff; padding: 1.5rem; border-radius: 0.5rem; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; color: #2563eb;"><?php echo count($enrolled_courses); ?></div>
                <div style="color: #64748b;">الكورسات المسجل فيها</div>
            </div>
        </div>
        <a href="<?php echo site_url('/my-courses'); ?>" class="btn btn-primary">عرض كورساتي</a>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_my_account', 'edupress_my_account_shortcode');

/**
 * [edupress_profile] - Display user profile
 */
function edupress_profile_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '<p class="notice">' . __('يرجى تسجيل الدخول.', 'edupress') . '</p>';
    }

    $user = wp_get_current_user();

    ob_start();
    ?>
    <div class="edupress-profile">
        <div class="profile-header" style="display: flex; align-items: center; gap: 2rem; padding: 2rem; background: #f1f5f9; border-radius: 1rem; margin-bottom: 2rem;">
            <div class="avatar">
                <?php echo get_avatar($user->ID, 100, '', '', array('class' => 'rounded-circle', 'style' => 'border-radius: 50%;')); ?>
            </div>
            <div class="user-info">
                <h2 style="margin: 0 0 0.5rem 0;"><?php echo esc_html($user->display_name); ?></h2>
                <p style="margin: 0; color: #64748b;"><?php echo esc_html($user->user_email); ?></p>
            </div>
        </div>

        <div class="profile-details">
            <table class="form-table">
                <tr>
                    <th>اسم المستخدم:</th>
                    <td><?php echo esc_html($user->user_login); ?></td>
                </tr>
                <tr>
                    <th>البريد الإلكتروني:</th>
                    <td><?php echo esc_html($user->user_email); ?></td>
                </tr>
                <tr>
                    <th>تاريخ التسجيل:</th>
                    <td><?php echo date_i18n(get_option('date_format'), strtotime($user->user_registered)); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_profile', 'edupress_profile_shortcode');

/**
 * [edupress_logout] - Logout button
 */
function edupress_logout_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text' => 'تسجيل الخروج',
        'redirect' => home_url(),
        'class' => 'btn btn-secondary'
    ), $atts);

    if (!is_user_logged_in()) {
        return '';
    }

    return '<a href="' . wp_logout_url(esc_url($atts['redirect'])) . '" class="' . esc_attr($atts['class']) . '">' . esc_html($atts['text']) . '</a>';
}
add_shortcode('edupress_logout', 'edupress_logout_shortcode');

// ==========================================
// 2. COURSES SHORTCODES
// ==========================================

/**
 * [edupress_courses] - Display courses grid
 */
function edupress_courses_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => 6,
        'columns' => 3,
        'category' => '',
        'level' => '',
        'orderby' => 'date',
        'order' => 'DESC'
    ), $atts);

    $args = array(
        'post_type' => 'course',
        'posts_per_page' => intval($atts['number']),
        'orderby' => $atts['orderby'],
        'order' => $atts['order']
    );

    if ($atts['category']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'course_category',
            'field' => 'slug',
            'terms' => $atts['category']
        );
    }

    if ($atts['level']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'course_level',
            'field' => 'slug',
            'terms' => $atts['level']
        );
    }

    $courses = new WP_Query($args);

    ob_start();
    ?>
    <div class="edupress-courses-grid grid grid-<?php echo esc_attr($atts['columns']); ?>">
        <?php
        while ($courses->have_posts()) : $courses->the_post();
            $price = get_post_meta(get_the_ID(), '_course_price', true);
            $duration = get_post_meta(get_the_ID(), '_course_duration', true);
            $lessons = get_post_meta(get_the_ID(), '_course_lessons', true);
        ?>
            <div class="course-card card">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('course-thumbnail', array('class' => 'card-image')); ?>
                    </a>
                <?php endif; ?>
                <div class="card-body">
                    <h3 class="card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php if ($duration || $lessons) : ?>
                        <div class="card-meta">
                            <?php if ($duration) : ?>
                                <span><i class="far fa-clock"></i> <?php echo esc_html($duration); ?></span>
                            <?php endif; ?>
                            <?php if ($lessons) : ?>
                                <span><i class="far fa-file-alt"></i> <?php echo esc_html($lessons); ?> درس</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="card-footer">
                        <span class="course-price"><?php echo $price ? esc_html($price) . (is_numeric($price) ? ' ريال' : '') : 'مجاني'; ?></span>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('edupress_courses', 'edupress_courses_shortcode');

/**
 * [edupress_my_courses] - Display user's enrolled courses
 */
function edupress_my_courses_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '<p class="notice">يرجى تسجيل الدخول لعرض كورساتك.</p>';
    }

    $user_id = get_current_user_id();
    $courses = edupress_get_user_courses($user_id);

    if (empty($courses)) {
        return '<p>لم تسجل في أي كورس بعد. <a href="' . get_post_type_archive_link('course') . '">تصفح الكورسات</a></p>';
    }

    ob_start();
    ?>
    <div class="edupress-my-courses grid grid-2">
        <?php foreach ($courses as $course_id) :
            $course = get_post($course_id);
            if (!$course) continue;
            $progress = edupress_get_course_progress($user_id, $course_id);
        ?>
            <div class="course-card card">
                <?php if (has_post_thumbnail($course_id)) : ?>
                    <a href="<?php echo get_permalink($course_id); ?>">
                        <?php echo get_the_post_thumbnail($course_id, 'course-thumbnail', array('class' => 'card-image')); ?>
                    </a>
                <?php endif; ?>
                <div class="card-body">
                    <h3><a href="<?php echo get_permalink($course_id); ?>"><?php echo esc_html($course->post_title); ?></a></h3>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: <?php echo $progress; ?>%;"></div>
                    </div>
                    <p>التقدم: <?php echo $progress; ?>%</p>
                    <a href="<?php echo add_query_arg('learn', '1', get_permalink($course_id)); ?>" class="btn btn-primary">
                        <?php echo $progress > 0 ? 'متابعة التعلم' : 'ابدأ الآن'; ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_my_courses', 'edupress_my_courses_shortcode');

/**
 * [edupress_course_progress] - Show progress for specific course
 */
function edupress_course_progress_shortcode($atts) {
    $atts = shortcode_atts(array(
        'course_id' => get_the_ID()
    ), $atts);

    if (!is_user_logged_in()) {
        return '';
    }

    $progress = edupress_get_course_progress(get_current_user_id(), $atts['course_id']);

    ob_start();
    ?>
    <div class="course-progress">
        <div class="progress-bar-container">
            <div class="progress-bar" style="width: <?php echo $progress; ?>%;"></div>
        </div>
        <p>التقدم: <?php echo $progress; ?>%</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_course_progress', 'edupress_course_progress_shortcode');

// ==========================================
// 3. INSTRUCTORS SHORTCODES
// ==========================================

/**
 * [edupress_instructors] - Display instructors grid
 */
function edupress_instructors_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => 4,
        'columns' => 4,
        'orderby' => 'title',
        'order' => 'ASC'
    ), $atts);

    $instructors = get_posts(array(
        'post_type' => 'instructor',
        'posts_per_page' => intval($atts['number']),
        'orderby' => $atts['orderby'],
        'order' => $atts['order']
    ));

    ob_start();
    ?>
    <div class="edupress-instructors grid grid-<?php echo esc_attr($atts['columns']); ?>">
        <?php foreach ($instructors as $instructor) :
            $specialization = get_post_meta($instructor->ID, '_instructor_specialization', true);
            $students = get_post_meta($instructor->ID, '_instructor_students', true);
        ?>
            <div class="instructor-card card">
                <div class="card-body" style="text-align: center;">
                    <?php if (has_post_thumbnail($instructor->ID)) : ?>
                        <?php echo get_the_post_thumbnail($instructor->ID, 'instructor-avatar', array('class' => 'card-image', 'style' => 'border-radius: 50%; margin: 0 auto;')); ?>
                    <?php endif; ?>
                    <h3><a href="<?php echo get_permalink($instructor->ID); ?>"><?php echo esc_html($instructor->post_title); ?></a></h3>
                    <?php if ($specialization) : ?>
                        <p class="instructor-specialization"><?php echo esc_html($specialization); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo get_permalink($instructor->ID); ?>" class="btn btn-primary">عرض الملف</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_instructors', 'edupress_instructors_shortcode');

// ==========================================
// 4. STATS & INFO SHORTCODES
// ==========================================

/**
 * [edupress_stats] - Display statistics
 */
function edupress_stats_shortcode($atts) {
    $atts = shortcode_atts(array(
        'students' => '10,000+',
        'courses' => '500+',
        'instructors' => '50+',
        'satisfaction' => '95%'
    ), $atts);

    ob_start();
    ?>
    <div class="edupress-stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><?php echo esc_html($atts['students']); ?></div>
                <div class="stat-label">طالب نشط</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo esc_html($atts['courses']); ?></div>
                <div class="stat-label">كورس متاح</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo esc_html($atts['instructors']); ?></div>
                <div class="stat-label">مدرب محترف</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo esc_html($atts['satisfaction']); ?></div>
                <div class="stat-label">نسبة الرضا</div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_stats', 'edupress_stats_shortcode');

/**
 * [edupress_search] - Course search form
 */
function edupress_search_shortcode($atts) {
    $atts = shortcode_atts(array(
        'placeholder' => 'ابحث عن كورس...'
    ), $atts);

    ob_start();
    ?>
    <form role="search" method="get" class="edupress-search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" name="s" placeholder="<?php echo esc_attr($atts['placeholder']); ?>" required>
        <input type="hidden" name="post_type" value="course">
        <button type="submit"><i class="fas fa-search"></i> بحث</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_search', 'edupress_search_shortcode');

/**
 * [edupress_button] - Custom button
 */
function edupress_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'url' => '#',
        'style' => 'primary', // primary, secondary, outline
        'size' => 'medium', // small, medium, large
        'icon' => '',
        'target' => '_self'
    ), $atts);

    $classes = 'btn btn-' . esc_attr($atts['style']) . ' btn-' . esc_attr($atts['size']);

    $icon_html = $atts['icon'] ? '<i class="' . esc_attr($atts['icon']) . '"></i> ' : '';

    return '<a href="' . esc_url($atts['url']) . '" class="' . $classes . '" target="' . esc_attr($atts['target']) . '">' . $icon_html . do_shortcode($content) . '</a>';
}
add_shortcode('edupress_button', 'edupress_button_shortcode');

/**
 * [edupress_login_form] - Login form
 */
function edupress_login_form_shortcode($atts) {
    if (is_user_logged_in()) {
        return '<p>أنت مسجل دخول بالفعل. <a href="' . wp_logout_url(home_url()) . '">تسجيل الخروج</a></p>';
    }

    $atts = shortcode_atts(array(
        'redirect' => home_url()
    ), $atts);

    ob_start();
    wp_login_form(array(
        'redirect' => esc_url($atts['redirect']),
        'label_username' => __('اسم المستخدم', 'edupress'),
        'label_password' => __('كلمة المرور', 'edupress'),
        'label_remember' => __('تذكرني', 'edupress'),
        'label_log_in' => __('تسجيل الدخول', 'edupress'),
    ));
    return ob_get_clean();
}
add_shortcode('edupress_login_form', 'edupress_login_form_shortcode');

/**
 * [edupress_contact_info] - Display contact information
 */
function edupress_contact_info_shortcode($atts) {
    $atts = shortcode_atts(array(
        'show' => 'all' // all, phone, email, address, whatsapp
    ), $atts);

    $phone = get_option('edupress_phone');
    $email = get_option('edupress_email');
    $address = get_option('edupress_address');
    $whatsapp = get_option('edupress_whatsapp');

    ob_start();
    ?>
    <div class="edupress-contact-info">
        <?php if (($atts['show'] == 'all' || $atts['show'] == 'phone') && $phone) : ?>
            <p><i class="fas fa-phone"></i> <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></p>
        <?php endif; ?>

        <?php if (($atts['show'] == 'all' || $atts['show'] == 'email') && $email) : ?>
            <p><i class="fas fa-envelope"></i> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
        <?php endif; ?>

        <?php if (($atts['show'] == 'all' || $atts['show'] == 'address') && $address) : ?>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
        <?php endif; ?>

        <?php if (($atts['show'] == 'all' || $atts['show'] == 'whatsapp') && $whatsapp) : ?>
            <p><i class="fab fa-whatsapp"></i> <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank">واتساب</a></p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_contact_info', 'edupress_contact_info_shortcode');

/**
 * [edupress_social_links] - Social media links
 */
function edupress_social_links_shortcode($atts) {
    $atts = shortcode_atts(array(
        'style' => 'icons' // icons, buttons
    ), $atts);

    $social = array(
        'facebook' => array('icon' => 'fab fa-facebook-f', 'option' => 'edupress_facebook'),
        'twitter' => array('icon' => 'fab fa-twitter', 'option' => 'edupress_twitter'),
        'instagram' => array('icon' => 'fab fa-instagram', 'option' => 'edupress_instagram'),
        'linkedin' => array('icon' => 'fab fa-linkedin-in', 'option' => 'edupress_linkedin'),
        'youtube' => array('icon' => 'fab fa-youtube', 'option' => 'edupress_youtube'),
    );

    ob_start();
    ?>
    <div class="edupress-social-links" style="display: flex; gap: 1rem;">
        <?php foreach ($social as $platform => $data) :
            $url = get_option($data['option']);
            if ($url) :
        ?>
            <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-link" style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="<?php echo esc_attr($data['icon']); ?>"></i>
                <?php if ($atts['style'] == 'buttons') : ?>
                    <span><?php echo ucfirst($platform); ?></span>
                <?php endif; ?>
            </a>
        <?php
            endif;
        endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('edupress_social_links', 'edupress_social_links_shortcode');
