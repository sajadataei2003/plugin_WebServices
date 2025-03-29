<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * Filter inboxino messages
 * @param array $messages
 * @return array
 */
function inboxino_messages($messages)
{
    $filtered_messages = array();
    foreach ($messages as $message) {
        switch ($message['type']) {
            case 'message':
                $filtered_messages[] = array(
                    'message' => $message['content'],
                    'message_type' => 'message',
                    'attachment_file' => '',
                );
                break;
            default:
                if ($message['type'] == 'image') $attachment = $message['image'];
                else if ($message['type'] == 'video') $attachment = $message['video'];
                else if ($message['type'] == 'file') $attachment = $message['file'];
                else if ($message['type'] == 'audio') $attachment = $message['audio'];
                if (!$attachment) break;
                $api = new InboxinoAPI();
                $upload_path = $api->upload($attachment, $message['type']);
                if (!$upload_path) break;
                $filtered_messages[] = array(
                    'message' => $message['content'],
                    'message_type' => $message['type'],
                    'attachment_file' => $upload_path,
                );
                break;
        }
    }
    return $filtered_messages;
}
add_filter('inboxino_messages', 'inboxino_messages', 10, 1);

/**
 * * Filter inboxino bulk messages
 * @param array $messages
 * @return array
 */
function inboxino_bulk_messages($messages)
{
    $filtered_messages = array();
    foreach ($messages as $idx => $message) {
        
        switch ($message['type']) {
            case 'message':
                $filtered_messages[$idx] = array(
                    'message_type' => 'message',
                    'attachment_file' => '',
                );
                break;
            default:
                if ($message['type'] == 'image') $attachment = $message['image'];
                else if ($message['type'] == 'video') $attachment = $message['video'];
                else if ($message['type'] == 'file') $attachment = $message['file'];
                else if ($message['type'] == 'audio') $attachment = $message['audio'];
                if (!$attachment) break;
                $api = new InboxinoAPI();
                $upload_path = $api->upload($attachment, $message['type']);
                if (!$upload_path) break;
                $filtered_messages[$idx] = array(
                    'message_type' => $message['type'],
                    'attachment_file' => $upload_path,
                );
                break;
        }
        $filtered_messages[$idx]['message'] = $message['content'];
    }
    return $filtered_messages;
}
add_filter('inboxino_bulk_messages', 'inboxino_bulk_messages', 10, 1);

/**
 * * Filter inboxino message with general options
 * @param array $messages
 * @return array
 */
function inboxino_general_filter($messages)
{
    foreach ($messages as $key => $message) {
        $messages[$key]['message'] = str_replace('%date%', date_i18n(get_option('date_format')), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%time%', date_i18n(get_option('time_format')), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%datetime%', date_i18n(get_option('date_format') . ' ' . get_option('time_format')), $messages[$key]['message']);
    }
    return $messages;
}
add_filter('inboxino_general', 'inboxino_general_filter', 10, 1);

/**
 * * Filter inboxino message with user options
 * @param array $messages
 * @param int $user_id
 * @return array
 */
