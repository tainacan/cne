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

		// Fitlros horizontais na busca facetada
		register_block_style(
			'tainacan/faceted-search',
			array(
				'name'  => 'horizontal-filters',
				'label' => esc_html__( 'Filtros horizontais', 'cne' ),
				// 'is_default'   => true,
			)
		);
	}
	add_action( 'init', 'cne_register_block_styles' );
}
