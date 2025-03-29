<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * API class for handling API requests to interact with inboxino
 * @package Inboxino
 */
class InboxinoAPI
{
    private $server_url;
    private $upload_url;
    private $token;
    private $platforms;
    private $user;

    /**
     * * API class constructor
     * @return void
     */
    public function __construct()
    {
        $this->server_url = 'https://back.inboxino.com/api';
        $this->upload_url = 'https://dl1.inboxino.com/api/upload/';
        $options = get_option(INBOXINO_FRAMEWORK_PREFIX);
        $this->token = $options['api_token'] ? $options['api_token'] : '';
        $this->platforms = $options['platforms'] ? $options['platforms'] : array();
    }

    /**
     * * Send bulk message to recipients via inboxino API
     * @param array $messages array of messages to send
     * @param array $recipients array of recipients to send messages to
     * @param array $platforms array of platforms
     * @param array $settings array of settings for the message
     * @param string sned_schedule parameter of the api
     * @return object data from inboxino API
     */
    public function send_bulk_message($messages, $recipients, $platforms, $settings = array(), $send_schedule = '')
    {
        // Default values for $settings
        $defaults = array(
            'break_time' => '',
            'expired_date' => '',
            'finish_clock' => '',
            'messages_count_per_day' => '',
            'send_count' => '',
            'start_clock' => '',
        );

        $settings = wp_parse_args($settings, $defaults);

        $edit_country_code = get_option(INBOXINO_FRAMEWORK_PREFIX);
        $edit_country_code = array_key_exists( 'edit_country_code', $edit_country_code ) ? $edit_country_code['edit_country_code'] : true;
        // Check if recipients items starts with + or not
        // If not, replace 0 with +98 in each item
        if ( $edit_country_code ) {
            foreach ($recipients as $key => $recipient) {
                if (substr($recipient, 0, 1) != '+') {
                    if ($recipient[0] == '0') {
                        $recipients[$key] = '+98' . substr($recipient, 1);
                    } else {
                        $recipients[$key] = '+98' . $recipient;
                    }
                }
            }
        }

        // Prepare body for request
        $body = array(
            'messages' => $messages,
            'recipients' => $recipients,
            'platforms' => $platforms,
            'setting' => $settings,
            'send_schedule' => $send_schedule,
            'with_country_code' => false,
        );

        // Send request to inboxino API
        $response = $this->_post('/access-api/message/send', $body);
        return $response;
    }

    /**
     * * Send bulk message using an excel file via inboxino API
     * @param array $messages array of messages to send
     * @param string $import_file path of the excel file
     * @param array $settings array of settings for the message
     * @param array $platforms array of platforms
     * @param string sned_schedule parameter of the api
     * @return object data from inboxino API
     */
    public function send_excel_bulk_message($messages, $import_file, $platforms, $settings = array(), $send_schedule = '')
    {
        // Default values for $settings
        $defaults = array(
            'break_time' => '',
            'expired_date' => '',
            'finish_clock' => '',
            'messages_count_per_day' => '',
            'send_count' => '',
            'start_clock' => '',
        );

        $settings = wp_parse_args($settings, $defaults);

        // Prepare body for request
        $body = array(
            'messages' => $messages,
            'platforms' => $platforms,
            'setting' => $settings,
            'send_schedule' => $send_schedule,
            'import_file' => $import_file,
            'with_country_code' => false,
        );
        // Send request to inboxino API
        $response = $this->_post('/access-api/message/send', $body);
        return $response;
    }

    /**
     * * Send message to recipients via inboxino API
     * @param array $messages array of messages to send
     * @param array $recipients array of recipients to send messages to
     * @return object data from inboxino API
     */
    public function send_message($messages, $recipients)
    {

        $edit_country_code = get_option(INBOXINO_FRAMEWORK_PREFIX);
        $edit_country_code = array_key_exists( 'edit_country_code', $edit_country_code ) ? $edit_country_code['edit_country_code'] : true;
        // Check if recipients items starts with + or not
        // If not, replace 0 with +98 in each item
        if ( $edit_country_code ) {
            foreach ($recipients as $key => $recipient) {
                if (substr($recipient, 0, 1) != '+') {
                    if ($recipient[0] == '0') {
                        $recipients[$key] = '+98' . substr($recipient, 1);
                    } else {
                        $recipients[$key] = '+98' . $recipient;
                    }
                }
            }
        }

        $expire_minutes = isset(get_option(INBOXINO_FRAMEWORK_PREFIX)['expire_minutes']) ? get_option(INBOXINO_FRAMEWORK_PREFIX)['expire_minutes'] : '';
        if (!is_numeric($expire_minutes)) {
            $expire_minutes = '';
        }

        // Prepare body for request
        $body = array(
            'type' => 'notification',
            'messages' => $messages,
            'recipients' => $recipients,
            'platforms' => $this->platforms,
            'setting' => array('expired_minutes' => $expire_minutes),
            'with_country_code' => false,
        );

        // Send request to inboxino API
        $response = $this->_post('/access-api/message/send', $body);
        return $response;
    }

