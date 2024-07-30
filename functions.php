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
	
	wp_enqueue_style( 'cne-tainacan-icons', get_stylesheet_directory_uri() . '/icons.css', array(), wp_get_theme()->get('Version') );
	wp_enqueue_style( 'view-mode-cnegrid', get_stylesheet_directory_uri() . '/assets/css/view-mode-cnegrid.css', array(), wp_get_theme()->get('Version') );
	
	if ( is_page( 'cadastro' ) )
		wp_enqueue_script( 'cne-register-form-script', get_stylesheet_directory_uri() . '/assets/js/register-form.js', array(), wp_get_theme()->get('Version'), true );

	if ( is_singular() && cne_get_instituicoes_collection_post_type() == get_post_type() )
		wp_enqueue_style( 'cne-instituicao-single', get_stylesheet_directory_uri() . '/assets/css/instituicao-single.css', array(), wp_get_theme()->get('Version') );

	if ( is_singular() && cne_is_post_type_a_tainacan_collection( get_post_type() ) && cne_get_instituicoes_collection_post_type() != get_post_type() )
		wp_enqueue_style( 'cne-atividade-single', get_stylesheet_directory_uri() . '/assets/css/atividade-single.css', array(), wp_get_theme()->get('Version') );

	wp_enqueue_style( 'cne-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
	wp_enqueue_script( 'cne-feather-icons', 'https://unpkg.com/feather-icons', array(), wp_get_theme()->get('Version') );
});

/** 
 * Registra estilo do lado admin
 */
function cne_admin_enqueue_styles() {
	wp_enqueue_style( 'cne-admin-style', get_stylesheet_directory_uri() . '/admin.css', array(), wp_get_theme()->get('Version') );
		
	if ( cne_user_is_gestor() ) {
		wp_enqueue_script( 'cne-feather-icons', 'https://unpkg.com/feather-icons', array(), wp_get_theme()->get('Version') );
		wp_enqueue_style( 'cne-tainacan-icons', get_stylesheet_directory_uri() . '/icons.css', array(), wp_get_theme()->get('Version') );
		wp_enqueue_style( 'cne-gestor-admin-style', get_stylesheet_directory_uri() . '/assets/css/gestor-admin.css', array(), wp_get_theme()->get('Version') );
		
		wp_enqueue_script( 'cne-admin-script', get_stylesheet_directory_uri() . '/admin.js', array('wp-hooks', 'cne-feather-icons'), wp_get_theme()->get('Version') );
		
		wp_localize_script( 'cne-admin-script', 'cne_theme', array(
			'instituicoes_collection_id' => cne_get_instituicoes_collection_id(),
			'instituicao_admin_url' => admin_url( 'admin.php?page=instituicao'),
			'edit_admin_url' => admin_url( 'edit.php'),
		) );
	}
}
add_action( 'admin_enqueue_scripts', 'cne_admin_enqueue_styles', 3 );

/**
 * Lista somente os itens das coleções de eventos no nível repositório
 */
