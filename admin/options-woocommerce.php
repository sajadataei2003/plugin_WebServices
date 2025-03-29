<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Create parent section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'id' => 'woocommerce',
    'title' => 'رویدادهای ووکامرس',
));

// Create new order section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'woocommerce',
    'title' => 'پس از ثبت سفارش',
    'fields' => array(
        // New order subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیم پیام‌ها پس از ثبت سفارش جدید',
        ),
        // New order user switcher
        array(
            'id' => 'new_order_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ثبت سفارش جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // New order user messages
        array(
            'id' => 'new_order_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_order_user', '==', 'true'),
        ),
        // New order admin switcher
        array(
            'id' => 'new_order_admin',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به مدیران',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ثبت سفارش جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
        ),
        // New order admin messages
        array(
            'id' => 'new_order_admin_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به مدیران',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_order_admin', '==', 'true'),
        ),

        array(
            'id' => 'new_order_specific_admin',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به مدیران خاص',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ثبت سفارش جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
        ),
        array(
            'id' => 'new_order_specific_admin_ids',
            'type' => 'text',
            'title' => 'شناسه مدیران',
            'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
            'dependency' => array('new_order_specific_admin', '==', 'true'),
        ),
        array(
            'id' => 'new_order_specific_admin_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به مدیران',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_order_specific_admin', '==', 'true'),
        ),
        // New order variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ثبت سفارش جدید',
        ),
        // New user register callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_new_order_variables_callback',
        ),
    )
));

$order_statuses = inboxino_get_wc_order_statuses();
foreach($order_statuses as $order_status => $status_label) {

    $order_status = 'wc-' === substr( $order_status, 0, 3 ) ? substr( $order_status, 3 ) : $order_status;
    // Create order status section
    CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
        'parent' => 'woocommerce',
        'title' => 'پس از تغییر وضعیت سفارش به ' . $status_label,
        'fields' => array(
            // Order status subheader
            array(
                'type' => 'subheading',
                'content' => 'تنظیم پیام‌ها پس از تغییر وضعیت سفارش به ' . $status_label,
            ),
            // Order status user switcher
            array(
                'id' => "order_{$order_status}_user",
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به کاربر',
                'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از تغییر وضعیت سفارش به ' . $status_label . ' پیام‌های فعال به کاربر ارسال خواهد شد.'
            ),
            // Order status user messages
            array(
                'id' => "order_{$order_status}_user_messages",
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به کاربر',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array("order_{$order_status}_user", '==', 'true'),
            ),
            // Order status admin switcher
            array(
                'id' => "order_{$order_status}_admin",
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از تغییر وضعیت سفارش به ' . $status_label . ' پیام‌های فعال به مدیران ارسال خواهد شد.',
            ),
            // Order status admin messages
            array(
                'id' => "order_{$order_status}_admin_messages",
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array("order_{$order_status}_admin", '==', 'true'),
            ),

            array(
                'id' => "order_{$order_status}_specific_admin",
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران خاص',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از تغییر وضعیت سفارش به ' . $status_label . ' پیام‌های فعال به مدیران ارسال خواهد شد.',
            ),
            array(
                'id' => "order_{$order_status}_specific_admin_ids",
                'type' => 'text',
                'title' => 'شناسه مدیران',
                'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
                'dependency' => array("order_{$order_status}_specific_admin", '==', 'true'),
            ),
            array(
                'id' => "order_{$order_status}_admin_messages",
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array("order_{$order_status}_specific_admin", '==', 'true'),
            ),

            //  Order status variables subheader
            array(
                'type' => 'subheading',
                'content' => 'متغیرهای قابل استفاده پس از تغییر وضعیت سفارش به ' . $status_label,
            ),
            // Order status callback
            array(
                'type' => 'callback',
                'function' => 'inboxino_order_status_variables_callback',
            ),
        )
    ));
}

/**
 * * Print variables for new order
 * @return void
 */
function inboxino_new_order_variables_callback()
{
    inboxino_print_variables(array('order', 'general', 'user'));
}

/**
 * * Print variables for order status change
 * @return void
 */
function inboxino_order_status_variables_callback()
{
    inboxino_print_variables(array('order', 'order_status', 'general', 'user'));
}

/**
 * * At this stage wc_get_order_statuses is not defined
 * * so we need our own function to get all order statuses
 * * the code is directly copied from woocommerce source code
 * @return array
 */
function inboxino_get_wc_order_statuses()
{
	$order_statuses = array(
		'wc-pending'    => _x('Pending payment', 'Order status', 'woocommerce'),
		'wc-processing' => _x('Processing', 'Order status', 'woocommerce'),
		'wc-on-hold'    => _x('On hold', 'Order status', 'woocommerce'),
		'wc-completed'  => _x('Completed', 'Order status', 'woocommerce'),
		'wc-cancelled'  => _x('Cancelled', 'Order status', 'woocommerce'),
		'wc-refunded'   => _x('Refunded', 'Order status', 'woocommerce'),
		'wc-failed'     => _x('Failed', 'Order status', 'woocommerce'),
	);
	return apply_filters('wc_order_statuses', $order_statuses);
}

