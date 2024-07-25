<?php
/**
 * Lógica para viabilizar a configuração de tipos de coleções, permitindo por exemplo distinguir coleções "evento" de outras, além dos links pros tipos de coleções
 */

CONST KIT_DIGITAL_DO_EVENTO_FIELD = 'cne_kit_digital_do_evento'; // slug do campo na api onde vai ficar guardado o link pro kit digital

function cne_register_admin_hooks() {
    tainacan_register_admin_hook( 'collection', 'cne_collection_form', 'end-right' );
}
add_action( 'tainacan-register-admin-hooks', 'cne_register_admin_hooks' );

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
            <h4><?php _e( 'Opções do VisiteMuseus', 'cne' ); ?></h4>
            <hr>
        </div>
        <div class="field">
            <label class="label"><?php _e('Kit digital audiovisual do Evento:', 'cne'); ?></label>
            <div class="control is-clearfix">  
                <input class="input" type="url" placeholder="<?php _e('Insira o link para a página do kit digital do evento', 'cne'); ?>" name="<?php echo KIT_DIGITAL_DO_EVENTO_FIELD; ?>">
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

        if ( isset( $post->{KIT_DIGITAL_DO_EVENTO_FIELD} ) )
            update_post_meta( $object->get_id(), KIT_DIGITAL_DO_EVENTO_FIELD, $post->{KIT_DIGITAL_DO_EVENTO_FIELD});

    }
}
add_action( 'tainacan-insert-tainacan-collection', 'cne_collection_save_data' );

/** 
 * Função que faz com que a nova meta seja retornada na API
 */
function cne_collection_add_meta_to_response( $extra_meta, $request ) {
    $extra_meta = array(
        KIT_DIGITAL_DO_EVENTO_FIELD
    );
    return $extra_meta;
}
add_filter( 'tainacan-api-response-collection-meta', 'cne_collection_add_meta_to_response', 10, 2 );

