<?php
/**
 * Block Styles
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_style/
 */

if ( function_exists( 'register_block_style' ) ) {
	/**
	 * Register block styles.
	 */
	function cne_register_block_styles() {

		// Sem quebra de linha
		register_block_style(
			'core/paragraph',
			array(
				'name'  => 'nowrap',
				'label' => 'Sem quebra de linha',
				'inline_style' => 'p.is-style-nowrap { white-space: nowrap; }',
			)
		);
		register_block_style(
			'core/button',
			array(
				'name'  => 'nowrap',
				'label' => 'Sem quebra de linha',
				'inline_style' => '.wp-block-button.is-style-nowrap .wp-block-button__link { white-space: nowrap; }',
			)
		);
	}
	add_action( 'init', 'cne_register_block_styles' );
}
