// Function to display post view count in theme templates
function display_post_view_count($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID(); // If no ID is passed, get the current post ID
    }
    $views = get_post_meta($post_id, 'post_views_count', true);
    echo $views ? $views : '0'; // Display view count or 0 if not set
}
