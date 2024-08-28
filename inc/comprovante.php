<?php

if ( is_admin() && defined ('TAINACAN_VERSION') ) {
    new CNE_Comprovante_Page();
}

/**
 * CNE_Comprovante_Page classe para criar e exibir a página de um comprovante de participação
 */
class CNE_Comprovante_Page {

    private $id_instituicao = '';
    private $tainacan_items_repository = null;
    private $tainacan_collections_repository = null;
    private $tainacan_metadata_repository = null;

    /**
     * Constructor will create the menu item
     */
    public function __construct() {
        add_action( 'admin_menu', array($this, 'add_menu_comprovante_page' ));
        add_action( 'admin_print_styles-admin_page_comprovante', array( $this, 'admin_print_comprovante_custom_css' ) );
        add_filter( 'admin_title', array( $this, 'comprovante_admin_title' ), 10, 2);

        $this->tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
        $this->tainacan_collections_repository = \Tainacan\Repositories\Collections::get_instance();
        $this->tainacan_metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_comprovante_page() {
        add_submenu_page(
            '', // Definindo o parent como nulo para não criar um menu, apenas registrar a página
            'Comprovante',
            'Comprovante',
            'read',
            'comprovante',
            array($this, 'render_comprovante_page')
        );
    }

    /**
     * Change the admin title
     */
    function comprovante_admin_title($admin_title, $title) {
        
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'comprovante' )
            $admin_title = 'Comprovante de Inscrição';
        
        return $admin_title;
    }

    /**
     * Add the custom css to the page
     */
    function admin_print_comprovante_custom_css() {
        wp_dequeue_style( 'dashicons' );
        wp_dequeue_style( 'admin-bar' );
        wp_dequeue_style( 'common' );
        wp_dequeue_style( 'forms' );
        wp_dequeue_style( 'admin-menu' );
        wp_dequeue_style( 'dashboard' );
        wp_dequeue_style( 'edit' );
        wp_dequeue_style( 'revisions' );
        wp_dequeue_style( 'media' );
        wp_dequeue_style( 'nav-menus' );
        wp_dequeue_style( 'buttons' );
        wp_dequeue_style( 'cne-admin-style' );
        wp_enqueue_style(
            'cne-comprovante-style',
            get_stylesheet_directory_uri() . '/assets/css/comprovante.css',
            array(),
            wp_get_theme()->get('Version'),
            'print'
        );
    }

    /**
     * Display the page
     *
     * @return Void
     */
    public function render_comprovante_page() {

        if ( !isset($_GET['id']) ) {
            ?>  
                <div class="wrap">
                    <h1>Comprovante</h1>
                    <p>ID da instituição não informado.</p>
                </div>
            <?php
            
            return; 
        }

        $this->id_instituicao = $_GET['id'];
        
        $comprovante_items = $this->tainacan_items_repository->fetch( array( 'id' => $this->id_instituicao ), cne_get_instituicoes_collection_id() );

        if ( !$comprovante_items->have_posts() ) {
            ?>
                <div class="wrap">
                   <h1>Instituição não encontrada</h1>
                </div>
            <?php 

            return;
        }

        $comprovante_items->the_post();

        $current_evento_collection_id = cne_get_evento_collection_id();
        $current_evento_collection = $this->tainacan_collections_repository->fetch($current_evento_collection_id);

        if ( !( $current_evento_collection instanceof \Tainacan\Entities\Collection ) ) {
            ?>
                <h2>Evento</h2>
                <p>Nenhum evento configurado</p>
            <?php
            return;
        }

        wp_enqueue_style( 'cne-instituicao-single', get_stylesheet_directory_uri() . '/assets/css/instituicao-single.css', array(), wp_get_theme()->get('Version') );

        ?>
            <div class="comprovante-header">
                <div class="wrap">
                    <h1>Comprovante de Inscrição</h1>
                    <div class="comprovante-logo">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo.svg'; ?>" alt="Logo do Visite Museus" class="logo">
                        <p>Plataforma de promoção dos museus brasileiros</p>
                    </div>
                </div>
            </div>
            <div class="wrap single instituicao-admin-area" data-prefix="tnc_col_<?php echo cne_get_instituicoes_collection_id(); ?>_item_single">

                <?php $this->render_current_evento_section($current_evento_collection); ?>

                <?php $this->render_instituicao_section(); ?>

            </div>
            <div class="comprovante-footer">
                <div class="wrap">
                    <h1 style="text-transform: uppercase;">Instituto Brasileiro de Museus</h1>
                    <p>visitemuseus@museus.gov.br</p>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/regua_footer_comprovante.png'; ?>" alt="Logos do Sistema Braileiro de Museus, do Instituto Brasileiro de Museus e do Ministério da Cultura, Governo Federal." class="logo">
                </div>
            </div>
        <?php
    }

