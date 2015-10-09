<?php

if( defined( 'ABSPATH' ) && function_exists('add_action') ) {
	if( !has_action('init', array( 'Voce_Post_Meta_Post_Selection_UI', 'initialize' ) ) ) {
		add_action( 'init', array( 'Voce_Post_Meta_Post_Selection_UI', 'initialize' ) );
	}
}