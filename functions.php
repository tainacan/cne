<?php
if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

require get_stylesheet_directory() . '/inc/utils.php';

/**
 * Carregas estilos básicos do tema
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'cne-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
});

/** 
 * Registra estilo do lado admin
 */
function cne_admin_enqueue_styles() {
	wp_enqueue_style( 'cne-admin-style', get_stylesheet_directory_uri() . '/admin.css', array(), wp_get_theme()->get('Version') );
	wp_enqueue_script( 'cne-admin-script', get_stylesheet_directory_uri() . '/admin.js', array('wp-hooks'), wp_get_theme()->get('Version') );
	
	wp_localize_script( 'cne-admin-script', 'cne_theme', array(
        'instituicoes_collection_id' => cne_get_instituicoes_collection_id(),
		'instituicao_admin_url' => admin_url( 'admin.php?page=instituicao'),
		'edit_admin_url' => admin_url( 'edit.php'),
    ) );
}
add_action( 'admin_enqueue_scripts', 'cne_admin_enqueue_styles' );

/**
 * Lista somente os itens das coleções de eventos no nível repositório
 */
function cne_fetch_args_posts_items_repository( $args, $entity ) {
	
	if ( $entity !== 'items' || !isset($args['post_type']) || count($args['post_type']) <= 1 )
		return $args;

	$referer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	if ( !empty($referer_url) ) {
		$query_string = parse_url($referer_url, PHP_URL_QUERY);
		parse_str($query_string, $params);
		//error_log($referer_url);

		$args['post_type'] = array_filter(
			$args['post_type'], 
			function($collection_post_type) {
				return $collection_post_type !== cne_get_instituicoes_collection_post_type();
			}
		);
	}

	return $args;
}
add_filter( 'tainacan-fetch-args', 'cne_fetch_args_posts_items_repository', 11, 2 );

/**
 * Filtra as colunas que aparecem de algumas coleções
 */
function cne_manage_collections_table_columns() {

	$tainacan_collections_post_types = \Tainacan\Repositories\Repository::get_collections_db_identifiers();

	foreach ($tainacan_collections_post_types as $collection_post_type) {

		add_filter( 'manage_' . $collection_post_type . '_posts_columns', function($columns) {
			
			unset($columns['date']);
			unset($columns['comments']);
			
			return array_merge($columns, array(
				'description' => __('Descrição', 'cne')
			));
		}, 10, 1 );

		add_action('manage_' . $collection_post_type . '_posts_custom_column', function($column_key, $post_id) {
			
			if ( $column_key == 'description' ) {
				echo get_the_excerpt($post_id);
			}
		}, 10, 2);
	}
}
add_action('admin_init', 'cne_manage_collections_table_columns', 10);

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
								
								cne_preset_atividade_location_from_instituicao($item, $from_instituicao);
							}
						}
					}
				}
			}
		}
	}
};

add_action('tainacan-insert', 'cne_preset_atividade_instituicao', 10, 1);

