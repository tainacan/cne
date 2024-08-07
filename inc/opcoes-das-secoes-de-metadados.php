<?php
/**
 * Lógica para viabilizar a configuração das áreas das seções de metadados
 */
CONST AREA_DA_SECAO_DE_METADADOS_FIELD = 'cne_area_da_secao_de_metadados'; // slug do campo na api onde vai ficar guardada a área da seção de metadados

function cne_register_metadata_section_admin_hooks() {
    if ( function_exists( 'tainacan_register_admin_hook' ) )
        tainacan_register_admin_hook( 'metadataSection', 'cne_metadata_section_form' );
}
add_action( 'tainacan-register-admin-hooks', 'cne_register_metadata_section_admin_hooks' );

/**
 * Função que monta o formulário de opções extra que aparecerá nas seções de metadados do Tainacan
 */
function cne_metadata_section_form () {

    if ( ! function_exists( 'tainacan_get_api_postdata' ) )
            return '';

    ob_start();
    ?>
    <div class="cne-tainacan-metadata-section-form-extra"> 
        <div class="field tainacan-metadata_section--section-header">
            <h4>Opções do VisiteMuseus</h4>
            <hr>
        </div>
        <div class="field">
            <label class="label">Área da Seção:</label>
            <div class="control is-clearfix">
                <span class="select">
                    <select placeholder="Selecione..." name="<?php echo AREA_DA_SECAO_DE_METADADOS_FIELD; ?>">
                        <option value="">Selecione...</option>
                        <option value="endereco-fisico-da-atividade">Endereço físico da atividade</option>
                        <option value="endereco-virtual-da-atividade">Endereço virtual da atividade</option>
                        <option value="contato-2">Contato</option>
                    </select>
                </span>  
            </div>
            <small class="help">Selecione a área à qual esta seção pertence para que na página pública da atividade os metadados apareçam no lugar correto. Caso esta seja a seção padrão ou seção de metadados desabilitados, não é preciso configurar.</small>
        </div>
    </div>
    <?php
    return ob_get_clean();

}

/** 
 * Função que guarda as opções extras como post meta da seção de metadados
 */
function cne_metadata_section_save_data( $object ) {

    if ( ! function_exists( 'tainacan_get_api_postdata' ) )
        return;

    $post = tainacan_get_api_postdata();
    
    if ( $object->can_edit() ) {

        if ( isset( $post->{AREA_DA_SECAO_DE_METADADOS_FIELD} ) )
            update_post_meta( $object->get_id(), AREA_DA_SECAO_DE_METADADOS_FIELD, $post->{AREA_DA_SECAO_DE_METADADOS_FIELD} );
    }
}
add_action( 'tainacan-insert-tainacan-metasection', 'cne_metadata_section_save_data' );

/** 
 * Função que faz com que a nova post meta seja retornada na API
 */
function cne_metadata_section_add_meta_to_response( $extra_meta, $request ) {
    $extra_meta = array(
        AREA_DA_SECAO_DE_METADADOS_FIELD
    );
    return $extra_meta;
}
add_filter( 'tainacan-api-response-metadata-section-meta', 'cne_metadata_section_add_meta_to_response', 10, 2 );

