<?php
/**
 * Botão com modal para buscar dados do MuseusBR e gerar um item na coleção de instituições
 */

/** 
 * Faz os enqueues necessários para o component react
 */
function cne_museusbr_fetcher_enqueue_style_script( $admin_page ) {

    if ( 'edit.php' !== $admin_page )
        return;

    $current_screen = get_current_screen();

    if ( ! $current_screen || ! property_exists( $current_screen, 'post_type' ) )
        return;
    
    $post_type = $current_screen->post_type;

	if ( cne_get_instituicoes_collection_post_type() !== $post_type ) 
        return;

    $asset_file = get_stylesheet_directory() . '/museusbr-fetcher/build/index.asset.php';

    if ( ! file_exists( $asset_file ) )
        return;
    
    $asset = include $asset_file;

    wp_enqueue_script(
        'museusbr-fetcher-script',
        get_stylesheet_directory_uri() . '/museusbr-fetcher/build/index.js',
        $asset['dependencies'],
        $asset['version'],
        array(
            'in_footer' => true,
        )
    );
    wp_localize_script( 'museusbr-fetcher-script', 'cne_museusbr_fetcher', array(
        'instituicoes_collection_id' => cne_get_instituicoes_collection_id(),
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'create-instituicao' ),
    ) );
    wp_enqueue_style( 'wp-components' );
}
add_action( 'admin_enqueue_scripts', 'cne_museusbr_fetcher_enqueue_style_script' );

/**
 * AJAX handler using JSON
 */
