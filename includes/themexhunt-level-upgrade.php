<?php

// Hook into WooCommerce before my account
add_action('woocommerce_before_my_account', 'themexhunt_check_and_upgrade_membership_level');

/**
 * Check user points and upgrade membership level if needed.
 */
function themexhunt_check_and_upgrade_membership_level() {
    $user_id = get_current_user_id();
    $points = (int) get_user_meta($user_id, 'themexhunt_points_balance', true);
    
    $gold_threshold = (int) get_option('themexhunt_gold_threshold', 1000);
    $silver_threshold = (int) get_option('themexhunt_silver_threshold', 500);

    if ($points >= $gold_threshold) {
        themexhunt_upgrade_membership_level($user_id, 'gold');
    } elseif ($points >= $silver_threshold) {
        themexhunt_upgrade_membership_level($user_id, 'silver');
    }
}

/**
 * Upgrade user membership level.
 *
 * @param int $user_id
 * @param string $level
 */
function themexhunt_upgrade_membership_level($user_id, $level) {
    update_user_meta($user_id, 'themexhunt_membership_level', $level);
}

// Display membership level on My Account page
add_action('woocommerce_before_my_account', 'themexhunt_display_membership_level');

/**
 * Display membership level on My Account page.
 */
function themexhunt_display_membership_level() {
    $user_id = get_current_user_id();
    $membership_level = get_user_meta($user_id, 'themexhunt_membership_level', true);

    if ($membership_level) {
        echo '<p>' . __('Your Membership Level: ', 'themexhunt') . ucfirst($membership_level) . '</p>';
    }
}

// Display membership level in user profile (admin)
add_action('show_user_profile', 'themexhunt_display_membership_level_admin');
add_action('edit_user_profile', 'themexhunt_display_membership_level_admin');

/**
 * Display membership level in user profile (admin).
 *
 * @param WP_User $user
 */
function themexhunt_display_membership_level_admin($user) {
    $membership_level = get_user_meta($user->ID, 'themexhunt_membership_level', true);
    ?>
    <h3><?php _e('Membership Level', 'themexhunt'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="themexhunt_membership_level"><?php _e('Membership Level', 'themexhunt'); ?></label></th>
            <td>
                <select name="themexhunt_membership_level" id="themexhunt_membership_level">
                    <option value="none" <?php selected($membership_level, 'none'); ?>><?php _e('None', 'themexhunt'); ?></option>
                    <option value="silver" <?php selected($membership_level, 'silver'); ?>><?php _e('Silver', 'themexhunt'); ?></option>
                    <option value="gold" <?php selected($membership_level, 'gold'); ?>><?php _e('Gold', 'themexhunt'); ?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Save membership level in user profile (admin)
add_action('personal_options_update', 'themexhunt_save_membership_level_admin');
add_action('edit_user_profile_update', 'themexhunt_save_membership_level_admin');

/**
 * Save membership level in user profile (admin).
 *
 * @param int $user_id
 */
function themexhunt_save_membership_level_admin($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['themexhunt_membership_level'])) {
        update_user_meta($user_id, 'themexhunt_membership_level', sanitize_text_field($_POST['themexhunt_membership_level']));
    }
}
