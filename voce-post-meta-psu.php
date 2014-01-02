<?php
/*
  Plugin Name: Voce Post Meta Post Selection UI
  Plugin URI: http://vocecommunications.com
  Description: Extends Voce Post Meta with a Post Selection UI
  Version: 1.0.1
  Author: kevinlangleyjr
  Author URI: http://vocecommunications.com
  License: GPL2
 */

if ( ! class_exists( 'Voce_Post_Meta_Post_Selection_UI' ) ) :

class Voce_Post_Meta_Post_Selection_UI {

	public static function initialize() {
		if( !class_exists( 'Post_Selection_UI' ) ){
			_doing_it_wrong( __METHOD__, __( 'This plugin requires the Post Selection UI plugin to already be loaded' ), '3.5' );
			return;
		}

		add_filter( 'meta_type_mapping', array( __CLASS__, 'meta_type_mapping' ) );
	}

	/**
	 * @method meta_type_mapping
	 * @param type $mapping
	 * @return array
	 */
	public static function meta_type_mapping( $mapping ) {
		$mapping['psu'] = array(
			'class' => 'Voce_Meta_Field',
			'args' => array(
				'display_callbacks' => array( 'voce_post_selection_ui_meta_field_display' ),
				'sanitize_callbacks' => array( function($field, $old_value, $new_value, $post_id){
					return $new_value;
				} )
			)
		);
		return $mapping;
	}

}

if ( class_exists( 'Voce_Meta_API' ) ) {
	Voce_Post_Meta_Post_Selection_UI::initialize();

	function voce_post_selection_ui_meta_field_display( $field, $value, $post_id ) {
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
							echo ( isset( $args['description'] ) ) ? '<br><span class="description">' . $args['description'] . '</span>' : '';
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

endif;
