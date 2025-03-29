<?php

/**
 * Plugin Name: inboxino
 * Plugin URI: https://app.inboxino.com/
 * Description: افزونه ارسال پیام و اعلان در واتساپ، تلگرام، بله، ایتا و روبیکا. ارسال پیام هنگام رویدادهای مختلف (ثبت نام، ورود کاربر، ارسال نظرات، پر کردن فرم ها) به کاربران و مدیران سایت. امکان اتصال به ووکامرس، گرویتی فرم و المنتور
 * Version: 2.0.1
 * Author: تیم قاصدک
 * Author URI: https://inboxino.com/
 * Text Domain: inboxino
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @package Inboxino
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Define plugin constants
$platforms = array('telegram' => 'تلگرام', 'bale' => 'بله', 'eitaa' => 'ایتا', 'whatsapp' => 'واتس اپ', 'rubika' => 'روبیکا', 'whatsapp_vip' => 'واتس اپ pro');
define('INBOXINO_PLATFORMS', $platforms);
define('INBOXINO_FRAMEWORK_PREFIX', 'inboxino_framework');
define('INBOXINO_SEND_MESSAGES_PERFIX', 'inboxino_send_messages');
define('INBOXINO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('INBOXINO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('INBOXINO_VERSION', '2.0.0');

// Require plugin files
require_once INBOXINO_PLUGIN_DIR . 'lib/codestar/codestar-framework.php';
require_once INBOXINO_PLUGIN_DIR . 'src/persiandate.php';
require_once INBOXINO_PLUGIN_DIR . 'src/api.php';
require_once INBOXINO_PLUGIN_DIR . 'functions.php';
require_once INBOXINO_PLUGIN_DIR . 'events.php';
require_once INBOXINO_PLUGIN_DIR . 'actions/wordpress.php';
require_once INBOXINO_PLUGIN_DIR . 'filters.php';

// At this stage is_plugin_active is not defined so we use the following to check if different plugins are installed
$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if (in_array('woocommerce/woocommerce.php', $active_plugins)) { 
    require_once INBOXINO_PLUGIN_DIR . 'actions/woocommerce.php';
}

if (in_array('gravityforms/gravityforms.php', $active_plugins)) {
    require_once INBOXINO_PLUGIN_DIR . 'actions/gravityforms.php';
}

if (in_array('contact-form-7/wp-contact-form-7.php', $active_plugins)) {
    require_once INBOXINO_PLUGIN_DIR . 'actions/contact-form-7.php';
}

if (in_array('elementor/elementor.php', $active_plugins)) {
    require_once INBOXINO_PLUGIN_DIR . 'actions/elementor.php';
}

if (in_array('wpforms-lite/wpforms.php', $active_plugins) || in_array('wpforms/wpforms.php', $active_plugins)) {
    require_once INBOXINO_PLUGIN_DIR . 'actions/wpforms.php';
}

function inboxino_load_admin() {
    if (is_admin()) {
        require_once INBOXINO_PLUGIN_DIR . 'admin/class-inboxino-admin.php';
        new InboxinoAdmin();
    }
}
add_action( 'plugins_loaded', 'inboxino_load_admin' );

/**
 * Show settings next to plugin activation link
 * @param mixed $links
 * @return array
 */
function inboxino_action_links($links, $file)
{
    if ($file == plugin_basename(__FILE__)) {
        $action_links = [
            'settings' => '<a href="' . admin_url('admin.php?page=inboxino-framework') . '">تنظیمات</a>',
        ];

        return array_merge($action_links, $links);
    }

    return $links;
}
add_filter('plugin_action_links', 'inboxino_action_links', 10, 2);
