<?php

/**
 * Alterações feitas no comportamento do admin do WordPress que afetam todos os usuários
 */

/** 
 * Registra estilo do lado admin
 */
function cne_admin_enqueue_styles() {
	wp_enqueue_style( 'cne-admin-style', get_stylesheet_directory_uri() . '/admin.css', array(), wp_get_theme()->get('Version') );
		
	if ( cne_user_is_gestor() ) {
		wp_enqueue_style( 'cne-tainacan-icons', get_stylesheet_directory_uri() . '/assets/css/icons-tweaks.css', array(), wp_get_theme()->get('Version') );
		wp_enqueue_style( 'cne-gestor-admin-style', get_stylesheet_directory_uri() . '/assets/css/gestor-admin.css', array(), wp_get_theme()->get('Version') );
		
		wp_enqueue_script( 'cne-admin-script', get_stylesheet_directory_uri() . '/admin.js', array('wp-hooks'), wp_get_theme()->get('Version') );
		
		wp_localize_script( 'cne-admin-script', 'cne_theme', array(
			'instituicoes_collection_id' => cne_get_instituicoes_collection_id(),
			'instituicao_admin_url' => admin_url( 'admin.php?page=instituicao'),
			'edit_admin_url' => admin_url( 'edit.php'),
		) );
	}
}
add_action( 'admin_enqueue_scripts', 'cne_admin_enqueue_styles', 3 );

/**
 * Filtra as colunas que aparecem de algumas coleções
 */
function cne_manage_collections_table_columns() {

	if ( !defined ('TAINACAN_VERSION') )
		return;

	$tainacan_collections_post_types = \Tainacan\Repositories\Repository::get_collections_db_identifiers();

	foreach ($tainacan_collections_post_types as $collection_post_type) {

		add_filter( 'manage_' . $collection_post_type . '_posts_columns', function($columns) use ($collection_post_type) {
			
			unset($columns['comments']);
			
			if ( $collection_post_type === cne_get_instituicoes_collection_post_type() )  {

				$tainacan_collections_repository = \Tainacan\Repositories\Collections::get_instance();   
				
				$current_evento_collection_id = cne_get_evento_collection_id();
				$current_evento_collection = $tainacan_collections_repository->fetch($current_evento_collection_id);
				
				if ( !( $current_evento_collection instanceof \Tainacan\Entities\Collection ) ) {
					return $columns;
				} else {
					$columns['current_evento'] = $current_evento_collection->get_name();
					return $columns;
				}
			}

			unset($columns['date']);
			
			return array_merge($columns, array(
				'description' => 'Descrição'
			));

		}, 10, 1 );

		add_action('manage_' . $collection_post_type . '_posts_custom_column', function($column_key, $post_id) {
			
			if ( $column_key == 'description' ) {
				echo get_the_excerpt($post_id);
			}
			if ( $column_key == 'current_evento' ) {
				$current_evento_collection_id = cne_get_evento_collection_id();
				?>
				<a class="page-title-action button button-primary cne-button-cta wp-button-with-icon" href="<?php echo admin_url( '?from-instituicao=' . $post_id . '&page=tainacan_admin#/collections/' . $current_evento_collection_id . '/items/new' );  ?>">
					Cadastrar nova atividade &nbsp;
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M12 8V16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M8 12H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>
				<?php
			}
			
		}, 10, 2);
	}
}
add_action('admin_init', 'cne_manage_collections_table_columns', 10);

/* Função para remover a edição em linha (Edição rápida) das tabelas padrão do WordPress */
function cne_remove_quick_edit( $actions ) {
	unset($actions['inline hide-if-no-js']);
	return $actions;
}

/**
 * Altera os rótulos de post types do Tainacan e altera algumas tabelas padrão do WordPress
 */
