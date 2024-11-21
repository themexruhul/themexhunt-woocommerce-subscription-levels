<?php

// Hook into WooCommerce to apply discounts
add_action('woocommerce_cart_calculate_fees', 'themexhunt_apply_membership_discount');

/**
 * Apply discount based on membership level.
 */
function themexhunt_apply_membership_discount() {
    $user_id = get_current_user_id();
    $level = get_user_meta($user_id, 'themexhunt_membership_level', true);
    $discount = 0;

    $gold_discount = get_option('themexhunt_gold_discount', 20); // 20% default
    $silver_discount = get_option('themexhunt_silver_discount', 10); // 10% default

    if ($level === 'gold') {
        $discount = $gold_discount;
    } elseif ($level === 'silver') {
        $discount = $silver_discount;
    }

    if ($discount > 0) {
        $cart = WC()->cart;
        $discount_amount = ($discount / 100) * $cart->subtotal;
        $cart->add_fee('Membership Discount', -$discount_amount);
    }
}
