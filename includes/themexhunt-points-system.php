<?php

// Hook into WooCommerce to award points
add_action('woocommerce_order_status_completed', 'themexhunt_award_points_for_subscription');

/**
 * Award points to users upon subscription order completion.
 *
 * @param int $order_id
 */
function themexhunt_award_points_for_subscription($order_id) {
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();
    $total = $order->get_total();
    $points_per_dollar = get_option('themexhunt_points_per_dollar', 1);
    $points = floor($total * $points_per_dollar); // Points based on the setting

    if ($user_id) {
        // Ensure current_points is an integer
        $current_points = (int) get_user_meta($user_id, 'themexhunt_points_balance', true);
        $new_points = $current_points + $points;
        update_user_meta($user_id, 'themexhunt_points_balance', $new_points);
    }
}
