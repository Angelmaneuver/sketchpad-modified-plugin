<?php
/**
 * Add the filter features.
 *
 * @package SketchpadModifiedPlugin
 * @since   0.2.0
 */

namespace SketchpadModifiedPlugin;

use SketchpadModifiedPlugin\Flag;
use SketchpadModifiedPlugin\ArticleTitleExtend;

if (
	Flag::ON !== get_option( 'article_title_is_enable', Flag::OFF ) &&
	Flag::ON !== get_option( 'page_title_is_enable', Flag::OFF )
) {
	return;
}

/**
 * Extend post title.
 *
 * @param  string    $block_content The block content about to be appended.
 * @param  array     $block         The full block, including name and attributes.
 * @param  \WP_Block $instance      The block instance.
 * @return string    Filtering results.
 * @see              https://developer.wordpress.org/reference/hooks/render_block_this-name/
 *
 * @since  0.2.0
 */
function render_block_post_title_filter( string $block_content, array $block, \WP_Block $instance ): string {
	if ( ! isset( $instance->context['postId'] ) ) {
		return $block_content;
	}

	$post_type = get_post_type( $instance->context['postId'] );
	$is_link   = isset( $block['attrs']['isLink'] ) ? $block['attrs']['isLink'] : false;

	preg_match(
		'/(?P<open><h(?P<rank>\d)(?:.*?)>)(?P<value>.*?)(?P<close><\/h\d>)/s',
		$block_content,
		$h,
	);

	if ( $is_link ) {
		preg_match(
			'/(?P<open><a(?:.*?)>)(?P<value>.*?)(?P<close><\/a>)/s',
			$h['value'],
			$a,
		);
	} else {
		$a = array(
			'open'  => '',
			'value' => $h['value'],
			'close' => '',
		);
	}

	if ( 'post' === $post_type && ( Flag::ON === get_option( 'article_title_is_enable', Flag::OFF ) ) ) {
		$a['value'] = str_replace(
			'{title}',
			$a['value'],
			get_option( 'article_title_extend', ArticleTitleExtend::EXTEND )
		);
	} elseif ( 'page' === $post_type && ( Flag::ON === get_option( 'page_title_is_enable', Flag::OFF ) ) ) {
		$a['value'] = str_replace(
			'{title}',
			$a['value'],
			get_option( 'page_title_extend', ArticleTitleExtend::EXTEND )
		);
	} else {
		return $block_content;
	}

	return "{$h['open']}{$a['open']}{$a['value']}{$a['close']}{$h['close']}";
}

add_filter( 'render_block_core/post-title', 'SketchpadModifiedPlugin\render_block_post_title_filter', 10, 3 );
