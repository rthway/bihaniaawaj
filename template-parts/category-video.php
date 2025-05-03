<style>
.video-section-wrapper {
    padding-inline: 16%; /* 15% left and right space */
    background-color: #f8f9fa;
}

.video-section {
    padding: 40px 0;
}

.video-section h2.section-title {
    font-size: 32px;
    font-weight: bold;
    text-align: left;
    margin-bottom: 40px;
    color: #0056b3;
}

.card-title {
    font-size: 20px;
    font-weight: 600;
    color: #0056b3;
}

.card-text {
    font-size: 16px;
    color: #444;
}

.card {
    overflow: hidden;
    border-radius: 0.5rem;
}

.card-img-top-fixed {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}
</style>

<div class="video-section-wrapper">
    <div class="video-section">
        <h2 class="section-title">भिडियो </h2>
        <hr>
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php
                $args = array(
                    'post_type' => 'video',
                    'posts_per_page' => -1,
                );

                $video_query = new WP_Query($args);

                if ($video_query->have_posts()) :
                    while ($video_query->have_posts()) : $video_query->the_post(); ?>
                    
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', ['class' => 'card-img-top-fixed']); ?>
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <div class="card-text">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="text-center">No videos found.</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
