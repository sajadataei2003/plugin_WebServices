<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

$messages_fields = array(
    // Message content
    array(
        'id' => 'content',
        'type' => 'textarea',
        'title' => 'محتوای پیام',
    ),
    // Message type select
    array(
        'id' => 'type',
        'type' => 'select',
        'title' => 'نوع پیام',
        'options' => array(
            'message' => 'متن',
            'image' => 'تصویر',
            'video' => 'ویدیو',
            'file' => 'فایل',
            'audio' => 'صدا',
        ),
    ),
    // Message image
    array(
        'id' => 'image',
        'type' => 'upload',
        'title' => 'فایل تصویر',
        'library' => 'image',
        'preview' => true,
        'desc' => 'تصویری که می‌خواهید به کاربر ارسال شود را انتخاب کنید.',
        'dependency' => array('type', '==', 'image'),
    ),
    // Message video
    array(
        'id' => 'video',
        'type' => 'upload',
        'title' => 'فایل ویدیو',
        'library' => 'video',
        'desc' => 'ویدیویی که می‌خواهید به کاربر ارسال شود را انتخاب کنید.',
        'dependency' => array('type', '==', 'video'),
    ),
    // Message file
    array(
        'id' => 'file',
        'type' => 'upload',
        'title' => 'فایل',
        'desc' => 'فایلی که می‌خواهید به کاربر ارسال شود را انتخاب کنید.',
        'dependency' => array('type', '==', 'file'),
    ),
    // Message audio
    array(
        'id' => 'audio',
        'type' => 'upload',
        'title' => 'فایل صدا',
        'library' => 'audio',
        'desc' => 'فایل صدایی که می‌خواهید به کاربر ارسال شود را انتخاب کنید.',
        'dependency' => array('type', '==', 'audio'),
    ),
);

