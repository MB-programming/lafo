<?php
/**
 * Main Template File
 *
 * @package EduPress
 */

get_header();
?>

<div class="container">
    <div class="row">
        <div class="col main-content">
            <?php if (have_posts()) : ?>
                <div class="posts-grid grid grid-2">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('class' => 'card-image')); ?>
                                </a>
                            <?php endif; ?>

                            <div class="card-body">
                                <h2 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="card-meta">
                                    <span class="card-meta-item">
                                        <i class="far fa-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span class="card-meta-item">
                                        <i class="far fa-user"></i>
                                        <?php the_author(); ?>
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
                <div class="no-results">
                    <h2>لا توجد نتائج</h2>
                    <p>عذراً، لم يتم العثور على محتوى.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
