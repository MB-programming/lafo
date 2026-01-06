<?php
/**
 * Template for displaying Courses Archive
 *
 * @package EduPress
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>جميع الكورسات</h1>
            <p>اكتشف مجموعة واسعة من الكورسات التعليمية المصممة لتطوير مهاراتك</p>

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

<!-- Courses Section -->
<section class="section">
    <div class="container">
        <!-- Filter Options -->
        <div class="course-filters">
            <div class="filter-group">
                <label>تصنيف:</label>
                <select id="category-filter">
                    <option value="">جميع التصنيفات</option>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'course_category',
                        'hide_empty' => true,
                    ));
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="filter-group">
                <label>المستوى:</label>
                <select id="level-filter">
                    <option value="">جميع المستويات</option>
                    <?php
                    $levels = get_terms(array(
                        'taxonomy' => 'course_level',
                        'hide_empty' => true,
                    ));
                    foreach ($levels as $level) {
                        echo '<option value="' . esc_attr($level->slug) . '">' . esc_html($level->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <?php if (have_posts()) : ?>
            <div class="courses-grid grid grid-3">
                <?php while (have_posts()) : the_post();
                    $duration = get_post_meta(get_the_ID(), '_course_duration', true);
                    $students = get_post_meta(get_the_ID(), '_course_students', true);
                    $lessons = get_post_meta(get_the_ID(), '_course_lessons', true);
                    $price = get_post_meta(get_the_ID(), '_course_price', true);
                    $instructor_id = get_post_meta(get_the_ID(), '_course_instructor', true);
                    $level_terms = get_the_terms(get_the_ID(), 'course_level');
                ?>
                    <article id="course-<?php the_ID(); ?>" <?php post_class('course-card card'); ?>>
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
                                <span class="course-price <?php echo (strtolower($price) === 'مجاني' || strtolower($price) === 'free') ? 'free' : ''; ?>">
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
                <h2>لا توجد كورسات</h2>
                <p>عذراً، لم يتم العثور على كورسات في الوقت الحالي.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