$fields = array(
    // Select users subheading
    array(
        'type' => 'subheading',
        'content' => 'انتخاب کاربران',
    ),
    // Users selector
    array(
        'id' => 'users_selector',
        'type' => 'select',
        'title' => 'روش ورود شماره ها',
        'desc' => 'کاربران را بر چه اساسی می‌خواهید انتخاب کنید',
        'placeholder' => 'یک گزینه را انتخاب کنید',
        'options' => array(
            'users' => 'کاربران وردپرس',
            'phone' => 'شماره تماس',
            'excel' => 'فایل اکسل',
        ),
    ),
    // Wordpress users
    array(
        'id' => 'users_wordpress',
        'type' => 'select',
        'title' => 'انتخاب کاربران',
        'options' => 'inboxino_get_users',
        'multiple' => true,
        'chosen' => true,
        'ajax' => true,
        'dependency' => array( 'users_selector', '==', 'users' ),
    ),
    // Phone numbers
    array(
        'id' => 'users_phone',
        'type' => 'textarea',
        'title' => 'شماره موبایل',
        'desc' => 'در هر خط یک شماره موبایل را وارد کنید. در صورتی که می‌خواهید کد کشور در شماره ها باشد حتما باید + را اول کد کشور بزارید ( مثال با فرمت صحیح : 989120001122+ )',
        'dependency' => array( 'users_selector', '==', 'phone' ),
    ),
    // Excel file
    array(
        'id' => 'users_excel',
        'type' => 'upload',
        'button_title' => 'آپلود',
        'desc' => '<p><a href="https://inboxino.com/media/samples/send-with-variables.xlsx">دانلود فایل نمونه</a><br>در ستون A : شماره‌های خود را وارد کنید<br>در فایل اکسل همانند فایل نمونه در ستون‌های B به بعد متغیرهای خود را به ترتیب وارد کنید و در متن پیام ارسالی به جای هر متغیر حرف ستون آن را وارد کنید. به طور مثال: سلام (B) عزیز<br>سقف مجاز ورود شماره اکسل 2000 شماره می‌باشد</p>',
        'dependency' => array( 'users_selector', '==', 'excel' ),
    ),
    // Platforms select option
    array(
        'id' => 'platforms',
        'type' => 'checkbox',
        'title' => 'پلتفرم‌ها',
        'options' => INBOXINO_PLATFORMS,
    ),
    // Message subheading
    array(
        'type' => 'subheading',
        'content' => 'پیام',
    ),
    // Messages
    array(
        'id' => 'bulk_messages',
        'type' => 'repeater',
        'title' => 'پیام‌ها',
        'min' => 1,
        'button_title' => '+ افزودن پیام دیگر',
        'fields' => $messages_fields,
        'default' => array(
            array(),
        ),
    ),
    // Settings subheading
    array(
        'type' => 'subheading',
        'content' => 'تنظیمات پیشرفته پیام',
    ),
    // Messages count per day
    array(
        'id' => 'messages_count_per_day',
        'type' => 'number',
        'title' => 'روزانه چند پیام ارسال شود؟',
        'desc' => 'با این گزینه تعداد ارسال پیام در بازه زمانی شروع و پایان ارسال پیام‌ها در یک شبانه روز را مشخص می‌کنید. باقی مانده پیامها روز بعد ارسال خواهد شد.توجه داشته باشید که هر چه این عدد کمتر باشد، احتمال اینکه پیام‌رسان شما را مسدود کند کمتر است',
        'default' => 250,
    ),
    // Start date
    array(
        'id' => 'send_schedule',
        'type' => 'persiandate',
        'desc' => 'تاریخی که می‌خواهید پیام‌های شما شروع به ارسال کند برای مثال اگه تاریخ سه روز دیگر را انتخاب کنید پیام‌های شما سه روز دیگر شروع به ارسال می‌شوند',
        'title' => 'تاریخ شروع ارسال',
    ),
    // Expired date
    array(
        'id' => 'expired_date',
        'type' => 'persiandate',
        'desc' => 'تاریخی که می‌خواهید پیام‌های شما پس از آن ارسال نشود را تعیین کنید.',
        'title' => 'تاریخ پایان ارسال',
    ),
    // Start clock
    array(
        'id' => 'start_clock',
        'type' => 'text',
        'class' => 'inboxino-time',
        'title' => 'ساعت شروع ارسال',
        'desc' => 'ساعتی که می‌خواهید هر روز پیام‌های شما ارسال شود برای مثال شما می‌خواهید هر روز از ساعت 8 صبح پیام‌های شما ارسال شود',
        'placeholder' => 'hh:mm'
    ),
    // Finish clock
    array(
        'id' => 'finish_clock', 
        'type' => 'text',
        'class' => 'inboxino-time',
        'title' => 'ساعت توقف ارسال',
        'desc' => 'ساعتی که پیام‌های شما دیگر نمی‌خواهید ارسال شود. برای مثال اگر شما نمی‌خواهید ساعت 23 به بعد برای کاربر پیامی ارسال شود',
        'placeholder' => 'hh:mm'
    ),
    // Send count
    array(
        'id' => 'send_count',
        'type' => 'number',
        'desc' => 'در هر دوره3 پیام ‌ارسال می‌شود.توجه داشته باشید که هر چه این عدد کمتر باشد، احتمال اینکه پیام‌رسان شما را مسدود کند کمتر است',
        'title' => 'تعداد ارسال پیام‌ها در هر دوره',
        'default' => 3,
    ),
    // Break time
    array(
        'id' => 'break_time',
        'type' => 'number',
        'desc' => 'زمان استراحت بین هر دوره2دقیقه است و سپس دوباره شروع به ارسال می‌کندتوجه داشته باشید که هر چه این عدد کمتر باشد، احتمال اینکه پیام‌رسان شما را مسدود کند کمتر است',
        'title' => 'زمان استراحت بین هر دوره به دقیقه',
        'default' => 2,
    ),
    
);

// Create parent section
CSF::createSection( INBOXINO_SEND_MESSAGES_PERFIX, array(
    'id' => 'send_message',
    'title' => 'ارسال پیام',
    'fields' => $fields
));

/**
 * * Change submit button labels
 * @param array $labels Labels of the button
 * @return array
 */
function inboxino_csf_submit_label($labels) 
{
    $labels['value'] = 'ارسال پیام';
    $labels['data-save'] = 'در حال ارسال...';
    return $labels;
}
add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_submit_label', 'inboxino_csf_submit_label');

/**
 * * Prevent form result message from fading
 * @param string $class html class of the form result message
 * @return string
 */ 
function inboxino_csf_notice_class($class) 
{
    return 'inboxino-csf-form-result';
}
add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_notice_class', 'inboxino_csf_notice_class');

/**
 * * Show form notification result in a different place
 * @param bool $bool value for showing the alternative notifcation
 * @return string
 */ 
function inboxino_csf_alt_notification( $bool ) 
{
    return ! $bool;
}
add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_alt_notification', 'inboxino_csf_alt_notification');


/**
 * * Change csf form result message color from success to warning
 * @param strin $class html class of the form result message
 * @return string
 */
