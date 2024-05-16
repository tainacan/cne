import { __ } from '@wordpress/i18n';
import { Flex, FlexBlock, FlexItem, Icon, __experimentalTruncate as Truncate } from '@wordpress/components';

function MuseuItemCard( { item } ) {
    const { label, author, thumbnail, description } = item;
    return <Flex gap={ 3 }>
        <FlexItem>
            { 
                thumbnail ? 
                    <img src={ thumbnail } alt={ label } width="68px" height="68px" /> : 
                    <Icon icon="bank" size="68" />
            }
        </FlexItem>
        <FlexBlock>
            <strong>{ label ? label : <em>{ __( 'Museu sem título', 'cne' ) }</em> }</strong>
            { 
                author ?
                    <>
                        <br />
                        <small>{ __( 'por', 'cne' ) } <em>{ author }</em></small>
                    </> :
                    null
            }
            
            { 
                description ?
                    <>
                        <br />
                        <small>
                            <Truncate numberOfLines={2}>
                                { description }
                            </Truncate>
                        </small>
                    </> :
                    null
            }
        </FlexBlock>
    </Flex>
};

export { MuseuItemCard };