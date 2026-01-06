<?php
/**
 * Template for displaying Pages
 *
 * @package EduPress
 */

get_header();
?>

<div class="container section">
    <div class="row">
        <div class="col main-content">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail" style="margin-bottom: 2rem; border-radius: 1rem; overflow: hidden;">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <header class="entry-header" style="margin-bottom: 2rem;">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="comments-area" style="margin-top: 3rem;">
                            <?php comments_template(); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
