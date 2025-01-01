use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class View_Tracker_Elementor_Widget extends Widget_Base {

    public function get_name() {
        return 'view-tracker';
    }

    public function get_title() {
        return 'View Tracker';
    }

    public function get_icon() {
        return 'eicon-chart-bar';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'plugin-domain'),
            ]
        );

        $this->add_control(
            'post_id',
            [
                'label' => __('Post ID', 'plugin-domain'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $post_id = $settings['post_id'] ? $settings['post_id'] : get_the_ID();
        $views = get_post_meta($post_id, 'post_views_count', true);
        echo '<div class="view-tracker-widget">Views: ' . esc_html($views) . '</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new View_Tracker_Elementor_Widget());
