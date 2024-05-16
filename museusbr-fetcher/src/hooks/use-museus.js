import { __ } from '@wordpress/i18n';
import axios from 'axios';
import { store as noticesStore } from '@wordpress/notices';
import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';
import { useDispatch } from '@wordpress/data';

const useMuseus = () => {
    const [ museuSelecionado, setMuseuSelecionado ] = useState( null );
    const [ museus, setMuseus ] = useState( [] );
    const [ isFetchingMuseus, setIsFetchingMuseus ] = useState( false );
    const [ isCreatingInstituicao, setIsCreatingInstituicao ] = useState( false );

    //const { createSuccessNotice } = useDispatch( noticesStore );

    const museusBREndpoint = 'https://cadastro.museus.gov.br/wp-json/tainacan/v2/collection/208/items/?perpage=5&paged=1&fetch_only=thumbnail,document,author_name,title,description';

    const fetchMuseusFromMuseusBR = ( inputValue ) => {
		setIsFetchingMuseus( true );
        axios( museusBREndpoint + '&search=' + inputValue)
            .then( (response) => {
                setMuseus(
                    response.data.items ?  
                    response.data.items.map((anItem) => {
                        return {
                            value: anItem.id,
                            label: anItem.title,
                            description: anItem.description,
                            author: anItem.author_name,
                            thumbnail: anItem.thumbnail && anItem.thumbnail['thumbnail'] && anItem.thumbnail['thumbnail'][0] ? anItem.thumbnail['thumbnail'][0] : null,
                            document: anItem.document,
                        }
                    }) : []
                );
                setIsFetchingMuseus( false );
            } )
            .catch( (error) => {
                setIsFetchingMuseus( false );
                // createSuccessNotice(
                //     __( 'Erro ao buscar museus', 'cne' ),
                // );
            }
        );
	};

    const createInstituicaoFromMuseu = (item, itemMetadata, itemDocumentURL) => {
        const instituicoesCollectionId = cne_museusbr_fetcher.instituicoes_collection_id ? cne_museusbr_fetcher.instituicoes_collection_id : 14;
       
        axios.post( cne_museusbr_fetcher.ajax_url, {
            item: item,
            itemDocumentURL: itemDocumentURL,
            itemMetadata: itemMetadata
        }, { 
            params: {
                _ajax_nonce: cne_museusbr_fetcher.nonce, //nonce
                action: 'create_instituicao',  //action
            }
        })
        .then( ( res ) => {
            if ( res.data.success && res.data.data.itemId )
                window.location.replace('/wp-admin/?page=tainacan_admin#/collections/' + instituicoesCollectionId + '/items/' + res.data.data.itemId + '/edit');
        
            setIsCreatingInstituicao( false );
        } )
        .catch( (error) => {
            setIsCreatingInstituicao( false );
        }); 

    };

    const prepareItemToCreateInstituicao = () => {
        const selectedMuseuBRItemMetadataEndpoint = 'https://cadastro.museus.gov.br/wp-json/tainacan/v2/item/' + museuSelecionado.value + '/metadata';
        const selectMuseuBRMediaEndpoing = 'https://cadastro.museus.gov.br/wp-json/wp/v2/media/';

        setIsCreatingInstituicao( true );

        // First we must fetch item metadata
        axios.get( selectedMuseuBRItemMetadataEndpoint )
            .then( (response) => {
                const itemMetadata = response.data.map((itemMetadatum) => {
                    if ( 'Tainacan\\Metadata_Types\\Compound' === itemMetadatum.metadatum.metadata_type ) {
                        return {
                            metadatumId: itemMetadatum.metadatum.id,
                            metadatumValue: itemMetadatum.value.map((compoundValue) => {
                                return {
                                    metadatumId: compoundValue.metadatum_id,
                                    metadatumValue: compoundValue.value
                                }
                            })
                        }
                    }
                    
                    if ( 'Tainacan\\Metadata_Types\\Taxonomy' === itemMetadatum.metadatum.metadata_type ) {
                        let taxonomyValue = itemMetadatum.value;

                        if ( Array.isArray(taxonomyValue) ) {
                            taxonomyValue = taxonomyValue.map((aTaxonomyValue) => {
                                return aTaxonomyValue.name ? aTaxonomyValue.name : aTaxonomyValue;
                            });
                        } else {
                            if (taxonomyValue.name)
                                taxonomyValue = taxonomyValue.name;
                        }
                        return {
                            metadatumId: itemMetadatum.metadatum.id,
                            metadatumValue: taxonomyValue
                        }
                    }
                    
                    return {
                        metadatumId: itemMetadatum.metadatum.id,
                        metadatumValue: itemMetadatum.value
                    }
                    
                });

                // If we have a document, first we fetch it to get the media URL
                if ( museuSelecionado.document && !isNaN(museuSelecionado.document) ) {
                    axios.get( selectMuseuBRMediaEndpoing + museuSelecionado.document )
                        .then( (mediaResponse) => {
                            // Now we have both the metadata and the media URL
                            createInstituicaoFromMuseu(museuSelecionado, itemMetadata, mediaResponse.data.source_url ? mediaResponse.data.source_url : '');
                        } )
                        .catch( (error) => {
                            // In case the media didn't work, try to create the item without it
                            createInstituicaoFromMuseu(museuSelecionado, itemMetadata, '');
                        });

                // Creates item even without media URL
                } else {
                    createInstituicaoFromMuseu(museuSelecionado, itemMetadata, '');
                }
            })
            .catch( (error) => {
                setIsCreatingInstituicao( false );
            });   
    };

    return {
        museus,
        setMuseus,
        museuSelecionado,
        setMuseuSelecionado,
        fetchMuseusFromMuseusBR,
        createInstituicaoFromMuseu,
        prepareItemToCreateInstituicao,
        isFetchingMuseus,
        setIsFetchingMuseus,
        isCreatingInstituicao,
        setIsCreatingInstituicao
    };
};

export default useMuseus;
