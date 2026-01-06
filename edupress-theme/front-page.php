<?php
/**
 * Front Page Template
 *
 * @package EduPress
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>تعلم مهارات جديدة وحقق أهدافك</h1>
            <p>انضم إلى آلاف الطلاب واكتسب المهارات التي تحتاجها للنجاح في حياتك المهنية</p>

            <!-- Search Form -->
            <div class="hero-search">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" name="s" placeholder="ابحث عن كورس..." value="<?php echo get_search_query(); ?>">
                    <input type="hidden" name="post_type" value="course">
                    <button type="submit"><i class="fas fa-search"></i> بحث</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">10,000+</div>
                <div class="stat-label">طالب نشط</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">كورس متاح</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">مدرب محترف</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <div class="stat-label">نسبة الرضا</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses -->
<?php
$featured_courses = new WP_Query(array(
    'post_type' => 'course',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC',
));

if ($featured_courses->have_posts()) :
?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">أحدث الكورسات</h2>
            <p class="section-subtitle">اكتشف أحدث الكورسات التعليمية المضافة إلى منصتنا</p>
        </div>

        <div class="grid grid-3">
            <?php while ($featured_courses->have_posts()) : $featured_courses->the_post();
                $duration = get_post_meta(get_the_ID(), '_course_duration', true);
                $students = get_post_meta(get_the_ID(), '_course_students', true);
                $lessons = get_post_meta(get_the_ID(), '_course_lessons', true);
                $price = get_post_meta(get_the_ID(), '_course_price', true);
                $instructor_id = get_post_meta(get_the_ID(), '_course_instructor', true);
                $level_terms = get_the_terms(get_the_ID(), 'course_level');
            ?>
                <article class="course-card card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="card-image-wrapper">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('course-thumbnail', array('class' => 'card-image')); ?>
                            </a>
                            <?php if (!empty($level_terms) && !is_wp_error($level_terms)) : ?>
                                <span class="course-badge course-level <?php echo esc_attr($level_terms[0]->slug); ?>">
                                    <?php echo esc_html($level_terms[0]->name); ?>
                                </span>
                            <?php endif; ?>
                        </div>
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

                        <div class="card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                        </div>

                        <?php if ($instructor_id) :
                            $instructor = get_post($instructor_id);
                            if ($instructor) :
                                $instructor_avatar = get_the_post_thumbnail_url($instructor_id, 'thumbnail');
                        ?>
                            <div class="course-instructor">
                                <?php if ($instructor_avatar) : ?>
                                    <img src="<?php echo esc_url($instructor_avatar); ?>" alt="<?php echo esc_attr($instructor->post_title); ?>" class="instructor-avatar">
                                <?php endif; ?>
                                <span><?php echo esc_html($instructor->post_title); ?></span>
                            </div>
                        <?php
                            endif;
                        endif; ?>

                        <div class="card-footer">
                            <span class="course-price">
                                <?php echo $price ? edupress_format_price($price) : edupress_format_price(0); ?>
                            </span>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo get_post_type_archive_link('course'); ?>" class="btn btn-outline">
                عرض جميع الكورسات <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); endif; ?>

<!-- Categories Section -->
<?php
$course_categories = get_terms(array(
    'taxonomy' => 'course_category',
    'hide_empty' => true,
    'number' => 8,
));

if (!empty($course_categories) && !is_wp_error($course_categories)) :
?>
<section class="section bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">تصفح حسب التصنيف</h2>
            <p class="section-subtitle">اختر المجال الذي يناسب اهتماماتك</p>
        </div>

        <div class="grid grid-4">
            <?php foreach ($course_categories as $category) : ?>
                <a href="<?php echo get_term_link($category); ?>" class="category-card" style="background: #fff; padding: 2rem; border-radius: 1rem; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: all 0.3s; display: block;">
                    <i class="fas fa-book" style="font-size: 3rem; color: #2563eb; margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: #1e293b;"><?php echo esc_html($category->name); ?></h3>
                    <p style="color: #64748b; margin: 0;"><?php echo $category->count; ?> كورس</p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Instructors Section -->
<?php
$featured_instructors = new WP_Query(array(
    'post_type' => 'instructor',
    'posts_per_page' => 4,
    'orderby' => 'rand',
));

if ($featured_instructors->have_posts()) :
?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">المدربون المميزون</h2>
            <p class="section-subtitle">تعلم من الخبراء المحترفين في مجالاتهم</p>
        </div>

        <div class="grid grid-4">
            <?php while ($featured_instructors->have_posts()) : $featured_instructors->the_post();
                $specialization = get_post_meta(get_the_ID(), '_instructor_specialization', true);
                $students = get_post_meta(get_the_ID(), '_instructor_students', true);
                $courses = get_post_meta(get_the_ID(), '_instructor_courses', true);
            ?>
                <article class="instructor-card card">
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

                        <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%;">
                            عرض الملف الشخصي
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo get_post_type_archive_link('instructor'); ?>" class="btn btn-outline">
                عرض جميع المدربين <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); endif; ?>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #fff;">
    <div class="container">
        <div class="text-center">
            <h2 style="color: #fff; font-size: 2.5rem; margin-bottom: 1rem;">هل أنت مستعد للبدء؟</h2>
            <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.95;">انضم إلى آلاف الطلاب الذين يتعلمون مهارات جديدة كل يوم</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo get_post_type_archive_link('course'); ?>" class="btn btn-secondary" style="padding: 1rem 2rem; font-size: 1.125rem;">
                    تصفح الكورسات
                </a>
                <a href="#" class="btn btn-outline" style="background: transparent; color: #fff; border-color: #fff; padding: 1rem 2rem; font-size: 1.125rem;">
                    ابدأ التجربة المجانية
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
