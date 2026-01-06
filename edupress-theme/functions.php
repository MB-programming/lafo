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
    edupress_register_lesson_post_type();
    edupress_register_course_category();
    edupress_register_course_level();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'edupress_rewrite_flush');

// ============================================
// LESSONS & COURSE LEARNING FEATURES
// ============================================

/**
 * Register Custom Post Type: Lessons
 */
function edupress_register_lesson_post_type() {
    $labels = array(
        'name'               => __('الدروس', 'edupress'),
        'singular_name'      => __('درس', 'edupress'),
        'menu_name'          => __('الدروس', 'edupress'),
        'add_new'            => __('إضافة درس جديد', 'edupress'),
        'add_new_item'       => __('إضافة درس جديد', 'edupress'),
        'edit_item'          => __('تعديل الدرس', 'edupress'),
        'new_item'           => __('درس جديد', 'edupress'),
        'view_item'          => __('عرض الدرس', 'edupress'),
        'search_items'       => __('البحث في الدروس', 'edupress'),
        'not_found'          => __('لم يتم العثور على دروس', 'edupress'),
        'not_found_in_trash' => __('لا توجد دروس في سلة المهملات', 'edupress'),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => 'edit.php?post_type=course',
        'query_var'           => true,
        'rewrite'             => array('slug' => 'lesson'),
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => null,
        'menu_icon'           => 'dashicons-video-alt3',
        'supports'            => array('title', 'editor', 'thumbnail'),
        'show_in_rest'        => true,
    );

    register_post_type('lesson', $args);
}
add_action('init', 'edupress_register_lesson_post_type');

/**
 * Add Meta Boxes for Lessons
 */
