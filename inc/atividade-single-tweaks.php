<?php

/**
 * Alterações que impactam o template das páginas de Atividade de Eventos (atividade-single.php)
 */

const atividade_date_and_time_metadata_ids = [
	'38424', // Data de Início
	'38419', // Data de Término
	'38421', // Horário de Início
	'38416', // Horário de Término
];
const atividade_other_important_metadata_ids = [
	'85404', // Ingressos
	'48653', // Classificação indicativa
	'82056', // Formato
	'87133', // A atividade é gratuita?
];
const atividade_metadata_basic_args = array(
	'display_slug_as_class' => true,
	'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
	'after' 				=> '</div>',
	'after_title' => '</h2>',
	'before_value' => '<p class="tainacan-metadata-value">',
	'after_value' => '</p>',
	'exclude_title' => true
);

 /**
 * Adiciona horário, data, descrição, e galeria de mídia da atividade na área do cabeçalho
 */
function cne_atividade_single_page_hero_title_after() {

	if ( cne_is_post_type_a_tainacan_collection( get_post_type() ) && is_singular() && !is_singular( cne_get_instituicoes_collection_post_type() ) ) {
		
		function cne_view_mode_atividade_date_without_year($date_format) {
			return 'd/m';
		}
		add_filter( 'pre_option_date_format', 'cne_view_mode_atividade_date_without_year');

		add_filter('wp_kses_allowed_html', function($allowedposttags, $context) {
			switch ( $context ) {
				case 'tainacan_content':
					$post_allowed_html = wp_kses_allowed_html('post');
					return  array_merge(
						$post_allowed_html, 
						['iframe' => array(
							'src'             => true,
							'height'          => true,
							'width'           => true,
							'frameborder'     => true,
							'allowfullscreen' => true,
						)],
						['svg' => array(
							'width' => true,
							'height' => true,
							'viewBox' => true,
							'fill' => true,
							'xmlns' => true
						)],
						['path' => array(
							'd' => true,
							'stroke' => true,
							'stroke-width' => true,
							'stroke-linecap' => true,
							'stroke-linejoin' => true
						)]
					);
				default:
					return $allowedposttags;
			}
		}, 10, 2);

		add_filter( 'tainacan-get-item-metadatum-as-html-before-value', function($metadatum_value_before, $item_metadatum) {

			$metadatum_id = $item_metadatum->get_metadatum()->get_id();
	
			// Horário de Início
			if ( $metadatum_id == 38421 ) {
				$metadatum_value_before .= '<span class="date-icon">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#1EAD9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M12 6V12L16 14" stroke="#1EAD9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>';
			}

			// Data de Início
			if ( $metadatum_id == 38424 ) {
				$metadatum_value_before .= '<span class="date-icon">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="#1EAD9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M3 10H21" stroke="#1EAD9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M16 2V6" stroke="#1EAD9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M8 2V6" stroke="#1EAD9F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>';
			}
		
			return $metadatum_value_before;
		}, 10, 2 );

		?>
        <div class="atividade-main-section">

			<div class="atividade-description">
                <h1 itemprop="headline" class="tainacan-metadata-value page-title"><?php the_title(); ?></h1>
				<?php
					
					$metadata_args = array_merge(
						array(
							'metadata__in' => atividade_date_and_time_metadata_ids,
							'before_title' => '<h2 class="screen-reader-text tainacan-metadata-label">',
						),
						atividade_metadata_basic_args
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
 * Adiciona metadados importantes da atividade antes das primeiras seções de metadado
 */
function cne_atividade_single_page_important_metadata() {

	add_filter( 'tainacan-get-item-metadatum-as-html-before-value', function($metadatum_value_before, $item_metadatum) {

		$metadatum_id = $item_metadatum->get_metadatum()->get_id();

		// Metadado de Gratuidade da Inscrição
		if ( $metadatum_id == 87133 ) {

			if ( $item_metadatum->get_value() == 'Sim' )
				$metadatum_value_before .= '<span class="tainacan-metadata-value">Atividade gratuita</span>';

			$metadatum_value_before .= '<span class="screen-reader-text">';
		}
	
		return $metadatum_value_before;
	}, 10, 2 );


	add_filter( 'tainacan-get-item-metadatum-as-html-after-value', function($metadatum_value_after, $item_metadatum) {

		$metadatum_id = $item_metadatum->get_metadatum()->get_id();

		// Metadado de Gratuidade da Inscrição
		if ( $metadatum_id == 87133 )
			$metadatum_value_after .= '</span>';
	
		return $metadatum_value_after;
	}, 10, 2 );

?>
	<div class="tainacan-item-section tainacan-item-section--metadata tainacan-item-section-cne-important">
	<?php 
		$metadata_args = array_merge(
			array(
				'metadata__in' => atividade_other_important_metadata_ids,
				'before_title' => '<h2 class="tainacan-metadata-label">',
			),
			atividade_metadata_basic_args
		);
		tainacan_the_metadata($metadata_args);
	?>
	</div>
<?php
}
add_action('cne-atividade-important-metadata', 'cne_atividade_single_page_important_metadata');

function cne_atividade_single_page_bottom() {
	if ( cne_is_post_type_a_tainacan_collection( get_post_type() ) && is_singular() && !is_singular( cne_get_instituicoes_collection_post_type() ) ) : ?>

		<div class="atividade-instituicao-area"> 
			<p>Atividade organizada por</p>
			<?php 
				$metadata_args = array(
					'metadata__in' => [ cne_get_instituicoes_relationship_metadata_id() ],
					'display_slug_as_class' => true,
					'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
					'after' 				=> '</div>',
					'before_title' => '<h2 class="screen-reader-text tainacan-metadata-label">',
					'after_title' => '</h2>',
					'before_value' => '<p class="tainacan-metadata-value">',
					'after_value' => '</p>',
					'exclude_title' => true
				);
				tainacan_the_metadata($metadata_args);
			?>
			<p>As informações fornecidas são de total responsabilidade da Instituição</p>
		</div>
		<div class="atividade-evento-area">
			<?php 
			$collection = tainacan_get_collection();
            if ( $collection instanceof \Tainacan\Entities\Collection && $collection->get_header_image_id() ) {
				echo '<a alt="' . esc_attr( $collection->get_name() ) . '" href="' . tainacan_get_the_collection_url() . '">';
				echo '<img src="' . wp_get_attachment_image_url( $collection->get_header_image_id(), 'full' ) . '" alt="' . esc_attr( $collection->get_name() ) . '" />';
				echo '</a>';
			}
			?>
		</div>
	<?php endif;
}
add_action('blocksy:single:content:bottom', 'cne_atividade_single_page_bottom', 2);

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