<?php

if( defined( 'ABSPATH' ) && function_exists('add_action') ) {
	if( !has_action('admin_init', array( 'Voce_Post_Meta_Post_Selection_UI', 'admin_init' ) ) ) {
		Voce_Post_Meta_Post_Selection_UI::initialize();
	}
}