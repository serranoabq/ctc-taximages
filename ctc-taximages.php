<?php
/*
    Plugin Name: CTC Taxonomy Images
    Description: Plugin to add taxonomy images to the Church Theme Content special taxonomies (series, tags, groups, etc). Requires <strong>Church Theme Content</strong> plugin.
    Version: 0.1
    Author: Justin R. Serrano
    GitHub Plugin URI: https://github.com/serranoabq/ctc-taximages
    GitHub Branch:     master
*/

// No direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once( sprintf( "%s/ctc-taximages-class.php", dirname(__FILE__) ) );

if( class_exists( 'CTC_TaxImages' ) ) {
	new CTC_TaxImages();


	/**
	 * Output the URL of the image associated with the taxonomy
	 *
	 * @since 0.1
	 * @param mixed $term_id ID of the taxonomy term to output the image for. NULL by default
	 * @return mixed URL of image associated with a taxonomy term
	 */
	function ctc_tax_img_url( $term_id = NULL ) {
		if( $term_id )
			$imgsrc = get_option( 'ctc_tax_img_' . $term_id );
		elseif( is_tax() ) {	
			$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var('taxonomy' ) );
			$imgsrc = get_option( 'ctc_tax_img_' . $current_term->term_id );
		}

		// Allow filtering with add_filter( 'ctc_tax_img_url_filter', 'some_func', 10, 2 ) and function some_func( $imgsrc, $term_id )
		// This would allow overriding this particular function but allow another taxonomy image plugin to be used with CTC-related functions
		$imgsrc = apply_filters( 'ctc_tax_img_url_filter', $imgsrc, $term_id );
		return $imgsrc;
	}

}