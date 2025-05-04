<?php
class Popular_Posts_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'popular_posts_widget',
            __('🔥 लोकप्रिय', 'textdomain'),
            array('description' => __('Displays popular posts by comment count', 'textdomain'))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title'] ?? __('लोकप्रिय', 'textdomain'));
        $count = !empty($instance['count']) ? absint($instance['count']) : 5;

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        $popular_query = new WP_Query(array(
            'posts_per_page' => $count,
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        ));

        echo '<ul class="popular-posts-widget">';
        while ($popular_query->have_posts()) : $popular_query->the_post();
            echo '<li><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a> (' . get_comments_number() . ')</li>';
        endwhile;
        echo '</ul>';

        wp_reset_postdata();
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = $instance['title'] ?? __('लोकप्रिय', 'textdomain');
        $count = $instance['count'] ?? 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'textdomain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e('Number of Posts:', 'textdomain'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" step="1" min="1"
                   value="<?php echo esc_attr($count); ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        return array(
            'title' => sanitize_text_field($new_instance['title']),
            'count' => absint($new_instance['count']),
        );
    }
}
