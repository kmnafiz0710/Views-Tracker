<?php
// Track total site views
function track_total_site_views() {
    $total_views = get_option('total_site_views', 0);
    $total_views++;
    update_option('total_site_views', $total_views);
}
add_action('wp_footer', 'track_total_site_views');

// Track daily site views
function track_daily_site_views() {
    $today = date('Y-m-d');
    $daily_views = get_option('daily_site_views', []);
    if (!isset($daily_views[$today])) {
        $daily_views[$today] = 0;
    }
    $daily_views[$today]++;
    update_option('daily_site_views', $daily_views);
}
add_action('wp_footer', 'track_daily_site_views');

// Track post views
function track_post_views($post_id) {
    if (!is_single() || empty($post_id)) {
        return;
    }
    $views = get_post_meta($post_id, 'post_views_count', true);
    $views = $views ? $views : 0;
    $views++;
    update_post_meta($post_id, 'post_views_count', $views);
}
add_action('wp_head', function () {
    if (is_single()) {
        track_post_views(get_the_ID());
    }
});
