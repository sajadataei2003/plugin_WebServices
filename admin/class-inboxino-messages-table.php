<?php

defined( 'ABSPATH' ) || exit;

/**
 * * Messages table class
 * @package Inboxino
 */
class InboxinoMessagesTable extends WP_List_Table {

    /**
     * * Constructor
     * @return void
    */ 
    public function __construct() 
    {
		parent::__construct(array(
			'singular' 	=> 	'پیام',
            'plural'    =>  'پیام‌ها',
			'ajax' 		=> 	'false',
		));
	}

    /**
     * * Set table columns
     * @return void 	
     */
    public function get_columns() 
    {
        return array(
            'bot'       =>  'اشتراک‌ها',
            'platform'  =>  'پلتفرم',
            'status'    =>  'وضعیت',
            'recp'      =>  'دریافت کنندگان',
            'daily'     =>  'ارسال روزانه',
            'hour'      =>  'ساعت شروع ارسال',
            'action'    =>  'عملیات',
        );
    }


    /**
     * * Value of bot column
     * @return void
     */ 
    public function column_bot($data) 
    {
        $html = '<span class="inboxino-table-bot">' . $data->bot->name . '</span>';
        $html .= '<span class="inboxino-table-date">' . $data->created_at->jalali . '</span>';
        return $html;
    }

    /**
     * * Value of platform column
     * @return void
     */
    public function column_platform($data)
    {
        $html = '';
        foreach( $data->platforms as $platform ) {
            $avatar = esc_url($platform->avatar);
            $platform_avatar = esc_url($platform->platform_avatar);

            $html .= '<div class="inboxino-table-platform">';
            $html .= "<img class='inboxino-table-avatar' src='{$avatar}'>";
            $html .= "<img class='inboxino-table-logo' src='{$platform_avatar}'>";
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * * Value of status column
     * @return void
     */  
    public function column_status($data)
    {
        $status = $data->status;
        switch( $status ) {
            case 'sent':
                return '<span class="inboxino-sent">ارسال شده</span>';
            case 'all_done':
                return '<span class="inboxino-sent">انجام شده</span>';
            case 'pending':
                return '<span class="inboxino-pending">در انتظار ارسال</span>';
            case 'error':
                return '<span class="inboxino-error" data-tooltip="' . $data->error . '">خطا<span class="dashicons dashicons-warning"></span></span>';
            case 'sending':
                return '<span class="inboxino-sending">در صف ارسال</span>';
            case 'cancel':
                return '<span class="inboxino-cancel">لغو شده</span>';
            case 'need_pay':
                return '<span class="inboxino-need-pay">در انتظار خرید پکیج</span>';
        }
        return esc_html($data->status);
    }

    /**
     * * Value of recp column
     * @return void
     */
    public function column_recp($data)
    {
        return esc_html($data->recipients_count) . ' شماره';
    } 

    /**
     * * Value of daily column
     * @return void
     */
    public function column_daily($data)
    {
        if (isset($data->setting->messages_count_per_day)) {
            return esc_html($data->setting->messages_count_per_day) . ' پیام';
        }
        return '';
    } 

    /**
     * * Value of hour column
     * @return void
     */
    public function column_hour($data)
    {
        $start = $data->setting->start_clock ?? false;
        $finish = $data->setting->finish_clock ?? false;
        if ($start && $finish) {
            $html = '<span>';
            $html .= "از <span class='inboxino-table-time'>{$start}</span> ";
            $html .= "تا <span class='inboxino-table-time'>{$finish}</span>";
            $html .= '</span>';
            return $html;
        }
        return '';
    } 

    /**
     * * Value of action column
     * @return void
     */ 
    public function column_action($data)
    {
        $url = remove_query_arg('paged');
        $nonce = wp_create_nonce('view_inboxino_message');
        return '<a href="' . add_query_arg(['message_id' => (int)$data->id, '_wpnonce' => $nonce], $url) . '">جزئیات</a>';
    }

    /**
     * * Get items from Inboxino API
     * @reutrn void
     */ 
	public function prepare_items() {
        $pagenum = $this->get_pagenum(); 

        $api = new InboxinoAPI();
        $response = $api->get_messages($pagenum);

        if ($response) {
		    $this->prepare_column_headers();
            $this->items = $response->messages->data;

            $this->set_pagination_args(
                array(
                    'total_items' => $response->messages->pagination->total,
                    'per_page'    => $response->messages->pagination->per_page,
                    'total_pages' => $response->messages->pagination->total_pages,
                )
            );
        }
    }

    /**
     * * Set table headers
     * @return void
     */ 
    protected function prepare_column_headers() 
    {
		$this->_column_headers = array(
			$this->get_columns(),
		);
	}

}
