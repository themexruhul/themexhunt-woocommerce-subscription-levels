<?php

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('WC_Settings_Page')) {

/**
 * Themexhunt_Settings Class.
 */
class Themexhunt_Settings extends WC_Settings_Page {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->id    = 'themexhunt';
        $this->label = __('Themexhunt Settings', 'woocommerce');

        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_page'), 20);
        add_action('woocommerce_settings_' . $this->id, array($this, 'output'));
        add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'));
    }

    /**
     * Get settings array.
     *
     * @return array
     */
    public function get_settings() {
        $settings = array(
            'section_title' => array(
                'name' => __('Themexhunt Settings', 'woocommerce'),
                'type' => 'title',
                'desc' => '',
                'id'   => 'themexhunt_section_title'
            ),
            'points_per_dollar' => array(
                'name' => __('Points per Dollar', 'woocommerce'),
                'type' => 'number',
                'desc' => __('Number of points earned per dollar spent.', 'woocommerce'),
                'id'   => 'themexhunt_points_per_dollar'
            ),
            'gold_threshold' => array(
                'name' => __('Gold Level Points Threshold', 'woocommerce'),
                'type' => 'number',
                'desc' => __('Number of points required to reach Gold level.', 'woocommerce'),
                'id'   => 'themexhunt_gold_threshold'
            ),
            'silver_threshold' => array(
                'name' => __('Silver Level Points Threshold', 'woocommerce'),
                'type' => 'number',
                'desc' => __('Number of points required to reach Silver level.', 'woocommerce'),
                'id'   => 'themexhunt_silver_threshold'
            ),
            'gold_discount' => array(
                'name' => __('Gold Level Discount (%)', 'woocommerce'),
                'type' => 'number',
                'desc' => __('Discount percentage for Gold level members.', 'woocommerce'),
                'id'   => 'themexhunt_gold_discount'
            ),
            'silver_discount' => array(
                'name' => __('Silver Level Discount (%)', 'woocommerce'),
                'type' => 'number',
                'desc' => __('Discount percentage for Silver level members.', 'woocommerce'),
                'id'   => 'themexhunt_silver_discount'
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id'   => 'themexhunt_section_end'
            ),
        );

        return apply_filters('woocommerce_get_settings_' . $this->id, $settings);
    }
}

return new Themexhunt_Settings();

}
