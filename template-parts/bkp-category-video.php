<?php
$args = array(
    'post_type' => 'video',
    'posts_per_page' => -1, // Get all posts; change as needed
);

$video_query = new WP_Query($args);

if ($video_query->have_posts()) :
    while ($video_query->have_posts()) : $video_query->the_post(); ?>
    
        <div class="video-post">
            <h2><?php the_title(); ?></h2>
            <div class="video-thumbnail">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium'); // Change size as needed
                } ?>
            </div>
            <div class="video-content">
                <?php the_content(); ?>
            </div>
        </div>

    <?php endwhile;
    wp_reset_postdata();
else :
    echo '<p>No videos found.</p>';
endif;
?>
