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
			'singular' 	=> 	'اعلان',
            'plural'    =>  'اعلان‌ها',
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
            'avatar'        =>  'تصویر',
            'bot'           =>  'اشتراک',
            'platform'      =>  'پلتفرم',
            'number'        =>  'شماره',
            'status'        =>  'وضعیت',
            'sent_at'       =>  'ارسال شده در',
        );
    }

    /**
     * * Value of bot column
     * @return void
     */  
    public function column_bot($data)
    {
        return esc_html($data->bot->name);
    }

    /**
     * * Value of avatar column
     * @return void
     */  
    public function column_avatar($data)
    {
        return '<img class="inboxino-avatar" src="'. esc_url($data->avatar) . '" alt="تصویر">';
    }

    /**
     * * Value of platform column
     * @return void
     */  
    public function column_platform($data)
    {
        return esc_html(INBOXINO_PLATFORMS[$data->platform]);
    }

    /**
     * * Value of number column
     * @return void
     */  
    public function column_number($data)
    {
        return esc_html($data->to);
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
     * * Value of sent at column
     * @return void
     */ 
    public function column_sent_at($data)
    {
        if ( isset($data->sent_at_object->jalali) ) {
            return esc_html($data->sent_at_object->jalali);
        }
        return '';
    }

    /**
     * * Get items from Inboxino API
     * @reutrn void
     */ 
	public function prepare_items() {
        $pagenum = $this->get_pagenum(); 

        $api = new InboxinoAPI();
        $response = $api->get_notification_logs($pagenum);


        if ($response) {
		    $this->prepare_column_headers();
            $this->items = $response->notifications->data;

            $this->set_pagination_args(
                array(
                    'total_items' => $response->notifications->pagination->total,
                    'per_page'    => $response->notifications->pagination->per_page,
                    'total_pages' => $response->notifications->pagination->total_pages,
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
