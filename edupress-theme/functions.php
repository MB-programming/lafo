<?php
/**
 * EduPress Theme Functions
 *
 * @package EduPress
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function edupress_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800, 600, true);
    add_image_size('course-thumbnail', 400, 300, true);
    add_image_size('instructor-avatar', 300, 300, true);

    // Enable support for document Title tag
    add_theme_support('title-tag');

    // Enable support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // Enable support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Enable support for custom header
    add_theme_support('custom-header', array(
        'default-image' => '',
        'width'         => 1920,
        'height'        => 500,
        'flex-height'   => true,
        'flex-width'    => true,
    ));

    // Enable support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // Enable support for wide alignment
    add_theme_support('align-wide');

    // Enable support for responsive embeds
    add_theme_support('responsive-embeds');

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('القائمة الرئيسية', 'edupress'),
        'footer'  => __('قائمة الفوتر', 'edupress'),
    ));

    // Load text domain for translations
    load_theme_textdomain('edupress', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'edupress_setup');

/**
 * Register Widget Areas
 */
function edupress_widgets_init() {
    // Sidebar
    register_sidebar(array(
        'name'          => __('السايدبار الرئيسي', 'edupress'),
        'id'            => 'sidebar-1',
        'description'   => __('يظهر في الصفحات الداخلية', 'edupress'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Footer widgets
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('عمود الفوتر %d', 'edupress'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('عمود الفوتر رقم %d', 'edupress'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'edupress_widgets_init');

/**
 * Enqueue Scripts and Styles
 */
function edupress_scripts() {
    // Google Fonts
    wp_enqueue_style('edupress-google-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap', array(), null);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Main stylesheet
    wp_enqueue_style('edupress-style', get_stylesheet_uri(), array(), '1.0.0');

    // Custom CSS
    wp_enqueue_style('edupress-custom', get_template_directory_uri() . '/assets/css/custom.css', array('edupress-style'), '1.0.0');

    // Main JavaScript
    wp_enqueue_script('edupress-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('edupress-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'edupress_scripts');

/**
 * Register Custom Post Type: Courses
 */
function edupress_register_course_post_type() {
    $labels = array(
        'name'               => __('الكورسات', 'edupress'),
        'singular_name'      => __('كورس', 'edupress'),
        'menu_name'          => __('الكورسات', 'edupress'),
        'add_new'            => __('إضافة كورس جديد', 'edupress'),
        'add_new_item'       => __('إضافة كورس جديد', 'edupress'),
        'edit_item'          => __('تعديل الكورس', 'edupress'),
        'new_item'           => __('كورس جديد', 'edupress'),
        'view_item'          => __('عرض الكورس', 'edupress'),
        'search_items'       => __('البحث في الكورسات', 'edupress'),
        'not_found'          => __('لم يتم العثور على كورسات', 'edupress'),
        'not_found_in_trash' => __('لا توجد كورسات في سلة المهملات', 'edupress'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'courses'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-book-alt',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest'        => true,
    );

    register_post_type('course', $args);
}
add_action('init', 'edupress_register_course_post_type');

/**
 * Register Custom Post Type: Instructors
 */
function edupress_register_instructor_post_type() {
    $labels = array(
        'name'               => __('المدربون', 'edupress'),
        'singular_name'      => __('مدرب', 'edupress'),
        'menu_name'          => __('المدربون', 'edupress'),
        'add_new'            => __('إضافة مدرب جديد', 'edupress'),
        'add_new_item'       => __('إضافة مدرب جديد', 'edupress'),
        'edit_item'          => __('تعديل المدرب', 'edupress'),
        'new_item'           => __('مدرب جديد', 'edupress'),
        'view_item'          => __('عرض المدرب', 'edupress'),
        'search_items'       => __('البحث في المدربين', 'edupress'),
        'not_found'          => __('لم يتم العثور على مدربين', 'edupress'),
        'not_found_in_trash' => __('لا يوجد مدربون في سلة المهملات', 'edupress'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'instructors'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'        => true,
    );

    register_post_type('instructor', $args);
}
add_action('init', 'edupress_register_instructor_post_type');

/**
 * Register Taxonomy: Course Categories
 */
function edupress_register_course_category() {
    $labels = array(
        'name'              => __('تصنيفات الكورسات', 'edupress'),
        'singular_name'     => __('تصنيف', 'edupress'),
        'search_items'      => __('البحث في التصنيفات', 'edupress'),
        'all_items'         => __('كل التصنيفات', 'edupress'),
        'parent_item'       => __('التصنيف الأب', 'edupress'),
        'parent_item_colon' => __('التصنيف الأب:', 'edupress'),
        'edit_item'         => __('تعديل التصنيف', 'edupress'),
        'update_item'       => __('تحديث التصنيف', 'edupress'),
        'add_new_item'      => __('إضافة تصنيف جديد', 'edupress'),
        'new_item_name'     => __('اسم التصنيف الجديد', 'edupress'),
        'menu_name'         => __('التصنيفات', 'edupress'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'course-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('course_category', array('course'), $args);
}
add_action('init', 'edupress_register_course_category');

/**
 * Register Taxonomy: Course Levels
 */
function edupress_register_course_level() {
    $labels = array(
        'name'              => __('مستويات الكورسات', 'edupress'),
        'singular_name'     => __('مستوى', 'edupress'),
        'search_items'      => __('البحث في المستويات', 'edupress'),
        'all_items'         => __('كل المستويات', 'edupress'),
        'edit_item'         => __('تعديل المستوى', 'edupress'),
        'update_item'       => __('تحديث المستوى', 'edupress'),
        'add_new_item'      => __('إضافة مستوى جديد', 'edupress'),
        'new_item_name'     => __('اسم المستوى الجديد', 'edupress'),
        'menu_name'         => __('المستويات', 'edupress'),
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'course-level'),
        'show_in_rest'      => true,
    );

    register_taxonomy('course_level', array('course'), $args);
}
add_action('init', 'edupress_register_course_level');

/**
 * Add Meta Boxes for Courses
 */
function edupress_add_course_meta_boxes() {
    add_meta_box(
        'edupress_course_details',
        __('تفاصيل الكورس', 'edupress'),
        'edupress_course_details_callback',
        'course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'edupress_add_course_meta_boxes');

/**
 * Course Details Meta Box Callback
 */
function edupress_course_details_callback($post) {
    wp_nonce_field('edupress_save_course_details', 'edupress_course_details_nonce');

    $duration = get_post_meta($post->ID, '_course_duration', true);
    $students = get_post_meta($post->ID, '_course_students', true);
    $lessons = get_post_meta($post->ID, '_course_lessons', true);
    $price = get_post_meta($post->ID, '_course_price', true);
    $instructor_id = get_post_meta($post->ID, '_course_instructor', true);
    $video_url = get_post_meta($post->ID, '_course_video', true);
    $requirements = get_post_meta($post->ID, '_course_requirements', true);
    $objectives = get_post_meta($post->ID, '_course_objectives', true);
    ?>

    <div style="padding: 15px;">
        <table class="form-table">
            <tr>
                <th><label for="course_duration"><?php _e('مدة الكورس', 'edupress'); ?></label></th>
                <td>
                    <input type="text" id="course_duration" name="course_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text" placeholder="مثال: 8 أسابيع">
                </td>
            </tr>
            <tr>
                <th><label for="course_lessons"><?php _e('عدد الدروس', 'edupress'); ?></label></th>
                <td>
                    <input type="number" id="course_lessons" name="course_lessons" value="<?php echo esc_attr($lessons); ?>" class="regular-text" placeholder="مثال: 45">
                </td>
            </tr>
            <tr>
                <th><label for="course_students"><?php _e('عدد الطلاب', 'edupress'); ?></label></th>
                <td>
                    <input type="number" id="course_students" name="course_students" value="<?php echo esc_attr($students); ?>" class="regular-text" placeholder="مثال: 1250">
                </td>
            </tr>
            <tr>
                <th><label for="course_price"><?php _e('السعر (ريال)', 'edupress'); ?></label></th>
                <td>
                    <input type="text" id="course_price" name="course_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="مثال: 499 أو مجاني">
                </td>
            </tr>
            <tr>
                <th><label for="course_instructor"><?php _e('المدرب', 'edupress'); ?></label></th>
                <td>
                    <?php
                    $instructors = get_posts(array(
                        'post_type' => 'instructor',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ));
                    ?>
                    <select id="course_instructor" name="course_instructor" class="regular-text">
                        <option value=""><?php _e('-- اختر المدرب --', 'edupress'); ?></option>
                        <?php foreach ($instructors as $instructor) : ?>
                            <option value="<?php echo $instructor->ID; ?>" <?php selected($instructor_id, $instructor->ID); ?>>
                                <?php echo esc_html($instructor->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="course_video"><?php _e('رابط فيديو تعريفي', 'edupress'); ?></label></th>
                <td>
                    <input type="url" id="course_video" name="course_video" value="<?php echo esc_url($video_url); ?>" class="regular-text" placeholder="https://www.youtube.com/watch?v=...">
                </td>
            </tr>
            <tr>
                <th><label for="course_requirements"><?php _e('متطلبات الكورس', 'edupress'); ?></label></th>
                <td>
                    <textarea id="course_requirements" name="course_requirements" rows="5" class="large-text" placeholder="كل متطلب في سطر"><?php echo esc_textarea($requirements); ?></textarea>
                    <p class="description"><?php _e('اكتب كل متطلب في سطر منفصل', 'edupress'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="course_objectives"><?php _e('أهداف الكورس', 'edupress'); ?></label></th>
                <td>
                    <textarea id="course_objectives" name="course_objectives" rows="5" class="large-text" placeholder="كل هدف في سطر"><?php echo esc_textarea($objectives); ?></textarea>
                    <p class="description"><?php _e('اكتب كل هدف في سطر منفصل', 'edupress'); ?></p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Save Course Meta Data
 */
function edupress_save_course_details($post_id) {
    if (!isset($_POST['edupress_course_details_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['edupress_course_details_nonce'], 'edupress_save_course_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'course_duration',
        'course_students',
        'course_lessons',
        'course_price',
        'course_instructor',
        'course_video',
        'course_requirements',
        'course_objectives'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_course', 'edupress_save_course_details');

/**
 * Add Meta Boxes for Instructors
 */
function edupress_add_instructor_meta_boxes() {
    add_meta_box(
        'edupress_instructor_details',
        __('تفاصيل المدرب', 'edupress'),
        'edupress_instructor_details_callback',
        'instructor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'edupress_add_instructor_meta_boxes');

/**
 * Instructor Details Meta Box Callback
 */
function edupress_instructor_details_callback($post) {
    wp_nonce_field('edupress_save_instructor_details', 'edupress_instructor_details_nonce');

    $specialization = get_post_meta($post->ID, '_instructor_specialization', true);
    $experience = get_post_meta($post->ID, '_instructor_experience', true);
    $students = get_post_meta($post->ID, '_instructor_students', true);
    $courses = get_post_meta($post->ID, '_instructor_courses', true);
    $facebook = get_post_meta($post->ID, '_instructor_facebook', true);
    $twitter = get_post_meta($post->ID, '_instructor_twitter', true);
    $linkedin = get_post_meta($post->ID, '_instructor_linkedin', true);
    $email = get_post_meta($post->ID, '_instructor_email', true);
    ?>

    <div style="padding: 15px;">
        <table class="form-table">
            <tr>
                <th><label for="instructor_specialization"><?php _e('التخصص', 'edupress'); ?></label></th>
                <td>
                    <input type="text" id="instructor_specialization" name="instructor_specialization" value="<?php echo esc_attr($specialization); ?>" class="regular-text" placeholder="مثال: مطور Full Stack">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_experience"><?php _e('سنوات الخبرة', 'edupress'); ?></label></th>
                <td>
                    <input type="text" id="instructor_experience" name="instructor_experience" value="<?php echo esc_attr($experience); ?>" class="regular-text" placeholder="مثال: 10 سنوات">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_students"><?php _e('عدد الطلاب', 'edupress'); ?></label></th>
                <td>
                    <input type="number" id="instructor_students" name="instructor_students" value="<?php echo esc_attr($students); ?>" class="regular-text" placeholder="مثال: 5000">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_courses"><?php _e('عدد الكورسات', 'edupress'); ?></label></th>
                <td>
                    <input type="number" id="instructor_courses" name="instructor_courses" value="<?php echo esc_attr($courses); ?>" class="regular-text" placeholder="مثال: 12">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_email"><?php _e('البريد الإلكتروني', 'edupress'); ?></label></th>
                <td>
                    <input type="email" id="instructor_email" name="instructor_email" value="<?php echo esc_attr($email); ?>" class="regular-text" placeholder="instructor@example.com">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_facebook"><?php _e('Facebook', 'edupress'); ?></label></th>
                <td>
                    <input type="url" id="instructor_facebook" name="instructor_facebook" value="<?php echo esc_url($facebook); ?>" class="regular-text" placeholder="https://facebook.com/...">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_twitter"><?php _e('Twitter', 'edupress'); ?></label></th>
                <td>
                    <input type="url" id="instructor_twitter" name="instructor_twitter" value="<?php echo esc_url($twitter); ?>" class="regular-text" placeholder="https://twitter.com/...">
                </td>
            </tr>
            <tr>
                <th><label for="instructor_linkedin"><?php _e('LinkedIn', 'edupress'); ?></label></th>
                <td>
                    <input type="url" id="instructor_linkedin" name="instructor_linkedin" value="<?php echo esc_url($linkedin); ?>" class="regular-text" placeholder="https://linkedin.com/in/...">
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Save Instructor Meta Data
 */
function edupress_save_instructor_details($post_id) {
    if (!isset($_POST['edupress_instructor_details_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['edupress_instructor_details_nonce'], 'edupress_save_instructor_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'instructor_specialization',
        'instructor_experience',
        'instructor_students',
        'instructor_courses',
        'instructor_email',
        'instructor_facebook',
        'instructor_twitter',
        'instructor_linkedin'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_instructor', 'edupress_save_instructor_details');

/**
 * Custom Excerpt Length
 */
function edupress_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'edupress_excerpt_length');

/**
 * Custom Excerpt More
 */
function edupress_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'edupress_excerpt_more');

/**
 * Add Custom Classes to Body
 */
function edupress_body_classes($classes) {
    if (!is_singular()) {
        $classes[] = 'has-sidebar';
    }

    if (is_page_template('templates/template-fullwidth.php')) {
        $classes[] = 'fullwidth-page';
    }

    return $classes;
}
add_filter('body_class', 'edupress_body_classes');

/**
 * Flush Rewrite Rules on Theme Activation
 */
function edupress_rewrite_flush() {
    edupress_register_course_post_type();
    edupress_register_instructor_post_type();
    edupress_register_course_category();
    edupress_register_course_level();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'edupress_rewrite_flush');
