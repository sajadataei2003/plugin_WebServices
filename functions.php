<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * Get phone number by different ways
 * @param string $by the way to get phone number
 * @param mixed $variable the variable to get phone number
 * @return array
 */
function inboxino_get_phone_number_by($by, $variable = null)
{
    $phone_number_meta = get_option(INBOXINO_FRAMEWORK_PREFIX)['user_phone_number_meta_wordpress'];
    if (!$phone_number_meta && $by != 'admin') return array();
    switch ($by) {
        case 'user_id':
            $phone_number = get_user_meta($variable, $phone_number_meta);
            break;
        case 'comment_object':
            $phone_number = get_user_meta($variable->user_id, $phone_number_meta);
            break;
        case 'admin':
            $phone_numbers = get_option(INBOXINO_FRAMEWORK_PREFIX)['admins_phone_numbers'];
            foreach ($phone_numbers as $admin_phone_number) {
                $phone_number[] = $admin_phone_number['phone_number'];
            }
            break;
        case 'specific_admin':
            $ids = explode(',', $variable);
            $ids = array_map(function($id) { return trim($id); }, $ids);
            $phone_numbers = get_option(INBOXINO_FRAMEWORK_PREFIX)['admins_phone_numbers'];
            foreach ($phone_numbers as $admin_phone_number) {
                if (in_array($admin_phone_number['phone_id'], $ids)) {
                    $phone_number[] = $admin_phone_number['phone_number'];
                }
            }
            break;
        default:
            $phone_number = array();
            break;
    }
    return $phone_number;
}

/**
 * * Get not connected platforms from selected platforms
 * @param array $platforms
 * @return array
 */
function inboxino_get_not_connected_platforms($platforms)
{
    $not_connected_platforms = array();
    $selected_platforms = get_option(INBOXINO_FRAMEWORK_PREFIX)['platforms'];
    $available_platforms = array();
    foreach ($platforms as $platform) {
        $available_platforms[] = $platform->platform;
    }
    foreach ($selected_platforms as $platform) {
        if (!in_array($platform, $available_platforms)) {
            $not_connected_platforms[] = $platform;
        }
    }
    return $not_connected_platforms;
}

/**
 * * Print variables usage help
 * @param array $variables
 * @return void
 */
function inboxino_print_variables($variables)
{
    // Password reset filter
    if (in_array('password_reset', $variables)) {
        echo '<ul>';
        echo '<li><code>%new_password%</code> - <strong>رمز عبور جدید</strong></li>';
        echo '</ul>';
    }
    // Comment filter
    if (in_array('comment', $variables)) {
        echo '<ul>';
        echo '<li><code>%comment_id%</code> - <strong>شناسه نظر</strong></li>';
        echo '<li><code>%comment_author%</code> - <strong>نام نویسنده نظر</strong></li>';
        echo '<li><code>%comment_author_email%</code> - <strong>ایمیل نویسنده نظر</strong></li>';
        echo '<li><code>%comment_author_url%</code> - <strong>آدرس وب سایت نویسنده نظر</strong></li>';
        echo '<li><code>%comment_author_ip%</code> - <strong>آدرس IP نویسنده نظر</strong></li>';
        echo '<li><code>%comment_date%</code> - <strong>تاریخ ارسال نظر</strong></li>';
        echo '<li><code>%comment_time%</code> - <strong>زمان ارسال نظر</strong></li>';
        echo '<li><code>%comment_datetime%</code> - <strong>تاریخ و زمان ارسال نظر</strong></li>';
        echo '<li><code>%comment_content%</code> - <strong>محتوای نظر</strong></li>';
        echo '<li><code>%comment_link%</code> - <strong>لینک نظر</strong></li>';
        echo '<li><code>%comment_post_title%</code> - <strong>عنوان مطلب نظر</strong></li>';
        echo '<li><code>%comment_post_link%</code> - <strong>لینک مطلب نظر</strong></li>';
        echo '<li><code>%comment_admin%</code> - <strong>لینک ادمین نظرات</strong></li>';
        echo '</ul>';
    }
    // User filter
    if (in_array('user', $variables)) {
        echo '<ul>';
        echo '<li><code>%user_id%</code> - <strong>شناسه کاربر</strong></li>';
        echo '<li><code>%user_username%</code> - <strong>نام کاربری</strong></li>';
        echo '<li><code>%user_display_name%</code> - <strong>نام نمایشی کاربر</strong></li>';
        echo '<li><code>%user_first_name%</code> - <strong>نام کاربر</strong></li>';
        echo '<li><code>%user_last_name%</code> - <strong>نام خانوادگی کاربر</strong></li>';
        echo '<li><code>%user_email%</code> - <strong>ایمیل کاربر</strong></li>';
        echo '<li><code>%user_phone_number%</code> - <strong>شماره تلفن کاربر</strong></li>';
        echo '<li><code>%user_joined_date%</code> - <strong>تاریخ عضویت کاربر</strong></li>';
        echo '</ul>';
    }
    // General filter
    if (in_array('general', $variables)) {
        echo '<ul>';
        echo '<li><code>%date%</code> - <strong>تاریخ ارسال پیام</strong></li>';
        echo '<li><code>%time%</code> - <strong>زمان ارسال پیام</strong></li>';
        echo '<li><code>%datetime%</code> - <strong>تاریخ و زمان ارسال پیام</strong></li>';
        echo '</ul>';
    }
    // Order filter
    if (in_array('order', $variables)) {
        echo '<ul>';
        echo '<li><code>%order_id%</code> - <strong>شناسه سفارش</strong></li>';
        echo '<li><code>%order_total%</code> - <strong>مبلغ سبد خرید</strong></li>';
        echo '<li><code>%order_discount%</code> - <strong>جمع تخفیف</strong></li>';
        echo '<li><code>%billing_first_name%</code> - <strong>نام مشتری</strong></li>';
        echo '<li><code>%billing_last_name%</code> - <strong>نام خانوادگی مشتری</strong></li>';
        echo '<li><code>%order_items%</code> - <strong>آیتم‌های سفارش بدون تعداد</strong></li>';
        echo '<li><code>%order_items_qty%</code> - <strong>آیتم‌های سفارش با تعداد</strong></li>';
        echo '<li><code>%order_date%</code> - <strong>تاریخ ثبت سفارش</strong></li>';
        echo '<li><code>%order_time%</code> - <strong>زمان ثبت سفارش</strong></li>';
        echo '<li><code>%order_datetime%</code> - <strong>تاریخ و زمان ثبت سفارش</strong></li>';
        echo '</ul>';
    }
    // Order status filter
    if (in_array('order_status', $variables)) {
        echo '<ul>';
        echo '<li><code>%order_status%</code> - <strong>وضعیت سفارش</strong></li>';
        echo '</ul>';
    }
    // Form filter
    if (in_array('form', $variables)) {
        echo '<ul>';
        echo '<li><code>%form_data%</code> - <strong>تمامی فیلدهای فرم</strong></li>';
        echo '<li><code>%form_data_required%</code> - <strong>فیلدهای ضروری فرم</strong></li>';
        echo '</ul>';
    }
}
