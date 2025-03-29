<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

// Create parent section
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'id' => 'forms',
    'title' => 'رویدادهای فرم‌ها',
));

if ($if_gravityforms) {
    // Create gravityforms section
    CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
        'parent' => 'forms',
        'title' => 'فرم‌های گرویتی فرم',
        'fields' => array(
            // Gravityforms subheader
            array(
                'type' => 'subheading',
                'content' => 'پیام‌ها پس از ثبت فرم',
            ),
            // Gravityforms user switcher
            array(
                'id' => 'gravityforms_user',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به کاربر',
                'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
            ),
            // Gravityforms user messages
            array(
                'id' => 'gravityforms_user_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به کاربر',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('gravityforms_user', '==', 'true'),
            ),
            // Gravityforms phone switcher
            array(
                'id' => 'gravityforms_phone',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'دریافت شماره تماس از فرم',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه شماره تماس کاربر از یکی از فیلدهای فرم گرفته خواهد شد.',
                'dependency' => array('gravityforms_user', '==', 'true'),
            ),
            // Gravityforms phone id
            array(
                'id' => 'gravityforms_phone_id',
                'type' => 'text',
                'title' => 'آیدی فیلد شماره موبایل',
                'dependency' => array('gravityforms_phone', '==', 'true'),
            ),
            // Gravityforms admin switcher
            array(
                'id' => 'gravityforms_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            // Gravityforms admin messages
            array(
                'id' => 'gravityforms_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('gravityforms_admin', '==', 'true'),
            ),

            array(
                'id' => 'gravityforms_specific_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران خاص',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            array(
                'id' => 'gravityforms_specific_admin_ids',
                'type' => 'text',
                'title' => 'شناسه مدیران',
                'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
                'dependency' => array('gravityforms_specific_admin', '==', 'true'),
            ),
            array(
                'id' => 'gravityforms_specific_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('gravityforms_specific_admin', '==', 'true'),
            ),

            array(
                'id' => 'gravityforms_forms',
                'type' => 'repeater',
                'title' => 'پیام مخصوص برای هر فرم',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $forms_messages_fields,
                'subtitle' => 'با تعیین شناسه فرم می‌توانید پیام را تنها برای آن فرم ارسال کنید.',
            ),

            // Gravityforms variables subheader
            array(
                'type' => 'subheading',
                'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ثبت فرم',
            ),
            // Gravityforms register callback
            array(
                'type' => 'callback',
                'function' => 'inboxino_gravityforms_variables_callback',
            ),
        )
    ));
}

if ($if_contactform) {
    // Create Contact Form 7 section
    CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
        'parent' => 'forms',
        'title' => 'فرم‌های کانتک فرم 7',
        'fields' => array(
            // Contact Form 7 subheader
            array(
                'type' => 'subheading',
                'content' => 'پیام‌ها پس از ثبت فرم',
            ),
            // Contact Form 7 user switcher
            array(
                'id' => 'contactform_user',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به کاربر',
                'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
            ),
            // Contact Form 7 user messages
            array(
                'id' => 'contactform_user_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به کاربر',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('contactform_user', '==', 'true'),
            ),
            // Contact Form 7 admin switcher
            array(
                'id' => 'contactform_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            // Contact Form 7 admin messages
            array(
                'id' => 'contactform_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('contactform_admin', '==', 'true'),
            ),

            array(
                'id' => 'contactform_specific_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران خاص',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            array(
                'id' => 'contactform_specific_admin_ids',
                'type' => 'text',
                'title' => 'شناسه مدیران',
                'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
                'dependency' => array('contactform_specific_admin', '==', 'true'),
            ),
            array(
                'id' => 'contactform_specific_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('contactform_specific_admin', '==', 'true'),
            ),

            array(
                'id' => 'contactform_forms',
                'type' => 'repeater',
                'title' => 'پیام مخصوص برای هر فرم',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $forms_messages_fields,
                'subtitle' => 'با تعیین شناسه فرم می‌توانید پیام را تنها برای آن فرم ارسال کنید.',
            ),

            // Contact Form 7 variables subheader
            array(
                'type' => 'subheading',
                'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ثبت فرم',
            ),
            // Contact Form 7 register callback
            array(
                'type' => 'callback',
                'function' => 'inboxino_contactform_variables_callback',
            ),
        )
    ));
}

