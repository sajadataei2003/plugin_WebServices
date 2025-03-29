<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * This action is triggered when a new user is registered for user
 * @param int $user_id the ID of the user that was registered
 * @return void
 */
function inboxino_user_register_user($user_id)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $recipients = inboxino_get_phone_number_by('user_id', $user_id);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_user_register', 'inboxino_user_register_user', 10, 1);

/**
 * * This action is triggered when a new user is registered for admin
 * @param int $user_id the ID of the user that was registered
 * @return void
 */
function inboxino_user_register_admin($user_id)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_admin']) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $recipients = inboxino_get_phone_number_by('admin');
    $api->send_message($messages, $recipients);
}
add_action('inboxino_user_register', 'inboxino_user_register_admin', 10, 1);


function inboxino_user_register_specific_admin($user_id)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_specific_admin']) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_specific_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $recipients = inboxino_get_phone_number_by('admin', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_user_register_specific_admin_ids']);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_user_register', 'inboxino_user_register_specific_admin', 10, 1);

/**
 * * This action is triggered when a user logs in for user
 * @param string $user_login the username of the user that logged in
 * @param WP_User $user the user object of the user that logged in
 * @return void
 */
function inboxino_user_login_user($user_login, $user)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['user_login_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['user_login_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user->ID);
    $recipients = inboxino_get_phone_number_by('user_id', $user->ID);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_user_login', 'inboxino_user_login_user', 10, 2);

/**
 * * This action is triggered when a user resets their password for user
 * @param WP_User $user the user object of the user that reset their password
 * @param string $new_pass the new password of the user that reset their password
 * @return void
 */
function inboxino_user_password_reset_user($user, $new_pass)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['user_password_reset_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['user_password_reset_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user->ID);
    $messages = apply_filters('inboxino_password_reset', $messages, $new_pass);
    $recipients = inboxino_get_phone_number_by('user_id', $user->ID);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_user_password_reset', 'inboxino_user_password_reset_user', 10, 2);

/**
 * * This action is triggered when a new comment is added for user
 * @param int $comment_id the ID of the comment that was added
 * @param WP_Comment $comment_object the comment object of the comment that was added
 * @return void
 */
function inboxino_new_comment_user($comment_id, $comment_object)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_comment', $messages, $comment_object);
    $recipients = inboxino_get_phone_number_by('comment_object', $comment_object);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_comment', 'inboxino_new_comment_user', 10, 2);

/**
 * * This action is triggered when a new comment is added for admin
 * @param int $comment_id the ID of the comment that was added
 * @param WP_Comment $comment_object the comment object of the comment that was added
 * @return void
 */
function inboxino_new_comment_admin($comment_id, $comment_object)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_admin']) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_comment', $messages, $comment_object);
    $recipients = inboxino_get_phone_number_by('admin');
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_comment', 'inboxino_new_comment_admin', 10, 2);


function inboxino_new_comment_specific_admin($comment_id, $comment_object)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_specific_admin']) return;
    $api = new InboxinoAPI();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_specific_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_comment', $messages, $comment_object);
    $recipients = inboxino_get_phone_number_by('specific_admin', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_specific_admin_ids']);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_comment', 'inboxino_new_comment_specific_admin', 10, 2);

/**
 * * This action is triggered when a new comment reply is added for user
 * @param int $comment_id the ID of the comment that was replied
 * @param WP_Comment $comment_object the comment object of the comment that was replied
 * @return void
 */
function inboxino_new_comment_reply_user($comment_id, $comment_object)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_reply_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['new_comment_reply_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_comment', $messages, $comment_object);
    $recipients = inboxino_get_phone_number_by('comment_object', $comment_object);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_new_comment_reply', 'inboxino_new_comment_reply_user', 10, 2);

/**
 * * This action is triggered when a comment is approved for user
 * @param WP_Comment $comment the comment object of the comment that was approved
 */
function inboxino_comment_approved_user($comment)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['comment_approved_user']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['comment_approved_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_comment', $messages, $comment);
    $recipients = inboxino_get_phone_number_by('comment_object', $comment);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_comment_approved', 'inboxino_comment_approved_user', 10, 1);
