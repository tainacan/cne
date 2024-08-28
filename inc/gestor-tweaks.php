<?php
/**
 * Conjunto de filters e actions para o usuário tipo gestor de eventos
 * 
 */

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

/* Esconde várias opções de contato na página do perfil do usuário */
function cne_hide_user_contactmethods( $contactmethods ) {
	
	if ( cne_user_is_gestor() )
		return [];

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'cne_hide_user_contactmethods', 12, 1 );

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
 * Remove dropdown de "opções da tela"
 */
function cne_remove_screen_options() { 	
	if ( cne_user_is_gestor() )
		return false; 
	return true;
}
add_filter('screen_options_show_screen', 'cne_remove_screen_options');