if ($if_elementor) {
    // Create Elementor section
    CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
        'parent' => 'forms',
        'title' => 'فرم‌های المنتور',
        'fields' => array(
            // Elementor subheader
            array(
                'type' => 'subheading',
                'content' => 'پیام‌ها پس از ثبت فرم',
            ),
            // Elementor user switcher
            array(
                'id' => 'elementor_user',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به کاربر',
                'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
            ),
            // Elementor user messages
            array(
                'id' => 'elementor_user_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به کاربر',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('elementor_user', '==', 'true'),
            ),
            // Elementor phone switcher
            array(
                'id' => 'elementor_phone',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'دریافت شماره تماس از فرم',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه شماره تماس کاربر از یکی از فیلدهای فرم گرفته خواهد شد.',
                'dependency' => array('elementor_user', '==', 'true'),
            ),
            // Elementor phone id
            array(
                'id' => 'elementor_phone_id',
                'type' => 'text',
                'title' => 'آیدی فیلد شماره موبایل',
                'dependency' => array('elementor_phone', '==', 'true'),
            ),
            // Elementor admin switcher
            array(
                'id' => 'elementor_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            // Elementor admin messages
            array(
                'id' => 'elementor_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('elementor_admin', '==', 'true'),
            ),

            array(
                'id' => 'elementor_specific_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران خاص',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            array(
                'id' => 'elementor_specific_admin_ids',
                'type' => 'text',
                'title' => 'شناسه مدیران',
                'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
                'dependency' => array('elementor_specific_admin', '==', 'true'),
            ),
            array(
                'id' => 'elementor_specific_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('elementor_specific_admin', '==', 'true'),
            ),

            array(
                'id' => 'elementor_forms',
                'type' => 'repeater',
                'title' => 'پیام مخصوص برای هر فرم',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $forms_messages_fields,
                'subtitle' => 'با تعیین شناسه فرم می‌توانید پیام را تنها برای آن فرم ارسال کنید.',
            ),
            // Elementor variables subheader
            array(
                'type' => 'subheading',
                'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ثبت فرم',
            ),
            // Elementor register callback
            array(
                'type' => 'callback',
                'function' => 'inboxino_elementor_variables_callback',
            ),
        )
    ));
}

if ($if_wpforms) {
    // Create WPForms section
    CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
        'parent' => 'forms',
        'title' => 'فرم‌های WPForms',
        'fields' => array(
            // WPForms subheader
            array(
                'type' => 'subheading',
                'content' => 'پیام‌ها پس از ثبت فرم',
            ),
            // WPForms user switcher
            array(
                'id' => 'wpforms_user',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به کاربر',
                'subtitle' => '(در صورتی که هنگام ثبت نام از کاربران خود شماره موبایل دریافت می‌کنید این پیام ارسال می‌شود)',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به کاربر ارسال خواهد شد.',
            ),
            // WPForms user messages
            array(
                'id' => 'wpforms_user_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به کاربر',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای کاربر تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('wpforms_user', '==', 'true'),
            ),
            // WPForms admin switcher
            array(
                'id' => 'wpforms_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            // WPForms admin messages
            array(
                'id' => 'wpforms_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('wpforms_admin', '==', 'true'),
            ),


            array(
                'id' => 'wpforms_specific_admin',
                'type' => 'switcher',
                'text_width' => 80,
                'title' => 'ارسال پیام به مدیران خاص',
                'default' => false,
                'desc' => 'با فعال سازی این گزینه، پس از ثبت فرم، پیام‌های تنظیم شده در پلتفرم‌های فعال به مدیران ارسال خواهد شد.',
            ),
            array(
                'id' => 'wpforms_specific_admin_ids',
                'type' => 'text',
                'title' => 'شناسه مدیران',
                'subtitle' => 'شناسه‌ها را با , از یکدیگر جدا کنید.',
                'dependency' => array('wpforms_specific_admin', '==', 'true'),
            ),
            array(
                'id' => 'wpforms_specific_admin_messages',
                'type' => 'repeater',
                'title' => 'پیام‌های ارسالی به مدیران',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $messages_fields,
                'subtitle' => 'پیام‌هایی که برای مدیران تنظیم می‌کنید، به ترتیب ارسال خواهند شد.',
                'dependency' => array('wpforms_specific_admin', '==', 'true'),
            ),

            array(
                'id' => 'wpforms_forms',
                'type' => 'repeater',
                'title' => 'پیام مخصوص برای هر فرم',
                'button_title' => 'افزودن پیام دیگر',
                'fields' => $forms_messages_fields,
                'subtitle' => 'با تعیین شناسه فرم می‌توانید پیام را تنها برای آن فرم ارسال کنید.',
            ),
            // WPForms variables subheader
            array(
                'type' => 'subheading',
                'content' => 'متغیرهای قابل استفاده در پیام‌های پس از ثبت فرم',
            ),
            // WPForms register callback
            array(
                'type' => 'callback',
                'function' => 'inboxino_wpforms_variables_callback',
            ),
        )
    ));
}

/**
 * * Print variables for Gravityforms section
 * @return void
 */
function inboxino_gravityforms_variables_callback()
{
    inboxino_print_variables(array('general', 'user', 'form'));
}

/**
 * * Print variables for Contact Forms 7 section
 * @return void
 */
function inboxino_contactform_variables_callback()
{
    inboxino_print_variables(array('general', 'user', 'form'));
}

/**
 * * Print variables for Elementor section
 * @return void
 */
function inboxino_elementor_variables_callback()
{
    inboxino_print_variables(array('general', 'user', 'form'));
}

/**
 * * Print variables for WPForms section
 * @return void
 */
function inboxino_wpforms_variables_callback()
{
    inboxino_print_variables(array('general', 'user', 'form'));
}
