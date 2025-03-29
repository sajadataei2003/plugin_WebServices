<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * inboxino_user_register - triggered when a new user is registered
 * inboxino_user_login - triggered when a user logs in
 * inboxino_user_password_reset - triggered when a user resets their password
 * inboxino_new_comment - triggered when a new comment is added
 * inboxino_new_comment_reply - triggered when a new comment reply is added
 * inboxino_comment_approved - triggered when a comment is approved
 */

/**
 * * This action is triggered when a new user is registered
 * @param int $user_id the ID of the user that was registered
 * @param array $user_data the data of the user that was registered
 * @return void
 */
function inboxino_user_register_hook($user_id, $user_data)
{
    do_action('inboxino_user_register', $user_id);
}
add_action('user_register', 'inboxino_user_register_hook', 10, 2);

/**
 * * This action is triggered when a user logs in
 * @param string $user_login the username of the user that logged in
 * @param WP_User $user the user object of the user that logged in
 * @return void
 */
function inboxino_wp_login_hook($user_login, $user)
{
    do_action('inboxino_user_login', $user_login, $user);
}
add_action('wp_login', 'inboxino_wp_login_hook', 10, 2);

/**
 * * This action is triggered when a user resets their password
 * @param WP_User $user the user object of the user that reset their password
 * @param string $new_pass the new password of the user that reset their password
 * @return void
 */
function inboxino_after_password_reset_hook($user, $new_pass)
{
    do_action('inboxino_user_password_reset', $user, $new_pass);
}
add_action('after_password_reset', 'inboxino_after_password_reset_hook', 10, 2);

/**
 * * This action is triggered when a new comment is added
 * @param int $comment_id the ID of the comment that was added
 * @param WP_Comment $comment_object the comment object of the comment that was added
 * @return void
 */
function inboxino_wp_insert_comment_hook($comment_id, $comment_object)
{
    do_action('inboxino_new_comment', $comment_id, $comment_object);
    $parent_comment = get_comment($comment_object->comment_parent);
    if ($parent_comment == null) return;
    if ($parent_comment->user_id == 0) return;
    if ($parent_comment->user_id == $comment_object->user_id) return;
    do_action('inboxino_new_comment_reply', $comment_id, $comment_object);
}
add_action('wp_insert_comment', 'inboxino_wp_insert_comment_hook', 10, 2);

/**
 * * This action is triggered when status of a comment is changed
 * @param string $new_status the new status of the comment
 * @param string $old_status the old status of the comment
 * @param WP_Comment $comment the comment object of the comment that was updated
 * @return void
 */
function inboxino_transition_comment_status_hook($new_status, $old_status, $comment)
{
    if ($old_status != $new_status && $new_status == 'approved') {
        do_action('inboxino_comment_approved', $comment);
    }
}
add_action('transition_comment_status', 'inboxino_transition_comment_status_hook', 10, 3);

/** 
 * * This action is triggered when a user visits thank you page (We can check to see if an order is submitted)
 * @param int $order_id
 * @return void
 */  
function inboxino_order_created_hook($order_id)
{
    $order = wc_get_order($order_id);
    if ($order->has_status('failed')) return;
    if ($order->get_meta('_inboxino_created_message')) return;
    $user_id = get_current_user_id();
    do_action('inboxino_new_order', $user_id, $order);

    // Prevent sending multiple messages when user reloads the thankyou page
    $order->update_meta_data('_inboxino_created_message', true);
    $order->save();
}
add_action('woocommerce_thankyou', 'inboxino_order_created_hook');

/** 
 * * This action is triggered when order status is changed
 * @param int $order_id
 * @param string $old_status
 * @param string $new_status
 * @param WC_Order $order
 * @return void
 */  
function inboxino_order_status_changed_hook($order_id, $old_status, $new_status, $order)
{
    $user_id = $order->get_customer_id();
    do_action('inboxino_order_status_changed', $user_id, $order);
}
add_action('woocommerce_order_status_changed', 'inboxino_order_status_changed_hook', 10, 4);