function inboxino_user_filter($messages, $user_id)
{
    $user = get_user_by('id', $user_id);
    foreach ($messages as $key => $message) {
        $messages[$key]['message'] = str_replace('%user_id%', $user->ID, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_username%', $user->user_login, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_display_name%', $user->display_name, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_first_name%', $user->first_name, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_last_name%', $user->last_name, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_email%', $user->user_email, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_phone_number%', inboxino_get_phone_number_by('user_id', $user_id)[0], $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%user_joined_date%', date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($user->user_registered)), $messages[$key]['message']);
    }
    return $messages;
}
add_filter('inboxino_user', 'inboxino_user_filter', 10, 2);

/**
 * * Filter inboxino message with password reset options
 * @param array $messages
 * @param string $new_pass
 * @return array
 */
function inboxino_password_reset_filter($messages, $new_pass)
{
    foreach ($messages as $key => $message) {
        $messages[$key]['message'] = str_replace('%new_password%', $new_pass, $messages[$key]['message']);
    }
    return $messages;
}
add_filter('inboxino_password_reset', 'inboxino_password_reset_filter', 10, 2);

/**
 * * Filter inboxino message with comment options
 * @param array $messages
 * @param WP_Comment $comment
 * @return array
 */
function inboxino_comment_filter($messages, $comment)
{
    foreach ($messages as $key => $message) {
        $messages[$key]['message'] = str_replace('%comment_id%', $comment->comment_ID, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_author%', $comment->comment_author, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_author_email%', $comment->comment_author_email, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_author_url%', $comment->comment_author_url, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_author_ip%', $comment->comment_author_IP, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_date%', date_i18n(get_option('date_format'), strtotime($comment->comment_date)), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_time%', date_i18n(get_option('time_format'), strtotime($comment->comment_date)), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_datetime%', date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($comment->comment_date)), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_content%', $comment->comment_content, $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_link%', get_comment_link($comment->comment_ID), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_post_title%', get_the_title($comment->comment_post_ID), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_post_link%', get_permalink($comment->comment_post_ID), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%comment_admin%', admin_url('edit-comments.php'), $messages[$key]['message']);
    }
    return $messages;
}
add_filter('inboxino_comment', 'inboxino_comment_filter', 10, 2);

/**
 * * Filter inboxino message with order options
 * @param array $messages
 * @param WC_Order $order
 * @return array
*/    
function inboxino_order_filter($messages, $order)
{
    foreach ($messages as $key => $message) {
        $messages[$key]['message'] = str_replace('%order_total%', strip_tags(wc_price($order->get_total())), $messages[$key]['message'] );
        if ( $order->get_total_discount() > 0 ) {
            $messages[$key]['message'] = str_replace('%order_discount%', strip_tags(wc_price($order->get_total_discount())), $messages[$key]['message']);
        }
        $messages[$key]['message'] = str_replace('%billing_first_name%', $order->get_billing_first_name(), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%billing_last_name%', $order->get_billing_last_name(), $messages[$key]['message']);
        $note = '';
        if (strpos($messages[$key]['message'], '%order_items_qty%') !== false) {
            $items = $order->get_items();
            $note .= 'آیتم‌های سفارش:\n';
            foreach( $items as $item_id => $item ) {
                $note .= $item->get_name();
                $note .= ' × ' . $item->get_quantity();
                $note .= '\n';
            }
        }
        $messages[$key]['message'] = str_replace('%order_items_qty%', $note, $messages[$key]['message']);

        $note = '';
        if (strpos($messages[$key]['message'], '%order_items%') !== false) {
            $items = $order->get_items();
            $note .= 'آیتم‌های سفارش:\n';
            foreach( $items as $item_id => $item ) {
                $note .= $item->get_name();
                $note .= '\n';
            }
        }
        $messages[$key]['message'] = str_replace('%order_items%', $note, $messages[$key]['message']);


        $messages[$key]['message'] = str_replace('%order_id%', $order->get_id(), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%order_date%', $order->get_date_created()->date_i18n(get_option('date_format')), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%order_time%', $order->get_date_created()->date_i18n(get_option('time_format')), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%order_datetime%', $order->get_date_created()->date_i18n(get_option('date_format') . ' ' . get_option('time_format')), $messages[$key]['message']);
    }
    
    return $messages;
}
add_filter('inboxino_order', 'inboxino_order_filter', 10, 2);

/**
 * * Filter inboxino message with order status options
 * @param array $messages
 * @param WC_Order $order
 * @return array
*/    
function inboxino_order_status_filter($messages, $order)
{
    foreach ($messages as $key => $message) {
        $messages[$key]['message'] = str_replace('%order_status%', wc_get_order_status_name($order->get_status()), $messages[$key]['message']);
    }
    return $messages;
}
add_filter('inboxino_order_status', 'inboxino_order_status_filter', 10, 2);

/**
 * * Filter inboxino message when a form is submitted
 * @param array $messages
 * @param array $form_data
 * @return array
*/    
function inboxino_form_filter($messages, $form_data)
{
    foreach ($messages as $key => $message) {
        $all_lines = [];
        $required_lines = [];

        foreach ($form_data as $item) {
            $line = !empty($item['title']) ? $item['title'] . ": " . $item['value'] : $item['value'];
            $all_lines[] = $line;

            if (!empty($item['required'])) {
                $required_lines[] = $line;
            }
        }

        $messages[$key]['message'] = str_replace('%form_data%', implode("\n", $all_lines), $messages[$key]['message']);
        $messages[$key]['message'] = str_replace('%form_data_required%', implode("\n", $required_lines), $messages[$key]['message']);
    }
    return $messages;
}
add_filter('inboxino_form', 'inboxino_form_filter', 10, 2);
