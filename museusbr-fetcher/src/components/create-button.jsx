import { Button, Spinner } from '@wordpress/components';

const CreateButton = ( { onClick, isCreatingInstituicao } ) => {
	return (
		<Button variant="primary" __next40pxDefaultSize={ true } onClick={ onClick } __next40pxDefaultSize disabled={ isCreatingInstituicao }>
			{ isCreatingInstituicao ? <Spinner /> : 'Criar instituição' }
		</Button>
	);
};

export { CreateButton }