function cne_create_instituicao() {

    check_ajax_referer( 'create-instituicao' );
    
    $data_as_string = file_get_contents("php://input");
    $data_as_object = json_decode($data_as_string, true);
    $data_as_object = wp_unslash( $data_as_object );

    if (    
        !$data_as_object ||
        !isset( $data_as_object['item'] ) ||
        !isset( $data_as_object['itemMetadata'] )
    ) {
        wp_send_json_error( array(
            'message' => 'Item não encontrado'
        ) );
        wp_die();
        return;
    }

    $item = $data_as_object['item'];
    $item_metadata = $data_as_object['itemMetadata'];
    $item_document_url = isset( $data_as_object['itemDocumentURL'] ) ? $data_as_object['itemDocumentURL'] : '';
    $instituicoes_collection_id = cne_get_instituicoes_collection_id();

    $new_item = new \Tainacan\Entities\Item();
    $tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();

    $new_item->set_status( 'draft' );
    $new_item->set_title( $item['label'] );
    $new_item->set_description( $item['description'] );
    $new_item->set_collection_id( $instituicoes_collection_id );

    $errors = [];
    $warnings = [];

    $metadata_mapping = [
        '214' => '18',      // Nome do Museu => Nome da Instituição
        '216' => '20',      // Sobre a instituição,
        '274' => '142',     // Tipo do Museu
        '279' => '29593',   // Temática do Museu
        '259' => '29956',   // Esfera Administrativa
        '1587' => '85282',  // Redes Sociais

        '1367' => '38388',  // Endereço (Logradouro)
        '15563' => '38396', // Estado 
        '11568' => '38390', // Cidade 
        '2261' => '38386',  // Bairro 
        '1379' => '38384',  // Complemento 
        '1375' => '38382',  // Número 
        '2797' => '85235',  // CEP 
        '1219' => '85081',  // Telefone 
        '1508' => '29943',  // Dias e horários de aberturo para o público 
        '1503' => '29946',  // Valor da entrada 
        '1517' => '29949',  // Política de Gratuidade 
        '1213' => '85087',  // E-mail 
        '1200' => '85103',  // Site 
    ];

    $child_metadata_mapping = [
        '15626' => '85286',  // ... => Facebook
        '2249' => '85309',   // ... => YouTube
        '39908' => '85303',  // ... => Instagram
        '119857' => '85316', // ... => TikTok
        '39901' => '85295',  // ... => Twitter
    ];

    if ( $new_item->validate() ) {

        $new_item = $tainacan_items_repository->insert($new_item);

        // Este loop cria e insere os valores de metadados no item
        foreach ($item_metadata as $item_metadatum) {

            $metadatum = false;

            // Coloca o objeto do $metadatum da coleção atual dentro do $item_metadata que em do MuseusBR
            if ( isset( $metadata_mapping[ $item_metadatum['metadatumId'] ] ) )
                $metadatum = new \Tainacan\Entities\Metadatum( $metadata_mapping[ $item_metadatum['metadatumId'] ] );

            // Se nenhum mapeamento foi encontrado, pulamos para o próximo metadatum
            if ( false === $metadatum ) {
                $warnings[] = 'O seguinte metadado não encontrou mapeamento nesta instalação: ' . $item_metadatum['metadatumId'] . '.';
                continue;
            }

            if ( $metadatum->get_metadata_type() == 'Tainacan\Metadata_Types\Compound' ) {

                $child_item_metadata = is_array($item_metadatum['metadatumValue']) ? $item_metadatum['metadatumValue'] : [ $item_metadatum['metadatumValue'] ] ;
                
                $parent_meta_id = null;
                foreach ($child_item_metadata as $child_item_metadatum) {
                    $child_metadatum = false;

                    // Coloca o objeto do $metadatum da coleção atual dentro do $item_metadata que em do MuseusBR
                    if ( isset( $child_metadata_mapping[ $child_item_metadatum['metadatumId'] ] ) )
                        $child_metadatum = new \Tainacan\Entities\Metadatum( $child_metadata_mapping[ $child_item_metadatum['metadatumId'] ] );
    
                    // Se nenhum mapeamento foi encontrado, pulamos para o próximo metadatum
                    if ( false === $child_metadatum ) {
                        $warnings[] = 'O seguinte metadado não encontrou mapeamento nesta instalação: ' . $child_item_metadatum['metadatumId'] . '.';
                        continue;
                    }
                        
                    $child_item_metadata = new \Tainacan\Entities\Item_Metadata_Entity($new_item, $child_metadatum, null, $parent_meta_id);
                    $child_item_metadata->set_value( $child_item_metadatum['metadatumValue'] );

                    if ( $child_item_metadata->validate() ) {
                        $child_item_metadata = \Tainacan\Repositories\Item_Metadata::get_instance()->insert( $child_item_metadata );
                        $parent_meta_id = $child_item_metadata->get_parent_meta_id();
                    } else {
                        $errors[] = $child_item_metadata->get_errors();
                    }
                }

            } else {
                $new_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $new_item, $metadatum );
                $proper_value = $item_metadatum['metadatumValue'];

                if ( $metadatum->is_multiple() && !is_array($item_metadatum['metadatumValue']) )
                    $proper_value = [ $proper_value ];
                else if ( !$metadatum->is_multiple() && is_array($item_metadatum['metadatumValue']) && count($item_metadatum['metadatumValue']) > 0 )
                    $proper_value = array_shift($proper_value);

                $new_item_metadatum->set_value( $proper_value );

                if ( $new_item_metadatum->validate() ) {
                    \Tainacan\Repositories\Item_Metadata::get_instance()->insert( $new_item_metadatum );
                } else {
                    $errors[] = $new_item_metadatum->get_errors();
                }
            }

            // No caso no metadaoo de Região, insere-se baseando-se no Estado
            if ( $item_metadatum['metadatumId'] == '15563' && $item_metadatum['metadatumValue'] ) {

                $regiao_metadatum = new \Tainacan\Entities\Metadatum( 73 );
                $new_regiao_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $new_item, $regiao_metadatum );

                $regiao_value = cne_get_regiao_from_estado($item_metadatum['metadatumValue']);

                if ( $regiao_value) {
                    $new_regiao_item_metadatum->set_value( $regiao_value );

                    if ( $new_regiao_item_metadatum->validate() ) {
                        \Tainacan\Repositories\Item_Metadata::get_instance()->insert( $new_regiao_item_metadatum );
                    } else {
                        $errors[] = $new_regiao_item_metadatum->get_errors();
                    }
                }
            }
        }

        // O metadado que indica que está cadastrado no MuseusBR deve sempre vir "Sim"
        $cadastrado_metadatum = new \Tainacan\Entities\Metadatum( 41 );
        $new_cadastrado_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $new_item, $cadastrado_metadatum );

        $new_cadastrado_item_metadatum->set_value( 'Sim' );

        if ( $new_cadastrado_item_metadatum->validate() ) {
            \Tainacan\Repositories\Item_Metadata::get_instance()->insert( $new_cadastrado_item_metadatum );
        } else {
            $errors[] = $new_cadastrado_item_metadatum->get_errors();
        }

        // Se o item possui miniatura, importa ela
        $new_thumbnail_id = false;
        if ( isset( $item['thumbnail'] ) && !empty( parse_url($item['thumbnail']) ) ) {
            $new_thumbnail_id = \Tainacan\Media::get_instance()->insert_attachment_from_url($item['thumbnail'], $new_item->get_id());

            if ( !$new_thumbnail_id )
                $errors[] = 'Erro ao tentar importar miniatura de URL ' . $item['thumbnail'];

            set_post_thumbnail( $new_item->get_id(), (int) $new_thumbnail_id );
        } else {
            $warnings[] = 'Não foi possível encontrar URL de miniatura para importar.';
        }

        // Se o item possui documento, importa ele
        if ( isset( $item_document_url ) && !empty( parse_url($item_document_url) ) ) {
            $new_attachment_id = \Tainacan\Media::get_instance()->insert_attachment_from_url($item_document_url, $new_item->get_id());

            if ( !$new_attachment_id )
                $errors[] = 'Erro ao tentar importar documento de URL ' . $item_document_url;

            $new_item->set_document( $new_attachment_id );
            $new_item->set_document_type( 'attachment' );

            if ( $new_item->validate() )
                $new_item = $tainacan_items_repository->update($new_item);
            else
                $errors[] = 'Não foi possível validar o item após inserção de documento.';

            $thumbnail_id = $tainacan_items_repository->get_thumbnail_id_from_document($new_item);
            if ( !is_null($thumbnail_id) && !$new_thumbnail_id )
                set_post_thumbnail( $new_item->get_id(), (int) $thumbnail_id );

        } else {
            $warnings[] = 'Não foi possível encontrar URL de documento para importar.';
        }

    } else {
        $errors[] = 'Não foi possível validar o item.';
    }

    if ( !empty( $errors ) ) {
        wp_send_json_error(array(
            'message' => 'Erro ao inserir item',
            'errors' => $errors
        ));
        wp_die();
    } else {
        wp_send_json_success(array(
            'message' => 'Item inserido com sucesso',
            'itemId' => $new_item->get_id(),
            'warnings' => $warnings
        ));
        wp_die();
    }
}   
add_action( 'wp_ajax_create_instituicao', 'cne_create_instituicao' );

function cne_get_regiao_from_estado( $uf ) {
    switch ( $uf ) {
        case 'AC':
        case 'AM':
        case 'AP':
        case 'PA':
        case 'RO':
        case 'RR':
        case 'TO':
            return 'Norte';
        case 'AL':
        case 'BA':
        case 'CE':
        case 'MA':
        case 'PB':
        case 'PE':
        case 'PI':
        case 'RN':
        case 'SE':
            return 'Nordeste';
        case 'DF':
        case 'GO':
        case 'MT':
        case 'MS':
            return 'Centro-Oeste';
        case 'ES':
        case 'MG':
        case 'RJ':
        case 'SP':
            return 'Sudeste';
        case 'PR':
        case 'RS':
        case 'SC':
            return 'Sul';
        default:
            return false;
    }
}
