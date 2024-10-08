<?php

/**
 * Alterações que impactam o template das páginas de Atividade de Eventos (atividade-single.php)
 */
const ATIVIDADE_DATE_AND_TIME_METADATA_IDS = [
	'38424', // Data de Início
	'38419', // Data de Término
	'38421', // Horário de Início
	'38416', // Horário de Término
];
const ATIVIDADE_OTHER_IMPORTANT_METADATA_IDS = [
	'85404', // Ingressos
	'48653', // Classificação indicativa
	'82056', // Formato
	'87133', // A atividade é gratuita?
];
const ATIVIDADE_METADATA_BASIC_ARGS = array(
	'display_slug_as_class' => true,
	'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
	'after' 				=> '</div>',
	'after_title' => '</h2>',
	'before_value' => '<p class="tainacan-metadata-value">',
	'after_value' => '</p>',
	'exclude_title' => true
);

/**
 * Sobrescreve o conteúdo da single da atividade
 * 
 * @param string $content
 * @return string
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

/**
 * Adiciona botão de editar dados da atividade na área do cabeçalho
 */
function cne_atividade_single_page_hero_title_before() {
	if ( cne_is_post_type_a_tainacan_collection( get_post_type() ) && is_singular() && !is_singular( cne_get_instituicoes_collection_post_type() ) ) {
		$item = tainacan_get_item();
			
		if ( $item->can_edit() ) {
			$url = $item->get_edit_url();

			if ( $url ) : ?>
				<div class="wp-block-buttons" style="float: right;">
					<div class="wp-block-button">
						<a href="<?php echo esc_url( $url ); ?>" class="is-style-outline wp-block-button__link wp-element-button">
							Editar dados da atividade &nbsp;
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
								<path d="M18.5 2.50023C18.8978 2.1024 19.4374 1.87891 20 1.87891C20.5626 1.87891 21.1022 2.1024 21.5 2.50023C21.8978 2.89805 22.1213 3.43762 22.1213 4.00023C22.1213 4.56284 21.8978 5.1024 21.5 5.50023L12 15.0002L8 16.0002L9 12.0002L18.5 2.50023Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</a>
					</div>
				</div>
			<?php endif;
		} 
	}
}
add_action('blocksy:hero:custom_meta:before', 'cne_atividade_single_page_hero_title_before');

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
							'metadata__in' => ATIVIDADE_DATE_AND_TIME_METADATA_IDS,
							'before_title' => '<h2 class="screen-reader-text tainacan-metadata-label">',
						),
						ATIVIDADE_METADATA_BASIC_ARGS
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
				'metadata__in' => ATIVIDADE_OTHER_IMPORTANT_METADATA_IDS,
				'before_title' => '<h2 class="tainacan-metadata-label">',
			),
			ATIVIDADE_METADATA_BASIC_ARGS
		);
		tainacan_the_metadata($metadata_args);
	?>
	</div>
<?php
}
add_action('cne-atividade-important-metadata', 'cne_atividade_single_page_important_metadata');

/**
 * Ao invés do slug, usa o 'cne_area_da_secao_de_metadados' para definir a área da seção de metadados.
 * Isso permite estilizar seções de metadados em diferentes coleções de eventos de uma mesma forma.
 */
function cne_atividade_single_page_metadata_section_args($args, $metadata_section) {
	$metadata_section_area = get_post_meta($metadata_section->get_ID(), 'cne_area_da_secao_de_metadados', true);
	if ( $metadata_section_area )
		$args['before_name'] = '<h2 class="tainacan-single-item-section" id="metadata-section-' . $metadata_section_area  . '">';
	
	return $args;
}
add_filter('tainacan-get-metadata-section-as-html-filter-args', 'cne_atividade_single_page_metadata_section_args', 10, 2);


/**
 * Adiciona a instituição responsável pela atividade e a imagem do evento no final da página
 */
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
			<?php
				$related_instituicao_id = get_post_meta( get_the_ID(), cne_get_instituicoes_relationship_metadata_id(), true ); 
				
				if ( $related_instituicao_id ) {
					echo tainacan_get_the_metadata(
						array(
							'metadata__in' => [ 85282 ], // Metadado composto das redes sociais
							'display_slug_as_class' => true,
							'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
							'after' 				=> '</div>',
							'before_title' => '<h3 class="tainacan-metadata-label">',
							'after_title' => '</h3>',
							'before_value' => '<p class="tainacan-metadata-value">',
							'after_value' => '</p>',
						),
						$related_instituicao_id
					);
				}
			?>
		</div>
		<div class="atividade-evento-area">
			<?php 
			$collection = tainacan_get_collection();
            if ( $collection instanceof \Tainacan\Entities\Collection && $collection->get_header_image_id() ) {
				echo '<a alt="' . esc_attr( $collection->get_name() ) . '" href="' . tainacan_get_the_collection_url() . '">';
				echo '<img class="is-hidden-mobile" src="' . wp_get_attachment_image_url( $collection->get_header_image_id(), 'full' ) . '" alt="' . esc_attr( $collection->get_name() ) . '" />';
				echo '<img class="is-hidden-tablet" src="' . wp_get_attachment_image_url( $collection->get__thumbnail_id(), 'large' ) . '" alt="' . esc_attr( $collection->get_name() ) . '" />';
				echo '</a>';
			}
			?>
		</div>
	<?php endif;
}
add_action('blocksy:single:content:bottom', 'cne_atividade_single_page_bottom', 2);