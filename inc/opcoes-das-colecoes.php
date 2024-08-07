<?php
/**
 * Lógica para viabilizar a configuração dos links pros tipos de coleções
 */
CONST TEXTO_DE_REFERENCIA_DO_EVENTO_FIELD = 'cne_texto_de_referencia_do_evento'; // slug do campo na api onde vai ficar guardado o link para o texto de referência do evento
CONST KIT_DIGITAL_DO_EVENTO_FIELD = 'cne_kit_digital_do_evento'; // slug do campo na api onde vai ficar guardado o link pro kit digital
CONST CRONOGRAMA_DO_EVENTO_FIELD = 'cne_cronograma_do_evento'; // slug do campo na api onde vai ficar guardado o link para o cronograma
CONST CONTATO_SUPORTE_DO_EVENTO_FIELD = 'cne_contato_suporte_do_evento'; // slug do campo na api onde vai ficar guardado o link para o contato de suporte

function cne_register_collection_admin_hooks() {
    tainacan_register_admin_hook( 'collection', 'cne_collection_form', 'end-right' );
}
add_action( 'tainacan-register-admin-hooks', 'cne_register_collection_admin_hooks' );

/**
 * Função que monta o formulário de opções extra que aparecerá nas coleções do Tainacan
 */
function cne_collection_form () {

    if ( ! function_exists( 'tainacan_get_api_postdata' ) )
            return '';

    ob_start();
    ?>
    <div class="tainacan-taxonomy-collection"> 
        <div class="field tainacan-collection--section-header">
            <h4>Opções do VisiteMuseus</h4>
            <hr>
        </div>
        <div class="field">
            <label class="label">Cronograma do Evento:</label>
            <div class="control is-clearfix">  
                <input class="input" type="url" placeholder="Insira o link para a página do cronograma do evento" name="<?php echo CRONOGRAMA_DO_EVENTO_FIELD; ?>">
            </div>
        </div>
        <div class="field">
            <label class="label">Texto de referência do Evento:</label>
            <div class="control is-clearfix">  
                <input class="input" type="url" placeholder="Insira o link para a página do texto de referência do evento" name="<?php echo TEXTO_DE_REFERENCIA_DO_EVENTO_FIELD; ?>">
            </div>
        </div>
        <div class="field">
            <label class="label">Kit digital audiovisual do Evento:</label>
            <div class="control is-clearfix">  
                <input class="input" type="url" placeholder="Insira o link para a página do kit digital do evento" name="<?php echo KIT_DIGITAL_DO_EVENTO_FIELD; ?>">
            </div>
        </div>
        <div class="field">
            <label class="label">Contato para suporte do Evento:</label>
            <div class="control is-clearfix">  
                <input class="input" type="url" placeholder="Insira um link do WhatsApp para o contato de suporte" name="<?php echo CONTATO_SUPORTE_DO_EVENTO_FIELD; ?>">
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();

}

/** 
 * Função que guarda as opções extras como meta da coleção
 */
function cne_collection_save_data( $object ) {

    if ( ! function_exists( 'tainacan_get_api_postdata' ) )
        return;

    $post = tainacan_get_api_postdata();
    
    if ( $object->can_edit() ) {

        if ( isset( $post->{CRONOGRAMA_DO_EVENTO_FIELD} ) )
            update_post_meta( $object->get_id(), CRONOGRAMA_DO_EVENTO_FIELD, $post->{CRONOGRAMA_DO_EVENTO_FIELD});

        if ( isset( $post->{KIT_DIGITAL_DO_EVENTO_FIELD} ) )
            update_post_meta( $object->get_id(), KIT_DIGITAL_DO_EVENTO_FIELD, $post->{KIT_DIGITAL_DO_EVENTO_FIELD});

        if ( isset( $post->{TEXTO_DE_REFERENCIA_DO_EVENTO_FIELD} ) )
            update_post_meta( $object->get_id(), TEXTO_DE_REFERENCIA_DO_EVENTO_FIELD, $post->{TEXTO_DE_REFERENCIA_DO_EVENTO_FIELD});

        if ( isset( $post->{CONTATO_SUPORTE_DO_EVENTO_FIELD} ) )
            update_post_meta( $object->get_id(), CONTATO_SUPORTE_DO_EVENTO_FIELD, $post->{CONTATO_SUPORTE_DO_EVENTO_FIELD});

    }
}
add_action( 'tainacan-insert-tainacan-collection', 'cne_collection_save_data' );

/** 
 * Função que faz com que a nova meta seja retornada na API
 */
function cne_collection_add_meta_to_response( $extra_meta, $request ) {
    $extra_meta = array(
        CRONOGRAMA_DO_EVENTO_FIELD,
        KIT_DIGITAL_DO_EVENTO_FIELD,
        TEXTO_DE_REFERENCIA_DO_EVENTO_FIELD,
        CONTATO_SUPORTE_DO_EVENTO_FIELD
    );
    return $extra_meta;
}
add_filter( 'tainacan-api-response-collection-meta', 'cne_collection_add_meta_to_response', 10, 2 );

