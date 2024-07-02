import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';

import { MuseusFetcherModal } from './components/museus-fetcher-modal';

const MuseusBRFetcherButton = () => {
    return <MuseusFetcherModal />;
};

domReady( () => {
    const newButtonRoot = document.createElement("span");
    newButtonRoot.classList.add('museusbr-fetcher-button-container')
    
    const elementAfterButton = document.getElementsByClassName('wp-header-end')[0];
    
    elementAfterButton.parentNode.insertBefore(newButtonRoot, elementAfterButton);

    const root = createRoot(
        newButtonRoot
    );
    root.render( <MuseusBRFetcherButton /> );
} );