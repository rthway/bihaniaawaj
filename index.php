
<?php get_header(); ?>
<main class="container py-5">

<?php

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'meta_key'       => '_bihani_featured_post',
    'meta_value'     => 'yes',
);

$featured_query = new WP_Query($args);

if ($featured_query->have_posts()) :
    while ($featured_query->have_posts()) : $featured_query->the_post();

        // Get the post thumbnail URL
        $thumbnail_id = get_post_thumbnail_id();
        $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
        ?>
        
        <div class="featured-post text-center">
            <h2 class="post-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            
            <div class="post-meta">
                <span class="post-author"><?php the_author(); ?></span> | 
                <span class="post-time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' अघि'; ?></span> | 
                <span class="post-comments"><?php comments_number(); ?></span>
            </div>

            <?php if ($thumbnail_url): ?>
                <div class="post-thumbnail">
                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title(); ?>" class="img-fluid" />
                </div>
            <?php endif; ?>

            <div class="post-content">
                <?php 
                $content = wp_trim_words(get_the_content(), 25, '...'); 
                echo $content; 
                ?>
            </div>

            <a href="<?php the_permalink(); ?>" class="read-more">थप पढ्नुहोस्</a>
        </div>

    <?php endwhile;
    wp_reset_postdata();
else :
    echo '<p>No featured posts found.</p>';
endif;
?>



<hr>




<?php
get_template_part('template-parts/category-politics'); 
?>

<?php
get_template_part('template-parts/category-society'); 
?>
<?php
get_template_part('template-parts/category-education'); 
?>
<?php
get_template_part('template-parts/category-health'); 
?>
<?php
get_template_part('template-parts/category-sports'); 
?>
<?php
get_template_part('template-parts/catagory-entertainment'); 
?>
<?php
get_template_part('template-parts/category-science'); 
?>
<?php
get_template_part('template-parts/category-video'); 
?>
<?php
get_template_part('template-parts/category-world'); 
?>
<?php
get_template_part('template-parts/category-lifestyle'); 
?>
<?php
get_template_part('template-parts/category-blog'); 
?>

<?php
get_template_part('template-parts/category-interview'); 
?>


</main>
<?php get_footer(); ?>