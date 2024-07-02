<?php
/**
 * Conjunto de funções utilitárias para facilitar acesso às configurações do tema
 */

// Slug do papel de usuário "Gestor de Eventos"
const CNE_GESTOR_DE_EVENTOS_ROLE = 'tainacan-gestor-de-eventos';

// Valor padrão para a coleção de Instituições. Será definido no customizer.
const CNE_INSTITUICOES_COLLECTION_ID = 14;//267;

// Valor padrão para a coleção de Evento atual. Será definido no customizer.
const CNE_EVENTO_COLLECTION_ID = 15;//267;

// Valor padrão para a taxonomia que define as coleções Evento. Será definido no customizer.
const CNE_TYPE_OF_COLLECTION_TAXONOMY_ID = 18259;

// Valor padrão para o metadado nível repositório que amarra os eventos às instituições. Será definido no customizer.
const CNE_INSTITUICOES_RELATIONSHIP_METADATA_ID = 38430;

/**
 * Função utilitaria para obter o id da coleção Museus
 */
function cne_get_instituicoes_collection_id() {
	return get_theme_mod( 'cne_instituicoes_collection', CNE_INSTITUICOES_COLLECTION_ID );
}

/**
 * Função utilitaria para obter o tipo de post da coleção Instituições
 */
function cne_get_instituicoes_collection_post_type() {
	return 'tnc_col_' . cne_get_instituicoes_collection_id() . '_item';
}

/**
 * Função utilitaria para obter o id da coleção Museus
 */
function cne_get_evento_collection_id() {
	return get_theme_mod( 'cne_evento_collection', CNE_EVENTO_COLLECTION_ID );
}

/**
 * Função utilitaria para obter o tipo de post da coleção Instituições
 */
function cne_get_evento_collection_post_type() {
	return 'tnc_col_' . cne_get_evento_collection_id() . '_item';
}

/**
 * Função utilitaria para verificar se um post type é de alguma coleção do Tainacan
 */
function cne_is_post_type_a_tainacan_collection( $post_type ) {
	return strpos($post_type, 'tnc_col_') !== false;
}

/**
 * Função utilitaria para obter o id da taxonomia que define o tipo de coleção
 */
function cne_get_type_of_collection_taxonomy_id() {
	return get_theme_mod( 'cne_type_of_collection_taxonomy', CNE_TYPE_OF_COLLECTION_TAXONOMY_ID );
}

/**
 * Função utilitaria para obter o id do metadado nível repositório de relacionamento entre eventos e instituições
 */
function cne_get_instituicoes_relationship_metadata_id() {
	return get_theme_mod( 'cne_instituicoes_relationship_metadata', CNE_INSTITUICOES_RELATIONSHIP_METADATA_ID );
}

/**
 * Extrai ID da coleção a partir de um slug de post type
 */
function cne_get_collection_id_from_post_type($post_type) {

	if ( strpos($post_type, 'tnc_col_') < 0 )
		return false;
	
	$string_as_array = explode('_', $post_type);
	if ( count($string_as_array) < 3 )
		return false;

	return $string_as_array[2];
}

/** 
 * Obtém apenas coleções do tipo "evento"
 */
function cne_get_eventos() {
	$collections_repository = \Tainacan\Repositories\Collections::get_instance();
	$args = array(
		'tax_query' => array(
			array(
				'taxonomy' => cne_get_type_of_collection_taxonomy_id(),
				'field' => 'slug',
				'terms' => 'evento'
			)
		),
		'perpage' => -1	
	);
	$collections = $collections_repository->fetch($args, 'OBJECT');
	return $collections;
}

/**
 * Função para obter uma lista de itens "atividades".
 * @param array $args Argumentos para a busca de itens (WP_Query)
 * @param int $id_instituicao ID da instituição a ser filtrada (opcional)
 * @param int $ids_eventos array de IDs dos eventos a ser filtrado (opcional)
 * @param int $id_author ID do autor a ser filtrado (opcional) 
 */
function cne_get_atividades($args = array(), $id_instituicao = null, $ids_eventos = [], $id_author = null) {
    $tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();

    if ( $id_instituicao ) {
        $args['meta_query'] = array(
            array(
                'key' => cne_get_instituicoes_relationship_metadata_id(),
                'value' => $id_instituicao,
                'compare' => '='
            )
        );
    }

    if ( $id_author ) {
        $args['author'] = $id_author;
    }

    $default_args = array(
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $args = array_merge($default_args, $args);

    $items = $tainacan_items_repository->fetch($args, $ids_eventos,  'OBJECT');

    return $items;
}

/* Builds navigation link for custom view modes */
function cne_get_item_link_for_navigation($item_url, $index) {
		
	if ( $_GET && isset($_GET['paged']) && isset($_GET['perpage']) ) {
		$query = '';
		$perpage = (int)$_GET['perpage'];
		$paged = (int)$_GET['paged'];
		$index = (int)$index;
		$query .= '&pos=' . ( ($paged - 1) * $perpage + $index );
		$query .= '&source_list=' . (is_tax() ? 'term' : 'collection');
		return $item_url . '?' .  $_SERVER['QUERY_STRING'] . $query;
	}
	return $item_url;
}
