<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Create parent section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'id' => 'wordpress',
    'title' => 'رویدادهای وردپرس',
));

// Create new user register section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'wordpress',
    'title' => 'پس از ثبت نام کاربر جدید',
    'fields' => array(
        // New user register subheader
        array(
            'type' => 'subheading',
            'content' => 'در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود',
        ),
        // New user register user switcher
        array(
            'id' => 'new_user_register_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از عضویت کاربر جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // New user register user messages
        array(
            'id' => 'new_user_register_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_user_register_user', '==', 'true'),
            'default' => array(
                array(),
            ),
        ),
        // New user register admin switcher
        array(
            'id' => 'new_user_register_admin',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به مدیران',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از عضویت کاربر جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
        ),
        // New user register admin messages
        array(
            'id' => 'new_user_register_admin_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به مدیران',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_user_register_admin', '==', 'true'),
        ),
        // New user register specific admin switcher
        array(
            'id' => 'new_user_register_specific_admin',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به مدیران خاص',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از عضویت کاربر جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
        ),
        array(
            'id' => 'new_user_register_specific_admin_ids',
            'type' => 'text',
            'title' => 'شناسه مدیران',
            'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
            'dependency' => array('new_user_register_specific_admin', '==', 'true'),
        ),
        array(
            'id' => 'new_user_register_specific_admin_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به مدیران',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_user_register_specific_admin', '==', 'true'),
        ),

        // New user register variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ثبت نام کاربر جدید',
        ),
        // New user register callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_new_user_register_variables_callback',
        ),
    )
));

// Create new login section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'wordpress',
    'title' => 'پس از ورود کاربر',
    'fields' => array(
        // User login subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیم پیام‌ها پس از ورود کاربر',
        ),
        // User login user switcher
        array(
            'id' => 'user_login_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ورود کاربر، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // User login user messages
        array(
            'id' => 'user_login_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('user_login_user', '==', 'true'),
        ),
        // User login variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ورود کاربر',
        ),
        // User login callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_user_login_variables_callback',
        ),
    )
));

// Create password reset section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'wordpress',
    'title' => 'پس از بازیابی رمز عبور کاربر',
    'fields' => array(
        // User password reset subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیم پیام‌ها پس از بازیابی رمز عبور کاربر',
        ),
        // User password reset user switcher
        array(
            'id' => 'user_password_reset_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از بازیابی رمز عبور کاربر، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // User password reset user messages
        array(
            'id' => 'user_password_reset_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('user_password_reset_user', '==', 'true'),
        ),
        // User password reset variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از بازیابی رمز عبور کاربر',
        ),
        // User password reset callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_user_password_reset_callback',
        ),
    )
));

// Create new comment section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'wordpress',
    'title' => 'پس از ارسال نظر جدید',
    'fields' => array(
        // New comment subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیم پیام‌ها پس از ارسال نظر جدید',
        ),
        // New comment user switcher
        array(
            'id' => 'new_comment_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ارسال نظر جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // New comment user messages
        array(
            'id' => 'new_comment_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_comment_user', '==', 'true'),
        ),
        // New comment admin switcher
        array(
            'id' => 'new_comment_admin',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به مدیران',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ارسال نظر جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
        ),
        // New comment admin messages
        array(
            'id' => 'new_comment_admin_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به مدیران',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_comment_admin', '==', 'true'),
        ),

        array(
            'id' => 'new_comment_specific_admin',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به مدیران خاص',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ارسال نظر جدید، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
        ),
        array(
            'id' => 'new_comment_specific_admin_ids',
            'type' => 'text',
            'title' => 'شناسه مدیران',
            'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
            'dependency' => array('new_comment_specific_admin', '==', 'true'),
        ),
        array(
            'id' => 'new_comment_specific_admin_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به مدیران',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_comment_specific_admin', '==', 'true'),
        ),
        // New comment variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ارسال نظر جدید',
        ),
        // New comment callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_new_comment_variables_callback',
        ),
    )
));

// Create new comment reply section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'wordpress',
    'title' => 'پس از ارسال پاسخ به نظر',
    'fields' => array(
        // New comment reply subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیم پیام‌ها پس از ارسال پاسخ به نظر',
        ),
        // New comment reply user switcher
        array(
            'id' => 'new_comment_reply_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از ارسال پاسخ به نظر، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // New comment reply user messages
        array(
            'id' => 'new_comment_reply_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('new_comment_reply_user', '==', 'true'),
        ),
        // Comment approved variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از تایید نظر',
        ),
        // New comment reply callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_new_comment_reply_variables_callback',
        ),
    )
));

// Create comment approved section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'parent' => 'wordpress',
    'title' => 'پس از تایید نظر',
    'fields' => array(
        // Comment approved subheader
        array(
            'type' => 'subheading',
            'content' => 'تنظیم پیام‌ها پس از تایید نظر',
        ),
        // Comment approved user switcher
        array(
            'id' => 'comment_approved_user',
            'type' => 'switcher',
            'text_width' => 80,
            'title' => 'ارسال پیام به کاربر',
            'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
            'default' => false,
            'desc' => 'با فعال سازی این گزینه، پس از تایید نظر، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
        ),
        // Comment approved user messages
        array(
            'id' => 'comment_approved_user_messages',
            'type' => 'repeater',
            'title' => 'پیام‌های ارسالی به کاربر',
            'button_title' => 'افزودن پیام دیگر',
            'fields' => $messages_fields,
            'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
            'dependency' => array('comment_approved_user', '==', 'true'),
        ),
        // Comment approved variables subheader
        array(
            'type' => 'subheading',
            'content' => 'متغیرهای قابل استفاده در پیام‌های پس از تایید نظر',
        ),
        // Comment approved callback
        array(
            'type' => 'callback',
            'function' => 'inboxino_comment_approved_variables_callback',
        ),
    )
));

/**
 * * Print variables for new user register
 * @return void
 */
function inboxino_new_user_register_variables_callback()
{
    inboxino_print_variables(array('general', 'user'));
}

/**
 * * Print variables for user login
 * @return void
 */
function inboxino_user_login_variables_callback()
{
    inboxino_print_variables(array('general', 'user'));
}

/**
 * * Print variables for user password reset
 * @return void
 */
function inboxino_user_password_reset_callback()
{
    inboxino_print_variables(array('general', 'user', 'password_reset'));
}

/**
 * * Print variables for new comment
 * @return void
 */
function inboxino_new_comment_variables_callback()
{
    inboxino_print_variables(array('general', 'comment'));
}

/**
 * * Print variables for new comment reply
 * @return void
 */
function inboxino_new_comment_reply_variables_callback()
{
    inboxino_print_variables(array('general', 'comment'));
}

/**
 * * Print variables for comment approved
 * @return void
 */
function inboxino_comment_approved_variables_callback()
{
    inboxino_print_variables(array('general', 'comment'));
}
