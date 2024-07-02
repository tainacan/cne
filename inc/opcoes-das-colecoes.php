<?php
/**
 * Lógica para viabilizar a configuração de tipos de coleções, permitindo por exemplo distinguir coleções "evento" de outras, além dos links pros tipos de coleções
 */

CONST TYPE_OF_COLLECTION_FIELD = 'cne_type_of_collection'; // slug do campo na api onde vai ficar guardado o tipo de coleção
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
    
    $args = array(
        'taxonomy'  => cne_get_type_of_collection_taxonomy_id(),
        'hide_empty' => 0,
        'orderby'   => 'name',
        'order'     => 'ASC'
    );
    $terms = get_terms($args);

    if ( is_wp_error( $terms ) || empty( $terms ) )
        return;

    ob_start();
    ?>
    <div class="tainacan-taxonomy-collection"> 
        <div class="field tainacan-collection--section-header">
            <h4><?php _e( 'Opções do VisiteMuseus', 'cne' ); ?></h4>
            <hr>
        </div>
        <div class="field">
            <label class="label"><?php _e('Tipo de Coleção:', 'cne'); ?></label>
            <div class="control is-clearfix">
                <?php foreach ($terms as $term): ?>
                    <label class="b-checkbox checkbox is-inline-block">
                        <input type="checkbox" name="<?php echo TYPE_OF_COLLECTION_FIELD; ?>" value="<?php echo $term->slug;?>">
                        <span class="check"></span>
                        <span class="control-label"><?php echo $term->name; ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
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

    $taxonomy_id = cne_get_type_of_collection_taxonomy_id();

    $post = tainacan_get_api_postdata();
    
    if ( $object->can_edit() ) {

        if ( isset( $post->{TYPE_OF_COLLECTION_FIELD} ) ) {
            update_post_meta( $object->get_id(), TYPE_OF_COLLECTION_FIELD, $post->{TYPE_OF_COLLECTION_FIELD});
            
            $terms = wp_get_object_terms( $object->get_id(), $taxonomy_id);
            $terms_ID  = [];
            foreach ($terms as $term) {
                $terms_ID[] = $term->term_id;
            }
            wp_remove_object_terms( $object->get_id(), $terms_ID, $taxonomy_id );
            wp_set_object_terms( $object->get_id(), $post->{TYPE_OF_COLLECTION_FIELD}, $taxonomy_id);
        }

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
        TYPE_OF_COLLECTION_FIELD,
        KIT_DIGITAL_DO_EVENTO_FIELD
    );
    return $extra_meta;
}
add_filter( 'tainacan-api-response-collection-meta', 'cne_collection_add_meta_to_response', 10, 2 );

