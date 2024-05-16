import { __ } from '@wordpress/i18n';
import { ComboboxControl } from '@wordpress/components';
import { MuseuItemCard } from './museu-item-card';

const MuseusBRAutocomplete = ( { 
        museus,
        fetchMuseus,
        museuSelecionado,
        setMuseuSelecionado
    } ) => {
    return (
        <>
            <ComboboxControl
                __experimentalRenderItem={ ({ item }) => <MuseuItemCard item={ item } /> }
                label={ __( 'Pesquise um museu', 'cne' ) }
                options={ museus }
                onFilterValueChange={ ( inputValue) => fetchMuseus(inputValue) }
                value={ museuSelecionado ? museuSelecionado.label : '' }
                onChange={ ( museuSelecionadoId ) => {
                    setMuseuSelecionado( museus.find((museu) => museu.value === museuSelecionadoId) );
                } }
            />
        </>
    );
}

export { MuseusBRAutocomplete }