
<?php


// // Add a custom admin menu
// function custom_view_tracker_admin_menu() {
//     add_menu_page(
//         'View Tracker Settings',     // Page title
//         'View Tracker',              // Menu title
//         'manage_options',            // Capability
//         'view-tracker-settings',     // Menu slug
//         'custom_view_tracker_settings_page', // Callback function
//         'dashicons-chart-bar',       // Icon
//         100                          // Position
//     );
// }
// add_action('admin_menu', 'custom_view_tracker_admin_menu');

// // Settings page content
// function custom_view_tracker_settings_page() {
//     // Handle form submission for resetting data or selecting post types
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         if (isset($_POST['reset_views']) && check_admin_referer('reset_views_nonce')) {
//             update_option('total_site_views', 0);
//             update_option('daily_site_views', []);
//             echo '<div class="notice notice-success"><p>View data has been reset successfully!</p></div>';
//         }

//         if (isset($_POST['view_tracker_post_types']) && check_admin_referer('view_tracker_post_types_nonce')) {
//             $selected_post_types = array_map('sanitize_text_field', $_POST['view_tracker_post_types']);
//             update_option('view_tracker_post_types', $selected_post_types);
//             echo '<div class="notice notice-success"><p>Post types updated successfully!</p></div>';
//         }
//     }

//     // Get saved data
//     $total_views = get_option('total_site_views', 0);
//     $daily_views = get_option('daily_site_views', []);
//     $selected_post_types = get_option('view_tracker_post_types', []);
//     $post_types = get_post_types(['public' => true], 'objects');

//     echo '<div class="wrap">';
//     echo '<h1>View Tracker Settings</h1>';

//     // Display total site views
//     echo '<h2>Total Site Views</h2>';
//     echo '<p>' . esc_html($total_views) . '</p>';

//     // Display daily site views
//     echo '<h2>Daily Site Views</h2>';
//     echo '<table class="widefat"><thead><tr><th>Date</th><th>Views</th></tr></thead><tbody>';
//     foreach ($daily_views as $date => $views) {
//         echo '<tr><td>' . esc_html($date) . '</td><td>' . esc_html($views) . '</td></tr>';
//     }
//     echo '</tbody></table>';

// // Display post type selection with checkboxes
// echo '<h2>Select Post Types for View Tracking</h2>';
// echo '<form method="post">';
// wp_nonce_field('view_tracker_post_types_nonce');
// foreach ($post_types as $post_type_slug => $post_type) {
//     $checked = in_array($post_type_slug, $selected_post_types) ? 'checked' : '';
//     echo '<label>';
//     echo '<input type="checkbox" name="view_tracker_post_types[]" value="' . esc_attr($post_type_slug) . '" ' . $checked . '> ';
//     echo esc_html($post_type->label);
//     echo '</label><br>';
// }
// echo '<br>';
// echo '<input type="submit" class="button button-primary" value="Save Settings">';
// echo '</form>';


//     // Reset data form
//     echo '<h2>Reset Data</h2>';
//     echo '<form method="post">';
//     wp_nonce_field('reset_views_nonce');
//     echo '<input type="submit" name="reset_views" class="button button-primary" value="Reset Views">';
//     echo '</form>';

//     echo '</div>';
// }

// // Dynamically add Views column to selected post types
// function add_views_column_to_selected_post_types($columns) {
//     global $current_screen;
//     $selected_post_types = get_option('view_tracker_post_types', []);

//     if (in_array($current_screen->post_type, $selected_post_types)) {
//         $columns['post_views'] = 'Views';
//     }
//     return $columns;
// }
// add_filter('manage_posts_columns', function ($columns) {
//     return add_views_column_to_selected_post_types($columns);
// });

// // Populate the Views column for selected post types
// function populate_views_column_with_error_handling($column_name, $post_id) {
//     if ($column_name === 'post_views') {
//         // Retrieve the post views count
//         $views = get_post_meta($post_id, 'post_views_count', true);

//         // Check if the meta key exists; if not, initialize it
//         if ($views === '' || $views === false) {
//             $views = 0; // Default value
//             update_post_meta($post_id, 'post_views_count', $views);
//         }

//         // Safely display the views count
//         echo esc_html($views);
//     }
// }
// add_action('manage_posts_custom_column', function ($column_name, $post_id) {
//     populate_views_column_with_error_handling($column_name, $post_id);
// });

// add_action('manage_pages_custom_column', function ($column_name, $post_id) {
//     populate_views_column_with_error_handling($column_name, $post_id);
// });

?>

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_tracker_post_types'])) {
        $selected_post_types = array_map('sanitize_text_field', $_POST['view_tracker_post_types']); // Sanitize inputs
        update_option('view_tracker_post_types', $selected_post_types); // Save selected post types
    }
    ?>
    <div class="wrap">
        <h1>View Tracker Settings</h1>
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_tracker_post_types'])) {
        $selected_post_types = array_map('sanitize_text_field', $_POST['view_tracker_post_types']); // Sanitize inputs
        update_option('view_tracker_post_types', $selected_post_types); // Save selected post types
    }
    ?>
    <div class="wrap">
        <h1>View Tracker Settings</h1>
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

