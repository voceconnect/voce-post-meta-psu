=== Voce Post Meta PSU ===

Contributors: kevinlangleyjr, voceplatforms  
Tags: meta, psu, post, selection  
Requires at least: 3.0  
Tested up to: 3.9.2  
Stable tag: 1.2.0
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extend Voce Post Meta with post selection fields

== Description ==

Extend Voce Post Meta with [post selection ui](http://github.com/voceconnect/post-selection-ui) inputs

== Installation ==

=== As standard plugin: ===
> See [Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

=== As theme or plugin dependency: ===
> After dropping the plugin into the containing theme or plugin, add the following:
```php
if( ! class_exists( 'Voce_Post_Meta_Post_Selection_UI' ) ) {
	require_once( $path_to_voce_post_meta_psu . '/voce-post-meta-psu.php' );
}
```

== Usage ==

==== Example ====

```php
<?php
add_action('init', function(){
	add_metadata_group( 'demo_meta', 'Page Options', array(
		'capability' => 'edit_posts'
	));
	add_metadata_field( 'demo_meta', 'post_selection_ui_key', 'Title', 'psu', array(
		'post_type' => 'custom_post_type',
		'post_status' => 'publish',
		'limit' => 3
	) );
	add_post_type_support( 'page', 'demo_meta' );
});
?>
```

== Changelog ==
= 1.2.0 =  
*Separate sanitize callback into its own method insetad of anonymous function. Adding better sanitization of post selection UI value.*

= 1.1.1 =  
*Updated composer.json to require VPM ~1.6 instead of ~1.6.0*

= 1.1.0 =  
* Now returns null for sanitize callback if the $new_value is empty

= 1.0.0 =  
* Initial release