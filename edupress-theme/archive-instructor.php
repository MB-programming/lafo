<?php
/**
 * Template for displaying Instructors Archive
 *
 * @package EduPress
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>المدربون المحترفون</h1>
            <p>تعلم من خبراء مختصين في مجالاتهم مع سنوات من الخبرة العملية</p>
        </div>
    </div>
</section>

<!-- Instructors Section -->
<section class="section">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="instructors-grid grid grid-4">
                <?php while (have_posts()) : the_post();
                    $specialization = get_post_meta(get_the_ID(), '_instructor_specialization', true);
                    $experience = get_post_meta(get_the_ID(), '_instructor_experience', true);
                    $students = get_post_meta(get_the_ID(), '_instructor_students', true);
                    $courses = get_post_meta(get_the_ID(), '_instructor_courses', true);
                    $facebook = get_post_meta(get_the_ID(), '_instructor_facebook', true);
                    $twitter = get_post_meta(get_the_ID(), '_instructor_twitter', true);
                    $linkedin = get_post_meta(get_the_ID(), '_instructor_linkedin', true);
                ?>
                    <article id="instructor-<?php the_ID(); ?>" <?php post_class('instructor-card card'); ?>>
                        <div class="card-body">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('instructor-avatar', array('class' => 'card-image')); ?>
                                </a>
                            <?php endif; ?>

                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <?php if ($specialization) : ?>
                                <div class="instructor-specialization">
                                    <?php echo esc_html($specialization); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (has_excerpt()) : ?>
                                <div class="card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </div>
                            <?php endif; ?>

                            <div class="instructor-stats" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin: 1rem 0; padding: 1rem; background: #f1f5f9; border-radius: 0.5rem;">
                                <?php if ($students) : ?>
                                    <div style="text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: #2563eb;"><?php echo esc_html(number_format($students)); ?></div>
                                        <div style="font-size: 0.875rem; color: #64748b;">طالب</div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($courses) : ?>
                                    <div style="text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: #2563eb;"><?php echo esc_html($courses); ?></div>
                                        <div style="font-size: 0.875rem; color: #64748b;">كورس</div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($facebook || $twitter || $linkedin) : ?>
                                <div class="instructor-social">
                                    <?php if ($facebook) : ?>
                                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" aria-label="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($twitter) : ?>
                                        <a href="<?php echo esc_url($twitter); ?>" target="_blank" aria-label="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($linkedin) : ?>
                                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                                عرض الملف الشخصي
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('<i class="fas fa-arrow-right"></i> السابق', 'edupress'),
                    'next_text' => __('التالي <i class="fas fa-arrow-left"></i>', 'edupress'),
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="no-results">
                <h2>لا يوجد مدربون</h2>
                <p>عذراً، لم يتم العثور على مدربين في الوقت الحالي.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
