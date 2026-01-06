<?php
/**
 * Template for displaying Single Instructor
 *
 * @package EduPress
 */

get_header();

while (have_posts()) : the_post();
    $specialization = get_post_meta(get_the_ID(), '_instructor_specialization', true);
    $experience = get_post_meta(get_the_ID(), '_instructor_experience', true);
    $students = get_post_meta(get_the_ID(), '_instructor_students', true);
    $courses_count = get_post_meta(get_the_ID(), '_instructor_courses', true);
    $facebook = get_post_meta(get_the_ID(), '_instructor_facebook', true);
    $twitter = get_post_meta(get_the_ID(), '_instructor_twitter', true);
    $linkedin = get_post_meta(get_the_ID(), '_instructor_linkedin', true);
    $email = get_post_meta(get_the_ID(), '_instructor_email', true);
?>

<!-- Instructor Header -->
<section class="instructor-header" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #fff; padding: 4rem 0;">
    <div class="container">
        <div class="row" style="align-items: center;">
            <div class="col" style="text-align: center;">
                <?php if (has_post_thumbnail()) : ?>
                    <div style="width: 200px; height: 200px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; border: 6px solid #fff; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);">
                        <?php the_post_thumbnail('instructor-avatar'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col" style="flex: 2;">
                <h1 style="color: #fff; margin-bottom: 0.5rem;"><?php the_title(); ?></h1>

                <?php if ($specialization) : ?>
                    <div style="font-size: 1.25rem; margin-bottom: 1rem; color: #fbbf24; font-weight: 600;">
                        <?php echo esc_html($specialization); ?>
                    </div>
                <?php endif; ?>

                <?php if (has_excerpt()) : ?>
                    <div style="font-size: 1.125rem; margin-bottom: 1.5rem; opacity: 0.95; line-height: 1.8;">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <!-- Stats -->
                <div style="display: flex; gap: 2rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                    <?php if ($experience) : ?>
                        <div style="background: rgba(255,255,255,0.1); padding: 1rem 1.5rem; border-radius: 0.5rem;">
                            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">الخبرة</div>
                            <div style="font-size: 1.25rem; font-weight: 700;"><?php echo esc_html($experience); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($students) : ?>
                        <div style="background: rgba(255,255,255,0.1); padding: 1rem 1.5rem; border-radius: 0.5rem;">
                            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">الطلاب</div>
                            <div style="font-size: 1.25rem; font-weight: 700;"><?php echo esc_html(number_format($students)); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($courses_count) : ?>
                        <div style="background: rgba(255,255,255,0.1); padding: 1rem 1.5rem; border-radius: 0.5rem;">
                            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">الكورسات</div>
                            <div style="font-size: 1.25rem; font-weight: 700;"><?php echo esc_html($courses_count); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social Links -->
                <?php if ($facebook || $twitter || $linkedin) : ?>
                    <div style="display: flex; gap: 1rem;">
                        <?php if ($facebook) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" target="_blank" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.2); border-radius: 50%; color: #fff; font-size: 1.25rem; transition: all 0.3s;" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($twitter) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.2); border-radius: 50%; color: #fff; font-size: 1.25rem; transition: all 0.3s;" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($linkedin) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.2); border-radius: 50%; color: #fff; font-size: 1.25rem; transition: all 0.3s;" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.2); border-radius: 50%; color: #fff; font-size: 1.25rem; transition: all 0.3s;" aria-label="Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Instructor Content -->
<section class="section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col" style="flex: 2;">
                <!-- Biography -->
                <div class="instructor-bio" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                    <h2 style="margin-bottom: 1.5rem; color: #1e293b; border-bottom: 3px solid #2563eb; padding-bottom: 0.75rem; display: inline-block;">نبذة عن المدرب</h2>
                    <div class="instructor-content">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Instructor Courses -->
                <?php
                $instructor_courses = new WP_Query(array(
                    'post_type' => 'course',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => '_course_instructor',
                            'value' => get_the_ID(),
                            'compare' => '='
                        )
                    ),
                ));

                if ($instructor_courses->have_posts()) :
                ?>
                    <div class="instructor-courses" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h2 style="margin-bottom: 1.5rem; color: #1e293b; border-bottom: 3px solid #2563eb; padding-bottom: 0.75rem; display: inline-block;">الكورسات المقدمة</h2>

                        <div class="grid grid-2">
                            <?php while ($instructor_courses->have_posts()) : $instructor_courses->the_post();
                                $duration = get_post_meta(get_the_ID(), '_course_duration', true);
                                $students = get_post_meta(get_the_ID(), '_course_students', true);
                                $lessons = get_post_meta(get_the_ID(), '_course_lessons', true);
                                $price = get_post_meta(get_the_ID(), '_course_price', true);
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
                                            <?php if ($duration) : ?>
                                                <span class="card-meta-item">
                                                    <i class="far fa-clock"></i>
                                                    <?php echo esc_html($duration); ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($lessons) : ?>
                                                <span class="card-meta-item">
                                                    <i class="far fa-file-alt"></i>
                                                    <?php echo esc_html($lessons); ?> درس
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($students) : ?>
                                                <span class="card-meta-item">
                                                    <i class="far fa-user"></i>
                                                    <?php echo esc_html($students); ?> طالب
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="card-footer">
                                            <span class="course-price">
                                                <?php echo $price ? esc_html($price) . (is_numeric($price) ? ' ريال' : '') : 'مجاني'; ?>
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
                <?php
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <!-- Sidebar -->
            <div class="col">
                <!-- Contact Card -->
                <div class="contact-card" style="background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); position: sticky; top: 2rem;">
                    <h3 style="margin-bottom: 1.5rem; text-align: center;">تواصل مع المدرب</h3>

                    <?php if ($email) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-primary" style="width: 100%; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            <i class="fas fa-envelope"></i>
                            إرسال رسالة
                        </a>
                    <?php endif; ?>

                    <div style="border-top: 1px solid #e2e8f0; padding-top: 1.5rem; margin-top: 1.5rem;">
                        <h4 style="font-size: 1rem; margin-bottom: 1rem;">متابعة على:</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <?php if ($facebook) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f1f5f9; border-radius: 0.5rem; transition: all 0.3s;">
                                    <i class="fab fa-facebook-f" style="color: #3b5998; font-size: 1.25rem;"></i>
                                    <span>Facebook</span>
                                </a>
                            <?php endif; ?>

                            <?php if ($twitter) : ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f1f5f9; border-radius: 0.5rem; transition: all 0.3s;">
                                    <i class="fab fa-twitter" style="color: #1da1f2; font-size: 1.25rem;"></i>
                                    <span>Twitter</span>
                                </a>
                            <?php endif; ?>

                            <?php if ($linkedin) : ?>
                                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f1f5f9; border-radius: 0.5rem; transition: all 0.3s;">
                                    <i class="fab fa-linkedin-in" style="color: #0077b5; font-size: 1.25rem;"></i>
                                    <span>LinkedIn</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
