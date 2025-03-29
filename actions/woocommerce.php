<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * This action is triggered when a new order is created, for user
 * @param int $user_id the ID of the user that created the order
 * @param WC_Order $order the order
 * @return void
 */
function inboxino_new_order_user($user_id, $order)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_order', $messages, $order);
    if (!empty($order->get_billing_phone())) {
        $recipients = [$order->get_billing_phone()];
    } else if (!empty($order->get_shipping_phone())) {
        $recipients = [$order->get_shipping_phone()];
    } else {
        $recipients = inboxino_get_phone_number_by('user_id', $user_id);
    }
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_order', 'inboxino_new_order_user', 10, 2);

/**
 * * This action is triggered when a new order is created, for admin
 * @param int $user_id the ID of the user that created the order
 * @param WC_Order $order the order
 * @return void
 */
function inboxino_new_order_admin($user_id, $order)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_admin']) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_order', $messages, $order);
    $recipients = inboxino_get_phone_number_by('admin');
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_order', 'inboxino_new_order_admin', 10, 2);


function inboxino_new_order_specific_admin($user_id, $order)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_specific_admin']) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_specific_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_order', $messages, $order);
    $recipients = inboxino_get_phone_number_by('admin', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_order_specific_admin_ids']);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_order', 'inboxino_new_order_specific_admin', 10, 2);

/**
 * * This action is triggered when order status is changed, for user
 * @param int $user_id the ID of the customer
 * @param WC_Order $order the order
 * @return void
 */
function inboxino_order_status_user($user_id, $order)
{
    $order_status = $order->get_status();
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_user"]) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_user_messages"]);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_order', $messages, $order);
    $messages = apply_filters('inboxino_order_status', $messages, $order);
    if (!empty($order->get_billing_phone())) {
        $recipients = [$order->get_billing_phone()];
    } else if (!empty($order->get_shipping_phone())) {
        $recipients = [$order->get_shipping_phone()];
    } else {
        $recipients = inboxino_get_phone_number_by('user_id', $user_id);
    }
    $api->send_message($messages, $recipients);
}
add_action('inboxino_order_status_changed', 'inboxino_order_status_user', 10, 2);

/**
 * * This action is triggered when order status is changed, for admin
 * @param int $user_id the ID of the customer
 * @param WC_Order $order the order
 * @return void
 */
function inboxino_order_status_admin($user_id, $order)
{
    $order_status = $order->get_status();
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_admin"]) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_admin_messages"]);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_order', $messages, $order);
    $messages = apply_filters('inboxino_order_status', $messages, $order);
    $recipients = inboxino_get_phone_number_by('admin');
    $api->send_message($messages, $recipients);
}
add_action('inboxino_order_status_changed', 'inboxino_order_status_admin', 10, 2);


function inboxino_order_status_specific_admin($user_id, $order)
{
    $order_status = $order->get_status();
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_specific_admin"]) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_specific_admin_messages"]);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_order', $messages, $order);
    $messages = apply_filters('inboxino_order_status', $messages, $order);
    $recipients = inboxino_get_phone_number_by('specific_admin', get_option(INBOXINO_FRAMEWORK_PREFIX)["order_{$order_status}_specific_admin_ids"]);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_order_status_changed', 'inboxino_order_status_specific_admin', 10, 2);
