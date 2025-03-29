<?php

// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * * Adde persian date picker field to Codestar
 * @package Inboxino
 */

if (!class_exists('CSF_Field_persiandate')) {
    class CSF_Field_persiandate extends CSF_Fields 
    {

        /**
         * * Persiandate field class constructor
         * @return void
         */
        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '') 
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        /**
         * * Render the field
         * @return void
         */ 
        public function render() 
        {

            echo $this->field_before(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

            echo '<input type="text" class="inboxino-persian-datepicker" name="'. esc_attr($this->field_name()) .'" value="'. esc_attr($this->value) .'"'. $this->field_attributes() .'/>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

            echo $this->field_after(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        }

        /**
         * * Enqueue necessary styles/scripts
         * @returnn void
         */ 
        public function enqueue() 
        {

            if (!wp_script_is('inboxino-persian-date')) {
                wp_enqueue_script('inboxino-persian-date', INBOXINO_PLUGIN_URL . 'assets/persian-date.min.js', [], INBOXINO_VERSION, ['in_footer' => true]);
            }

            if (!wp_script_is('inboxino-persian-datepicker')) {
                wp_enqueue_script('inboxino-persian-datepicker', INBOXINO_PLUGIN_URL . 'assets/persian-datepicker.min.js', array('jquery'), INBOXINO_VERSION, ['in_footer' => true]);
            }

            if (!wp_style_is('inboxino-persian-datepicker')) {
                wp_enqueue_style('inboxino-persian-datepicker', INBOXINO_PLUGIN_URL . 'assets/persian-datepicker.min.css', [], INBOXINO_VERSION);
            }

            if (!wp_script_is('inboxino-persian-datefield')) {
                wp_enqueue_script('inboxino-persian-datefield', INBOXINO_PLUGIN_URL . 'assets/persian-datefield.js', array('jquery'), INBOXINO_VERSION, ['in_footer' => true]);
            }

        }

    }
}
