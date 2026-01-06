<?php
/**
 * Search Results Template
 *
 * @package EduPress
 */

get_header();
?>

<section class="section">
    <div class="container">
        <header class="search-header" style="text-align: center; margin-bottom: 3rem;">
            <h1>نتائج البحث عن: "<?php echo get_search_query(); ?>"</h1>
            <p style="color: #64748b; margin-top: 0.5rem;">
                <?php
                global $wp_query;
                echo 'تم العثور على ' . $wp_query->found_posts . ' نتيجة';
                ?>
            </p>
        </header>

        <?php if (have_posts()) : ?>
            <div class="search-results grid grid-2">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('class' => 'card-image')); ?>
                            </a>
                        <?php endif; ?>

                        <div class="card-body">
                            <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">
                                <?php
                                $post_type = get_post_type();
                                $post_type_obj = get_post_type_object($post_type);
                                echo '<i class="fas fa-folder"></i> ' . $post_type_obj->labels->singular_name;
                                ?>
                            </div>

                            <h2 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="card-meta">
                                <span class="card-meta-item">
                                    <i class="far fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                            </div>

                            <div class="card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                اقرأ المزيد <i class="fas fa-arrow-left"></i>
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
            <div class="no-results" style="text-align: center; padding: 3rem; background: #f1f5f9; border-radius: 1rem;">
                <h2>لا توجد نتائج</h2>
                <p>عذراً، لم يتم العثور على نتائج تطابق بحثك. حاول استخدام كلمات مفتاحية مختلفة.</p>
                <div class="search-form" style="max-width: 500px; margin: 2rem auto 0;">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
