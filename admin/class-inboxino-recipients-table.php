<?php

defined( 'ABSPATH' ) || exit;

/**
 * * Recipients table class
 * @package Inboxino
 */
class InboxinoRecipientsTable extends WP_List_Table {

    private $message_id;

    /**
     * * Constructor
     * @return void
    */ 
    public function __construct($message_id) 
    {
		parent::__construct(array(
			'singular' 	=> 	'دریافت کننده',
            'plural'    =>  'دریافت کنندگان',
			'ajax' 		=> 	'false',
		));

        $this->message_id = $message_id;
	}

    /**
     * * Set table columns
     * @return void 	
     */
    public function get_columns() 
    {
        return array(
            'platform'  =>  'پلتفرم',
            'user'      =>  'کاربر',
            'status'    =>  'وضعیت',
            'date'      =>  'تاریخ',
        );
    }

    /**
     * * Value of avatar column
     * @return void
     */  
    public function column_user($data)
    {
        return  '<div class="inboxino-user"><img class="inboxino-avatar" src="'. esc_url($data->avatar) . '" alt="تصویر"><span>' . esc_html($data->to) . '</span></div>';
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
    public function column_date($data)
    {
        return esc_html($data->sent_at->jalali);
    }

    /**
     * * Get items from Inboxino API
     * @reutrn void
     */ 
	public function prepare_items() {
        $pagenum = $this->get_pagenum(); 

        $api = new InboxinoAPI();
        $response = $api->recipients($this->message_id, $pagenum);

        if ($response) {
		    $this->prepare_column_headers();
            $this->items = $response->recipients->data;

            $this->set_pagination_args(
                array(
                    'total_items' => $response->recipients->pagination->total,
                    'per_page'    => $response->recipients->pagination->per_page,
                    'total_pages' => $response->recipients->pagination->total_pages,
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