function cne_fetch_args_posts_items_repository( $args, $entity ) {
	
	if ( $entity !== 'items' || !isset($args['post_type']) || count($args['post_type']) <= 1 )
		return $args;

	$referer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	if ( !empty($referer_url) ) {
		$path_string = parse_url($referer_url, PHP_URL_PATH);
		
		if ( $path_string === '/itens/' || $path_string === '/items/') {
			$args['post_type'] = array_filter(
				$args['post_type'], 
				function($collection_post_type) {
					return $collection_post_type !== cne_get_instituicoes_collection_post_type();
				}
			);
		}
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
				'description' => __('Descrição', 'cne')
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
					<?php _e('Cadastrar nova atividade', 'cne'); ?>
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

/* Função para remover a edição em linha (Edição rápida) das tabelas padrão do WordPress */
function cne_remove_quick_edit( $actions ) {
	unset($actions['inline hide-if-no-js']);
	return $actions;
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

function cne_add_collections_to_toolbar($admin_bar) {
	
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
		'title' => __( 'Gestão de instituições', 'cne' ),
		'href'  => admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() ),
		'meta'  => array(
			'title' => __( 'Acesse a página que lista todas as suas instituições', 'cne' ),        
		),
	));

	// Se houver apenas uma instituição, link direto pra ela
	if ( $total_instituicoes === 1) {

		while ( $instituicoes_items->have_posts() ) {
			$instituicoes_items->the_post();
			$admin_bar->add_menu( array(
				'id'    => 'instituicao-' . get_the_ID(),
				'title' => __( 'Minha instituição', 'cne' ),
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
			'title' => __( 'Eventos', 'cne' ),
			'href'  => '',
			'meta'  => array(
				'title' => __( 'Eventos', 'cne' ),    
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

/**
 * Muda ícone de conta 
 */
add_filter('blocksy:header:account:icons', function ($icon) {
    $icon['type-1'] = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<mask id="mask0_669_2704" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
			<rect width="24" height="24" fill="var(--theme-icon-color, var(--theme-text-color))"/>
		</mask>
		<g mask="url(#mask0_669_2704)">
			<path d="M5 17V10H7V17H5ZM11 17V10H13V17H11ZM2 21V19H22V21H2ZM17 17V10H19V17H17ZM2 8V6L12 1L22 6V8H2ZM6.45 6H17.55L12 3.25L6.45 6Z" fill="var(--theme-icon-color, var(--theme-text-color))"/>
		</g>
	</svg>';
    return $icon;
});

/* Registra modos de visualização */
function cne_register_tainacan_view_modes() {
	if ( function_exists( 'tainacan_register_view_mode' ) ) {

		// Grid
		tainacan_register_view_mode('cnegrid', array(
			'label' => __( 'Cartão do Visite Museus', 'cne' ),
			'description' => __( 'Uma grade de itens de atividades e instituições feita para o VisiteMUSEUS', 'cne' ),
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewcards tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => false,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-cnegrid.php'
		));

		// Grid 2
		tainacan_register_view_mode('cnegrid2', array(
			'label' => __( 'Cartão de instituição', 'cne' ),
			'description' => __( 'Uma grade de itens de instituições feita para o VisiteMUSEUS', 'cne' ),
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewrecords tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => false,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-cnegrid.php'
		));
	}
}
add_action( 'after_setup_theme', 'cne_register_tainacan_view_modes' );

/* Define o novo Cartões como modo de visualização padrão */
function cne_set_default_view_mode($default) {
	if ( !is_admin() )
		return 'cnegrid';

	return $default;
}
add_filter( 'tainacan-default-view-mode-for-themes', 'cne_set_default_view_mode', 10, 1 );
function cne_set_enabled_view_modes($registered_view_modes_slugs) {

	if ( !is_admin() )
		return [ 'cnegrid', 'cnegrid2' ];

	return $registered_view_modes_slugs;
}
add_filter( 'tainacan-enabled-view-modes-for-themes', 'cne_set_enabled_view_modes', 10, 1 );

/* Desabilita Google fontes já que ele não é necessário */
add_filter('blocksy:typography:google:use-remote', function () {
	return false;
});
add_filter('blocksy_typography_font_sources', function ($sources) {
	unset($sources['google']);
	return $sources;
});

/* Adiciona a informação do post type nos cartões da busca */
function cne_add_post_type_to_card() {
	if ( is_search() ) {
		$post_type_object = get_post_type_object( get_post_type() );

		if ( !$post_type_object )
			return;

		if ( !$post_type_object->labels || !$post_type_object->labels->singular_name )
			return;

		$post_type_label = $post_type_object->labels->singular_name;
		?>
		<ul class="entry-meta" data-type="simple:slash" data-id="meta_2">
			<li class="meta-post-type" itemprop="type">
				<span itemprop="name"> <?php echo $post_type_label; ?></span>
			</li>
		</ul>
		<?php
	}
}
add_action('blocksy:loop:card:end', 'cne_add_post_type_to_card', 10);

function cne_add_collection_id_filtering_to_body_class( $classes ) {
	$current_metaquery = isset($_GET['metaquery']) ? $_GET['metaquery'] : false;

	if ( !$current_metaquery || !count( $current_metaquery ) )
		return $classes;

	foreach( $current_metaquery as $metaquery ) {
		if ( isset($metaquery['value']) && isset($metaquery['key']) && $metaquery['key'] === 'collection_id' ) {
			if ( is_array( $metaquery['value'] ) ) {
				foreach ($metaquery['value'] as $value) {
					$classes[] = 'filtered-by-collection-' . $value;
				}
			} else {
				$classes[] = 'filtered-by-collection-' . $metaquery['value'];
			}

			break;
		}
	}

	return $classes;
}
add_filter( 'body_class', 'cne_add_collection_id_filtering_to_body_class' );

/* Permite o upload de imagens JFIF */
function cne_add_jfif_files($mimes){
    $mimes['jfif'] = "image/jpeg";
    return $mimes;
}
add_filter('mime_types', 'cne_add_jfif_files');

/* ----------------------------- INC IMPORTS  ----------------------------- */
require get_stylesheet_directory() . '/inc/gestor-tweaks.php';
require get_stylesheet_directory() . '/inc/customizer.php';
require get_stylesheet_directory() . '/inc/instituicao.php';
require get_stylesheet_directory() . '/inc/opcoes-das-colecoes.php';
//require get_stylesheet_directory() . '/inc/block-styles.php';
require get_stylesheet_directory() . '/inc/block-filters.php';
require get_stylesheet_directory() . '/inc/block-bindings.php';
require get_stylesheet_directory() . '/inc/instituicao-single-tweaks.php';
require get_stylesheet_directory() . '/inc/atividade-single-tweaks.php';
require get_stylesheet_directory() . '/inc/comprovante.php';

/* -------------------------- MUSEUSBR FETCHER -----------------*/
require get_stylesheet_directory() . '/museusbr-fetcher/museusbr-fetcher.php';
