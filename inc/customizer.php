<?php

/**
 * Adiciona opções para o menu Personalizar.
 *
 */
function cne_options_panel($options) {

    $collections_repository = \Tainacan\Repositories\Collections::get_instance();
    $collections_options = [];
    $collections = $collections_repository->fetch()->posts;

    foreach($collections as $collection) {
        $collections_options[$collection->ID] = $collection->post_title;
    }

    $taxonomies_repository = \Tainacan\Repositories\Taxonomies::get_instance();
    $taxonomies_options = [];
    $taxonomies = $taxonomies_repository->fetch()->posts;

    foreach($taxonomies as $taxonomy) {
        $taxonomies_options['tnc_tax_' . $taxonomy->ID] = $taxonomy->post_title;
    }

    $metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
    $metadata_options = [];
    $metadata = $metadata_repository->fetch(array( 
        'meta_query' => array(
            array(
            'key'     => 'collection_id',
            'value'   => 'default',
            'compare' => '='
        ))))->posts;

    foreach($metadata as $metadatum) {
        $metadata_options[$metadatum->ID] = $metadatum->post_title;
    }
    
    $cne_extra_options = [
        'title' => __('Configurações do Visite Museus', 'cne'),
        'container' => [ 'priority' => 8 ],
        'options' => [
            'cne_list_section_options' => [
                'type' => 'ct-options',
                'setting' => [ 'transport' => 'postMessage' ],
                'inner-options' => [
                    'cne_instituicoes_collection' => [
                        'label' => __( 'Coleção de Instituições', 'cne' ),
                        'type' => 'ct-select',
                        'value' => cne_get_instituicoes_collection_id(),
                        'view' => 'text',
                        'design' => 'inline',
                        'sync' => '',
                        'choices' => blocksy_ordered_keys(
                            $collections_options
                        )
                    ],
                    'cne_evento_collection' => [
                        'label' => __( 'Coleção de Evento Atual', 'cne' ),
                        'type' => 'ct-select',
                        'value' => cne_get_evento_collection_id(),
                        'view' => 'text',
                        'design' => 'inline',
                        'sync' => '',
                        'choices' => blocksy_ordered_keys(
                            $collections_options
                        )
                    ],
                    'cne_type_of_collection_taxonomy' => [
                        'label' => __( 'Taxonomia que define os tipos de coleção', 'cne' ),
                        'type' => 'ct-select',
                        'value' => cne_get_type_of_collection_taxonomy_id(),
                        'view' => 'text',
                        'design' => 'block',
                        'sync' => '',
                        'choices' => blocksy_ordered_keys(
                            $taxonomies_options
                        )
                    ],
                    'cne_instituicoes_relationship_metadata' => [
                        'label' => __( 'Relacionamento que vincular instituições aos eventos', 'cne' ),
                        'type' => 'ct-select',
                        'value' => cne_get_instituicoes_relationship_metadata_id(),
                        'view' => 'text',
                        'design' => 'block',
                        'sync' => '',
                        'choices' => blocksy_ordered_keys(
                            $metadata_options
                        )
                    ],
                ]
            ]
        ]
    ];

    $options['cne_list'] = $cne_extra_options;

    return $options;
}
add_filter( 'blocksy_extensions_customizer_options', 'cne_options_panel', 10, 1 );