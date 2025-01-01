function register_view_tracker_block() {
    wp_register_script(
        'view-tracker-block',
        plugins_url('view-tracker-block.js', __FILE__), // Create the JS file for the block
        ['wp-blocks', 'wp-element', 'wp-editor'],
        filemtime(plugin_dir_path(__FILE__) . 'view-tracker-block.js')
    );

    register_block_type('view-tracker/block', [
        'editor_script' => 'view-tracker-block',
        'render_callback' => 'render_view_tracker_block'
    ]);
}
add_action('init', 'register_view_tracker_block');

function render_view_tracker_block($attributes) {
    $post_id = isset($attributes['postId']) ? $attributes['postId'] : get_the_ID();
    $views = get_post_meta($post_id, 'post_views_count', true);
    return '<div class="view-tracker-block">Views: ' . esc_html($views) . '</div>';
}
