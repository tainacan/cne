import { __ } from '@wordpress/i18n';
import { Button, Spinner } from '@wordpress/components';

const CreateButton = ( { onClick, isCreatingInstituicao } ) => {
	return (
		<Button variant="primary" onClick={ onClick } __next40pxDefaultSize disabled={ isCreatingInstituicao }>
			{ isCreatingInstituicao ? <Spinner /> : __( 'Criar instituição', 'cne' ) }
		</Button>
	);
};

export { CreateButton }