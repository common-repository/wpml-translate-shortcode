<?php
/*
Plugin Name: WPML Translate Shortcode (DEPRECATED)
Plugin URI: http://github.com/mirkolofio/wpml-translate-shortcode
Description: It's deprecated. Use WPML Shortcodes instead.
Author: Mirco Babini
Version: 1.0.1
Author URI: http://github.com/mirkolofio
*/

/**
 * Usage (via shortcode)
 * [wpml_translate lang='en']Text[/wpml_translate]
 * [wpml_translate lang='it']Testo[/wpml_translate]
 * ( wpml_language is an alias for wpml_translate shortcode )
 * ( code and language are alias for lang attribute )
 *
 * Usage (via code)
 * echo wpml_text_if_language( 'en', 'Text' );
 * echo wpml_text_if_language( 'it', 'Testo' );
 *
 */
// init shortcode and handler
if ( !function_exists( 'load_wpml_translate_shortcode' ) ){
	function load_wpml_translate_shortcode(){

		add_shortcode( 'wpml_translate', 'wpml_text_if_language_sc');
		add_shortcode( 'wpml_language', 'wpml_text_if_language_sc');
	}
	add_action( 'init', 'load_wpml_translate_shortcode' );

	function wpml_text_if_language_sc( $attr, $content = null ){
		if ( ! defined( 'ICL_LANGUAGE_CODE' ) ){
			return '';
		}

		// choose the attr that you prefer
		extract(shortcode_atts(array(
			'lang' => '',
			'code' => '', // same of lang
			'language' => '', // same of lang
		), $attr));

		$lang = ( $code ) ? $code : $lang;
		$lang = ( $language ) ? $language : $lang;
		$lang = ( $lang ) ? $lang : ICL_LANGUAGE_CODE;

		return wpml_text_if_language( $lang, $content );
	}
}

// provide helper even for code
if ( !function_exists( 'wpml_text_if_language' ) ){
	function wpml_text_if_language( $lang, $content ){

		if ( ! defined( 'ICL_LANGUAGE_CODE' ) ){
			return '';
		}

		if ( $lang === null ){
			return '';
		}

		if ( ICL_LANGUAGE_CODE === $lang ){
			return do_shortcode( $content );
		} else{
			return '';
		}
	}
}

/* deprecate this plugin */
/* use WPML Shortcode instead! */
if( is_admin() ){
	function ___admin_notice__error() {
		$class = 'notice notice-error';

		$wpml_shortcode__search = admin_url( '/plugin-install.php?tab=search&s=wpml+shortcodes' );
		$message = __( '<strong>Heads up!</strong> WPML Translate Shortcode is deprecated. Use <a href="'.$wpml_shortcode__search.'">WPML Shortcodes</a> instead.', 'sample-text-domain' );

		printf( '<div class="%1$s" style="padding-top: 10px; padding-bottom: 10px;"><p>%2$s</p></div>', $class, $message ); 
	}
	add_action( 'admin_notices', '___admin_notice__error' );
}