function cne_list_collections_in_admin($args, $post_type) {
	
	if ( !defined ('TAINACAN_VERSION') )
		return $args;

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
		$args['labels']['name'] = 'Instituições';// General name for the post type, usually plural. The same and overridden by $post_type_object->label. Default is ‘Posts’ / ‘Pages’.
		$args['labels']['singular_name'] = 'Instituição';// Name for one object of this post type. Default is ‘Post’ / ‘Page’.
		$args['labels']['add_new'] = 'Adicionar nova';// Label for adding a new item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['add_new_item'] = 'Adicionar nova instituição';// Label for adding a new singular item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['edit_item'] = 'Editar instituição';// Label for editing a singular item. Default is ‘Edit Post’ / ‘Edit Page’.
		$args['labels']['new_item'] = 'Nova instituição';// Label for the new item page title. Default is ‘New Post’ / ‘New Page’.
		$args['labels']['view_item'] = 'Ver instituição';// Label for viewing a singular item. Default is ‘View Post’ / ‘View Page’.
		$args['labels']['view_items'] = 'Ver instituições';// Label for viewing post type archives. Default is ‘View Posts’ / ‘View Pages’.
		$args['labels']['search_items'] = 'Pesquisar instituições';// Label for searching plural items. Default is ‘Search Posts’ / ‘Search Pages’.
		$args['labels']['not_found'] = 'Nenhuma instituição encontrada';// Label used when no items are found. Default is ‘No posts found’ / ‘No pages found’.
		$args['labels']['not_found_in_trash'] = 'Nenhuma instituição na lixeira';// Label used when no items are in the Trash. Default is ‘No posts found in Trash’ / ‘No pages found in Trash’.
		$args['labels']['all_items'] = 'Todas as instituições';// Label to signify all items in a submenu link. Default is ‘All Posts’ / ‘All Pages’.
		$args['labels']['archives'] = 'Lista de instituições';// Label for archives in nav menus. Default is ‘Post Archives’ / ‘Page Archives’.
		$args['labels']['attributes'] = 'Dados das instituições';// Label for the attributes meta box. Default is ‘Post Attributes’ / ‘Page Attributes’.
		$args['labels']['insert_into_item'] = 'Inserir na instituição';// Label for the media frame button. Default is ‘Insert into post’ / ‘Insert into page’.
		$args['labels']['uploaded_to_this_item'] = 'Enviado para essa instituição';// Label for the media frame filter. Default is ‘Uploaded to this post’ / ‘Uploaded to this page’.
		$args['labels']['filter_items_list'] = 'Filtrar lista de instituições';// Label for the table views hidden heading. Default is ‘Filter posts list’ / ‘Filter pages list’.
		$args['labels']['items_list_navigation'] = 'Navegação na lista de instituições';// Label for the table pagination hidden heading. Default is ‘Posts list navigation’ / ‘Pages list navigation’.
		$args['labels']['items_list'] = 'Lista de instituições';// Label for the table hidden heading. Default is ‘Posts list’ / ‘Pages list’.
		$args['labels']['item_published'] = 'Instituição publicada';// Label used when an item is published. Default is ‘Post published.’ / ‘Page published.’
		$args['labels']['item_published_privately'] = 'Instituição publicada de forma privada';// Label used when an item is published with private visibility. Default is ‘Post published privately.’ / ‘Page published privately.’
		$args['labels']['item_reverted_to_draft'] = 'Instituição mantida como rascunho';// Label used when an item is switched to a draft. Default is ‘Post reverted to draft.’ / ‘Page reverted to draft.’
		$args['labels']['item_trashed'] = 'Instituição na lixeira';// Label used when an item is moved to Trash. Default is ‘Post trashed.’ / ‘Page trashed.’
		$args['labels']['item_scheduled'] = 'Instituiçõe agendada';// Label used when an item is scheduled for publishing. Default is ‘Post scheduled.’ / ‘Page scheduled.’
		$args['labels']['item_updated'] = 'Instituição atualizada';// Label used when an item is updated. Default is ‘Post updated.’ / ‘Page updated.’
		$args['labels']['item_link'] = 'Link da instituição';// Title for a navigation link block variation. Default is ‘Post Link’ / ‘Page Link’.
		$args['labels']['item_link_description'] = 'Um link para uma instituição';// Description for a navigation link block variation. Default is ‘A link to a post.’ / ‘A link to a page.’
    } else if ( array_search($post_type, $tainacan_collections_post_types) !== false ) {
		$args['show_ui'] = true;
		$args['labels']['add_new'] = 'Adicionar nova atividade';// Label for adding a new item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['add_new_item'] = 'Adicionar nova atividade';// Label for adding a new singular item. Default is ‘Add New Post’ / ‘Add New Page’.
		$args['labels']['edit_item'] = 'Editar atividade';// Label for editing a singular item. Default is ‘Edit Post’ / ‘Edit Page’.
		$args['labels']['new_item'] = 'Nova atividade';// Label for the new item page title. Default is ‘New Post’ / ‘New Page’.
		$args['labels']['view_item'] = 'Ver atividade';// Label for viewing a singular item. Default is ‘View Post’ / ‘View Page’.
		$args['labels']['view_items'] = 'Ver atividades';// Label for viewing post type archives. Default is ‘View Posts’ / ‘View Pages’.
		$args['labels']['search_items'] = 'Pesquisar atividades';// Label for searching plural items. Default is ‘Search Posts’ / ‘Search Pages’.
		$args['labels']['not_found'] = 'Nenhuma atividade encontrada';// Label used when no items are found. Default is ‘No posts found’ / ‘No pages found’.
		$args['labels']['not_found_in_trash'] = 'Nenhuma atividade na lixeira';// Label used when no items are in the Trash. Default is ‘No posts found in Trash’ / ‘No pages found in Trash’.
		$args['labels']['all_items'] = 'Todas as atividades';// Label to signify all items in a submenu link. Default is ‘All Posts’ / ‘All Pages’.
		$args['labels']['archives'] = 'Lista de atividades';// Label for archives in nav menus. Default is ‘Post Archives’ / ‘Page Archives’.
		$args['labels']['attributes'] = 'Dados das atividades';// Label for the attributes meta box. Default is ‘Post Attributes’ / ‘Page Attributes’.
		$args['labels']['insert_into_item'] = 'Inserir na atividade';// Label for the media frame button. Default is ‘Insert into post’ / ‘Insert into page’.
		$args['labels']['uploaded_to_this_item'] = 'Enviado para essa atividade';// Label for the media frame filter. Default is ‘Uploaded to this post’ / ‘Uploaded to this page’.
		$args['labels']['filter_items_list'] = 'Filtrar lista de atividades';// Label for the table views hidden heading. Default is ‘Filter posts list’ / ‘Filter pages list’.
		$args['labels']['items_list_navigation'] = 'Navegação na lista de atividades';// Label for the table pagination hidden heading. Default is ‘Posts list navigation’ / ‘Pages list navigation’.
		$args['labels']['items_list'] = 'Lista de atividades';// Label for the table hidden heading. Default is ‘Posts list’ / ‘Pages list’.
		$args['labels']['item_published'] = 'Atividade publicada';// Label used when an item is published. Default is ‘Post published.’ / ‘Page published.’
		$args['labels']['item_published_privately'] = 'Atividade publicada de forma privada';// Label used when an item is published with private visibility. Default is ‘Post published privately.’ / ‘Page published privately.’
		$args['labels']['item_reverted_to_draft'] = 'Atividade mantida como rascunho';// Label used when an item is switched to a draft. Default is ‘Post reverted to draft.’ / ‘Page reverted to draft.’
		$args['labels']['item_trashed'] = 'Atividade na lixeira';// Label used when an item is moved to Trash. Default is ‘Post trashed.’ / ‘Page trashed.’
		$args['labels']['item_scheduled'] = 'Instituiçõe agendada';// Label used when an item is scheduled for publishing. Default is ‘Post scheduled.’ / ‘Page scheduled.’
		$args['labels']['item_updated'] = 'Atividade atualizada';// Label used when an item is updated. Default is ‘Post updated.’ / ‘Page updated.’
		$args['labels']['item_link'] = 'Link da atividade';// Title for a navigation link block variation. Default is ‘Post Link’ / ‘Page Link’.
		$args['labels']['item_link_description'] = 'Um link para uma atividade';// Description for a navigation link block variation. Default is ‘A link to a post.’ / ‘A link to a page.’
	}

	// Remove da maioria dos post types a opção de edição em linha na tabela
	add_filter('post_row_actions','cne_remove_quick_edit', 10, 1);
	add_filter('page_row_actions','cne_remove_quick_edit', 10, 1);
	add_filter('tag_row_actions','cne_remove_quick_edit', 10, 1);
	add_filter('user_row_actions','cne_remove_quick_edit', 10, 1);
	add_filter('media_row_actions','cne_remove_quick_edit', 10, 1);
	foreach ($tainacan_collections_post_types as $collection_post_type) {
		add_filter($collection_post_type . '_row_actions','cne_remove_quick_edit', 10, 1);
	}

    return $args;
}
add_filter('register_post_type_args', 'cne_list_collections_in_admin', 10, 2);



