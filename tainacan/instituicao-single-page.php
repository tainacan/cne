<?php
/**
 * Template para mostrar o Museu
 */

$prefix = blocksy_manager()->screen->get_prefix();

// $localization_metadata_section = get_theme_mod( 'museusbr_localization_metadata_section', 0 );
// $internal_data_for_banner_metadata_section = get_theme_mod( 'museusbr_internal_data_for_banner_metadata_section', 0 );

$page_structure_type = get_theme_mod( $prefix . '_page_structure_type', 'type-dam');
$template_columns_style = '';
$metadata_list_structure_type = get_theme_mod($prefix . '_metadata_list_structure_type', 'metadata-type-1');

if ($page_structure_type == 'type-gm' || $page_structure_type == 'type-mg') {
    $column_documents_attachments_width = 60;
    $column_metadata_width = 40;

    $column_documents_attachments_width = intval(substr(get_theme_mod( $prefix . '_document_attachments_columns', '60%'), 0, -1));
    $column_metadata_width = 100 - $column_documents_attachments_width;

    if ($page_structure_type == 'type-gm') {
        $template_columns_style = 'grid-template-columns: ' . $column_documents_attachments_width . '% calc(' . $column_metadata_width . '% - 48px);';
    } else {
        $template_columns_style = 'grid-template-columns: ' . $column_metadata_width . '% calc(' . $column_documents_attachments_width . '% - 48px);';
    }
}

$metadata_args = array(
    'metadata__not_in' => [ 20, 1192 ], // Descrição e a SIGLA
    'exclude_core' => true,
    'display_slug_as_class' => true,
    'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
    'after' 				=> '</div>',
    'before_title' => '<h3 class="tainacan-metadata-label">',
    'after_title' => '</h3>',
    'before_value' => '<p class="tainacan-metadata-value">',
    'after_value' => '</p>',
    'exclude_title' => true
);

$sections_args = array(
    'before' => '<section class="tainacan-item-section tainacan-item-section--metadata">',
    'after' => '</section>',
    'before_name' => '<h2 class="tainacan-single-item-section" id="metadata-section-$slug">',
    'after_name' => '</h2>',
    'hide_name' => false,
    'before_metadata_list' => do_action( 'tainacan-blocksy-single-item-metadata-begin' ) . '<div class="tainacan-item-section__metadata ' . $metadata_list_structure_type . '">',
    'after_metadata_list' => '</div>' . do_action( 'tainacan-blocksy-single-item-metadata-end' ),
    'metadata_list_args' => $metadata_args
);

do_action( 'tainacan-blocksy-single-item-top' ); 

do_action( 'tainacan-blocksy-single-item-after-title' );

?>
<div class="tainacan-item-single tainacan-instituicao-single-body"> 
    <div class="tainacan-item-section tainacan-item-section--metadata-sections">
        <?php tainacan_the_metadata_sections( $sections_args ); ?>
        <?php echo blocksy_get_social_share_box(); ?>
    </div>
</div>