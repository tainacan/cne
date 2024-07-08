<?php

/**
 * Alterações que impactam o template das páginas de Atividade de Eventos (atividade-single.php)
 */

 /**
 * Adiciona horário, data, descrição, e outros metadados particulares da atividade
 */
function cne_atividade_single_page_hero_title_after() {

	if ( cne_is_post_type_a_tainacan_collection( get_post_type() ) && is_singular() && !is_singular( cne_get_instituicoes_collection_post_type() ) ) {
		?>
        <div class="atividade-pre-header">
            <?php 
                $metadata_args = array(
                    'metadata__in' => [
                        38411,   // Tipo da Atividade
                        38430   // Instituição
                    ],
                    'display_slug_as_class' => true,
                    'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
                    'after' 				=> '</div>',
                    'before_title' => '<span class="screen-reader-text tainacan-metadata-label">',
                    'after_title' => '</span>',
                    'before_value' => '<p class="tainacan-metadata-value">',
                    'after_value' => '</p>',
                    'exclude_title' => true
                );
                tainacan_the_metadata($metadata_args);
            ?>
        </div>
        <div class="atividade-main-section">

			<div class="atividade-description">
                <h1 itemprop="headline" class="tainacan-metadata-value page-title"><?php the_title(); ?></h1>
				<?php 
					$metadata_args = array(
						'metadata__in' => [
                            38424,   // Data de Início
                            38419,   // Data de Término
                            38421,   // Horário de Início
                            38416   // Horário de Término
                        ],
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

                    $item = tainacan_get_item();
                    if ( $item instanceof \Tainacan\Entities\Item && $item->get_description() ) : ?>
                        <p class="tainacan-metadata-value page-description"><?php echo $item->get_description(); ?></p>
                    <?php endif; 
				?>
			</div>
            <div class="atividade-gallery">
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
		<?php
	}
}
add_action('blocksy:hero:custom_meta:after', 'cne_atividade_single_page_hero_title_after');

/**
 * Sobrescreve o conteúdo da single da atividade
 */
function cne_atividade_single_page_content( $content ) {

	if ( !cne_is_post_type_a_tainacan_collection( get_post_type() ) || !is_singular() || is_singular( cne_get_instituicoes_collection_post_type() ) )
		return $content;

	ob_start();
	include( get_stylesheet_directory() . '/tainacan/atividade-single-page.php' );
	$new_content = ob_get_contents();
	ob_end_clean();

	return $new_content;
}
add_filter( 'the_content', 'cne_atividade_single_page_content', 12, 1);