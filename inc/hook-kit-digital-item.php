<?php
/**
 * Lógica para exibir o kit digital da coleção no item
 */

function cne_register_admin_item_hooks() {
    tainacan_register_admin_hook( 'item', 'cne_item_form', 'begin-left' );
}
add_action( 'tainacan-register-admin-hooks', 'cne_register_admin_item_hooks' );

/**
 * Função que monta o formulário de opções extra que aparecerá nas coleções do Tainacan
 */
function cne_item_form () {

    ob_start();
    ?>
    <div id="tainacan-cne-item-hook" class="is-hidden"> 
        <div class="field tainacan-collection--section-header">
            <h4><?php _e( 'Kit audiovisual', 'cne' ); ?></h4>
            <hr>
        </div>
    </div>
    <?php
    return ob_get_clean();

}
