<?php
/**
 * The template for displaying search results pages.
 *
 * @package Bihani
 */

get_header(); ?>

<div class="container my-5">
    <h1 class="mb-4">
        <?php printf( esc_html__( 'Search Results for: %s', 'bihani' ), '<span>' . get_search_query() . '</span>' ); ?>
    </h1>

    <?php if ( have_posts() ) : ?>
        <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium', ['class' => 'card-img-top'] ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>
                            <p class="card-text"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><?php echo get_the_date(); ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php
            the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => __( '« Prev', 'bihani' ),
                'next_text' => __( 'Next »', 'bihani' ),
            ) );
            ?>
        </div>

    <?php else : ?>
        <div class="alert alert-warning">
            <p><?php esc_html_e( 'No results found. Please try a different search.', 'bihani' ); ?></p>
        </div>
        <?php get_search_form(); ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
