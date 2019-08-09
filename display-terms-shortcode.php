<?php
/**
 * Plugin Name: Display Terms Shortcode
 * Plugin URI:  https://github.com/seothemes/display-terms-shortcode/
 * Description: Display a list of terms using the [display-terms] shortcode.
 * Version:     1.0.0
 * Author:      SEO Themes
 * Author URI:  https://seothemes.com/
 * License:     GPL-3.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: display-terms-shortcode
 * Domain Path: /languages
 */

namespace SeoThemes\DisplayTermsShortcode;

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_shortcode( 'display-terms', __NAMESPACE__ . '\add_shortcode' );
/**
 * Create the shortcode.
 *
 * @since 1.0.0
 *
 * @param  array $atts Shortcode attributes.
 *
 * @return string
 */
function add_shortcode( $atts ) {
	$atts = shortcode_atts( [
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
		'meta_key'               => [],
		'meta_value'             => '',
		'show_link'              => true,
		'show_name'              => true,
		'show_description'       => false,
		'show_count'             => false,
		'show_image'             => true,
		'image_size'             => 'full',
		'parent_element'         => 'ul',
		'child_element'          => 'li',
		'parent_class'           => 'terms-list',
		'child_class'            => 'terms-list-item',
	], $atts, 'display-terms' );

	$terms  = get_terms( $atts );
	$output = sprintf( '<%s class="%s">', $atts['parent_element'], $atts['parent_class'] );

	foreach ( $terms as $term ) {
		$output .= sprintf( '<%s class="%s term-%s">', $atts['child_element'], $atts['child_class'], esc_attr( $term->slug ) );

		if ( $atts['show_link'] ) {
			$output .= sprintf( '<a href="%s" class="term-link">', esc_url( get_term_link( $term->term_id ) ) );
		}

		if ( $atts['show_name'] ) {
			$output .= sprintf( '<b class="term-name">%s</b>', esc_html( $term->name ) );
		}

		if ( $atts['show_description'] && ! empty( $term->description ) ) {
			$output .= sprintf( '<p class="term-description">%s</p>', esc_html( $term->description ) );
		}

		if ( $atts['show_count'] ) {
			$output .= sprintf( '<span class="term-count">%s</span>', esc_html( $term->count ) );
		}

		if ( $atts['show_image'] ) {
			$posts = get_posts( apply_filters( 'display_terms_shortcode_latest', [
				'posts_per_page' => 10,
				'cat'            => $term->term_id,
				'orderby'        => 'modified',
			] ) );

			foreach ( $posts as $post ) {
				$image_id = get_post_thumbnail_id( $post->ID );

				if ( $image_id ) {
					break;
				}
			}

			$image_id = apply_filters( 'display_terms_shortcode_image_id', $image_id, $term->term_id );

			if ( isset( $image_id ) && $image_id ) {
				$alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				$attr   = [
					'alt' => $alt ? $alt : $term->name . ' ' . $term->taxonomy,
				];
				$output .= wp_get_attachment_image( $image_id, $atts['image_size'], false, $attr );
			}
		}

		if ( $atts['show_link'] ) {
			$output .= '</a>';
		}

		$output .= sprintf( '</%s>', $atts['child_element'] );
	}

	$output .= sprintf( '</%s>', $atts['parent_element'] );

	return apply_filters( 'display_terms_shortcode_output', $output );
}
