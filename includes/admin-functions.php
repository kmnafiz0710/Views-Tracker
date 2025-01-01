<?php

// Add a custom admin menu
function custom_view_tracker_admin_menu() {
    add_menu_page(
        'View Tracker Settings',     // Page title
        'View Tracker',              // Menu title
        'manage_options',            // Capability
        'view-tracker-settings',     // Menu slug
        'custom_view_tracker_settings_page', // Callback function
        'dashicons-chart-bar',       // Icon
        100                          // Position
    );
}
add_action('admin_menu', 'custom_view_tracker_admin_menu');

// Callback for the settings page
function custom_view_tracker_settings_page() {
    $post_types = get_post_types(['public' => true], 'objects'); // Get all public post types
    $selected_post_types = get_option('view_tracker_post_types', []); // Get saved post types

    // Get total site views
    $total_site_views = get_option('total_site_views', 0);

    // Get daily site views
    $daily_site_views = get_option('daily_site_views', []);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['view_tracker_post_types'])) {
            // Save selected post types
            $selected_post_types = array_map('sanitize_text_field', $_POST['view_tracker_post_types']);
            update_option('view_tracker_post_types', $selected_post_types);
        }

        if (isset($_POST['reset_total_views'])) {
            // Reset total site views
            update_option('total_site_views', 0);
        }

        if (isset($_POST['reset_daily_views'])) {
            // Reset daily site views
            update_option('daily_site_views', []);
        }
    }

    ?>
    <div class="wrap">
        <h1>View Tracker Settings</h1>

        <!-- Total Site Views -->
        <h2>Total Site Views: <?php echo $total_site_views; ?></h2>

        <!-- Daily Site Views Table -->
        <h3>Daily Site Views</h3>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Views</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($daily_site_views)) {
                    foreach ($daily_site_views as $date => $views) {
                        echo '<tr><td>' . esc_html($date) . '</td><td>' . esc_html($views) . '</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No data available</td></tr>';
                }
                ?>
            </tbody>
        </table>
        
        <br>

        <!-- Form for selecting post types -->
        <form method="POST">
            <label for="view_tracker_post_types"><strong>Select Post Types:</strong></label>
            <select name="view_tracker_post_types[]" id="view_tracker_post_types" multiple style="width: 100%; max-width: 400px;">
                <?php foreach ($post_types as $post_type_slug => $post_type) : ?>
                    <option value="<?php echo esc_attr($post_type_slug); ?>"
                        <?php echo in_array($post_type_slug, $selected_post_types) ? 'selected' : ''; ?>>
                        <?php echo esc_html($post_type->label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <input type="submit" class="button button-primary" value="Save Settings">
        </form>

        <!-- Reset buttons -->
        <form method="POST" style="margin-top: 20px;">
            <input type="submit" name="reset_total_views" class="button button-secondary" value="Reset Total Views">
            <input type="submit" name="reset_daily_views" class="button button-secondary" value="Reset Daily Views">
        </form>
    </div>
    <?php
}

// Add Views column to selected post types dynamically
function add_views_column_to_selected_post_types($columns) {
    $selected_post_types = get_option('view_tracker_post_types', []); // Get selected post types
    $screen = get_current_screen();

    if (in_array($screen->post_type, $selected_post_types)) {
        $columns['post_views'] = 'Views'; // Add the Views column
    }
    return $columns;
}
add_filter('manage_posts_columns', 'add_views_column_to_selected_post_types');
add_filter('manage_pages_columns', 'add_views_column_to_selected_post_types');

// Populate the Views column dynamically
function populate_views_column_for_selected_post_types($column_name, $post_id) {
    if ($column_name === 'post_views') {
        $views = get_post_meta($post_id, 'post_views_count', true); // Get the view count
        echo $views ? $views : '0'; // Display the view count or 0 if not set
    }
}
add_action('manage_posts_custom_column', 'populate_views_column_for_selected_post_types', 10, 2);
add_action('manage_pages_custom_column', 'populate_views_column_for_selected_post_types', 10, 2);

// Make the Views column sortable dynamically
function make_views_column_sortable_for_selected_post_types($columns) {
    $selected_post_types = get_option('view_tracker_post_types', []);
    $screen = get_current_screen();

    if (in_array($screen->post_type, $selected_post_types)) {
        $columns['post_views'] = 'post_views_count'; // Make the Views column sortable
    }
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'make_views_column_sortable_for_selected_post_types');
add_filter('manage_edit-page_sortable_columns', 'make_views_column_sortable_for_selected_post_types');

// Sorting logic for Views column
function sort_views_column_query_for_selected_post_types($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $post_type = $query->get('post_type');
    $selected_post_types = get_option('view_tracker_post_types', []);

    if (in_array($post_type, $selected_post_types) && $query->get('orderby') === 'post_views_count') {
        $query->set('meta_key', 'post_views_count'); // Sort by the meta key
        $query->set('orderby', 'meta_value_num'); // Sort numerically
    }
}
add_action('pre_get_posts', 'sort_views_column_query_for_selected_post_types');

?>