    /**
     * * Get user data from inboxino API
     * @return object data from inboxino API
     */
    public function get_user()
    {
        // A simple caching mechanism
        if ($this->user) {
            return $this->user;
        }

        // Send request to inboxino API
        $response = $this->_get('/access-api/token/verify?with_user=true&with_platforms=true');
        if (!$response) return false;
        if ($response->code == 401) {
            return false;
        }

        $this->user = $response->data;
        return $this->user;
    }

    /**
     * * Get notification logs from inboxion API
     * @param int $page page number
     * @return object|bool Response data as an object if successful, otherwise boolean false     
     */
    public function get_notification_logs($page = 1)
    {
        $response = $this->_get("/access-api/message/notifications-log?sort=latest_sends&page={$page}");
        if (!$response) return false;
        if ($response->code != 200) return false;
        return $response->data;
    }

    /**
     * * Get message from Inboxino API
     * @param int $page page number
     * @return object|bool Response data as an object if sucessful, otherwise boolean false
     */
    public function get_messages($page = 1) 
    {
        $response = $this->_get("/access-api/message?page={$page}");
        if (!$response) return false;
        if ($response->code != 200) return false;
        return $response->data;
    }

    /**
     * * Get message and notifications details from Inboxino API 
     * @param int $id id of the message
     * @return object|bool Response data as an object if successful, otherwise boolean false     
     */
    public function get_message_details($id)
    {
        $response = $this->_get("/access-api/message/{$id}");
        if (!$response) return false;
        if ($response->code != 200) return false;
        return $response->data;
    }


    /**
     * * Get recipients of a message
     * @param int $id id of the message
     * @param int $page page number
     * @return object|bool Response data as an object if successful, otherwise boolean false     
     */
    public function recipients($id, $page=1)
    {
        $response = $this->_get("/access-api/message/{$id}/recipients?page={$page}");
        if (!$response) return false;
        if ($response->code != 200) return false;
        return $response->data;
    }

    /**
     * * Upload attachment to inboxino API
     * @param string $attachment_url attachment url
     * @param string $type attachment type
     * @return string attachment path
     */
    public function upload($attachment_url, $type)
    {
        // convert attachment url to attachment path
        $attachment_path = str_replace(site_url(), ABSPATH, $attachment_url);
        $attachment_path = str_replace('//', '/', $attachment_path);

        // Prepare headers for request
        $headers = array(
            'api-token: ' . $this->token,
            'Content-Type: multipart/form-data',
            'Authorization: Bearer ' . $this->token,
        );
        // Send request to inboxino API
        // wp_remote_post can't correcly handle file upload so we use curl instead
        $curl = curl_init(); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_init 
        curl_setopt_array($curl, array( // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt_array 
            CURLOPT_URL => $this->upload_url . $type,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'file' => new CURLFile($attachment_path)
            ),
            CURLOPT_HTTPHEADER => $headers,
        ));

        // Get response from inboxino API
        $response = curl_exec($curl); //phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_exec 
        curl_close($curl); //phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_close 
        $data = json_decode($response);
        if ($data->code != 200) return false;
        if ($type == 'excel') {
            if ($data->data->payload->valid_numbers <= 0) return false;
        }
        return $data->data->path;
    }

    /**
     * * Get request to inboxino API
     * @param string $endpoint get endpoint
     * @param array $body body of request
     * @return object data from inboxino API
     */
    private function _get($endpoint, $body = array())
    {
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' =>  'Bearer ' . $this->token
        );
        $body = empty($body) ? '' : wp_json_encode($body);
        $args = array(
            'headers'   => $headers,
            'body'      => $body,
            'timeout'   => 60,
        );

        $response = wp_remote_get($this->server_url . $endpoint, $args);
        if (is_wp_error($response)) {
            return false;
        }
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );
        return $data;
    }

    /**
     * * Post request to inboxino API
     * @param string $endpoint post endpoint
     * @param array $body body of request
     * @return object data from inboxino API
     */
    private function _post($endpoint, $body = array())
    {
        // Prepare headers for request
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        );

        $body = empty($body) ? '' : wp_json_encode($body);
        $args = array(
            'headers'   => $headers,
            'body'      => $body,
            'timeout'   => 60,
        );

        $response = wp_remote_post($this->server_url . $endpoint, $args);
        if (is_wp_error($response)) {
            return false;
        }
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );

        return $data;
    }
}
