<?php

/**
 * Alterações gerais feitas pelo tema que impactam na parte pública do site
 */

/**
 * Carregas estilos básicos do tema
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	
	wp_enqueue_style( 'cne-tainacan-icons', get_stylesheet_directory_uri() . '/assets/css/icons-tweaks.css', array(), wp_get_theme()->get('Version') );
	wp_enqueue_style( 'view-mode-cnegrid', get_stylesheet_directory_uri() . '/assets/css/view-mode-cnegrid.css', array(), wp_get_theme()->get('Version') );
	
	if ( is_page( 'cadastro' ) )
		wp_enqueue_script( 'cne-register-form-script', get_stylesheet_directory_uri() . '/assets/js/register-form.js', array(), wp_get_theme()->get('Version'), true );

	if ( is_singular() && cne_get_instituicoes_collection_post_type() == get_post_type() )
		wp_enqueue_style( 'cne-instituicao-single', get_stylesheet_directory_uri() . '/assets/css/instituicao-single.css', array(), wp_get_theme()->get('Version') );

	if ( is_singular() && cne_is_post_type_a_tainacan_collection( get_post_type() ) && cne_get_instituicoes_collection_post_type() != get_post_type() )
		wp_enqueue_style( 'cne-atividade-single', get_stylesheet_directory_uri() . '/assets/css/atividade-single.css', array(), wp_get_theme()->get('Version') );

	wp_enqueue_style( 'cne-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
});

/**
 * Lista somente os itens das coleções de eventos no nível repositório (Página da Agenda Cultural)
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

/* Registra modos de visualização Tainacan para o VisiteMuseus */
function cne_register_tainacan_view_modes() {
	if ( function_exists( 'tainacan_register_view_mode' ) ) {

		// Cartão de Atividades
		tainacan_register_view_mode('cnegrid', array(
			'label' => 'Cartão do Visite Museus',
			'description' => 'Uma grade de itens de atividades e instituições feita para o VisiteMUSEUS',
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewcards tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => false,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-cnegrid.php'
		));

		// Cartão de Instituição
		tainacan_register_view_mode('cnegrid2', array(
			'label' => 'Cartão de instituição',
			'description' => 'Uma grade de itens de instituições feita para o VisiteMUSEUS',
			'icon' => '<span class="icon"><i class="tainacan-icon tainacan-icon-viewrecords tainacan-icon-1-25em"></i></span>',
			'dynamic_metadata' => false,
			'template' => get_stylesheet_directory() . '/tainacan/view-mode-cnegrid.php'
		));
	}
}
add_action( 'after_setup_theme', 'cne_register_tainacan_view_modes' );

/* Define o novo cartões do VisiteMuseus como modo de visualização padrão */
function cne_set_default_view_mode($default) {
	if ( !is_admin() )
		return 'cnegrid';

	return $default;
}
add_filter( 'tainacan-default-view-mode-for-themes', 'cne_set_default_view_mode', 10, 1 );

/* Permite que apenas os cartões do VisiteMuseus estejam disponíveis como modos de visualição */
function cne_set_enabled_view_modes($registered_view_modes_slugs) {

	if ( !is_admin() )
		return [ 'cnegrid', 'cnegrid2' ];

	return $registered_view_modes_slugs;
}
add_filter( 'tainacan-enabled-view-modes-for-themes', 'cne_set_enabled_view_modes', 10, 1 );

/**
 * Adiciona a informação do post type nos cartões da busca. Isso ajuda a diferenciar
 * os tipos de conteúdo nas listagens genéricas
 */
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

/**
 * Adiciona classes ao body para identificar se o usuário está filtrando por uma coleção.
 * Com esta classe conseguimos esconder os filtros de data (nível repositório) no contexto
 * das listas de itens de termos usados pelas instituições.
 */
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

/**
 * Muda ícone de conta que aparece no cabeçalho do site
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

/* Desabilita os recursos de Google fontes do Blocksy já que ele não é necessário */
add_filter('blocksy:typography:google:use-remote', function () {
	return false;
});
add_filter('blocksy_typography_font_sources', function ($sources) {
	unset($sources['google']);
	return $sources;
});