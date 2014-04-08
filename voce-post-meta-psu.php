<?php
/*
  Plugin Name: Voce Post Meta Post Selection UI
  Plugin URI: http://vocecommunications.com
  Description: Extends Voce Post Meta with a Post Selection UI
  Version: 1.0.3
  Author: kevinlangleyjr
  Author URI: http://vocecommunications.com
  License: GPL2
 */

if ( ! class_exists( 'Voce_Post_Meta_Post_Selection_UI' ) ) :

class Voce_Post_Meta_Post_Selection_UI {

	static function initialize() {
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_filter( 'meta_type_mapping', array( __CLASS__, 'meta_type_mapping' ) );
	}

	/**
	 * Display message if dependencies are not loaded
	 * @method add_admin_notice
	 * @param string $notice
	 * @return void
	 */
	static function add_admin_notice( $notice ){
		echo '<div class="error"><p' . $notice . '</p></div>';
	}

	static function check_dependencies(){
		$dependencies = array(
			'Voce Post Meta' => array(
				'url' => 'https://github.com/voceconnect/voce-post-meta',
				'class' => 'Voce_Post_Meta'
			),
			'Post Selection UI' => array(
				'url' => 'https://github.com/voceconnect/post-selection-ui',
				'class' => 'Post_Selection_UI'
			)
		);

		foreach( $dependencies as $plugin => $plugin_data ){
			if ( !class_exists( $plugin_data['class'] ) ){
				$notice = sprintf( 'Voce Post Meta Post Selection UI Plugin cannot be utilized without the <a href="%s" target="_blank">%s</a> plugin.', esc_url( $plugin_data['url'] ), $plugin_data['class'] );
				self::add_admin_notice( __( $notice, 'voce-post-meta-psu' ) );
			}
		}
	}

	/**
	 * Check if Voce Post Meta is loaded
	 * @method check_voce_meta_api
	 * @return void
	 */
	static function admin_init(){
		add_action( 'admin_notices', array( __CLASS__, 'check_dependencies' ) );
	}

	/**
	 * @method meta_type_mapping
	 * @param type $mapping
	 * @return array
	 */
	static function meta_type_mapping( $mapping ) {
		$mapping['psu'] = array(
			'class' => 'Voce_Meta_Field',
			'args' => array(
				'display_callbacks' => array( array( __CLASS__, 'display_callback' ) ),
				'sanitize_callbacks' => array( function($field, $old_value, $new_value, $post_id){
					return $new_value;
				} )
			)
		);
		return $mapping;
	}

	static function display_callback( $field, $value, $post_id ) {
		$args = array_merge( array(
			'id' => $field->get_input_id(),
			'selected' => (array) explode( ',', $value ),
		), (array) $field->args );
		?>
		<div class="voce-post-meta-psu-container">
			<div class="label">
				<?php voce_field_label_display( $field ); ?>
			</div>
			<div class="form-input">
				<div class="widget">
					<div class="widget-inside" style="display:block;">
						<?php
							echo post_selection_ui( $field->get_name(), $args );
							echo ( !empty( $args['description'] ) ) ? '<br><span class="description">' . $args['description'] . '</span>' : '';
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'init', array( 'Voce_Post_Meta_Post_Selection_UI', 'initialize' ) );

endif;