function edupress_add_lesson_meta_boxes() {
    add_meta_box(
        'edupress_lesson_details',
        __('تفاصيل الدرس', 'edupress'),
        'edupress_lesson_details_callback',
        'lesson',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'edupress_add_lesson_meta_boxes');

/**
 * Lesson Details Meta Box Callback
 */
function edupress_lesson_details_callback($post) {
    wp_nonce_field('edupress_save_lesson_details', 'edupress_lesson_details_nonce');

    $course_id = get_post_meta($post->ID, '_lesson_course', true);
    $video_url = get_post_meta($post->ID, '_lesson_video', true);
    $duration = get_post_meta($post->ID, '_lesson_duration', true);
    $order = get_post_meta($post->ID, '_lesson_order', true);
    $is_preview = get_post_meta($post->ID, '_lesson_preview', true);
    ?>

    <div style="padding: 15px;">
        <table class="form-table">
            <tr>
                <th><label for="lesson_course"><?php _e('الكورس', 'edupress'); ?></label></th>
                <td>
                    <?php
                    $courses = get_posts(array(
                        'post_type' => 'course',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ));
                    ?>
                    <select id="lesson_course" name="lesson_course" class="regular-text" required>
                        <option value=""><?php _e('-- اختر الكورس --', 'edupress'); ?></option>
                        <?php foreach ($courses as $course) : ?>
                            <option value="<?php echo $course->ID; ?>" <?php selected($course_id, $course->ID); ?>>
                                <?php echo esc_html($course->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="lesson_video"><?php _e('رابط الفيديو', 'edupress'); ?></label></th>
                <td>
                    <input type="url" id="lesson_video" name="lesson_video" value="<?php echo esc_url($video_url); ?>" class="large-text" placeholder="https://www.youtube.com/watch?v=...">
                    <p class="description"><?php _e('رابط فيديو YouTube أو Vimeo', 'edupress'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="lesson_duration"><?php _e('مدة الفيديو', 'edupress'); ?></label></th>
                <td>
                    <input type="text" id="lesson_duration" name="lesson_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text" placeholder="مثال: 15:30">
                    <p class="description"><?php _e('بالدقائق والثواني (مثال: 15:30)', 'edupress'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="lesson_order"><?php _e('ترتيب الدرس', 'edupress'); ?></label></th>
                <td>
                    <input type="number" id="lesson_order" name="lesson_order" value="<?php echo esc_attr($order); ?>" class="regular-text" min="0" placeholder="0">
                    <p class="description"><?php _e('ترتيب ظهور الدرس في الكورس (0 = أول درس)', 'edupress'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="lesson_preview"><?php _e('معاينة مجانية', 'edupress'); ?></label></th>
                <td>
                    <input type="checkbox" id="lesson_preview" name="lesson_preview" value="1" <?php checked($is_preview, '1'); ?>>
                    <label for="lesson_preview"><?php _e('السماح بمشاهدة هذا الدرس بدون شراء الكورس', 'edupress'); ?></label>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Save Lesson Meta Data
 */
function edupress_save_lesson_details($post_id) {
    if (!isset($_POST['edupress_lesson_details_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['edupress_lesson_details_nonce'], 'edupress_save_lesson_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'lesson_course' => 'intval',
        'lesson_video' => 'esc_url_raw',
        'lesson_duration' => 'sanitize_text_field',
        'lesson_order' => 'intval',
    );

    foreach ($fields as $field => $sanitize_func) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_func($_POST[$field]));
        }
    }

    // Handle checkbox
    $preview = isset($_POST['lesson_preview']) ? '1' : '0';
    update_post_meta($post_id, '_lesson_preview', $preview);
}
add_action('save_post_lesson', 'edupress_save_lesson_details');

// ============================================
// WOOCOMMERCE INTEGRATION
// ============================================

/**
 * Check if WooCommerce is active
 */
function edupress_is_woocommerce_active() {
    return class_exists('WooCommerce');
}

/**
 * Add WooCommerce support
 */
function edupress_add_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'edupress_add_woocommerce_support');

/**
 * Add Product ID field to Course Meta Box
 */
function edupress_add_course_product_field($post) {
    if (!edupress_is_woocommerce_active()) {
        return;
    }

    $product_id = get_post_meta($post->ID, '_course_product_id', true);
    ?>
    <tr>
        <th><label for="course_product_id"><?php _e('منتج WooCommerce', 'edupress'); ?></label></th>
        <td>
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            );
            $products = get_posts($args);
            ?>
            <select id="course_product_id" name="course_product_id" class="regular-text">
                <option value=""><?php _e('-- اختر منتج --', 'edupress'); ?></option>
                <?php foreach ($products as $product) : ?>
                    <option value="<?php echo $product->ID; ?>" <?php selected($product_id, $product->ID); ?>>
                        <?php echo esc_html($product->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php _e('ربط الكورس بمنتج WooCommerce للدفع', 'edupress'); ?></p>
            <p class="description">
                <?php if (empty($products)) : ?>
                    <strong style="color: #d63638;"><?php _e('لا توجد منتجات! قم بإنشاء منتج في WooCommerce أولاً.', 'edupress'); ?></strong>
                <?php endif; ?>
            </p>
        </td>
    </tr>
    <?php
}

// Inject the field into existing meta box by hooking into display
add_action('add_meta_boxes', function() {
    if (edupress_is_woocommerce_active()) {
        remove_meta_box('edupress_course_details', 'course', 'normal');
        add_meta_box(
            'edupress_course_details',
            __('تفاصيل الكورس', 'edupress'),
            'edupress_course_details_with_woocommerce_callback',
            'course',
            'normal',
            'high'
        );
    }
}, 11);

/**
 * Course Details Meta Box with WooCommerce
 */
function edupress_course_details_with_woocommerce_callback($post) {
    wp_nonce_field('edupress_save_course_details', 'edupress_course_details_nonce');

    $duration = get_post_meta($post->ID, '_course_duration', true);
    $students = get_post_meta($post->ID, '_course_students', true);
    $lessons = get_post_meta($post->ID, '_course_lessons', true);
    $price = get_post_meta($post->ID, '_course_price', true);
    $instructor_id = get_post_meta($post->ID, '_course_instructor', true);
    $video_url = get_post_meta($post->ID, '_course_video', true);
    $requirements = get_post_meta($post->ID, '_course_requirements', true);
    $objectives = get_post_meta($post->ID, '_course_objectives', true);
    $product_id = get_post_meta($post->ID, '_course_product_id', true);
    ?>

    <div style="padding: 15px;">
        <table class="form-table">
            <?php if (edupress_is_woocommerce_active()) : ?>
                <tr style="background: #e7f5ff; border: 2px solid #2563eb;">
                    <th><label for="course_product_id"><?php _e('منتج WooCommerce 🛒', 'edupress'); ?></label></th>
                    <td>
                        <?php
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC'
                        );
                        $products = get_posts($args);
                        ?>
                        <select id="course_product_id" name="course_product_id" class="regular-text">
                            <option value=""><?php _e('-- اختر منتج --', 'edupress'); ?></option>
                            <?php foreach ($products as $product) : ?>
                                <option value="<?php echo $product->ID; ?>" <?php selected($product_id, $product->ID); ?>>
                                    <?php echo esc_html($product->post_title); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?php _e('ربط الكورس بمنتج WooCommerce للدفع', 'edupress'); ?></p>
                        <?php if (empty($products)) : ?>
                            <p style="color: #d63638; font-weight: bold;">⚠️ <?php _e('لا توجد منتجات! قم بإنشاء منتج في WooCommerce أولاً.', 'edupress'); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
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
                    <?php if (edupress_is_woocommerce_active() && $product_id) : ?>
                        <p class="description" style="color: #2563eb;">ℹ️ <?php _e('سيتم استخدام سعر منتج WooCommerce عند الشراء', 'edupress'); ?></p>
                    <?php endif; ?>
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
 * Update course save to include product_id
 */
function edupress_save_course_details_updated($post_id) {
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
        'course_objectives',
        'course_product_id'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
// Remove old hook and add new one
remove_action('save_post_course', 'edupress_save_course_details');
add_action('save_post_course', 'edupress_save_course_details_updated');

/**
 * Grant course access after purchase
 */
function edupress_grant_course_access_after_purchase($order_id) {
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();

    if (!$user_id) {
        return;
    }

    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();

        // Find course linked to this product
        $courses = get_posts(array(
            'post_type' => 'course',
            'meta_key' => '_course_product_id',
            'meta_value' => $product_id,
            'posts_per_page' => 1
        ));

        if (!empty($courses)) {
            $course_id = $courses[0]->ID;
            edupress_enroll_user_in_course($user_id, $course_id);
        }
    }
}
add_action('woocommerce_order_status_completed', 'edupress_grant_course_access_after_purchase');

/**
 * Enroll user in course
 */
function edupress_enroll_user_in_course($user_id, $course_id) {
    $enrolled_courses = get_user_meta($user_id, '_enrolled_courses', true);

    if (!is_array($enrolled_courses)) {
        $enrolled_courses = array();
    }

    if (!in_array($course_id, $enrolled_courses)) {
        $enrolled_courses[] = $course_id;
        update_user_meta($user_id, '_enrolled_courses', $enrolled_courses);

        // Store enrollment date
        update_user_meta($user_id, '_course_enrolled_' . $course_id, current_time('timestamp'));
    }
}

/**
 * Check if user has access to course
 */
function edupress_user_has_course_access($user_id, $course_id) {
    if (!$user_id) {
        return false;
    }

    // Admins always have access
    if (current_user_can('manage_options')) {
        return true;
    }

    $enrolled_courses = get_user_meta($user_id, '_enrolled_courses', true);

    if (!is_array($enrolled_courses)) {
        return false;
    }

    return in_array($course_id, $enrolled_courses);
}

/**
 * Get user's enrolled courses
 */
function edupress_get_user_courses($user_id) {
    $enrolled_courses = get_user_meta($user_id, '_enrolled_courses', true);

    if (!is_array($enrolled_courses) || empty($enrolled_courses)) {
        return array();
    }

    return $enrolled_courses;
}

// ============================================
// PROGRESS TRACKING
// ============================================

/**
 * Mark lesson as completed
 */
function edupress_complete_lesson() {
    check_ajax_referer('edupress_lesson_nonce', 'nonce');

    $user_id = get_current_user_id();
    $lesson_id = intval($_POST['lesson_id']);
    $course_id = intval($_POST['course_id']);

    if (!$user_id || !$lesson_id || !$course_id) {
        wp_send_json_error('Invalid data');
    }

    // Check access
    if (!edupress_user_has_course_access($user_id, $course_id)) {
        wp_send_json_error('No access');
    }

    // Get completed lessons
    $completed = get_user_meta($user_id, '_completed_lessons_' . $course_id, true);
    if (!is_array($completed)) {
        $completed = array();
    }

    if (!in_array($lesson_id, $completed)) {
        $completed[] = $lesson_id;
        update_user_meta($user_id, '_completed_lessons_' . $course_id, $completed);

        // Update completion timestamp
        update_user_meta($user_id, '_lesson_completed_' . $lesson_id, current_time('timestamp'));
    }

    // Calculate progress
    $progress = edupress_get_course_progress($user_id, $course_id);

    wp_send_json_success(array(
        'progress' => $progress,
        'message' => 'تم إكمال الدرس!'
    ));
}
add_action('wp_ajax_edupress_complete_lesson', 'edupress_complete_lesson');

/**
 * Get course progress for user
 */
function edupress_get_course_progress($user_id, $course_id) {
    $total_lessons = edupress_get_course_lessons_count($course_id);

    if ($total_lessons == 0) {
        return 0;
    }

    $completed = get_user_meta($user_id, '_completed_lessons_' . $course_id, true);

    if (!is_array($completed)) {
        return 0;
    }

    $completed_count = count($completed);
    return round(($completed_count / $total_lessons) * 100);
}

/**
 * Get course lessons count
 */
function edupress_get_course_lessons_count($course_id) {
    $lessons = get_posts(array(
        'post_type' => 'lesson',
        'meta_key' => '_lesson_course',
        'meta_value' => $course_id,
        'posts_per_page' => -1,
        'fields' => 'ids'
    ));

    return count($lessons);
}

/**
 * Check if lesson is completed
 */
function edupress_is_lesson_completed($user_id, $lesson_id, $course_id) {
    $completed = get_user_meta($user_id, '_completed_lessons_' . $course_id, true);

    if (!is_array($completed)) {
        return false;
    }

    return in_array($lesson_id, $completed);
}

/**
 * Get course lessons
 */
function edupress_get_course_lessons($course_id) {
    $lessons = get_posts(array(
        'post_type' => 'lesson',
        'meta_key' => '_lesson_course',
        'meta_value' => $course_id,
        'posts_per_page' => -1,
        'orderby' => 'meta_value_num',
        'meta_key' => '_lesson_order',
        'order' => 'ASC'
    ));

    return $lessons;
}

/**
 * Format price using WooCommerce currency settings
 */
function edupress_format_price($price) {
    // If WooCommerce is active, use its currency settings
    if (edupress_is_woocommerce_active() && get_option('edupress_use_woo_currency', '1') == '1') {
        if (is_numeric($price) && $price > 0) {
            return wc_price($price);
        } elseif ($price === '0' || $price === 0) {
            return '<span class="free-price">' . __('مجاني', 'edupress') . '</span>';
        } else {
            return esc_html($price);
        }
    }

    // Fallback: Use default format
    if (is_numeric($price) && $price > 0) {
        return '<span class="price-amount">' . number_format($price, 2) . ' ' . __('ريال', 'edupress') . '</span>';
    } elseif ($price === '0' || $price === 0) {
        return '<span class="free-price">' . __('مجاني', 'edupress') . '</span>';
    } else {
        return esc_html($price);
    }
}

// ========================================
// Include Additional Theme Components
// ========================================

// Include theme settings
require_once get_template_directory() . '/inc/theme-settings.php';

// Include Elementor support
require_once get_template_directory() . '/inc/elementor-support.php';

// Include shortcodes
require_once get_template_directory() . '/inc/shortcodes/shortcodes.php';