    function render_current_evento_section($current_evento_collection) {

		function cne_comprovante_date_without_year($date_format) {
			return 'd/m';
		}
		add_filter( 'pre_option_date_format', 'cne_comprovante_date_without_year');

        $metadata_objects = $this->tainacan_metadata_repository->fetch_by_collection(
            $current_evento_collection,
            [],
            'OBJECT'
        );
        $visible_metadata_objects = array_filter($metadata_objects, function($metadatum) {
            return $metadatum->get_display() === 'yes' && cne_get_instituicoes_relationship_metadata_id() != $metadatum->get_ID() ;
        });

        $items = cne_get_atividades(array(), $this->id_instituicao, [ $current_evento_collection->get_ID() ], get_current_user() );

        ?>
            <?php if ( $current_evento_collection->get_header_image_id() ) : ?>
                <img title="<?php echo $current_evento_collection->get_name(); ?>" class="instituicao-evento-banner" alt="<?php echo wp_get_attachment_caption( $current_evento_collection->get_header_image_id() ); ?>" src="<?php echo $current_evento_collection->get_header_image(); ?>">
            <?php endif; ?>

            <header class="entry-header">
                <div class="instituicao-title-and-thumbnail-container"> 
                    <p class="comprovante-intro">
                        A instituição <span style="text-transform: uppercase;"><?php the_title(); ?></span> está participando da <span style="text-transform: uppercase;"><?php echo $current_evento_collection->get_name(); ?></span>
                    </p>
                </div>
            </header>
            
            <h2 class="instituicao-atividade-heading" style="text-transform: uppercase;">Atividades inscritas no Evento</h2>

            <div class="evento-principal-dados">
                <?php if ( count($items) > 0 ) : ?>

                    <?php $this->render_activities_list($items, $visible_metadata_objects); ?>

                <?php endif; ?>
            </div>
        <?php
    }

    function render_activities_list($items, $metadata) {

        $visible_metadata_ids = array_map( function($metadatum) {
            return $metadatum->get_ID();
        }, $metadata );

        ?>
            <ul class="comprovante-lista-de-atividades">
                <?php foreach($items as $atividade) : ?>
                    <li>
                        <?php echo $atividade->get_title(); ?>,&nbsp;
                        <?php
                            echo tainacan_get_the_metadata(array(
                                'exclude_title' => true,
                                'metadata__in' => $visible_metadata_ids,
                                'before' => '<span class="metadata-type-$type" $id>',
                                'after' => ' </span>',
                                'before_title' => '<span class="screen-reader-text">',
                                'after_title' => '</span>',
                                'before_value' => '',
                                'after_value' => '',
                                'hide_empty' => true,
                            ), $atividade->get_ID() );
                        ?>
                    </li>
                 <?php endforeach; ?>
            </ul>
        <?php
    }

    function render_instituicao_section() {

        $metadata_args = array(
            'metadata__not_in' => [ 109069, 85282 ], // Ignora metadados de Geolocalização e Redes Sociais
            'exclude_core' => true,
            'display_slug_as_class' => true,
            'before' 				=> '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
            'after' 				=> '</div>',
            'before_title' => '<h4 class="tainacan-metadata-label">',
            'after_title' => '</h4>',
            'before_value' => '<p class="tainacan-metadata-value">',
            'after_value' => '</p>',
            'exclude_title' => true
        );

        $sections_args = array(
            'metadata_sections__in' => [ 112, 86 ], // Somente as seções de contato e endereço aparecem no comprovante
            'metadata_sections__not_in' => [ \Tainacan\Entities\Metadata_Section::$default_section_slug ],
            'before' => '<section class="tainacan-item-section tainacan-item-section--metadata">',
            'after' => '</section>',
            'before_name' => '<h3 class="tainacan-single-item-section" id="metadata-section-$slug">',
            'after_name' => '</h3>',
            'hide_name' => false,
            'before_metadata_list' => do_action( 'tainacan-blocksy-single-item-metadata-begin' ) . '<div class="tainacan-item-section__metadata metadata-type-1">',
            'after_metadata_list' => '</div>' . do_action( 'tainacan-blocksy-single-item-metadata-end' ),
            'metadata_list_args' => $metadata_args
        );
        ?>
            <div class="tainacan-item-single-page">
                <div class="tainacan-item-single tainacan-instituicao-single-body">
                    <h2 style="text-transform: uppercase;">Dados da instituição</h2> 
                    <div class="tainacan-item-section tainacan-item-section--metadata-sections">
                        <?php tainacan_the_metadata_sections( $sections_args ); ?>
                    </div>
                </div>
            </div>
        <?php
    }

}
