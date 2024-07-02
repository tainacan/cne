<?php

/**
 * Alterações que impactam o template de página de museu (museu-single-page.php)
 */

/**
 * Adiciona Thumbnail do item na página da instituição
 */
function cne_instituicao_single_page_hero_title_before() {

	if ( is_singular( cne_get_instituicoes_collection_post_type() ) ) {
		
		$item = tainacan_get_item();

		if ($item instanceof \Tainacan\Entities\Item) {

			?>
			<div class="instituicao-title-and-thumbnail-container"> 
				<?php the_post_thumbnail('tainacan-medium', array('class' => 'instituicao-thumbnail')); ?>
			<!-- tag will be closed in the after hook -->
			<?php
		}

	}
}
add_action('blocksy:hero:title:before', 'cne_instituicao_single_page_hero_title_before');


/**
 * Adiciona descrição, sigla e galeria de mídias após o título da instituição
 */
function cne_instituicao_single_page_hero_title_after() {

	if ( is_singular( cne_get_instituicoes_collection_post_type() ) ) {
		?>
		</div><!-- Closing of the instituicao-title-and-thumbnail-container -->	
        <div class="instituicao-main-section">
			<div class="instituicao-description">
				<?php 
				
					$metadata_args = array(
						'metadata__in' => [ 20, 1192 ], // Descrição e a SIGLA
						'display_slug_as_class' => true,
						'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
						'after' 				=> '</div>',
						'before_title' => '<h4 class="screen-reader-text tainacan-metadata-label">',
						'after_title' => '</h4>',
						'before_value' => '<p class="tainacan-metadata-value">',
						'after_value' => '</p>',
						'exclude_title' => true
					);
					tainacan_the_metadata($metadata_args);
				?>
			</div>
			<div class="instituicao-gallery">
				<?php
					tainacan_the_item_gallery([
						'blockId'                       => 'tainacan-item-document_id-' . get_the_ID(),
						'layoutElements'                => array( 'main' => true, 'thumbnails' => false ),
						'mediaSources'                  => array( 'document' => true, 'attachments' => true, 'metadata' => false),
						'hideFileNameMain'              => true,
						'hideFileCaptionMain'           => true,
						'hideFileDescriptionMain'       => true,
						'hideFileNameThumbnails'        => true,
						'hideFileCaptionThumbnails'     => true,
						'hideFileDescriptionThumbnails' => true, 
						'showDownloadButtonMain'        => false,
						'showArrowsAsSVG'               => false,
						'hideFileNameLightbox'          => true,
						'hideFileCaptionLightbox'       => false, 
						'hideFileDescriptionLightbox'   => false,
						'openLightboxOnClick'           => true,
						'lightboxHasLightBackground'    => true
					]);
				?>
			</div>  
        </div>

		<div class="tainacan-item-section tainacan-item-section--special-cne-related-items">
			<?php
				$prefix = blocksy_manager()->screen->get_prefix();
				$display_items_related_to_this = get_theme_mod( $prefix . '_display_items_related_to_this', 'no' ) === 'yes';
				if ($display_items_related_to_this) {
					tainacan_blocksy_get_template_part( 'template-parts/tainacan-item-single-items-related-to-this' );
					do_action( 'tainacan-blocksy-single-item-after-items-related-to-this' );
				}
			?>
		</div> 
		<?php
	}
}
add_action('blocksy:hero:title:after', 'cne_instituicao_single_page_hero_title_after');

/**
 * Sobrescreve o conteúdo da single da instituição
 */
function cne_instituicao_single_page_content( $content ) {

	if ( ! is_singular( cne_get_instituicoes_collection_post_type() ) )
		return $content;
	
	ob_start();
	include( get_stylesheet_directory() . '/tainacan/instituicao-single-page.php' );
	$new_content = ob_get_contents();
	ob_end_clean();

	return $new_content;
}
add_filter( 'the_content', 'cne_instituicao_single_page_content', 12, 1);