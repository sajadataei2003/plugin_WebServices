<?php

// خروج در صورت دسترسی مستقیم
defined('ABSPATH') || exit;

// ایجاد بخش تنظیمات
CSF::createSection(INBOXINO_FRAMEWORK_PREFIX, array(
    'title' => 'پیکربندی کلی',
    'fields' => array(
        // زیرعنوان API
        array(
            'type' => 'subheading',
            'content' => 'پیکربندی وب‌سرویس اقاصدک',
        ),
        // فیلد توکن API
        array(
            'id' => 'api_token',
            'type' => 'text',
            'title' => 'توکن API',
            'desc' => 'برای دریافت توکن، به بخش <a href="https://app.inboxino.com/services/api" target="_blank">وب‌سرویس</a> در پنل قاصدک مراجعه کنید و مقدار آن را در اینجا وارد نمایید.',
        ),
        // گزینه‌های انتخابی پلتفرم‌ها
        array(
            'id' => 'platforms',
            'type' => 'checkbox',
            'title' => 'پلتفرم‌های فعال',
            'options' => INBOXINO_PLATFORMS,
            'subtitle' => 'پلتفرم‌هایی که قصد استفاده از آن‌ها را دارید انتخاب کنید. برای هر پلتفرم باید اشتراک مرتبط را فعال کرده باشید. از طریق <a href="https://app.inboxino.com/bot-connections" target="_blank">بخش اشتراک‌های من</a> می‌توانید وضعیت اشتراک‌ها را بررسی کنید.',
        ),
        // بررسی وضعیت API
        array(
            'type' => 'callback',
            'function' => 'inboxino_api_callback',
        ),
        // مدت زمان انقضا
        array(
            'id' => 'expire_minutes',
            'type' => 'text',
            'title' => 'مدت اعتبار پیام‌ها',
            'subtitle' => 'زمان اعتبار پیام را به دقیقه وارد کنید. برای مثال، مقدار ۱۰ یعنی پیام پس از ۱۰ دقیقه ارسال‌نشده از صف حذف می‌شود. اگر نیازی به این ویژگی ندارید، این قسمت را خالی بگذارید.',
        ),
        // زیرعنوان مدیران
        array(
            'type' => 'subheading',
            'content' => 'مدیریت شماره‌های مدیران',
        ),
        // شماره‌های مدیران
        array(
            'id' => 'admins_phone_numbers',
            'type' => 'repeater',
            'title' => 'شماره‌های مدیران',
            'max' => 20,
            'button_title' => 'افزودن شماره',
            'subtitle' => 'شماره مدیران را برای ارسال پیام‌های مدیریتی وارد کنید.',
            'fields' => array(
                array(
                    'id' => 'phone_id',
                    'type' => 'text',
                    'title' => 'شناسه مدیر',
                    'desc' => 'شناسه‌ای یکتا برای این شماره ثبت کنید.',
                ),
                array(
                    'id' => 'phone_number',
                    'type' => 'text',
                    'title' => 'شماره همراه',
                    'desc' => 'شماره موبایل را با کد کشور وارد کنید. در صورت خالی گذاشتن، کد پیش‌فرض 98+ اضافه خواهد شد.',
                ),
            ),
        ),
        array(
            'type' => 'subheading',
            'content' => 'تنظیمات متا شماره تلفن کاربران',
        ),
        // راهنما متای شماره موبایل
        array(
            'type' => 'content',
            'content' => '<span class="badge info">راهنما</span> برای یافتن متای شماره موبایل، به بخش <a href="#tab=%d9%85%d8%aa%d8%a7%db%8c-%da%a9%d8%a7%d8%b1%d8%a8%d8%b1%d8%a7%d9%86" data-tab-id="%d9%85%d8%aa%d8%a7%db%8c-%da%a9%d8%a7%d8%b1%d8%a8%d8%b1%d8%a7%d9%86">متای کاربران</a> مراجعه کنید، یک کاربر را انتخاب کرده و سپس تنظیمات را ذخیره کنید. متای صحیح را در فیلد زیر وارد کنید.',
        ),
        // فیلد متا شماره موبایل وردپرس
        array(
            'id' => 'user_phone_number_meta_wordpress',
            'type' => 'text',
            'title' => 'متا شماره همراه کاربر',
            'desc' => 'نام متای مربوط به شماره موبایل کاربران وردپرس را وارد نمایید.',
        ),
        array(
            'id' => 'edit_country_code',
            'type' => 'switcher',
            'title' => 'افزودن کد 98+ به صورت خودکار',
            'subtitle' => 'در صورت فعال بودن، کد 98+ به شماره کاربران اضافه می‌شود.',
            'default' => true,
        ),
    )
));

/**
 * بررسی اتصال به API اینباکسینو
 */
function inboxino_api_callback()
{
    $api = new InboxinoAPI();
    $user = $api->get_user();
    
    if (!$user) {
        echo '<span class="badge danger">خطا در اتصال</span>';
        echo 'ارتباط با وب‌سرویس ناموفق بود. لطفاً توکن خود را بررسی و مجدداً ذخیره کنید.';
        return;
    }
    
    echo '<span class="badge success">اتصال موفق</span>';
    echo 'ارتباط با وب‌سرویس قاصدک برقرار شد.';
    
    if (!empty($user->bot->name)) {
        echo '<code>' . esc_html($user->bot->name) . '</code>';
    }
    
    echo '<div style="margin-bottom: 7px"></div>';
    
    foreach (inboxino_get_not_connected_platforms($user->bot->platforms) as $platform) {
        echo '<div style="margin-bottom: 7px"></div>';
        echo '<span class="badge danger">پلتفرم غیرفعال</span>';
        echo 'پلتفرم <strong>' . esc_html(INBOXINO_PLATFORMS[$platform]) . '</strong> در قاصدک غیرفعال است. لطفاً در پنل قاصدک این پلتفرم را فعال کنید.';
    }
}
