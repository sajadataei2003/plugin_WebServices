<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * This action is triggered when a form is submitted, for user
 * @param int $user_id the ID of the user that submitted the form
 * @return void
 */
function inboxino_wpcf7_submission_user($user_id, $form_data)
{
    if (!$user_id) return; // Return if user is not logged in
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_user']) return;

    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_user_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_form', $messages, $form_data);
    $recipients = inboxino_get_phone_number_by('user_id', $user_id);
    if (empty($recipients)) {
        return;
    }
    $api->send_message($messages, $recipients);
}
add_action('inboxino_wpcf7_submission', 'inboxino_wpcf7_submission_user', 10, 2);

/**
 * * This action is triggered when a form is submitted, for admin
 * @param int $user_id the ID of the user that submitted the form
 * @return void
 */
function inboxino_wpcf7_submission_admin($user_id, $form_data)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_admin']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_form', $messages, $form_data);
    $recipients = inboxino_get_phone_number_by('admin');
    $api->send_message($messages, $recipients);
}
add_action('inboxino_wpcf7_submission', 'inboxino_wpcf7_submission_admin', 10, 2);


function inboxino_wpcf7_submission_specific_admin($user_id, $form_data)
{
    if (!get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_specific_admin']) return;
    $api = new InboxinoApi();
    $messages = apply_filters('inboxino_messages', get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_specific_admin_messages']);
    $messages = apply_filters('inboxino_general', $messages);
    $messages = apply_filters('inboxino_user', $messages, $user_id);
    $messages = apply_filters('inboxino_form', $messages, $form_data);
    $recipients = inboxino_get_phone_number_by('specific_admin', get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_specific_admin_ids']);
    $api->send_message($messages, $recipients);
}
add_action('inboxino_wpcf7_submission', 'inboxino_wpcf7_submission_specific_admin', 10, 2);


function inboxino_wpcf7_submission_forms($user_id, $form_data, $form_id) {
    $forms = get_option(INBOXINO_FRAMEWORK_PREFIX)['contactform_forms'];
    if (!$forms) return;
    foreach($forms as $form) {
        if ($form['form_id'] == $form_id) {
            $api = new InboxinoApi();
            $messages = apply_filters('inboxino_messages', [$form]);
            $messages = apply_filters('inboxino_general', $messages);
            $messages = apply_filters('inboxino_user', $messages, $user_id);
            $messages = apply_filters('inboxino_form', $messages, $form_data);
            $recipients = inboxino_get_phone_number_by('specific_admin', $form['admin_ids']);
            $api->send_message($messages, $recipients);
        }
    }
}
add_action('inboxino_wpcf7_submission', 'inboxino_wpcf7_submission_forms', 10, 3);


/**
 * * Add user id to submitted form data
 * @param array $fields
 * @return array
 */
function inboxino_wpcf7_hidden_fields($fields) {
    $fields['_wpcf7_user_id'] = get_current_user_id();
    return $fields;
}
add_filter('wpcf7_form_hidden_fields', 'inboxino_wpcf7_hidden_fields');
