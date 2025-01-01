class View_Tracker_Widget extends WP_Widget {

function __construct() {
    parent::__construct(
        'view_tracker_widget', // Base ID
        'View Tracker Widget', // Name
        ['description' => 'Display view count for a post or page'] // Args
    );
}

public function widget($args, $instance) {
    $post_id = $instance['post_id']; // Get the selected post ID
    $views = get_post_meta($post_id, 'post_views_count', true);
    echo $args['before_widget'];
    echo $args['before_title'] . 'Views: ' . $views . $args['after_title'];
    echo $args['after_widget'];
}

public function form($instance) {
    $post_id = !empty($instance['post_id']) ? $instance['post_id'] : '';
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('post_id'); ?>">Post ID:</label>
        <input class="widefat" id="<?php echo $this->get_field_id('post_id'); ?>" name="<?php echo $this->get_field_name('post_id'); ?>" type="text" value="<?php echo esc_attr($post_id); ?>" />
    </p>
    <?php
}

public function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['post_id'] = strip_tags($new_instance['post_id']);
    return $instance;
}
}

function register_view_tracker_widget() {
register_widget('View_Tracker_Widget');
}
add_action('widgets_init', 'register_view_tracker_widget');
