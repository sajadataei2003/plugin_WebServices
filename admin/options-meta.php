<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Create section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'title' => 'متای کاربران',
    'fields' => array(
        // Phone number meta subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیمات متای شماره موبایل کاربر',
        ),
        // User select
        array(
            'id' => 'user_select',
            'type' => 'select',
            'title' => 'انتخاب کاربر',
            'options' => 'users',
            'chosen' => true,
            'ajax' => true,
            'desc' => 'برای نمایش متای کاربر، آن را انتخاب کرده و یک بار تنظیمات را ذخیره کنید.'
        ),
        // User meta callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_user_meta_callback',
        ),
    )
));

/**
 * * Callback to show user meta fields table
 * This callback shows the user meta fields table
 */
function inboxino_user_meta_callback()
{
    $user_id = get_option(INBOXINO_FRAMEWORK_PREFIX)['user_select'];
    if (!$user_id) {
        echo '<span class="badge danger">بدون کاربر</span>';
        echo 'ابتدا یکی از کاربران را انتخاب کرده و سپس یک بار تنظیمات را ذخیره کنید. سپس می‌توانید متاهای کاربر را مشاهده کنید.';
        return;
    }
    $user_meta = get_user_meta($user_id);
    echo '<table class="wp-list-table widefat striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>نام متا</th>';
    echo '<th>مقدار متا</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($user_meta as $key => $value) {
        echo '<tr>';
        echo '<td>' . esc_html($key) . '</td>';
        echo '<td>' . esc_html($value[0]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
