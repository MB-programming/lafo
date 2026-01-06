<?php
/**
 * Template Name: Course Learn
 * Description: Course learning page with lessons and progress tracking
 *
 * This template is loaded when ?learn=1 is added to course URL
 *
 * @package EduPress
 */

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

// Get course ID
$course_id = get_the_ID();
$user_id = get_current_user_id();

// Check if user has access to this course
if (!edupress_user_has_course_access($user_id, $course_id)) {
    wp_redirect(get_permalink($course_id));
    exit;
}

// Get lessons
$lessons = edupress_get_course_lessons($course_id);

if (empty($lessons)) {
    wp_redirect(get_permalink($course_id));
    exit;
}

// Get current lesson (from URL or first lesson)
$current_lesson_id = isset($_GET['lesson']) ? intval($_GET['lesson']) : $lessons[0]->ID;
$current_lesson = get_post($current_lesson_id);

if (!$current_lesson) {
    $current_lesson = $lessons[0];
    $current_lesson_id = $current_lesson->ID;
}

// Get lesson details
$video_url = get_post_meta($current_lesson_id, '_lesson_video', true);
$duration = get_post_meta($current_lesson_id, '_lesson_duration', true);

// Calculate progress
$progress = edupress_get_course_progress($user_id, $course_id);
$is_completed = edupress_is_lesson_completed($user_id, $current_lesson_id, $course_id);

// Find next and previous lessons
$current_index = 0;
foreach ($lessons as $index => $lesson) {
    if ($lesson->ID == $current_lesson_id) {
        $current_index = $index;
        break;
    }
}

