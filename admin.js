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

        // Adiciona título customizado para a página de edição de itens
        const pageContainer = document.getElementById('collection-page-container');
        if (pageContainer) {
            const newPageTitle = document.createElement('h1');
            newPageTitle.innerText = ( item.status === 'auto-draft' ? 'Inscrição da ' : 'Edição da ' ) + ( ( collection.id == cne_theme.instituicoes_collection_id ) ? 'Instituição' : 'Atividade' );
            newPageTitle.classList.add('cne-tainacan-page-title');

            const newPageSubtitle = document.createElement('p');

            if ( item.status === 'auto-draft' )
                newPageSubtitle.innerText = 'As informações serão salvas automaticamente desde que você clique em "Criar nova ' + ( ( collection.id == cne_theme.instituicoes_collection_id ) ? 'instituição' : 'atividade' ) + '" no rodapé da página ao menos uma vez.';
            else
                newPageSubtitle.innerText = 'Preencha os campos no seu tempo. As informações serão salvas automaticamente.';

            newPageSubtitle.classList.add('cne-tainacan-page-subtitle');

            const statusWrapper = document.createElement('div');
            statusWrapper.classList.add('cne-tainacan-page-status-wrapper');

            const statusLabel = document.createElement('span');
            statusLabel.classList.add('cne-tainacan-page-status-label');
            statusLabel.innerText = tainacan_plugin.i18n['status_' + item.status];

            const statusIcon = document.createElement('i');
            switch ( item.status ) {
                case 'auto-draft':
                    statusWrapper.style.color = '#3C4D76';
                    statusIcon.dataset.feather = 'loader';
                    break;
                case 'draft':
                    statusWrapper.style.color = '#9B9B9B';
                    statusIcon.dataset.feather = 'edit';
                    break;
                case 'private':
                    statusIcon.dataset.feather = 'lock';
                    break;
                case 'publish':
                    statusWrapper.style.color = '#218963';
                    statusIcon.dataset.feather = 'check-circle';
                    break;
            }

            statusWrapper.appendChild(statusIcon);
            statusWrapper.appendChild(statusLabel);

            const newPageTitleContainer = document.createElement('div');
            newPageTitleContainer.classList.add('cne-tainacan-page-title-container');
            newPageTitleContainer.appendChild(statusWrapper);
            newPageTitleContainer.appendChild(newPageTitle);
            newPageTitleContainer.appendChild(newPageSubtitle);

            pageContainer.insertBefore(newPageTitleContainer, pageContainer.firstChild);

            feather.replace();
        }

        // Extrai ID da Coleção da URL (já que não podemos confiar no objeto collection de estar carregado)
        const itemEditionUrl = document.location && document.location.hash ? document.location.hash : '';
        const regexForCollectionId = /#\/collections\/(\d+)\/items\/(?:\d+|new)/;
        const matches = itemEditionUrl.match(regexForCollectionId);
        const collectionId =  matches ? matches[1] : null;

        if ( collectionId && !isNaN(collectionId) && collectionId !== cne_theme.instituicoes_collection_id ) {
            const collectionEndpoint = tainacan_plugin.tainacan_api_url + '/collections/' + collectionId + '?fetch_only=cne_kit_digital_do_evento';
            fetch(collectionEndpoint)
                .then(response => response.json())
                .then(data => {
                    collection = data;
                    
                   // Adiciona botão de link para o kit digital do evento
                    if (collection && collection.cne_kit_digital_do_evento) {
                        const documentField = document.getElementsByClassName('document-field');

                        if ( documentField.length ) {
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
                })
                .catch(error => {
                    console.error('Erro ao buscar coleção', error);
                });
        }
        
        // Altera rótulos dos elementos do formulário de edição de itens
        if ( collectionId == cne_theme.instituicoes_collection_id ) {
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

    function tainacanItemEditionItemMetadataLoaded() {

        // Cria seção "Imagens" para o campo de anexos
        const imagensSectionBox = document.getElementsByClassName('sticky-container');
        if ( imagensSectionBox.length ) {
            const existingSectionLabel = document.getElementById('cne-images-section-label');

            if ( !existingSectionLabel ) {
                const sectionLabel = document.createElement('div');
                sectionLabel.id = 'cne-images-section-label';
                sectionLabel.classList.add('section-label');
                sectionLabel.classList.add('metadata-section-header');

                const sectionCollapse = document.createElement('span');
                sectionCollapse.classList.add('collapse-handle');

                const sectionTitle = document.createElement('label');
                sectionTitle.style.padding = '0 0.75rem 0 0.75rem';
                sectionTitle.innerText = 'Imagens';

                sectionCollapse.appendChild(sectionTitle);
                sectionLabel.appendChild(sectionCollapse);

                imagensSectionBox[0].insertBefore(sectionLabel, imagensSectionBox[0].firstChild);
            }
        }

        // Adiciona números para as seções
        const sectionLabels = document.getElementsByClassName('metadata-section-header') || [];

        for (let i = 0; i < sectionLabels.length; i++) {
            // Cria contador
            const sectionLabel = sectionLabels[i];
            const sectionCounter = document.createElement('span');
            sectionCounter.innerHTML = (i + 1);
            sectionCounter.classList.add('section-counter');

            // Cria indicador de quantas seções restam
            const sectionCountInfo = document.createElement('div');
            sectionCountInfo.classList.add('section-count-info');
            sectionCountInfo.innerHTML = '<span>Passo ' + (i + 1) + '</span> de ' + (sectionLabels.length) + '<hr><hr style="width: ' + ( 100 * (i + 1) )/sectionLabels.length + '%">';

            sectionLabel.insertBefore(sectionCounter, sectionLabel.firstChild);
            sectionLabel.appendChild(sectionCountInfo);
        }
    }
    wp.hooks.addAction('tainacan_item_edition_metadata_loaded', 'tainacan-hooks', tainacanItemEditionItemMetadataLoaded);
}