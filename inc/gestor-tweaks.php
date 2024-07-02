<?php
/**
 * Conjunto de filters e actions para o usuário tipo gestor de eventos
 * 
 */


/**
 * Função para checar se o usuário atual é um gestor de eventos
 */
function cne_user_is_gestor( $user = NULL ) {
	
	if ( !is_user_logged_in() )
			return false;

	if ( !isset($user) || $user === NULL )
		$user = wp_get_current_user();

	return is_user_logged_in() && in_array( CNE_GESTOR_DE_EVENTOS_ROLE, $user->roles ? $user->roles : [] );
}

/**
 * Altera o link de edição de posts de qualquer coleção Tainacan
 */
function cne_collection_edit_post_link( $url, $post_ID) {

	$post_type = get_post_type($post_ID);

	if ( cne_get_instituicoes_collection_post_type() == $post_type ) 
		$url = admin_url( 'admin.php?page=instituicao&id=' . $post_ID );
	else if ( cne_is_post_type_a_tainacan_collection( $post_type ) ) 
		$url = admin_url( '?page=tainacan_admin#/collections/' . cne_get_collection_id_from_post_type( $post_type ) . '/items/' . $post_ID . '/edit' );

    return $url;
}
add_filter( 'get_edit_post_link', 'cne_collection_edit_post_link', 10, 2 );

/**
 * Altera o link de criação de posts das coleções to tainacan
 */
function cne_collection_add_new_post( $url, $path) {

	if ( str_contains($path, "post-new.php") && str_contains( $path, 'post_type=tnc_col_' ) ) {
		$matches = [];
		preg_match('/post_type=tnc_col_(\d+)/', $path, $matches);
		
		if ( count($matches) < 2 )
			return $url;

		$collection_id = $matches[1];
		
		if ( is_nan($collection_id) )
			return $url;
		
		$url = admin_url( '?page=tainacan_admin#/collections/' . $collection_id . '/items/new' );
	}
	
    return $url;
}
add_filter( 'admin_url', 'cne_collection_add_new_post', 10, 2 );

/**
 * Redireciona o usuário após o login para a página de gestão das instituições
 */
function cne_instituicoes_login_redirect($redirect_url, $request, $user) {

	if ( cne_user_is_gestor($user) )
		return admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() );

	return $redirect_url;	
}	
add_filter('login_redirect', 'cne_instituicoes_login_redirect', 10, 3);

/**
 * Redireciona o usuário após o login via modal para a paǵina de gestão das instituições
 */
function cne_instituicoes_modal_login_redirect() {

	return admin_url( 'edit.php?post_type=' . cne_get_instituicoes_collection_post_type() );
}
add_filter('blocksy:account:modal:login:redirect_to', 'cne_instituicoes_modal_login_redirect');

/** 
 * Remove links desnecessários do menu admin
 */
function cne_menu_page_removing() {
    if ( cne_user_is_gestor() ) {
        remove_menu_page( 'tainacan_admin' );
        remove_menu_page( 'upload.php' );
	}
}
add_action( 'admin_menu', 'cne_menu_page_removing' );

/**
 * Lista somente os instituições do usuário atual, se ele for gestor
 */
function cne_pre_get_posts_admin( $query ) {
    if ( !is_admin() )
        return;

    if ( 
		$query->is_main_query() &&
		isset($query->query_vars['post_type']) &&
		cne_is_post_type_a_tainacan_collection($query->query_vars['post_type']) &&
		cne_user_is_gestor() 
	)
		$query->set( 'author', get_current_user_id() );
    
}
add_action( 'pre_get_posts', 'cne_pre_get_posts_admin' );

/**
 * Altera o link de criação de posts nas coleções do Tainacan
 */
function cne_instituicoes_collection_add_new_post_menu() {
	global $submenu;

	$instituicoes_collection_id = cne_get_instituicoes_collection_id();

	if ( isset($submenu['edit.php?post_type=tnc_col_' . $instituicoes_collection_id . '_item'][10]) && isset($submenu['edit.php?post_type=tnc_col_' . $instituicoes_collection_id . '_item'][10][2]) )
		$submenu['edit.php?post_type=tnc_col_' . $instituicoes_collection_id . '_item'][10][2] = admin_url( '?page=tainacan_admin#/collections/' . $instituicoes_collection_id . '/items/new' );

}
add_filter( 'admin_menu', 'cne_instituicoes_collection_add_new_post_menu', 10);

/**
 * Adiciona classe css ao Admin do WordPress para estilizar a página que lista das instituições
 */
function cne_custom_body_class($classes) {
	global $pagenow;

	if ( $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === cne_get_instituicoes_collection_post_type() )
        $classes .= ' post-type-cne-instituicoes';

	if ( cne_user_is_gestor() )
		$classes .= ' user-is-gestor';

    return $classes;
}
add_filter('admin_body_class', 'cne_custom_body_class');

/**
 * Remove dropdown de "opções da tela"
 */
function cne_remove_screen_options() { 	
	if ( cne_user_is_gestor() )
		return false; 
	return true;
}
add_filter('screen_options_show_screen', 'cne_remove_screen_options');

/*
 * Adiciona parâmetros para o Admin Tainacan para esconder elementos que não são necessários
 */
function cne_set_tainacan_admin_options($options) {
	
	if ( cne_user_is_gestor() ) {
		$options['hideTainacanHeader'] = true;
		$options['hidePrimaryMenu'] = true;
		$options['hideRepositorySubheader'] = true;
		$options['hideCollectionSubheader'] = true;
		$options['hideItemEditionCollectionName'] = true;
		$options['hideItemEditionCommentsToggle'] = true;
		$options['hideItemEditionCollapses'] = true;
		$options['hideItemEditionMetadataTypes'] = true;
		$options['hideItemSingleExposers'] = true;
		$options['hideItemSingleActivities'] = true;
	}
	return $options;
};
add_filter('tainacan-admin-ui-options', 'cne_set_tainacan_admin_options');

/** Adiciona mensagem de boas vindas ao título da lista de instituições */
function cne_add_welcome_message() {

	$current_screen = get_current_screen();
	
	if ( $current_screen && property_exists( $current_screen, 'parent_base' ) && property_exists( $current_screen, 'post_type' ) ) {
		
		$post_type = $current_screen->post_type;
		$parent_base = $current_screen->parent_base;

		if ( $parent_base === 'edit' && cne_get_instituicoes_collection_post_type() === $post_type ) : ?>
			<div class="cne-admin-welcome-panel">
				<h1><div class="welcome-intro">Boas vindas ao </div><img alt="Visite Museus" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo-tipo.svg'; ?>"></h1>
				<br>
				<p>
					Comece cadastrando sua instituição ou importando ela do MuseusBR, se for um Museu Cadastrado.<br>
					Uma vez cadastrada, você poderá adicionar atividades aos eventos da plataforma.
				</p>
			</div>
		<?php endif;
	}
}
add_action( 'admin_notices', 'cne_add_welcome_message', 10 );