$prev_lesson = isset($lessons[$current_index - 1]) ? $lessons[$current_index - 1] : null;
$next_lesson = isset($lessons[$current_index + 1]) ? $lessons[$current_index + 1] : null;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        body { margin: 0; padding: 0; background: #0f172a; }
        .course-learn-container { display: flex; height: 100vh; overflow: hidden; }
        .video-section { flex: 1; display: flex; flex-direction: column; background: #1e293b; }
        .sidebar-section { width: 400px; background: #0f172a; overflow-y: auto; border-right: 1px solid #334155; }
        .video-player { flex: 1; background: #000; display: flex; align-items: center; justify-content: center; position: relative; }
        .video-player iframe { width: 100%; height: 100%; border: none; }
        .lesson-content { padding: 2rem; color: #fff; }
        .lesson-header { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 2rem; border-bottom: 1px solid #334155; }
        .lesson-list { padding: 1rem; }
        .lesson-item { display: flex; align-items: center; gap: 1rem; padding: 1rem; margin-bottom: 0.5rem; background: #1e293b; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
        .lesson-item:hover { background: #334155; }
        .lesson-item.active { border-color: #2563eb; background: #1e3a8a; }
        .lesson-item.completed { border-color: #10b981; }
        .lesson-number { width: 40px; height: 40px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; flex-shrink: 0; }
        .lesson-item.active .lesson-number { background: #2563eb; }
        .lesson-item.completed .lesson-number { background: #10b981; }
        .lesson-info { flex: 1; min-width: 0; }
        .lesson-title { font-weight: 600; color: #fff; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .lesson-duration { font-size: 0.875rem; color: #94a3b8; }
        .progress-bar-container { background: #334155; height: 8px; border-radius: 999px; overflow: hidden; margin-bottom: 2rem; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, #2563eb, #3b82f6); transition: width 0.5s; }
        .lesson-actions { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn-lesson { flex: 1; padding: 1rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: Cairo, sans-serif; }
        .btn-complete { background: #10b981; color: #fff; }
        .btn-complete:hover { background: #059669; }
        .btn-complete.completed { background: #6b7280; }
        .btn-navigate { background: #334155; color: #fff; }
        .btn-navigate:hover { background: #475569; }
        .btn-navigate:disabled { opacity: 0.5; cursor: not-allowed; }
        @media (max-width: 1024px) {
            .sidebar-section { width: 320px; }
        }
        @media (max-width: 768px) {
            .course-learn-container { flex-direction: column; }
            .sidebar-section { width: 100%; height: 40vh; order: 2; }
            .video-section { order: 1; }
        }
    </style>
</head>
<body <?php body_class('course-learning'); ?>>

<div class="course-learn-container">
    <!-- Video Section -->
    <div class="video-section">
        <!-- Top Bar -->
        <div class="lesson-header">
            <div>
                <a href="<?php echo get_permalink($course_id); ?>" style="color: #94a3b8; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-arrow-right"></i> <span>العودة للكورس</span>
                </a>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="color: #94a3b8; font-size: 0.875rem;">التقدم: <?php echo $progress; ?>%</span>
                <div style="width: 120px;">
                    <div class="progress-bar-container" style="margin: 0;">
                        <div class="progress-bar" style="width: <?php echo $progress; ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Player -->
        <div class="video-player">
            <?php if ($video_url) :
                // Convert YouTube URL to embed
                $embed_url = '';
                if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $video_url, $id)) {
                    $embed_url = 'https://www.youtube.com/embed/' . $id[1] . '?rel=0&modestbranding=1';
                } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $video_url, $id)) {
                    $embed_url = 'https://www.youtube.com/embed/' . $id[1] . '?rel=0&modestbranding=1';
                } elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $id)) {
                    $embed_url = 'https://player.vimeo.com/video/' . $id[1];
                }

                if ($embed_url) :
            ?>
                <iframe src="<?php echo esc_url($embed_url); ?>" allowfullscreen allow="autoplay; fullscreen"></iframe>
            <?php else : ?>
                <div style="color: #94a3b8; text-align: center;">
                    <i class="fas fa-video" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>الفيديو غير متوفر</p>
                </div>
            <?php endif; ?>
            <?php else : ?>
                <div style="color: #94a3b8; text-align: center;">
                    <i class="fas fa-video-slash" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>لم يتم رفع فيديو لهذا الدرس بعد</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Lesson Content -->
        <div class="lesson-content">
            <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem;"><?php echo esc_html($current_lesson->post_title); ?></h1>
            <?php if ($duration) : ?>
                <p style="color: #94a3b8; margin-bottom: 1.5rem;">
                    <i class="far fa-clock"></i> <?php echo esc_html($duration); ?>
                </p>
            <?php endif; ?>

            <?php if ($current_lesson->post_content) : ?>
                <div style="color: #cbd5e1; line-height: 1.8;">
                    <?php echo apply_filters('the_content', $current_lesson->post_content); ?>
                </div>
            <?php endif; ?>

            <!-- Lesson Actions -->
            <div class="lesson-actions">
                <?php if ($prev_lesson) : ?>
                    <a href="<?php echo add_query_arg(array('learn' => '1', 'lesson' => $prev_lesson->ID), get_permalink($course_id)); ?>" class="btn-lesson btn-navigate">
                        <i class="fas fa-arrow-right"></i> الدرس السابق
                    </a>
                <?php else : ?>
                    <button class="btn-lesson btn-navigate" disabled>
                        <i class="fas fa-arrow-right"></i> الدرس السابق
                    </button>
                <?php endif; ?>

                <button class="btn-lesson btn-complete <?php echo $is_completed ? 'completed' : ''; ?>" id="complete-lesson-btn" data-lesson-id="<?php echo $current_lesson_id; ?>" data-course-id="<?php echo $course_id; ?>">
                    <?php echo $is_completed ? '<i class="fas fa-check"></i> مكتمل' : '<i class="far fa-check-circle"></i> إكمال الدرس'; ?>
                </button>

                <?php if ($next_lesson) : ?>
                    <a href="<?php echo add_query_arg(array('learn' => '1', 'lesson' => $next_lesson->ID), get_permalink($course_id)); ?>" class="btn-lesson btn-navigate">
                        الدرس التالي <i class="fas fa-arrow-left"></i>
                    </a>
                <?php else : ?>
                    <button class="btn-lesson btn-navigate" disabled>
                        الدرس التالي <i class="fas fa-arrow-left"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar - Lessons List -->
    <div class="sidebar-section">
        <div style="padding: 1.5rem; border-bottom: 1px solid #334155;">
            <h2 style="color: #fff; font-size: 1.25rem; margin-bottom: 0.5rem;">محتوى الكورس</h2>
            <p style="color: #94a3b8; font-size: 0.875rem; margin: 0;"><?php echo count($lessons); ?> درس • التقدم: <?php echo $progress; ?>%</p>
            <div class="progress-bar-container" style="margin-top: 1rem;">
                <div class="progress-bar" style="width: <?php echo $progress; ?>%;"></div>
            </div>
        </div>

        <div class="lesson-list">
            <?php foreach ($lessons as $index => $lesson) :
                $lesson_id = $lesson->ID;
                $lesson_duration = get_post_meta($lesson_id, '_lesson_duration', true);
                $lesson_completed = edupress_is_lesson_completed($user_id, $lesson_id, $course_id);
                $is_current = ($lesson_id == $current_lesson_id);
                $classes = array('lesson-item');
                if ($is_current) $classes[] = 'active';
                if ($lesson_completed) $classes[] = 'completed';
            ?>
                <a href="<?php echo add_query_arg(array('learn' => '1', 'lesson' => $lesson_id), get_permalink($course_id)); ?>" class="<?php echo implode(' ', $classes); ?>" style="text-decoration: none;">
                    <div class="lesson-number">
                        <?php if ($lesson_completed) : ?>
                            <i class="fas fa-check"></i>
                        <?php else : ?>
                            <?php echo $index + 1; ?>
                        <?php endif; ?>
                    </div>
                    <div class="lesson-info">
                        <div class="lesson-title"><?php echo esc_html($lesson->post_title); ?></div>
                        <?php if ($lesson_duration) : ?>
                            <div class="lesson-duration">
                                <i class="far fa-clock"></i> <?php echo esc_html($lesson_duration); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($is_current) : ?>
                        <i class="fas fa-play-circle" style="color: #2563eb; font-size: 1.5rem;"></i>
                    <?php elseif ($lesson_completed) : ?>
                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.5rem;"></i>
                    <?php else : ?>
                        <i class="far fa-circle" style="color: #475569; font-size: 1.5rem;"></i>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Complete lesson button
    $('#complete-lesson-btn').on('click', function() {
        const btn = $(this);
        const lessonId = btn.data('lesson-id');
        const courseId = btn.data('course-id');

        if (btn.hasClass('completed')) {
            return;
        }

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...');

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'edupress_complete_lesson',
                lesson_id: lessonId,
                course_id: courseId,
                nonce: '<?php echo wp_create_nonce('edupress_lesson_nonce'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    btn.addClass('completed').html('<i class="fas fa-check"></i> مكتمل');

                    // Update progress bars
                    const newProgress = response.data.progress;
                    $('.progress-bar').css('width', newProgress + '%');
                    $('.lesson-header span').text('التقدم: ' + newProgress + '%');

                    // Show success message
                    alert(response.data.message);

                    // Reload page to update lesson completion
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    alert('حدث خطأ، حاول مرة أخرى');
                    btn.prop('disabled', false).html('<i class="far fa-check-circle"></i> إكمال الدرس');
                }
            },
            error: function() {
                alert('حدث خطأ في الاتصال');
                btn.prop('disabled', false).html('<i class="far fa-check-circle"></i> إكمال الدرس');
            }
        });
    });

    // Keyboard navigation
    $(document).on('keydown', function(e) {
        // Right arrow = previous lesson
        if (e.keyCode === 39) {
            const prevBtn = $('.lesson-actions a:first-child');
            if (prevBtn.length) {
                window.location.href = prevBtn.attr('href');
            }
        }
        // Left arrow = next lesson
        if (e.keyCode === 37) {
            const nextBtn = $('.lesson-actions a:last-child');
            if (nextBtn.length) {
                window.location.href = nextBtn.attr('href');
            }
        }
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>
