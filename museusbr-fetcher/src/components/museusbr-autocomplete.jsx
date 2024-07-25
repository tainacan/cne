import { __ } from '@wordpress/i18n';
import { ComboboxControl } from '@wordpress/components';
import { MuseuItemCard } from './museu-item-card';

const MuseusBRAutocomplete = ( { 
        museus,
        setMuseus,
        fetchMuseus,
        museuSelecionado,
        setMuseuSelecionado
    } ) => {
    return (
        <>
            <ComboboxControl
                __next40pxDefaultSize={ true }
                __experimentalRenderItem={ ({ item }) => <MuseuItemCard item={ item } /> }
                label={ __( 'Pesquise um museu', 'cne' ) }
                options={ museus }
                onFilterValueChange={ ( inputValue) => fetchMuseus(inputValue) }
                value={ museuSelecionado ? museuSelecionado.label : '' }
                expandOnFocus={ false }
                onChange={ ( museuSelecionadoId ) => {
                    setMuseuSelecionado( museus.find((museu) => museu.value === museuSelecionadoId) );
                    setMuseus([]);
                } }
            />
        </>
    );
}

export { MuseusBRAutocomplete }