<?php
/**
 * Plugin Name: Display Terms Shortcode
 * Plugin URI:  https://github.com/seothemes/display-terms-shortcode/
 * Description: Display a list of terms using the [display-terms] shortcode.
 * Version:     0.1.0
 * Author:      SEO Themes
 * Author URI:  https://seothemes.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * version 2, as published by the Free Software Foundation. You may
 * NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   Display Terms Shortcode
 * @version   0.1.0
 * @author    SEO Themes <info@seothemes.com>
 * @copyright Copyright (c) 2017, SEO Themes
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Add the shortcode.
add_shortcode( 'display-terms', 'display_terms_shortcode' );

/**
 * Create the shortcode.
 *
 * @param  array $atts Shortcode attributes.
 * @return string
 */
function display_terms_shortcode( $atts ) {

	// Original Attributes, for filters.
	$original_atts = $atts;

	// Pull in shortcode attributes and set defaults.
	// https://developer.wordpress.org/reference/functions/get_terms/#comment-2180.
	$atts = shortcode_atts( array(
		'taxonomy'               => 'category',
		'orderby'                => 'name',
		'order'                  => 'ASC',
		'hide_empty'             => true,
		'include'                => 'all',
		'exclude'                => 'all',
		'exclude_tree'           => 'all',
		'number'                 => false,
		'offset'                 => '',
		'fields'                 => 'all',
		'name'                   => '',
		'slug'                   => '',
		'hierarchical'           => true,
		'search'                 => '',
		'name__like'             => '',
		'description__like'      => '',
		'pad_counts'             => false,
		'get'                    => '',
		'child_of'               => false,
		'childless'              => false,
		'cache_domain'           => 'core',
		'update_term_meta_cache' => true,
		'meta_query'             => '',
		'meta_key'               => array(),
		'meta_value'             => '',
		'show_link'              => true,
		'show_name'              => true,
		'show_description'       => false,
		'show_count'             => false,
		'show_image'             => true,
	), $atts, 'display-terms' );

	// Add image filter.
	add_filter( 'get_terms', 'display_terms_get_image', 10, 3 );

	$terms  = get_terms( $atts );
	$output = '<ul class="terms-list">';

	/**
	 * Loop through terms and output HTML.
	 */
	foreach ( $terms as $term ) {
		$output .= '<li class="terms-list-item term-' . $term->slug . '">';

		// Display term link.
		if ( $atts['show_link'] ) {
			$output .= '<a href="' . get_term_link( $term->term_id ) . '" class="term-link">';
		}

		// Display term name.
		if ( $atts['show_name'] ) {
			$output .= '<b class="term-name">' . esc_html( $term->name ) . '</b>';
		}

		// Display term description.
		if ( $atts['show_description'] ) {
			$output .= '<p class="term-description">' . esc_html( $term->description ) . '</p>';
		}

		// Display term count.
		if ( $atts['show_count'] ) {
			$output .= '<span class="term-count">' . esc_html( $term->count ) . '</span>';
		}

		// Display term image.
		if ( $atts['show_image'] ) {
			$output .= $term->image;
		}

		if ( $atts['show_link'] ) {
			$output .= '</a>';
		}
		$output .= '</li>';
	}

	$output .= '</ul>';

	// Remove image filter.
	remove_filter( 'get_terms', 'display_terms_get_image', 10, 3 );

	return $output;

}

/**
 * Gets the latest post's featured image for each term.
 *
 * @param  array $terms      Loop terms.
 * @param  array $taxonomies Loop taxonomies.
 * @param  array $args       Passed in args.
 * @return array
 */
function display_terms_get_image( $terms, $taxonomies, $args ) {

	foreach ( $terms as &$term ) {
		$parent = new WP_Query(
			array (
				'cat'    => $term->term_id,
				'fields' => 'ids',
			)
		);

		if ( $parent->have_posts() ) {
			$attach = new WP_Query(
				array (
					'post_parent__in' => $parent->posts,
					'post_type'       => 'attachment',
					'post_status'     => 'inherit',
					'posts_per_page'  => 1,
				)
			);
			if ( $attach->have_posts() ) {
				$term->image = wp_get_attachment_image( $attach->posts[0]->ID, 'full' );
			} else {
				$term->image = ''; // Placeholder image.
			}
		}
	}
	return $terms;
}