function inboxino_csf_warning($class)
{
    return 'csf-form-warning';  
}


/**
 * * Handle sending messages from send message section, 
 * while filters should not be used like this since 
 * codestar doesn't provide a suitable hook it's
 * our only option
 *
 * @param array $data form data
 * @param CSF_Options $obj the object responsible for handling the current form
 * @return array values to be saved
 */
function inboxino_send_messages($data, $obj) 
{
    if (!empty($data['users_selector'])) {
        if (empty($data['bulk_messages'])) {
            $obj->notice = 'پیامی برای ارسال انتخاب نشده';
            add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_message_class', 'inboxino_csf_warning');
            return array();
        }

        $messages = apply_filters('inboxino_bulk_messages', $data['bulk_messages']);
        $send_schedule = $data['send_schedule'];
        $settings = array(
            'break_time' => $data['break_time'],
            'expired_date' => $data['expired_date'],
            'finish_clock' => $data['finish_clock'],
            'messages_count_per_day' => $data['messages_count_per_day'],
            'send_count' => $data['send_count'],
            'start_clock' => $data['start_clock'],
        );

        $platforms = $data['platforms'];

        $api = new InboxinoApi();
        $recipients = array();
        switch($data['users_selector']) {
            case 'phone':
                if (empty($data['users_phone'])) {
                    $obj->notice = 'شماره تماس خالی است';
                    break;
                }
                $recipients = array_map(function($value) { return trim($value); },explode(PHP_EOL, $data['users_phone']));
                break;
            case 'users':
                if (empty($data['users_wordpress'])) {
                    $obj->notice = 'کاربری انتخاب نشده است';
                    break;
                }

                foreach( $data['users_wordpress'] as $user_id ) {
                    $phone = inboxino_get_phone_number_by('user_id', $user_id)[0];
                    if (empty($phone)) continue;
                    $recipients[] = $phone;
                }
                break;
            case 'excel':
                if (empty($data['users_excel'])) {
                    $obj->notice = 'فایلی انتخاب نشده است';
                    break;
                }

                $path = $api->upload($data['users_excel'], 'excel');

                if (!$path) {
                    $obj->notice = 'خطا در ارسال یا محتوای فایل اکسل';
                    break;
                }


                $response = $api->send_excel_bulk_message($messages, $path, $platforms, $settings, $send_schedule);

                if ($response->code == 200) {
                    $obj->notice = 'پیام شما با موفقیت در صف ارسال قرار گرفت و به زودی ارسال خواهد شد';
                } else {
                    $obj->notice = 'خطایی پیش آمده:' . $response->message;
                    add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_message_class', 'inboxino_csf_warning');
                }

                // Since handling excel files is different we don't want the rest of the function to run,
                return array();
        }

        if (empty($recipients)) {
            add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_message_class', 'inboxino_csf_warning');
            return array();
        }
        
        $response = $api->send_bulk_message($messages, $recipients, $platforms, $settings, $send_schedule);

        if ($response->code == 200) {
            $obj->notice = 'پیام شما با موفقیت در صف ارسال قرار گرفت و به زودی ارسال خواهد شد';
        } else {
            $obj->notice = 'خطایی پیش آمده:' . $response->message;
            add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_message_class', 'inboxino_csf_warning');
        }
    } else {
        $obj->notice = 'کاربری انتخاب نشده است.';
        add_filter('inboxino_csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_message_class', 'inboxino_csf_warning');
    }
    return array();
}
add_filter('csf_' . INBOXINO_SEND_MESSAGES_PERFIX . '_save', 'inboxino_send_messages', 10, 2);


/**
 * Get users for select field
 * @return array
 */
function inboxino_get_users() 
{
    check_admin_referer('csf_chosen_ajax_nonce', 'nonce');
    $user_name = sanitize_user($_POST['term']);
    $user_query = new WP_User_Query(array(
        'search'         => '*' . esc_attr($user_name) . '*',
        'search_columns' => array('user_login', 'user_nicename', 'display_name'),
        'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query 
            array(
                'key'     => get_option(INBOXINO_FRAMEWORK_PREFIX)['user_phone_number_meta_wordpress'],
                'value'   => '',
                'compare' => '>'
            ),
        ),
    ) );

    $users = $user_query->get_results();
    $response = [];
    foreach($users as $user) {
        $user_data = get_userdata($user->ID);
        $response[$user_data->ID] = $user_data->user_login;
    }

    return $response;
}
