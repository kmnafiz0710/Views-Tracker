<?php
// Shortcode for total site views
function total_views_shortcode() {
    $total_views = get_option('total_site_views', 0);
    return "Total Site Views: " . $total_views;
}
add_shortcode('total_site_views', 'total_views_shortcode');

// Shortcode for today's site views
function today_views_shortcode() {
    $today = date('Y-m-d');
    $daily_views = get_option('daily_site_views', []);
    $today_views = isset($daily_views[$today]) ? $daily_views[$today] : 0;
    return "Today's Site Views: " . $today_views;
}
add_shortcode('today_site_views', 'today_views_shortcode');

// Shortcode for post views
function post_views_shortcode() {
    if (is_single()) {
        $views = get_post_meta(get_the_ID(), 'post_views_count', true);
        $views = $views ? $views : 0;
        return "This post has been viewed " . $views . " times.";
    }
    return "This shortcode works only on single posts.";
}
add_shortcode('post_views', 'post_views_shortcode');