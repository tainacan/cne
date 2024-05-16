if (wp && wp.hooks) {
    function getTainacanItemEditionRedirect (itemEditionRedirect, itemObject, itemId) {
        
        // Se estamos criando/editando uma atividade, vindo da página da instituição, retornamos pra ela
        if ( document.location.href.indexOf('from-instituicao') > -1 ) {
            let urlObject = new URL(document.location.href);
            let searchParams = urlObject.searchParams;

            const instituicaoId = searchParams.get('from-instituicao');
            if ( instituicaoId )
                return cne_theme.instituicao_admin_url + '&id=' + instituicaoId;
        }

        // Se estamos criando/editando uma instituição, vamos pra página dela
        if ( itemObject.collectionId == cne_theme.instituicoes_collection_id ) {
            return cne_theme.instituicao_admin_url + '&id=' + itemId;
        }

        // Se estamos criando/editando uma atividade, voltamos pra lista de atividades do evento
        if ( itemObject.collectionId != cne_theme.instituicoes_collection_id ) {
            return cne_theme.edit_admin_url + '?post_type=tnc_col_' + itemObject.collectionId + '_item';
        }

        return itemEditionRedirect;
    }
    wp.hooks.addFilter('tainacan_item_edition_after_update_redirect', 'tainacan-hooks', getTainacanItemEditionRedirect);
}