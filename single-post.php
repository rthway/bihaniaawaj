<?php get_header(); ?>

<div class="container my-5">
    <div class="row">

        <!-- Main Content (8 columns) -->
        <div class="col-lg-8 pe-lg-5" >

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <!-- Post Heading -->
                <h1 class="mb-3 custom-heading"><?php the_title(); ?></h1>
                

                <!-- Author, Date & Text Size -->
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                    <div class="text-muted">
                    <?php echo get_avatar(get_the_author_meta('ID'), 64, '', '', ['class' => 'rounded-circle me-3']); ?>

                    <?php the_author(); ?> | <i class="fa fa-clock-o"></i><?php echo get_the_date(); ?> 

                    </div>
                    <div class="text-size-options">
                        <span class="me-2">Text Size:</span>
                        <button class="btn btn-sm btn-light me-1" onclick="changeTextSize('small')">S</button>
                        <button class="btn btn-sm btn-light me-1" onclick="changeTextSize('medium')">M</button>
                        <button class="btn btn-sm btn-light" onclick="changeTextSize('large')">L</button>
                    </div>
                </div>
                <!-- Reading Time -->
                <div>
                    <strong style="color:rgb(11, 67, 116); font-size: 1.5em; font-weight: 600;">
                        पढ्न लाग्ने समय : <?php echo reading_time(); ?> मिनेट
                    </strong>
                </div>
                <br>


                <!-- Thumbnail -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-4">
                        <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                    </div>
                <?php endif; ?>
                <?php echo sharethis_inline_buttons(); ?>
                <br>

                <!-- Post Content -->
                <div id="post-content" class="post-content mb-5 text-justify">
                    <?php the_content(); ?>
                </div>
                <?php echo sharethis_inline_buttons(); ?>
                <br>
                
                <!-- Comments Section -->
                <div class="comments-section mt-5">
                    <h3 class="mb-4 border-bottom pb-2">टिप्पणी गर्नुहोस्</h3>
                   
                    <div class="fb-comments" 
                        data-href="<?php the_permalink(); ?>" 
                        data-width="100%" 
                        data-numposts="5">
                    </div>
                </div>

                <!-- Related News -->
                <div class="related-news mt-5">
                    <h3 class="mb-4 border-bottom pb-2">सम्बन्धित खबर</h3>
                    <div class="row">
                        <?php
                        $related = new WP_Query([
                            'category__in'   => wp_get_post_categories($post->ID),
                            'posts_per_page' => 6,
                            'post__not_in'   => [$post->ID]
                        ]);

                        if ($related->have_posts()) :
                            while ($related->have_posts()) : $related->the_post(); ?>
                                <div class="col-md-4 mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid mb-2']); ?>
                                        <?php endif; ?>
                                        <h6><?php the_title(); ?></h6>
                                    </a>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata();
                        else : ?>
                            <p>No related news found.</p>
                        <?php endif; ?>
                    </div>
                </div>
                


            <?php endwhile; endif; ?>
            <!-- Popular News Filter Section -->
            <div class="popular-news mb-5">
                <h3 class="mb-4 border-bottom pb-2">लोकप्रिय</h3>

                <ul class="nav nav-pills mb-3" id="popular-tabs">
                    <li class="nav-item">
                        <button class="nav-link active" data-range="all">लोकप्रिय</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-range="24">२४ घण्टा</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-range="week">यो साता</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-range="month">यो महिना</button>
                    </li>
                </ul>

                <div id="popular-news-list" class="row">
                    <?php
                    $popular_default = new WP_Query([
                        'posts_per_page' => 6,
                        'meta_key'       => 'post_views_count',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC'
                    ]);

                    if ($popular_default->have_posts()) :
                        while ($popular_default->have_posts()) : $popular_default->the_post(); ?>
                            <div class="col-md-4 mb-3">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium', ['class' => 'img-fluid mb-2']); ?>
                                    <?php endif; ?>
                                    <h6><?php the_title(); ?></h6>
                                </a>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>समाचार फेला परेन।</p>';
                    endif;
                    ?>
                </div>
            </div>

        </div>

        <!-- Sidebar (4 columns) -->
        <div class="col-lg-4">
            <?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
                <div id="sidebar" class="widget-area">
                    <?php dynamic_sidebar( 'main-sidebar' ); ?>
                </div>
            <?php else : ?>
                <p>No widgets found. </p>
            <?php endif; ?>
        </div>


    </div>
</div>

<!-- Text Size Script -->
<script>
    function changeTextSize(size) {
        const content = document.getElementById('post-content');
        content.style.fontSize = size === 'small' ? '1.2em' :
                                 size === 'medium' ? '1.5em' :
                                 '1.8em'; // Default to large
    }
</script>

<?php get_footer(); ?>
<style>
    .text-justify {
    text-align: justify;
    }

    /* Popular Tabs Styling */
#popular-tabs .nav-link {
    cursor: pointer;
    color: #555;
    font-size: 16px;
    font-weight: 500;
    margin-right: 10px;
    border-radius: 0;
}

#popular-tabs .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
}

/* Headline section */
.popular-news h3 {
    font-size: 2em;
    font-weight: 700;
    color: #222;
    border-bottom: 2px solid #ddd;
    padding-bottom: 8px;
}

/* News items */
#popular-news-list h6 {
    font-size: 1.5em;
    line-height: 1.4;
    color: #333;
    margin: 0;
}

#popular-news-list a:hover h6 {
    color: #0d6efd;
    text-decoration: underline;
}

/* Thumbnail image (optional enhancement) */
#popular-news-list img {
    border-radius: 4px;
    transition: transform 0.2s ease;
}
#popular-news-list img:hover {
    transform: scale(1.03);
}
.custom-heading {
    color:rgb(37, 44, 51); /* Replace with the desired color */
    font-size: 4em; /* Replace with the desired font size */
}


</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('#popular-tabs button');
    const container = document.getElementById('popular-news-list');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const range = this.getAttribute('data-range');
            container.innerHTML = '<p>Loading...</p>';

            fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=get_popular_news&range=' + range)
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(err => {
                    container.innerHTML = '<p>Error loading news.</p>';
                });
        });
    });
});
</script>


