<?php
/**
 * 404 Error Page Template
 *
 * @package EduPress
 */

get_header();
?>

<section class="section" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="container">
        <div class="error-404" style="text-align: center; max-width: 600px; margin: 0 auto;">
            <div style="font-size: 8rem; font-weight: 700; color: #2563eb; line-height: 1; margin-bottom: 1rem;">404</div>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">الصفحة غير موجودة</h1>
            <p style="font-size: 1.125rem; color: #64748b; margin-bottom: 2rem;">عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>

            <!-- Search Form -->
            <div class="error-search" style="max-width: 500px; margin: 0 auto 2rem;">
                <?php get_search_form(); ?>
            </div>

            <!-- Helpful Links -->
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i> الصفحة الرئيسية
                </a>
                <a href="<?php echo get_post_type_archive_link('course'); ?>" class="btn btn-outline">
                    <i class="fas fa-book"></i> تصفح الكورسات
                </a>
            </div>

            <!-- Popular Courses -->
            <?php
            $popular_courses = new WP_Query(array(
                'post_type' => 'course',
                'posts_per_page' => 3,
                'orderby' => 'rand',
            ));

            if ($popular_courses->have_posts()) :
            ?>
                <div style="margin-top: 3rem;">
                    <h2 style="margin-bottom: 2rem;">أو جرب هذه الكورسات</h2>
                    <div class="grid grid-3">
                        <?php while ($popular_courses->have_posts()) : $popular_courses->the_post();
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
    </div>
</section>

<?php get_footer(); ?>
