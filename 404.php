<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Your_Theme_Name
 */

get_header(); // Includes the header.php file
?>

<section class="error-404 not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'your-theme' ); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'your-theme' ); ?></p>

        <?php get_search_form(); // Display search form ?>

        <p><?php _e( 'Or you can return to the homepage and browse other sections of the site.', 'your-theme' ); ?></p>
        <a href="<?php echo home_url(); ?>" class="button"><?php _e( 'Go to Homepage', 'your-theme' ); ?></a>
    </div><!-- .page-content -->
</section><!-- .error-404 -->

<?php
get_footer(); // Includes the footer.php file
?>