/**
 * Adiciona coleções do Tainacan ao menu de administração
 */
function cne_add_collections_to_toolbar($admin_bar) {

	if ( !defined ('TAINACAN_VERSION') )
		return;
	
	// Busca por itens da coleção instituições para montar o menu
	$tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
	$instituicoes_args = [
		'posts_per_page'=> -1,
		'post_status' => 'any',
		'author' => get_current_user_id(),
	];
	$instituicoes_items = $tainacan_items_repository->fetch($instituicoes_args, cne_get_instituicoes_collection_id(), 'WP_Query');
	$total_instituicoes = $instituicoes_items->found_posts;

	$admin_bar->add_menu( array(	
		'id'    => 'colecao-instituicoes',
		'title' => 'Gestão de instituições',
		'href'  => admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() ),
		'meta'  => array(
			'title' => 'Acesse a página que lista todas as suas instituições',        
		),
	));

	// Se houver apenas uma instituição, link direto pra ela
	if ( $total_instituicoes === 1) {

		while ( $instituicoes_items->have_posts() ) {
			$instituicoes_items->the_post();
			$admin_bar->add_menu( array(
				'id'    => 'instituicao-' . get_the_ID(),
				'title' => 'Minha instituição',
				'href'  =>  admin_url( 'admin.php?page=instituicao&id=' . get_the_ID() ),
				'meta'  => array(
					'title' => get_the_title()
				),
			));
		}

	} else {
		
		// Adiciona coleção de instituições
		$admin_bar->add_menu( array(
			'id'    => 'lista-instituicoes',
			'title' => 'Minhas instituições',
			'href'  => admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() ),
			'meta'  => array(
				'title' => 'Minhas instituições',        
			),
		));

		if ( $instituicoes_items->have_posts() ) {
			while ( $instituicoes_items->have_posts() ) {
				$instituicoes_items->the_post();
				$admin_bar->add_menu( array(
					'id'    => 'instituicao-' . get_the_ID(),
					'parent' => 'lista-instituicoes',
					'title' => get_the_title(),
					'href'  =>  admin_url( 'admin.php?page=instituicao&id=' . get_the_ID() ),
					'meta'  => array(
						'title' => get_the_title()
					),
				));
			}
		}	
	}

	if ( !cne_user_is_gestor() ) {

		// Adiciona coleções de eventos
		$admin_bar->add_menu( array(
			'id'    => 'colecoes-eventos',
			'title' => 'Eventos', 'cne',
			'href'  => '',
			'meta'  => array(
				'title' => 'Eventos', 'cne',    
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
	} else {
		$admin_bar->remove_menu('archive');
	}

	wp_reset_postdata();
	wp_reset_query();
	
}
add_action('admin_bar_menu', 'cne_add_collections_to_toolbar', 100);

/* Permite o upload de imagens JFIF */
function cne_add_jfif_files($mimes){
    $mimes['jfif'] = "image/jpeg";
    return $mimes;
}
add_filter('mime_types', 'cne_add_jfif_files');