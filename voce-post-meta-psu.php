<?php
/*
  Plugin Name: Voce Post Meta Post Selection UI
  Plugin URI: http://vocecommunications.com
  Description: Extends Voce Post Meta with a Post Selection UI
  Version: 1.1.0
  Author: kevinlangleyjr
  Author URI: http://vocecommunications.com
  License: GPL2
 */

if ( ! class_exists( 'Voce_Post_Meta_Post_Selection_UI' ) ) :

class Voce_Post_Meta_Post_Selection_UI extends Voce_Meta_Field {

	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_filter( 'voce_meta_type_mapping', array( __CLASS__, 'meta_type_mapping' ) );
	}

	/**
	 * Add action for admin_notices
	 * @method admin_init
	 * @return void
	 */
	public static function admin_init(){
		add_action( 'admin_notices', array( __CLASS__, 'check_dependencies' ) );
	}

	/**
	 * Display admin notice message
	 * @method add_admin_notice
	 * @param string $notice
	 * @return void
	 */
	public static function add_admin_notice( $notice ){
		echo '<div class="error"><p>' . $notice . '</p></div>';
	}

	/**
	 * Checks plugin dependencies
	 * @method check_dependencies
	 * @return void
	 */
	public static function check_dependencies(){
		$dependencies = array(
			'Voce Post Meta' => array(
				'url' => 'https://github.com/voceconnect/voce-post-meta',
				'class' => 'Voce_Meta_API'
			),
			'Post Selection UI' => array(
				'url' => 'https://github.com/voceconnect/post-selection-ui',
				'class' => 'Post_Selection_UI'
			)
		);

		foreach( $dependencies as $plugin => $plugin_data ){
			if ( !class_exists( $plugin_data['class'] ) ){
				$notice = sprintf( 'The Voce Post Meta Post Selection UI Plugin cannot be utilized without the <a href="%s" target="_blank">%s</a> plugin.', esc_url( $plugin_data['url'] ), $plugin );
				self::add_admin_notice( __( $notice, 'voce-post-meta-psu' ) );
			}
		}
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
				'display_callbacks' => array( array( __CLASS__, 'display_callback' ) ),
				'sanitize_callbacks' => array( function( $field, $old_value, $new_value, $post_id ) {
					return empty( $new_value ) ? null : $new_value;
				} ),
			)
		);
		return $mapping;
	}

	public static function display_callback( $field, $value, $post_id ) {
		$args = array_merge( array(
			'id' => $field->get_input_id(),
			'selected' => is_array( $value ) ? $value : (array)explode( ',', $value ),
		), (array)$field->args );
		?>
		<div class="voce-post-meta-psu-container">
			<div class="label">
				<?php echo self::get_label( $field ); ?>
			</div>
			<div class="form-input">
				<div class="widget">
					<div class="widget-inside" style="display:block; border:0;">
						<?php
						echo post_selection_ui( $field->get_name(), $args );
						echo ( ! empty( $args['description'] ) ? '<br><span class="description">' . $args['description'] . '</span>' : '' );
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}
Voce_Post_Meta_Post_Selection_UI::init();

endif;