/**
 * * This action is triggered when a Gravityforms form is submitted
 * @param array $lead The Entry object.
 * @param array $form The Form object.
*/
function inboxino_gform_submission_hook($lead, $form)
{
    $form_id = $form['id'];
    foreach ($form['fields'] as $field) {
        $field_label = $field->label;
        $field_id = $field->id;
        $inputs = $field->inputs;
        $values = [];
        if (is_array($inputs)) {
            foreach($inputs as $input) {
                $tmp = rgar($lead, $input['id']);
                if ($tmp) {
                    $values[] = $tmp;
                }
            }

            $field_value = implode(' ', $values);
        } else {
            $field_value = rgar($lead, $field->id);
        }

        $formatted_array[] = array(
            'id'        => $field_id,
            'title'     => $field_label,
            'value'     => $field_value,
            'required'  => $field->isRequired,
        );
    }

    $user_id = get_current_user_id();
    do_action('inboxino_gform_submission', $user_id, $formatted_array, $form_id);
}
add_action('gform_after_submission', 'inboxino_gform_submission_hook', 10, 2);

/**
 * * This action is triggered when a Contact Form 7 form is submitted
 * @param WPCF7_ContactForm $form
 * @param array $result
*/
function inboxino_wpcf7_submission_hook($form, $reuslt)
{
    $form_id = $form->id();
    $submission = WPCF7_Submission::get_instance();
    $data = $submission->get_posted_data();

    $form_settings = $form->get_properties();
    preg_match_all('/\[(\w+)\* ([^\s\]]+)/', $form_settings['form'], $matches);
    $required_fields = $matches[2];

    $form_data = [];
    foreach($data as $key => $field) {
        $required = in_array(  $key, $required_fields );
        $form_data[] = [
            'title' => '',
            'value' => $field,
            'required' => $required,
        ];
    }
    $user_id = (int) $_POST['_wpcf7_user_id']; // phpcs:ignore WordPress.Security.NonceVerification.Missing 
    do_action('inboxino_wpcf7_submission', $user_id, $form_data, $form_id);
}
add_action('wpcf7_submit', 'inboxino_wpcf7_submission_hook', 10, 2);

/**
 * * This action is triggered when an Elementor form is submitted
 * @param Form_Record $record the record submitted.
 * @param Ajax_Handler $handler The Ajax Handler component.
*/
function inboxino_elementor_submission_hook($record, $handler)
{

    $form_id = $record->get('form_settings')['form_id']; 
    $raw_fields = $record->get('fields');
	$form_data = [];
	foreach ($raw_fields as $field) {
        $form_data[] = [
            'id'        => $field['id'],
            'title'     => $field['title'],
            'value'     => $field['value'],
            'required'  => $field['required'],
        ];
	}
    $user_id = get_current_user_id();
    do_action('inboxino_elementor_submission', $user_id, $form_data, $form_id);
}
add_action('elementor_pro/forms/new_record', 'inboxino_elementor_submission_hook', 10, 2);

/**
 * * This action is triggered when a wpforms form is submitted
 * @param array $fields sanitized entry field values/properties.
*/
function inboxino_wpforms_submission_hook($fields, $entry, $form_data, $entry_id)
{
    $form_id = $form_data['id'];
    $form_fields = $form_data['fields'];
    $inboxino_data = [];
    foreach($fields as $id => $field) {
        $inboxino_data[] = [
            'title'     => $field['name'],
            'value'     => $field['value'],
            'required'  => $form_fields[$id]['required']
        ]; 
    }
    $user_id = get_current_user_id();
    do_action('inboxino_wpforms_submission', $user_id, $inboxino_data, $form_id);
}
add_action('wpforms_process_complete', 'inboxino_wpforms_submission_hook', 10, 4);
