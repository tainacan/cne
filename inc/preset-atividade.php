<?php

/**
 * Funções com a lógica para fazer com que uma nova atividade criada puxe
 * os dados possíveis da Instituição que a criou.
 */

/**
 * Define automaticamente o relacionamento da instituição com a atividade
 */
function cne_preset_atividade_instituicao($item) {
	if ( $item instanceof \Tainacan\Entities\Item ) {
		$collection_id = $item->get_collection_id();

	 	if ( $collection_id !== cne_get_instituicoes_collection_id() ) {

			$referer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			if ( !empty($referer_url) ) {
				
				$query_string = parse_url($referer_url, PHP_URL_QUERY);
				parse_str($query_string, $params);
				$from_instituicao = $params['from-instituicao'];

				if ( $from_instituicao && is_numeric($from_instituicao) ) {
					
					$instituicao_metadatum = new \Tainacan\Entities\Metadatum( cne_get_instituicoes_relationship_metadata_id() );

					if ( $instituicao_metadatum instanceof \Tainacan\Entities\Metadatum ) {
						
						$new_instituicao_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $item, $instituicao_metadatum );
				
						if ( !$new_instituicao_item_metadatum->has_value() ) {
							$new_instituicao_item_metadatum->set_value( $from_instituicao );
					
							if ( $new_instituicao_item_metadatum->validate() ) {
								\Tainacan\Repositories\Item_Metadata::get_instance()->insert( $new_instituicao_item_metadatum );
								
								cne_preset_atividade_data_from_instituicao($item, $from_instituicao);
							}
						}
					}
				}
			}
		}
	}
};
add_action('tainacan-insert', 'cne_preset_atividade_instituicao', 10, 1);

/**
 * Pré-preenche os metadados da atividade com os dados da instituição
 */
function cne_preset_atividade_data_from_instituicao($item_atividade, $instituicao_id) {

	$metadata_mapping = [
		'109029' => '38402',// Região (Instituição) => Região (Atividade)
		'109034' => '38396', // Estado 
		'109040' => '38390', // Cidade 
		'109045' => '38386', // Bairro 
		'109053' => '38388', // Endereço
		'109057' => '38384', // Complemento
		'109065' => '85235', // CEP
		'109049' => '38382', // Número
		'85237' => '85237', // Plus Code
		'109069' => '85239', // Geo Localização

		'85081' => '85081', // Telefone
		'85083' => '85083', // Telefone privado
		'85087' => '85087', // E-mail 
		'85089' => '85089', // E-mail privado
        '85103' => '85103', // Site 
        '85282' => '85282', // Redes Sociais
    ];

	$child_metadata_mapping = [
        '85286' => '85286',  // ... => Facebook
        '85309' => '85309',  // ... => YouTube
        '85303' => '85303',  // ... => Instagram
        '85316' => '85316',  // ... => TikTok
        '85295' => '85295',  // ... => Twitter
		'85421' => '85421'   // ... => Outra rede social
    ];

	$tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
	$item_instituicao = $tainacan_items_repository->fetch($instituicao_id, cne_get_instituicoes_collection_id());

	if ( $item_instituicao instanceof \Tainacan\Entities\Item ) {

		// Percorre os metadados da instituição e copia para a atividade
		foreach($metadata_mapping as $instituicao_metadatum_id => $atividade_metadatum_id) {
			
			$instituicao_metadatum = new \Tainacan\Entities\Metadatum( $instituicao_metadatum_id );
			$atividade_metadatum = new \Tainacan\Entities\Metadatum( $atividade_metadatum_id );

			// Verifica se os dois objetos de metadados foram montados corretamente
			if ( $instituicao_metadatum instanceof \Tainacan\Entities\Metadatum && $atividade_metadatum instanceof \Tainacan\Entities\Metadatum ) {
				
				$instituicao_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $item_instituicao, $instituicao_metadatum );

				if ( $instituicao_item_metadatum->has_value() ) {

					$atividade_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $item_atividade, $atividade_metadatum );

					// Insere o valor no metadado apenas se ele ainda não tiver sido preenchido
					if ( !$atividade_item_metadatum->has_value() ) {
						
						// No caso do metadado composto, percorre o vetor de metadados filhos
						if ( $instituicao_metadatum->get_metadata_type() == 'Tainacan\Metadata_Types\Compound' && $atividade_metadatum->get_metadata_type() == 'Tainacan\Metadata_Types\Compound' ) {

							if ( !$instituicao_metadatum->is_multiple() ) {

								$instituicao_child_item_metadata = $instituicao_item_metadatum->get_value();
								
								$parent_meta_id = null;
								foreach ($instituicao_child_item_metadata as $child_instituicao_metadatum_id => $instituicao_child_item_metadatum) {
									$atividade_child_metadatum = false;

									if ( $instituicao_child_item_metadatum->has_value() ) {

										$atividade_child_metadatum = new \Tainacan\Entities\Metadatum( $child_metadata_mapping[$child_instituicao_metadatum_id] );

										if ( $atividade_child_metadatum instanceof \Tainacan\Entities\Metadatum ) {
											$atividade_child_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $item_atividade, $atividade_child_metadatum, null, $parent_meta_id );
											$atividade_child_item_metadatum->set_value( $instituicao_child_item_metadatum->get_value() );

											if ( $atividade_child_item_metadatum->validate() ) {
												$updated_atividade_child_metadum = \Tainacan\Repositories\Item_Metadata::get_instance()->insert( $atividade_child_item_metadatum );
												$parent_meta_id = $updated_atividade_child_metadum->get_parent_meta_id();
											}
										}
									}
								}
							}
						} else {
						
							if ( 
								$instituicao_metadatum->get_metadata_type() == 'Tainacan\Metadata_Types\Taxonomy' &&
								$atividade_metadatum->get_metadata_type() == 'Tainacan\Metadata_Types\Taxonomy'
							) {
								
								$terms = $instituicao_item_metadatum->get_value();

								if ( false == $terms || null == $terms )
									continue;

								if ( is_array( $terms ) ) {
									$terms = array_map( function($term) {
										return is_object($term) && $term instanceof \Tainacan\Entities\Term ? $term->get_name() : null;
									}, $terms );
									$terms = array_filter( $terms, function($term) {
										return null != $term && !empty($term);
									});
								} else {
									$terms = is_object($terms) && $terms instanceof \Tainacan\Entities\Term ? $terms->get_name() : null;
								}

								if ( false == $terms || null == $terms || empty($terms) || !count($terms) )
									continue;

								$atividade_item_metadatum->set_value( $terms );
								
								if ( $atividade_item_metadatum->validate() ) {
									\Tainacan\Repositories\Item_Metadata::get_instance()->insert( $atividade_item_metadatum );
								}

							} else {
								$atividade_item_metadatum->set_value( $instituicao_item_metadatum->get_value() );
								
								if ( $atividade_item_metadatum->validate() ) {
									\Tainacan\Repositories\Item_Metadata::get_instance()->insert( $atividade_item_metadatum );
								}
							}
						}
					}
				}
			}
		}
	}
}