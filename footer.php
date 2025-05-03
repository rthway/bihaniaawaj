<footer class="text-center text-lg-start text-dark" style="background-color: #ECEFF1">
    <section class="d-flex justify-content-between p-4 text-white" style="background-color: #21D192">
        <!-- Left -->
        <div class="me-5">
            <span>Get connected with us on social networks:</span>
        </div>
        <!-- Left -->

        <!-- Right -->
        <div>
            <a href="<?php echo get_theme_mod('facebook_link', '#'); ?>" class="text-white me-2">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="<?php echo get_theme_mod('twitter_link', '#'); ?>" class="text-white me-2">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="<?php echo get_theme_mod('instagram_link', '#'); ?>" class="text-white me-2">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="<?php echo get_theme_mod('linkedin_link', '#'); ?>" class="text-white">
                <i class="fab fa-linkedin-in"></i>
            </a>

            
        </div>
        <!-- Right -->
    </section>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <!-- 1st Column: Logo and Short Info -->
            <div class="col-3">
                <?php if (get_theme_mod('footer_logo')) : ?>
                    <img src="<?php echo esc_url(get_theme_mod('footer_logo')); ?>" alt="Logo" class="img-fluid mb-3">
                <?php endif; ?>
                <p><?php echo wp_kses_post(get_theme_mod('footer_short_info', 'Your short info goes here.')); ?></p>
            </div>
            
            <!-- 2nd Column: Title and Paragraph -->
            <div class="col-3">
                <h5><?php echo esc_html(get_theme_mod('footer_column_2_title', 'Title 2')); ?></h5>
                <p><?php echo wp_kses_post(get_theme_mod('footer_column_2_paragraph', 'Your paragraph goes here.')); ?></p>
            </div>

            <!-- 3rd Column: Title and Paragraph -->
            <div class="col-3">
                <h5><?php echo esc_html(get_theme_mod('footer_column_3_title', 'Title 3')); ?></h5>
                <p><?php echo wp_kses_post(get_theme_mod('footer_column_3_paragraph', 'Your paragraph goes here.')); ?></p>
            </div>

            <!-- 4th Column: Contact Info -->
            <div class="col-3">
                <h5><?php echo esc_html(get_theme_mod('footer_contact_title', 'Contact Info')); ?></h5>
                <p><?php echo wp_kses_post(get_theme_mod('footer_contact_info', 'Your contact info goes here.')); ?></p>
            </div>
        </div>

    </div>
    <!-- Copyright Section -->
    
    <div class="row mt-4" style="background-color: #c1dbc8; padding: 10px 0;">
      <div class="col text-center">
          <p class="mb-0" style="font-size: 14px; color: #b52db1;">
              &copy; <?php echo date('Y'); ?> 
              <a href="<?php echo esc_url(home_url('/')); ?>" class="text-dark fw-bold">
                  <?php echo esc_html(get_bloginfo('name')); ?>
              </a>. All rights reserved.
          </p>
      </div>
    </div>


</div>

</footer>