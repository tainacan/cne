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

    function tainacanItemEditionItemLoaded (collection, item) {
        if (collection && collection.cne_kit_digital_do_evento) {
            const documentField = document.getElementsByClassName('document-field');
            if (documentField.length) {
                const wrapper = document.createElement('div');
                wrapper.style.width = '100%';
                wrapper.style.textAlign = 'right';
                wrapper.style.margin = '0.5rem 0';

                const button = document.createElement('a');
                button.classList.add('button');
                button.href = collection.cne_kit_digital_do_evento;
                button.innerText = 'Acessar Kit Digital';
                button.target = '_blank';
                wrapper.appendChild(button);

                documentField[0].prepend(wrapper);
            }
        }
        
        if ( collection.id == cne_theme.instituicoes_collection_id ) {
            tainacan_plugin.i18n.label_ready_to_create_item = 'Pronto para criar esta instituição?';
            tainacan_plugin.i18n.instruction_create_item_select_status = 'Selecione um status para a visibilidade da instituição no site. Você poderá alterar no futuro.';
            tainacan_plugin.i18n.helpers_label.items.document.description = 'Uma imagem represente a instituição.';
            tainacan_plugin.i18n.info_edit_attachments = 'Adicione imagens ou vídeos que representem a instituição. Você pode adicionar mais de um arquivo.';
            tainacan_plugin.i18n.title_create_item_collection = 'Criar nova instituição';
            tainacan_plugin.i18n.title_edit_item = 'Editar instituição';
            tainacan_plugin.i18n.info_item_draft = 'Esta instituição está salva como um rascunho e será visível apenas pelos editores com as permissões necessárias. Não é realizada nenhuma validação de campus obrigatórios neste estado.';
            tainacan_plugin.i18n.info_item_not_saved = 'Atenção, a instituição ainda não foi salva.';
            tainacan_plugin.i18n.info_item_private = 'Esta instituição está publicada de forma privada e será visível apenas para os editores com as permissões necessárias.';
            tainacan_plugin.i18n.info_item_publish = 'Esta instituição está publicada de forma pública e será visível para todos os visitantes do site.';
            tainacan_plugin.i18n.label_related_items = 'Atividades relacionadas';
        } else {
            tainacan_plugin.i18n.label_ready_to_create_item = 'Pronto para criar esta atividade?';
            tainacan_plugin.i18n.instruction_create_item_select_status = 'Selecione um status para a visibilidade da atividade no site. Você poderá alterar no futuro.';
            tainacan_plugin.i18n.helpers_label.items.document.description = 'Uma imagem ou o link de um vídeo do YouTube que represente a atividade.';
            tainacan_plugin.i18n.info_edit_attachments = 'Adicione imagens ou vídeos que representem a atividade. Você pode adicionar mais de um arquivo.';
            tainacan_plugin.i18n.title_create_item_collection = 'Criar nova atividade';
            tainacan_plugin.i18n.title_edit_item = 'Editar atividade';
            tainacan_plugin.i18n.info_item_draft = 'Esta atividade está salva como um rascunho e será visível apenas pelos editores com as permissões necessárias. Não é realizada nenhuma validação de campus obrigatórios neste estado.';
            tainacan_plugin.i18n.info_item_not_saved = 'Atenção, a atividade ainda não foi salva.';
            tainacan_plugin.i18n.info_item_private = 'Esta atividade está publicada de forma privada e será visível apenas para os editores com as permissões necessárias.';
            tainacan_plugin.i18n.info_item_publish = 'Esta atividade está publicada de forma pública e será visível para todos os visitantes do site.';
        }
        tainacan_plugin.i18n.label_create_new_term = 'Adicionar';
        tainacan_plugin.i18n.label_add_value = 'Adicionar';
        tainacan_plugin.i18n.instruction_click_error_to_go_to_metadata = 'Clique no erro para ir até o campo.';
        tainacan_plugin.i18n.label_all_terms = 'Todas as opções';
        tainacan_plugin.i18n.label_all_metadatum_values = 'Todas as opções';
        tainacan_plugin.i18n.info_no_terms_found = 'Nenhuma opção encontrada';
        tainacan_plugin.i18n.label_create_new_term = 'Adicionar';
        tainacan_plugin.i18n.label_root_terms = 'Opções iniciais';
        tainacan_plugin.i18n.label_children_terms = 'opções derivadas';
        tainacan_plugin.i18n.label_nothing_selected = 'Nada selecionado';
        tainacan_plugin.i18n.label_no_terms_selected = 'Nenhuma opção selecionada';
        tainacan_plugin.i18n.label_selected_terms = 'Opções selecionadas';
        tainacan_plugin.i18n.label_selected_metadatum_values = 'Opções selecionadas';
        tainacan_plugin.i18n.info_metadata_section_hidden_conditional = 'Área desabilidata devido a um valor selecionado anterioremente.';
    }
    wp.hooks.addAction('tainacan_item_edition_item_loaded', 'tainacan-hooks', tainacanItemEditionItemLoaded);
}