<?php
/**
 * Template for displaying Single Course
 *
 * @package EduPress
 */

get_header();

while (have_posts()) : the_post();
    $duration = get_post_meta(get_the_ID(), '_course_duration', true);
    $students = get_post_meta(get_the_ID(), '_course_students', true);
    $lessons = get_post_meta(get_the_ID(), '_course_lessons', true);
    $price = get_post_meta(get_the_ID(), '_course_price', true);
    $instructor_id = get_post_meta(get_the_ID(), '_course_instructor', true);
    $video_url = get_post_meta(get_the_ID(), '_course_video', true);
    $requirements = get_post_meta(get_the_ID(), '_course_requirements', true);
    $objectives = get_post_meta(get_the_ID(), '_course_objectives', true);
    $level_terms = get_the_terms(get_the_ID(), 'course_level');
    $category_terms = get_the_terms(get_the_ID(), 'course_category');
?>

<!-- Course Hero -->
<section class="course-hero" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #fff; padding: 3rem 0;">
    <div class="container">
        <div class="row">
            <div class="col" style="flex: 2;">
                <h1 style="color: #fff; margin-bottom: 1rem;"><?php the_title(); ?></h1>

                <div class="course-excerpt" style="font-size: 1.125rem; margin-bottom: 1.5rem; opacity: 0.95;">
                    <?php the_excerpt(); ?>
                </div>

                <div class="course-meta-info" style="display: flex; gap: 2rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                    <?php if (!empty($level_terms) && !is_wp_error($level_terms)) : ?>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-signal"></i>
                            المستوى: <?php echo esc_html($level_terms[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($duration) : ?>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="far fa-clock"></i>
                            <?php echo esc_html($duration); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($lessons) : ?>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="far fa-file-alt"></i>
                            <?php echo esc_html($lessons); ?> درس
                        </span>
                    <?php endif; ?>

                    <?php if ($students) : ?>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="far fa-user"></i>
                            <?php echo esc_html($students); ?> طالب
                        </span>
                    <?php endif; ?>
                </div>

                <?php if ($instructor_id) :
                    $instructor = get_post($instructor_id);
                    if ($instructor) :
                        $instructor_avatar = get_the_post_thumbnail_url($instructor_id, 'thumbnail');
                        $instructor_specialization = get_post_meta($instructor_id, '_instructor_specialization', true);
                ?>
                    <div class="course-instructor-info" style="display: flex; align-items: center; gap: 1rem; background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 0.5rem;">
                        <?php if ($instructor_avatar) : ?>
                            <img src="<?php echo esc_url($instructor_avatar); ?>" alt="<?php echo esc_attr($instructor->post_title); ?>" style="width: 60px; height: 60px; border-radius: 50%; border: 3px solid #fff;">
                        <?php endif; ?>
                        <div>
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">المدرب: <?php echo esc_html($instructor->post_title); ?></div>
                            <?php if ($instructor_specialization) : ?>
                                <div style="opacity: 0.9; font-size: 0.875rem;"><?php echo esc_html($instructor_specialization); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                    endif;
                endif; ?>
            </div>

            <div class="col">
                <?php if (has_post_thumbnail()) : ?>
                    <div style="border-radius: 1rem; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Course Content -->
<section class="section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col" style="flex: 2;">
                <!-- Video -->
                <?php if ($video_url) : ?>
                    <div class="course-video" style="margin-bottom: 2rem; border-radius: 1rem; overflow: hidden;">
                        <?php
                        // تحويل رابط YouTube إلى embed
                        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $video_url, $id)) {
                            $video_id = $id[1];
                            echo '<iframe width="100%" height="450" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
                        } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $video_url, $id)) {
                            $video_id = $id[1];
                            echo '<iframe width="100%" height="450" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Description -->
                <div class="course-description" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                    <h2 style="margin-bottom: 1.5rem; color: #1e293b; border-bottom: 3px solid #2563eb; padding-bottom: 0.75rem; display: inline-block;">وصف الكورس</h2>
                    <div class="course-content">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Objectives -->
                <?php if ($objectives) : ?>
                    <div class="course-objectives" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                        <h2 style="margin-bottom: 1.5rem; color: #1e293b; border-bottom: 3px solid #2563eb; padding-bottom: 0.75rem; display: inline-block;">ماذا ستتعلم؟</h2>
                        <ul style="list-style: none; padding: 0;">
                            <?php
                            $objectives_array = explode("\n", $objectives);
                            foreach ($objectives_array as $objective) {
                                if (trim($objective)) {
                                    echo '<li style="padding: 0.75rem; margin-bottom: 0.5rem; background: #f1f5f9; border-right: 4px solid #10b981; display: flex; gap: 0.75rem;"><i class="fas fa-check-circle" style="color: #10b981; margin-top: 0.25rem;"></i><span>' . esc_html(trim($objective)) . '</span></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Requirements -->
                <?php if ($requirements) : ?>
                    <div class="course-requirements" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                        <h2 style="margin-bottom: 1.5rem; color: #1e293b; border-bottom: 3px solid #2563eb; padding-bottom: 0.75rem; display: inline-block;">المتطلبات</h2>
                        <ul style="list-style: none; padding: 0;">
                            <?php
                            $requirements_array = explode("\n", $requirements);
                            foreach ($requirements_array as $requirement) {
                                if (trim($requirement)) {
                                    echo '<li style="padding: 0.75rem; margin-bottom: 0.5rem; background: #fef3c7; border-right: 4px solid #f59e0b; display: flex; gap: 0.75rem;"><i class="fas fa-info-circle" style="color: #f59e0b; margin-top: 0.25rem;"></i><span>' . esc_html(trim($requirement)) . '</span></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Comments -->
                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="course-comments" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col">
                <!-- Enrollment Card -->
                <div class="enrollment-card" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); position: sticky; top: 2rem;">
                    <div class="price" style="text-align: center; margin-bottom: 1.5rem;">
                        <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">سعر الكورس</div>
                        <div style="font-size: 2.5rem; font-weight: 700; color: #2563eb;">
                            <?php echo $price ? esc_html($price) . (is_numeric($price) ? ' ريال' : '') : 'مجاني'; ?>
                        </div>
                    </div>

                    <button class="btn btn-primary" style="width: 100%; margin-bottom: 1rem; padding: 1rem; font-size: 1.125rem;">
                        <i class="fas fa-shopping-cart"></i> سجل الآن
                    </button>

                    <div class="course-features" style="border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                        <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">يتضمن الكورس:</h3>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem; border-bottom: 1px solid #f1f5f9;"><i class="fas fa-video" style="color: #2563eb;"></i> فيديوهات عالية الجودة</li>
                            <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem; border-bottom: 1px solid #f1f5f9;"><i class="fas fa-file-download" style="color: #2563eb;"></i> مواد تعليمية قابلة للتحميل</li>
                            <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem; border-bottom: 1px solid #f1f5f9;"><i class="fas fa-infinity" style="color: #2563eb;"></i> وصول مدى الحياة</li>
                            <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem; border-bottom: 1px solid #f1f5f9;"><i class="fas fa-mobile-alt" style="color: #2563eb;"></i> الوصول عبر الجوال</li>
                            <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-certificate" style="color: #2563eb;"></i> شهادة إتمام</li>
                        </ul>
                    </div>

                    <div class="share-course" style="border-top: 1px solid #e2e8f0; padding-top: 1.5rem; margin-top: 1.5rem;">
                        <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">شارك الكورس:</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="flex: 1; padding: 0.75rem; background: #3b5998; color: #fff; text-align: center; border-radius: 0.5rem; transition: all 0.3s;"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" style="flex: 1; padding: 0.75rem; background: #1da1f2; color: #fff; text-align: center; border-radius: 0.5rem; transition: all 0.3s;"><i class="fab fa-twitter"></i></a>
                            <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" target="_blank" style="flex: 1; padding: 0.75rem; background: #25d366; color: #fff; text-align: center; border-radius: 0.5rem; transition: all 0.3s;"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Courses -->
<?php
$related_courses = new WP_Query(array(
    'post_type' => 'course',
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID()),
    'orderby' => 'rand',
));

if ($related_courses->have_posts()) :
?>
    <section class="section bg-light">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">كورسات ذات صلة</h2>
                <p class="section-subtitle">قد تكون مهتماً بهذه الكورسات أيضاً</p>
            </div>

            <div class="grid grid-3">
                <?php while ($related_courses->have_posts()) : $related_courses->the_post();
                    $r_price = get_post_meta(get_the_ID(), '_course_price', true);
                    $r_duration = get_post_meta(get_the_ID(), '_course_duration', true);
                    $r_students = get_post_meta(get_the_ID(), '_course_students', true);
                ?>
                    <article class="course-card card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('course-thumbnail', array('class' => 'card-image')); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="card-meta">
                                <?php if ($r_duration) : ?>
                                    <span class="card-meta-item">
                                        <i class="far fa-clock"></i>
                                        <?php echo esc_html($r_duration); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($r_students) : ?>
                                    <span class="card-meta-item">
                                        <i class="far fa-user"></i>
                                        <?php echo esc_html($r_students); ?> طالب
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="card-footer">
                                <span class="course-price">
                                    <?php echo $r_price ? esc_html($r_price) . (is_numeric($r_price) ? ' ريال' : '') : 'مجاني'; ?>
                                </span>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php
    wp_reset_postdata();
endif;
?>

<?php endwhile; ?>

<?php get_footer(); ?>
