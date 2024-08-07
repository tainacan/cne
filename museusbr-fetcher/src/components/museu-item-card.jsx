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
            <strong>{ label ? label : <em>{ 'Museu sem título' }</em> }</strong>
            { 
                author ?
                    <>
                        <br />
                        <small>{ 'por' } <em>{ author }</em></small>
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