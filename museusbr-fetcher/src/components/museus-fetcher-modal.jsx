import { Button, Modal, Flex, FlexItem, FlexBlock, Icon, Spinner } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { MuseusBRAutocomplete } from './museusbr-autocomplete';
import { MuseuItemCard } from './museu-item-card';
import { CreateButton } from './create-button';

import useMuseus from '../hooks/use-museus';

import { __ } from '@wordpress/i18n';

const MuseusFetcherModal = () => {
    const [ isOpen, setOpen ] = useState( false );
    const openModal = () => setOpen( true );
    const closeModal = () => setOpen( false );

    const { 
        museus, 
        setMuseus,
        museuSelecionado,
        setMuseuSelecionado,
        fetchMuseusFromMuseusBR,
        prepareItemToCreateInstituicao,
        isFetchingMuseus,
        isCreatingInstituicao
    } = useMuseus();

    return (
        <>
            <Button size="compact" variant="primary" onClick={ openModal }>
                { __( 'Importar instituição do MuseusBR', 'cne' ) }
            </Button>
            { isOpen && (
            <Modal 
                title={ __('Crie uma instituição a partir de dados existentes do MuseusBR', 'cne') } 
                icon={ <Icon icon="bank" /> }
                onRequestClose={ closeModal }
                size="large"
                style={{ minHeight: '320px' }}>

                <Flex 
                    gap={ 6 }
                    align='top'>
                    <FlexBlock>
                        <MuseusBRAutocomplete 
                            museuSelecionado={ museuSelecionado }
                            setMuseuSelecionado={ (museuSelecionadoId) => setMuseuSelecionado(museuSelecionadoId) }
                            museus={ museus }
                            fetchMuseus={ _.debounce((inputValue) => {
                                fetchMuseusFromMuseusBR(inputValue);
                            }, 500)} />
                    </FlexBlock>
                    <FlexItem>
                        { isFetchingMuseus ? <Spinner /> : <span style={{ width: '45px', display: 'block' }}></span> }
                    </FlexItem>
                    <FlexBlock>
                        {
                            museuSelecionado && <>
                                <MuseuItemCard item={ museuSelecionado } />
                                <br />
                                <CreateButton isCreatingInstituicao={ isCreatingInstituicao } onClick={ () => prepareItemToCreateInstituicao() }/>
                            </>
                        }
                    </FlexBlock>
                </Flex>

            </Modal>
            ) }
        </>
    );
};

export { MuseusFetcherModal };