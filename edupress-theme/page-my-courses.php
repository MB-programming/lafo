<?php
/**
 * Template Name: My Courses - Dashboard
 * Description: Student dashboard to view enrolled courses and progress
 *
 * @package EduPress
 */

// Redirect to login if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id = get_current_user_id();
$enrolled_courses = edupress_get_user_courses($user_id);
?>

<!-- Student Dashboard -->
<section class="student-dashboard section">
    <div class="container">
        <!-- Dashboard Header -->
        <div class="dashboard-header" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #fff; padding: 3rem; border-radius: 1rem; margin-bottom: 3rem;">
            <div class="row" style="align-items: center;">
                <div class="col">
                    <h1 style="color: #fff; margin-bottom: 0.5rem;">مرحباً، <?php echo esc_html($current_user->display_name); ?>!</h1>
                    <p style="opacity: 0.9; font-size: 1.125rem; margin: 0;">استمر في التعلم وحقق أهدافك</p>
                </div>
                <div class="col" style="text-align: left;">
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 1rem; text-align: center; min-width: 120px;">
                            <div style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;"><?php echo count($enrolled_courses); ?></div>
                            <div style="font-size: 0.875rem; opacity: 0.9;">كورساتي</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="dashboard-tabs" style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid #e2e8f0;">
            <button class="tab-btn active" data-tab="all-courses" style="padding: 1rem 2rem; background: none; border: none; border-bottom: 3px solid #2563eb; font-weight: 600; color: #2563eb; cursor: pointer;">
                <i class="fas fa-book"></i> جميع الكورسات
            </button>
            <button class="tab-btn" data-tab="in-progress" style="padding: 1rem 2rem; background: none; border: none; border-bottom: 3px solid transparent; font-weight: 600; color: #64748b; cursor: pointer;">
                <i class="fas fa-spinner"></i> قيد الدراسة
            </button>
            <button class="tab-btn" data-tab="completed" style="padding: 1rem 2rem; background: none; border: none; border-bottom: 3px solid transparent; font-weight: 600; color: #64748b; cursor: pointer;">
                <i class="fas fa-check-circle"></i> مكتملة
            </button>
        </div>

        <!-- Courses Content -->
        <div class="tab-content" id="all-courses">
            <?php if (!empty($enrolled_courses)) : ?>
                <div class="grid grid-2" style="gap: 2rem;">
                    <?php foreach ($enrolled_courses as $course_id) :
                        $course = get_post($course_id);
                        if (!$course) continue;

                        $progress = edupress_get_course_progress($user_id, $course_id);
                        $lessons_count = edupress_get_course_lessons_count($course_id);
                        $instructor_id = get_post_meta($course_id, '_course_instructor', true);
                        $duration = get_post_meta($course_id, '_course_duration', true);
                    ?>
                        <div class="course-dashboard-card" data-status="<?php echo $progress >= 100 ? 'completed' : ($progress > 0 ? 'in-progress' : 'not-started'); ?>" style="background: #fff; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); overflow: hidden; transition: all 0.3s;">
                            <div style="display: flex; gap: 2rem;">
                                <?php if (has_post_thumbnail($course_id)) : ?>
                                    <div style="flex-shrink: 0; width: 200px; height: 150px; overflow: hidden;">
                                        <?php echo get_the_post_thumbnail($course_id, 'course-thumbnail', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                    </div>
                                <?php endif; ?>

                                <div style="flex: 1; padding: 1.5rem;">
                                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">
                                        <a href="<?php echo get_permalink($course_id); ?>" style="color: #1e293b;"><?php echo esc_html($course->post_title); ?></a>
                                    </h3>

                                    <?php if ($instructor_id) :
                                        $instructor = get_post($instructor_id);
                                        if ($instructor) :
                                    ?>
                                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">
                                            <i class="fas fa-user"></i> <?php echo esc_html($instructor->post_title); ?>
                                        </div>
                                    <?php
                                        endif;
                                    endif; ?>

                                    <div style="display: flex; gap: 1.5rem; margin-bottom: 1rem; font-size: 0.875rem; color: #64748b;">
                                        <?php if ($lessons_count > 0) : ?>
                                            <span><i class="far fa-file-alt"></i> <?php echo $lessons_count; ?> درس</span>
                                        <?php endif; ?>
                                        <?php if ($duration) : ?>
                                            <span><i class="far fa-clock"></i> <?php echo esc_html($duration); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div style="margin-bottom: 1rem;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                            <span style="font-weight: 600;">التقدم</span>
                                            <span style="color: #2563eb; font-weight: 700;"><?php echo $progress; ?>%</span>
                                        </div>
                                        <div style="height: 8px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                            <div style="height: 100%; background: linear-gradient(90deg, #2563eb, #3b82f6); width: <?php echo $progress; ?>%; transition: width 0.3s;"></div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div style="display: flex; gap: 1rem;">
                                        <a href="<?php echo add_query_arg('learn', '1', get_permalink($course_id)); ?>" class="btn btn-primary" style="flex: 1;">
                                            <?php echo $progress > 0 ? 'متابعة التعلم' : 'ابدأ الآن'; ?> <i class="fas fa-play"></i>
                                        </a>
                                        <a href="<?php echo get_permalink($course_id); ?>" class="btn btn-outline" style="padding: 0.75rem 1.5rem;">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="no-courses" style="text-align: center; padding: 4rem; background: #f1f5f9; border-radius: 1rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h2 style="margin-bottom: 1rem;">لا توجد كورسات بعد</h2>
                    <p style="color: #64748b; margin-bottom: 2rem;">ابدأ رحلتك التعليمية الآن واختر كورسك الأول!</p>
                    <a href="<?php echo get_post_type_archive_link('course'); ?>" class="btn btn-primary">
                        تصفح الكورسات <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="tab-content" id="in-progress" style="display: none;">
            <div class="grid grid-2" style="gap: 2rem;"></div>
        </div>

        <div class="tab-content" id="completed" style="display: none;">
            <div class="grid grid-2" style="gap: 2rem;"></div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Tab switching
    $('.tab-btn').on('click', function() {
        const tab = $(this).data('tab');

        // Update active tab
        $('.tab-btn').removeClass('active').css({
            'border-bottom-color': 'transparent',
            'color': '#64748b'
        });
        $(this).addClass('active').css({
            'border-bottom-color': '#2563eb',
            'color': '#2563eb'
        });

        // Filter courses
        $('.tab-content').hide();

        if (tab === 'all-courses') {
            $('#all-courses').show();
        } else {
            // Filter based on progress
            const targetContainer = $('#' + tab + ' .grid');
            targetContainer.empty();

            $('.course-dashboard-card').each(function() {
                const status = $(this).data('status');

                if (tab === 'in-progress' && status === 'in-progress') {
                    targetContainer.append($(this).clone());
                } else if (tab === 'completed' && status === 'completed') {
                    targetContainer.append($(this).clone());
                }
            });

            if (targetContainer.children().length === 0) {
                targetContainer.html('<div style="text-align: center; padding: 3rem; color: #64748b;"><i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>لا توجد كورسات في هذا القسم</div>');
            }

            $('#' + tab).show();
        }
    });

    // Course card hover effect
    $('.course-dashboard-card').on('mouseenter', function() {
        $(this).css({
            'transform': 'translateY(-5px)',
            'box-shadow': '0 10px 15px -3px rgba(0,0,0,0.1)'
        });
    }).on('mouseleave', function() {
        $(this).css({
            'transform': 'translateY(0)',
            'box-shadow': '0 4px 6px -1px rgba(0,0,0,0.1)'
        });
    });
});
</script>

<?php get_footer(); ?>
