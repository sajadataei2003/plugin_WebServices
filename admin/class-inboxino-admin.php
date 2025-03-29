<?php

// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * * Admin class responsible for handling everythin related to the admin side
 * @package Inboxino
 */
class  InboxinoAdmin 
{

    private $platforms;

    /**
     * * Constructor for inboxino admin
     */  
    public function __construct() 
    {
        // Define messages fields
        $messages_fields = array(
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
            // Message content
            array(
                'id' => 'content',
                'type' => 'textarea',
                'title' => 'محتوای پیام',
                'subtitle' => 'می‌توانید از متغیرهای تعریف شده در این بخش نیز استفاده نمایید.',
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

        require_once INBOXINO_PLUGIN_DIR . 'admin/options-general.php';
        require_once INBOXINO_PLUGIN_DIR . 'admin/options-wordpress.php';

        // At this stage is_plugin_active is not defined so we use the following to check if different plugins are installed
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
        if (in_array('woocommerce/woocommerce.php', $active_plugins)) { 
            require_once INBOXINO_PLUGIN_DIR . 'admin/options-woocommerce.php';
        }

        $if_gravityforms = in_array('gravityforms/gravityforms.php', $active_plugins);
        $if_contactform = in_array('contact-form-7/wp-contact-form-7.php', $active_plugins);
        $if_elementor = in_array('elementor/elementor.php', $active_plugins);
        $if_wpforms = in_array('wpforms-lite/wpforms.php', $active_plugins) || in_array('wpforms/wpforms.php', $active_plugins);

        $forms_messages_fields = array(
            array(
                'id' => 'form_id',
                'type' => 'text',
                'title' => 'شناسه فرم',
            ),
            array(
                'id' => 'admin_ids',
                'type' => 'text',
                'title' => 'شناسه مدیران',
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
            // Message content
            array(
                'id' => 'content',
                'type' => 'textarea',
                'title' => 'محتوای پیام',
                'subtitle' => 'می‌توانید از متغیرهای تعریف شده در این بخش نیز استفاده نمایید.',
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

        if($if_gravityforms || $if_elementor || $if_contactform || $if_wpforms) {
            require_once INBOXINO_PLUGIN_DIR . 'admin/options-forms.php';
        }


        require_once INBOXINO_PLUGIN_DIR . 'admin/options-meta.php';
        require_once INBOXINO_PLUGIN_DIR . 'admin/options-send.php';

        $this->setup_csf();

        add_filter('inboxino_csf_' . INBOXINO_FRAMEWORK_PREFIX . '_tabs', array($this, 'add_tabs'));
        add_filter('inboxino_csf_checkbox-data', array($this, 'platforms_checkboxes'), 10, 2);
        add_filter('inboxino_csf_checkbox-status', array($this, 'platforms_status'), 10, 2);

        add_action('admin_menu', array($this, 'add_submenu_page'), 20);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }


    /**
     * * Add custom attributes to platofrms checkboxes
     * @param string custom attributes
     * @param string checkbox value
     * @return string
     */
    public function platforms_checkboxes($attr, $value) {
        if (!$this->platforms) {
            $api = new InboxinoAPI();
            $user = $api->get_user();
            if (isset($user->bot) && isset($user->bot->platforms)) {
                $this->platforms = $user->bot->platforms;
            }
            
        }

        foreach($this->platforms as $platform) {
            if ($platform->platform == $value) {
                return '';
            }
        }

        $attr = 'disabled title="این پلتفرم خریداری نشده است."';
        return $attr;
    }

    /**
     * * Echo platform status if it's not ready
     * @param string custom attributes
     * @param string checkbox value
     * @return string
     */
    public function platforms_status($status, $value) {
        if (!$this->platforms) {
            $api = new InboxinoAPI();
            $user = $api->get_user();
            if (isset($user->bot) && isset($user->bot->platforms)) {
                $this->platforms = $user->bot->platforms;
            }
            
        }

        foreach($this->platforms as $platform) {
            if ($platform->platform == $value) {
                if ($platform->status == 'need_login') {
                    return '<span class="badge danger">پلتفرم متصل نشده است.</span>';
                }

                if ($platform->status == 'stop') {
                    return '<span class="badge danger">پلتفرم فعال نمی‌باشد.</span>';
                }

                return '';
            }
        }

        return $status;
    }

    
    /**
     * * Add custom tabs to Inboxino section'
     * @param array tabs
     * @return array
     */
    public function add_tabs($tabs) {
        $tabs[] = [
            'url' => add_query_arg(['page' => 'inboxino-send-message'], admin_url('admin.php')),
            'title' => 'ارسال پیام',
        ];
        $tabs[] = [
            'url' => add_query_arg(['page' => 'inboxino-notifications'], admin_url('admin.php')),
            'title' => 'لیست اعلان‌ها',
        ];
        $tabs[] = [
            'url' => add_query_arg(['page' => 'inboxino-messages'], admin_url('admin.php')),
            'title' => 'لیست پیام‌ها',
        ];

        return $tabs;
    }


    /**
     * * Add admin static files
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('inboxino_admin_style', INBOXINO_PLUGIN_URL . 'assets/style.css', [], INBOXINO_VERSION);
    }

    
    /**
     * * Add messages submenu to admin menu
     * @return void
     */
    public function add_submenu_page()
    { 
        add_submenu_page( 
            'inboxino-framework',
            'لیست اعلان‌ها',
            'لیست اعلان‌ها',
            'manage_options',
            'inboxino-notifications',
            array($this, 'render_notifications_page'),
        );

        add_submenu_page( 
            'inboxino-framework',
            'لیست پیام‌ها',
            'لیست پیام‌ها',
            'manage_options',
            'inboxino-messages',
            array($this, 'render_messages_page'),
        );
    }


    /**
     * * Render notifications page
     * @return void
     */ 
    public function render_notifications_page()
    {
        require_once INBOXINO_PLUGIN_DIR . '/admin/class-inboxino-notifications-table.php';
		
		$table = new InboxinoMessagesTable();
		$table->prepare_items();

		echo '<div class="wrap">';
		echo '<h1 class="wp-heading-inline">' . esc_html( get_admin_page_title() ) . '</h1>';
		$table->display();	
		echo '</div>';
    }

    /**
     * * Render messages page
     * @return void
     */
    public function render_messages_page()
    {
        if (isset($_GET['message_id'])) {
            check_admin_referer('view_inboxino_message');
            $id = (int)$_GET['message_id'];
            $this->render_message_details($id);
        } else {
            $this->render_messages_table();
        }
    }


    /**
     * * Render message details
     * @param int $id of the message 
     * @return void
     */
    private function render_message_details($id)
    {
        $api = new InboxinoAPI();
        $response = $api->get_message_details($id);

        if ($response) {
            $message = $response->message;

            require_once INBOXINO_PLUGIN_DIR . '/admin/class-inboxino-recipients-table.php';
		    $recipients_table = new InboxinoRecipientsTable($id);
		    $recipients_table->prepare_items();

            ?>
            <div class="wrap" id="inboxino-message-details">
                <div id="col-container" class="wp-clearfilx">
                    <div id="col-left">
                        <div class="col-wrap">
                            <div class="inboxino-message-details">
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">شناسه پیام</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->id); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">اشتراک</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->bot->name); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">دریافت کنندگان پیام</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->recipients_count); ?> <span class="inboxino-grey-box">پیام</span></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">وضعیت</span>
                                    <span class="inboxino-content"><?php echo $this->message_status($message->status); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">دلیل توقف</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->stopping_reason); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">تعداد پیام‌ها</span>
                                    <span class="inboxino-content"><?php echo esc_html(count($message->messages)); ?> <span class="inboxino-grey-box">پیام</span></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">ساعت شروع ارسال</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->setting->start_clock ?? ''); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">ساعت توقف ارسال</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->setting->finish_clock ?? ''); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">تاریخ شروع ارسال</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->created_at->jalali ?? ''); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">تعداد ارسال پیامها در هر دوره</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->setting->send_count ?? ''); ?> <span class="inboxino-grey-box">پیام</span></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">زمان استراحت</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->setting->break_time ?? ''); ?> <span class="inboxino-grey-box">دقیقه</span></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">روزانه چند پیام ارسال شود ؟</span>
                                    <span class="inboxino-content"><?php echo esc_html($message->setting->messages_count_per_day ?? ''); ?> <span class="inboxino-grey-box">پیام</span></span>
                                </div>
                                <?php foreach( $message->messages as $key => $data ): ?>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">متن ارسالی <?php echo (int) $key + 1;?></span>
                                    <span class="inboxino-content"><?php echo esc_html($data->message); ?></span>
                                </div>
                                <div class="inboxino-message-item">
                                    <span class="inboxino-label">فایل ارسال شده <?php echo (int) $key + 1;?></span>
                                    <span class="inboxino-content">
                                        <?php if (!is_null($data->attachment_file)): ?>
                                        <a href="<?php echo esc_url($data->attachment_file) ?>" target="_blank">مشاهده</a>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <div id="col-right">
                        <h2>دریافت کنندگان پیام</h2>
                        <?php $recipients_table->display(); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }


    /**
     * * Render messages table
     * @return void
     */
    private function render_messages_table()
    {
        require_once INBOXINO_PLUGIN_DIR . '/admin/class-inboxino-messages-table.php';
		
		$table = new InboxinoMessagesTable();
		$table->prepare_items();

		echo '<div class="wrap">';
		echo '<h1 class="wp-heading-inline">' . esc_html( get_admin_page_title() ) . '</h1>';
		$table->display();	
		echo '</div>';
    }


    /**
     * * Maps status to appropriate output
     * @param string $status
     * @return string
     */ 
    private function message_status($status) {
        switch( $status ) {
            case 'sent':
                return '<span class="inboxino-sent">ارسال شده</span>';
            case 'all_done':
                return '<span class="inboxino-sent">انجام شده</span>';
            case 'pending':
                return '<span class="inboxino-pending">در انتظار ارسال</span>';
            case 'error':
                return '<span class="inboxino-error">خطا</span>';
            case 'sending':
                return '<span class="inboxino-sending">در صف ارسال</span>';
            case 'cancel':
                return '<span class="inboxino-cancel">لغو شده</span>';
            case 'need_pay':
                return '<span class="inboxino-need-pay">در انتظار خرید پکیج</span>';
        }
    }


    /**
     * * Define CSF Options 
     * @return void
     */
    private function setup_csf() 
    {
        // Create options framework
        CSF::createOptions(INBOXINO_FRAMEWORK_PREFIX, array(
            'framework_title' => 'قاصدک',
            'menu_title' => 'قاصدک',
            'menu_slug' => 'inboxino-framework',
            'menu_type' => 'menu',
            'menu_icon' => 'dashicons-email-alt',
            'show_bar_menu' => false,
            'show_in_customizer' => false,
            'ajax_save' => false,
            'footer_text' => '',
            'enqueue_webfont' => false,
            'output_css' => false,
            'class' => 'inboxino-framework'
        ));

        // Create send message submenu
        CSF::createOptions(INBOXINO_SEND_MESSAGES_PERFIX, array(
            'framework_title' => 'ارسال پیام',
            'menu_title' => 'ارسال پیام',
            'menu_slug' => 'inboxino-send-message',
            'menu_type' => 'submenu',
            'menu_parent' => 'inboxino-framework',
            'show_reset_all' => false,
            'show_reset_section' => false,
            'show_search' => false,
            'show_bar_menu' => false,
            'show_in_customizer' => false,
            'show_form_warning' => false,
            'save_form' => false,
            'ajax_save' => false,
            'footer_text' => '',
            'enqueue_webfont' => false,
            'output_css' => false,
            'class' => 'inboxino-framework'
        ));
    }
    
}