function cne_preset_atividade_location_from_instituicao($item_atividade, $instituicao_id) {

	$metadata_mapping = [
		'73' => '38402',	// Região (Instituição) => Região (Atividade)
		'1232' => '38388',  // Endereço
		'104' => '43915',   // Estado 
		'77' => '38390',    // Cidade 
		'1203' => '38386',  // Bairro 
		'151' => '38384'    // Complemento
    ];

	$tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
	$item_instituicao = $tainacan_items_repository->fetch($instituicao_id, cne_get_instituicoes_collection_id());

	if ( $item_instituicao instanceof \Tainacan\Entities\Item ) {

		foreach($metadata_mapping as $instituicao_metadatum_id => $atividade_metadatum_id) {
			
			$instituicao_metadatum = new \Tainacan\Entities\Metadatum( $instituicao_metadatum_id );
			$atividade_metadatum = new \Tainacan\Entities\Metadatum( $atividade_metadatum_id );

			if ( $instituicao_metadatum instanceof \Tainacan\Entities\Metadatum && $atividade_metadatum instanceof \Tainacan\Entities\Metadatum ) {
				$instituicao_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $item_instituicao, $instituicao_metadatum );

				if ( $instituicao_item_metadatum->has_value() ) {
					$atividade_item_metadatum = new \Tainacan\Entities\Item_Metadata_Entity( $item_atividade, $atividade_metadatum );

					if ( !$atividade_item_metadatum->has_value() ) {
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

/**
 * Inclui a coleção de instituições no menu admin e altera seus rótulos
 */
function cne_list_collections_in_admin($args, $post_type) {
	
	$tainacan_collections_post_types = \Tainacan\Repositories\Repository::get_collections_db_identifiers();
	
	if ( $post_type == 'tainacan-collection' ) {
		$args['show_ui'] = true; // Com isso, as coleções passam a poder ter taxonomias vinculadas a elas
		$args['show_in_menu'] = false;
		$args['show_in_admin_bar'] = false;	
	} else if ( $post_type == cne_get_instituicoes_collection_post_type() ) {
		$args['show_ui'] = true;
		$args['show_in_menu'] = true;
		$args['menu_icon'] = 'dashicons-bank';
		$args['menu_position'] = 3;
		$args['labels']['name'] = __( 'Instituições', 'cne ');// General name for the post type, usually plural. The same and overridden by $post_type_object->label. Default is ‘Posts’ / ‘Pages’.
		$args['labels']['singular_name'] = __( 'Instituição', 'cne ');// Name for one object of this post type. Default is ‘Post’ / ‘Page’.
		$args['labels']['add_new'] = __( 'Adicionar nova', 'cne ');// Label for adding a new item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['add_new_item'] = __( 'Adicionar nova instituição', 'cne ');// Label for adding a new singular item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['edit_item'] = __( 'Editar instituição', 'cne ');// Label for editing a singular item. Default is ‘Edit Post’ / ‘Edit Page’.
		$args['labels']['new_item'] = __( 'Nova instituição', 'cne ');// Label for the new item page title. Default is ‘New Post’ / ‘New Page’.
		$args['labels']['view_item'] = __( 'Ver instituição', 'cne ');// Label for viewing a singular item. Default is ‘View Post’ / ‘View Page’.
		$args['labels']['view_items'] = __( 'Ver instituições', 'cne ');// Label for viewing post type archives. Default is ‘View Posts’ / ‘View Pages’.
		$args['labels']['search_items'] = __( 'Pesquisar instituições', 'cne ');// Label for searching plural items. Default is ‘Search Posts’ / ‘Search Pages’.
		$args['labels']['not_found'] = __( 'Nenhuma instituição encontrada', 'cne ');// Label used when no items are found. Default is ‘No posts found’ / ‘No pages found’.
		$args['labels']['not_found_in_trash'] = __( 'Nenhuma instituição na lixeira', 'cne ');// Label used when no items are in the Trash. Default is ‘No posts found in Trash’ / ‘No pages found in Trash’.
		$args['labels']['all_items'] = __( 'Todas as instituições', 'cne ');// Label to signify all items in a submenu link. Default is ‘All Posts’ / ‘All Pages’.
		$args['labels']['archives'] = __( 'Lista de instituições', 'cne ');// Label for archives in nav menus. Default is ‘Post Archives’ / ‘Page Archives’.
		$args['labels']['attributes'] = __( 'Dados das instituições', 'cne ');// Label for the attributes meta box. Default is ‘Post Attributes’ / ‘Page Attributes’.
		$args['labels']['insert_into_item'] = __( 'Inserir na instituição', 'cne ');// Label for the media frame button. Default is ‘Insert into post’ / ‘Insert into page’.
		$args['labels']['uploaded_to_this_item'] = __( 'Enviado para essa instituição', 'cne ');// Label for the media frame filter. Default is ‘Uploaded to this post’ / ‘Uploaded to this page’.
		$args['labels']['filter_items_list'] = __( 'Filtrar lista de instituições', 'cne ');// Label for the table views hidden heading. Default is ‘Filter posts list’ / ‘Filter pages list’.
		$args['labels']['items_list_navigation'] = __( 'Navegação na lista de instituições', 'cne ');// Label for the table pagination hidden heading. Default is ‘Posts list navigation’ / ‘Pages list navigation’.
		$args['labels']['items_list'] = __( 'Lista de instituições', 'cne ');// Label for the table hidden heading. Default is ‘Posts list’ / ‘Pages list’.
		$args['labels']['item_published'] = __( 'Instituição publicada', 'cne ');// Label used when an item is published. Default is ‘Post published.’ / ‘Page published.’
		$args['labels']['item_published_privately'] = __( 'Instituição publicada de forma privada', 'cne ');// Label used when an item is published with private visibility. Default is ‘Post published privately.’ / ‘Page published privately.’
		$args['labels']['item_reverted_to_draft'] = __( 'Instituição mantida como rascunho', 'cne ');// Label used when an item is switched to a draft. Default is ‘Post reverted to draft.’ / ‘Page reverted to draft.’
		$args['labels']['item_trashed'] = __( 'Instituição na lixeira', 'cne ');// Label used when an item is moved to Trash. Default is ‘Post trashed.’ / ‘Page trashed.’
		$args['labels']['item_scheduled'] = __( 'Instituiçõe agendada', 'cne ');// Label used when an item is scheduled for publishing. Default is ‘Post scheduled.’ / ‘Page scheduled.’
		$args['labels']['item_updated'] = __( 'Instituição atualizada', 'cne ');// Label used when an item is updated. Default is ‘Post updated.’ / ‘Page updated.’
		$args['labels']['item_link'] = __( 'Link da instituição', 'cne ');// Title for a navigation link block variation. Default is ‘Post Link’ / ‘Page Link’.
		$args['labels']['item_link_description'] = __( 'Um link para uma instituição', 'cne ');// Description for a navigation link block variation. Default is ‘A link to a post.’ / ‘A link to a page.’
    } else if ( array_search($post_type, $tainacan_collections_post_types) !== false ) {
		$args['show_ui'] = true;
		$args['labels']['add_new'] = __( 'Adicionar nova atividade', 'cne ');// Label for adding a new item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['add_new_item'] = __( 'Adicionar nova atividade', 'cne ');// Label for adding a new singular item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['edit_item'] = __( 'Editar atividade', 'cne ');// Label for editing a singular item. Default is ‘Edit Post’ / ‘Edit Page’.
		$args['labels']['new_item'] = __( 'Nova atividade', 'cne ');// Label for the new item page title. Default is ‘New Post’ / ‘New Page’.
		$args['labels']['view_item'] = __( 'Ver atividade', 'cne ');// Label for viewing a singular item. Default is ‘View Post’ / ‘View Page’.
		$args['labels']['view_items'] = __( 'Ver atividades', 'cne ');// Label for viewing post type archives. Default is ‘View Posts’ / ‘View Pages’.
		$args['labels']['search_items'] = __( 'Pesquisar atividades', 'cne ');// Label for searching plural items. Default is ‘Search Posts’ / ‘Search Pages’.
		$args['labels']['not_found'] = __( 'Nenhuma atividade encontrada', 'cne ');// Label used when no items are found. Default is ‘No posts found’ / ‘No pages found’.
		$args['labels']['not_found_in_trash'] = __( 'Nenhuma atividade na lixeira', 'cne ');// Label used when no items are in the Trash. Default is ‘No posts found in Trash’ / ‘No pages found in Trash’.
		$args['labels']['all_items'] = __( 'Todas as atividades', 'cne ');// Label to signify all items in a submenu link. Default is ‘All Posts’ / ‘All Pages’.
		$args['labels']['archives'] = __( 'Lista de atividades', 'cne ');// Label for archives in nav menus. Default is ‘Post Archives’ / ‘Page Archives’.
		$args['labels']['attributes'] = __( 'Dados das atividades', 'cne ');// Label for the attributes meta box. Default is ‘Post Attributes’ / ‘Page Attributes’.
		$args['labels']['insert_into_item'] = __( 'Inserir na atividade', 'cne ');// Label for the media frame button. Default is ‘Insert into post’ / ‘Insert into page’.
		$args['labels']['uploaded_to_this_item'] = __( 'Enviado para essa atividade', 'cne ');// Label for the media frame filter. Default is ‘Uploaded to this post’ / ‘Uploaded to this page’.
		$args['labels']['filter_items_list'] = __( 'Filtrar lista de atividades', 'cne ');// Label for the table views hidden heading. Default is ‘Filter posts list’ / ‘Filter pages list’.
		$args['labels']['items_list_navigation'] = __( 'Navegação na lista de atividades', 'cne ');// Label for the table pagination hidden heading. Default is ‘Posts list navigation’ / ‘Pages list navigation’.
		$args['labels']['items_list'] = __( 'Lista de atividades', 'cne ');// Label for the table hidden heading. Default is ‘Posts list’ / ‘Pages list’.
		$args['labels']['item_published'] = __( 'Atividade publicada', 'cne ');// Label used when an item is published. Default is ‘Post published.’ / ‘Page published.’
		$args['labels']['item_published_privately'] = __( 'Atividade publicada de forma privada', 'cne ');// Label used when an item is published with private visibility. Default is ‘Post published privately.’ / ‘Page published privately.’
		$args['labels']['item_reverted_to_draft'] = __( 'Atividade mantida como rascunho', 'cne ');// Label used when an item is switched to a draft. Default is ‘Post reverted to draft.’ / ‘Page reverted to draft.’
		$args['labels']['item_trashed'] = __( 'Atividade na lixeira', 'cne ');// Label used when an item is moved to Trash. Default is ‘Post trashed.’ / ‘Page trashed.’
		$args['labels']['item_scheduled'] = __( 'Instituiçõe agendada', 'cne ');// Label used when an item is scheduled for publishing. Default is ‘Post scheduled.’ / ‘Page scheduled.’
		$args['labels']['item_updated'] = __( 'Atividade atualizada', 'cne ');// Label used when an item is updated. Default is ‘Post updated.’ / ‘Page updated.’
		$args['labels']['item_link'] = __( 'Link da atividade', 'cne ');// Title for a navigation link block variation. Default is ‘Post Link’ / ‘Page Link’.
		$args['labels']['item_link_description'] = __( 'Um link para uma atividade', 'cne ');// Description for a navigation link block variation. Default is ‘A link to a post.’ / ‘A link to a page.’
	}

    return $args;
}
add_filter('register_post_type_args', 'cne_list_collections_in_admin', 10, 2);

function cne_add_collections_to_toolbar($admin_bar) {
	
	// Busca por itens da coleção instituições para montar o menu
	$tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
	$instituicoes_args = [
		'posts_per_page'=> -1,
		'post_status' => 'publish',
		'author' => get_current_user_id(),
	];
	$instituicoes_items = $tainacan_items_repository->fetch($instituicoes_args, cne_get_instituicoes_collection_id(), 'WP_Query');
	$total_instituicoes = $instituicoes_items->found_posts;

	// Se houver apenas uma instituição, link direto pra ela
	if ( $total_instituicoes === 1) {

		while ( $instituicoes_items->have_posts() ) {
			$instituicoes_items->the_post();
			$admin_bar->add_menu( array(
				'id'    => 'instituicao-' . get_the_ID(),
				'title' => get_the_title(),
				'href'  =>  admin_url( 'admin.php?page=instituicao&id=' . get_the_ID() ),
				'meta'  => array(
					'title' => get_the_title()
				),
			));
			$admin_bar->add_menu( array(
				'parent' => 'instituicao-' . get_the_ID(),	
				'id'    => 'colecao-instituicoes',
				'title' => __( 'Todas as minhas instituições', 'cne' ),
				'href'  => admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() ),
				'meta'  => array(
					'title' => __( 'Todas as minhas instituições', 'cne' ),        
				),
			));
		}

	} else {
		
		// Adiciona coleção de instituições
		$admin_bar->add_menu( array(
			'id'    => 'colecao-instituicoes',
			'title' => __( 'Minhas instituições', 'cne' ),
			'href'  => admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() ),
			'meta'  => array(
				'title' => __( 'Minhas instituições', 'cne' ),        
			),
		));

		if ( $instituicoes_items->have_posts() ) {
			while ( $instituicoes_items->have_posts() ) {
				$instituicoes_items->the_post();
				$admin_bar->add_menu( array(
					'id'    => 'instituicao-' . get_the_ID(),
					'parent' => 'colecao-instituicoes',
					'title' => get_the_title(),
					'href'  =>  admin_url( 'admin.php?page=instituicao&id=' . get_the_ID() ),
					'meta'  => array(
						'title' => get_the_title()
					),
				));
			}
		}	
	}

	// Adiciona coleções de eventos
	$admin_bar->add_menu( array(
        'id'    => 'colecoes-eventos',
        'title' => __( 'Meus eventos', 'cne' ),
        'href'  => '',
        'meta'  => array(
            'title' => __( 'Meus eventos', 'cne' ),    
        ),
    ));

	$tainacan_collections_post_types = \Tainacan\Repositories\Repository::get_collections_db_identifiers();

	foreach ($tainacan_collections_post_types as $collection_post_type) {
		
		if ( $collection_post_type === cne_get_instituicoes_collection_post_type() )
			continue;

		$collection_object = get_post_type_object( $collection_post_type );
		
		if ( !current_user_can( str_replace('_item', '', $collection_post_type) . '_edit_items') && !current_user_can('tnc_col_all_edit_items') )
			continue;

		$admin_bar->add_menu( array(
			'id'    => 'colecao-evento-' . $collection_post_type,
			'parent' => 'colecoes-eventos',
			'title' => $collection_object->labels->name,
			'href'  => admin_url( 'edit.php?post_type=' . $collection_post_type ),
			'meta'  => array(
				'title' => $collection_object->labels->name,
				'class' => cne_get_evento_collection_post_type() == $collection_post_type ? 'evento-atual' : ''
			),
		));
	}
	
}
add_action('admin_bar_menu', 'cne_add_collections_to_toolbar', 100);


/* ----------------------------- INC IMPORTS  ----------------------------- */
require get_stylesheet_directory() . '/inc/gestor-tweaks.php';
require get_stylesheet_directory() . '/inc/customizer.php';
require get_stylesheet_directory() . '/inc/instituicao.php';
require get_stylesheet_directory() . '/inc/opcoes-das-colecoes.php';
require get_stylesheet_directory() . '/inc/hook-kit-digital-item.php';
//require get_stylesheet_directory() . '/inc/block-styles.php';
require get_stylesheet_directory() . '/inc/block-filters.php';

/* -------------------------- MUSEUSBR FETCHER -----------------*/
require get_stylesheet_directory() . '/museusbr-fetcher/museusbr-fetcher.php';
