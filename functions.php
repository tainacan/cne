<?php
if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

/**
 * Define o caminho para o arquivo de funções utilitárias, deve ser primeiro a ser incluído
 */
require get_stylesheet_directory() . '/inc/utils.php';

/* Demais funcionalidades do tema */
require get_stylesheet_directory() . '/inc/theme-tweaks.php';
require get_stylesheet_directory() . '/inc/admin-tweaks.php';
require get_stylesheet_directory() . '/inc/gestor-tweaks.php';
require get_stylesheet_directory() . '/inc/customizer.php';
require get_stylesheet_directory() . '/inc/preset-atividade.php';
require get_stylesheet_directory() . '/inc/instituicao.php';
require get_stylesheet_directory() . '/inc/opcoes-das-colecoes.php';
require get_stylesheet_directory() . '/inc/opcoes-das-secoes-de-metadados.php';
require get_stylesheet_directory() . '/inc/block-styles.php';
require get_stylesheet_directory() . '/inc/block-filters.php';
require get_stylesheet_directory() . '/inc/block-bindings.php';
require get_stylesheet_directory() . '/inc/instituicao-single-tweaks.php';
require get_stylesheet_directory() . '/inc/atividade-single-tweaks.php';
require get_stylesheet_directory() . '/inc/comprovante.php';

/**
 * Módulo da funcionalidade que implementa a importação de Instituições do MuseusBR 
 */
require get_stylesheet_directory() . '/museusbr-fetcher/museusbr-fetcher.php';
