<?php

if ( is_admin() && defined ('TAINACAN_VERSION') ) {
    new CNE_Instituicao_Page();
}

/**
 * CNE_Instituicao_Page classe para criar e exibir a página de uma instituição
 */
class CNE_Instituicao_Page
{

    private $id_instituicao = '';
    private $tainacan_collections_repository = null;
    private $tainacan_metadata_repository = null;
    private $tainacan_items_repository = null;

    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_menu_instituicao_page'));
        $this->tainacan_collections_repository = \Tainacan\Repositories\Collections::get_instance();
        $this->tainacan_metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
        $this->tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_instituicao_page()
    {
        add_submenu_page(
            '', // Definindo o parent como nulo para não criar um menu, apenas registrar a página
            'Instituição',
            'Instituição',
            'read',
            'instituicao',
            array($this, 'render_instituicao_page')
        );
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function render_instituicao_page()
    {

        wp_enqueue_style('cne-instituicao-single', get_stylesheet_directory_uri() . '/assets/css/instituicao-single.css', array(), wp_get_theme()->get('Version'));

        if (!isset($_GET['id'])) {
            ?>
            <div class="wrap">
                <h1>Instituicao</h1>
                <p>ID da instituição não informado.</p>
            </div>
            <?php
            return;
        }

        $this->id_instituicao = $_GET['id'];

        $instituicao_items = $this->tainacan_items_repository->fetch(array('id' => $this->id_instituicao), cne_get_instituicoes_collection_id());

        if (!$instituicao_items->have_posts()) {
        ?>
            <div class="wrap">
                <h1>Instituicao</h1>
                <p>Instituição não encontrada</p>
            </div>
        <?php

            return;
        }

        $instituicao_items->the_post();

        ?>
        <div class="wrap single instituicao-admin-area" data-prefix="tnc_col_<?php echo cne_get_instituicoes_collection_id(); ?>_item_single">
            <header class="entry-header">
                <div class="instituicao-title-and-thumbnail-container">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('tainacan-medium', array('class' => 'instituicao-thumbnail')); ?>
                    <?php endif; ?>

                    <h1 class="page-title">
                        <?php the_title(); ?>
                    </h1>

                    <a class="wp-button-with-icon button button-primary cne-button-cta" href="<?php echo get_permalink();  ?>">
                        Ver instituição publicada &nbsp;
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <div>
                        <div class="instituicao-status">
                            <?php
                            switch (get_post_status()) {
                                case 'publish':
                                    echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 11.0801V12.0001C21.9988 14.1565 21.3005 16.2548 20.0093 17.9819C18.7182 19.7091 16.9033 20.9726 14.8354 21.584C12.7674 22.1954 10.5573 22.122 8.53447 21.3747C6.51168 20.6274 4.78465 19.2462 3.61096 17.4372C2.43727 15.6281 1.87979 13.4882 2.02168 11.3364C2.16356 9.18467 2.99721 7.13643 4.39828 5.49718C5.79935 3.85793 7.69279 2.71549 9.79619 2.24025C11.8996 1.76502 14.1003 1.98245 16.07 2.86011" stroke="#218963" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M22 4L12 14.01L9 11.01" stroke="#218963" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>';
                                    echo '<span style="color: #218963;">Publicado</span>';
                                    break;
                                case 'draft':
                                    echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="#9B9B9B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.5 2.49998C18.8978 2.10216 19.4374 1.87866 20 1.87866C20.5626 1.87866 21.1022 2.10216 21.5 2.49998C21.8978 2.89781 22.1213 3.43737 22.1213 3.99998C22.1213 4.56259 21.8978 5.10216 21.5 5.49998L12 15L8 16L9 12L18.5 2.49998Z" stroke="#9B9B9B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>';
                                    echo '<span style="color: #9B9B9B;">Rascunho</span>';
                                    break;
                                case 'auto-draft':
                                    echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 18V22" stroke="#3C4D76" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.2402 16.24L19.0702 19.07" stroke="#3C4D76" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4.92969 19.07L7.75969 16.24" stroke="#9B9B9B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18 12H22" stroke="#3C4D76" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2 12H6" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.2402 7.75993L19.0702 4.92993" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4.92969 4.92993L7.75969 7.75993" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 2V6" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>';
                                    echo '<span style="color: #3C4D76;">Rascunho automático</span>';
                                    break;
                                case 'private':
                                    echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="#3A3A3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>';
                                    echo '<span>Privado</span>';
                                    break;
                                case 'trash':
                                    echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 6H5H21" stroke=#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke=#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14 11V17" stroke=#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10 11V17" stroke=#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>';
                                    echo '<span style="color: #970E05;">Lixeira</span>';
                                    break;
                            }
                            ?>
                        </div>
                        <?php

                        if ( !function_exists('tainacan_get_item') )
                            return;
                        
                        $item = tainacan_get_item();

                        if ($item->can_edit()) {
                            $url = $item->get_edit_url();

                            if ($url) : ?>
                                <a class="page-title-action wp-button-with-icon" href="<?php echo esc_url($url); ?>">
                                    Editar dados &nbsp;
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="#01174E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M18.5 2.50023C18.8978 2.1024 19.4374 1.87891 20 1.87891C20.5626 1.87891 21.1022 2.1024 21.5 2.50023C21.8978 2.89805 22.1213 3.43762 22.1213 4.00023C22.1213 4.56284 21.8978 5.1024 21.5 5.50023L12 15.0002L8 16.0002L9 12.0002L18.5 2.50023Z" stroke="#01174E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        <?php } ?>
                    </div>
                </div>
                <!-- <div class="instituicao-main-section">      
                        <?php the_excerpt(); ?>
                    </div> -->
            </header>

            <?php
            // $this->render_instituicao_section();
            ?>
            <!--                 
                <div class="instituicao-aviso-area"> 
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 16H12.01" stroke="#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 8V12" stroke="#970E05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p>AVISO: As informações fornecidas são de total responsabilidade da Instituição.</p>
                </div> -->

            <hr>

            <?php $this->render_current_evento_section(); ?>
        </div>
    <?php
    }

    function render_instituicao_section()
    {

        $metadata_args = array(
            'metadata__not_in' => [20, 1192], // Descrição e a SIGLA
            'exclude_core' => true,
            'display_slug_as_class' => true,
            'before'                 => '<div class="tainacan-item-section__metadatum metadata-type-$type" id="$id">',
            'after'                 => '</div>',
            'before_title' => '<h3 class="tainacan-metadata-label">',
            'after_title' => '</h3>',
            'before_value' => '<p class="tainacan-metadata-value">',
            'after_value' => '</p>',
            'exclude_title' => true
        );

        $sections_args = array(
            'before' => '<section class="tainacan-item-section tainacan-item-section--metadata">',
            'after' => '</section>',
            'before_name' => '<h2 class="tainacan-single-item-section" id="metadata-section-$slug">',
            'after_name' => '</h2>',
            'hide_name' => false,
            'before_metadata_list' => do_action('tainacan-blocksy-single-item-metadata-begin') . '<div class="tainacan-item-section__metadata metadata-type-1">',
            'after_metadata_list' => '</div>' . do_action('tainacan-blocksy-single-item-metadata-end'),
            'metadata_list_args' => $metadata_args
        );
    ?>
        <div class="tainacan-item-single-page">
            <div class="tainacan-item-single tainacan-instituicao-single-body">
                <div class="tainacan-item-section tainacan-item-section--metadata-sections">
                    <?php tainacan_the_metadata_sections($sections_args); ?>
                </div>
            </div>
        </div>
        <?php
    }

    function render_current_evento_section()
    {
        $current_evento_collection_id = cne_get_evento_collection_id();
        $current_evento_collection = $this->tainacan_collections_repository->fetch($current_evento_collection_id);

        if (!($current_evento_collection instanceof \Tainacan\Entities\Collection)) {
        ?>
            <h2>Evento</h2>
            <p>Nenhum evento configurado</p>
        <?php
            return;
        }

        $metadata_objects = $this->tainacan_metadata_repository->fetch_by_collection(
            $current_evento_collection,
            [],
            'OBJECT'
        );
        $visible_metadata_objects = array_filter($metadata_objects, function ($metadatum) {
            return $metadatum->get_display() === 'yes' && cne_get_instituicoes_relationship_metadata_id() != $metadatum->get_ID();
        });

        $items = cne_get_atividades(array(['post_status' => 'any']), $this->id_instituicao, [$current_evento_collection_id], get_current_user());

        $kit_digital_url = get_post_meta($current_evento_collection->get_ID(), 'cne_kit_digital_do_evento', true);
        $texto_referencia_url = get_post_meta($current_evento_collection->get_ID(), 'cne_texto_de_referencia_do_evento', true);
        $cronograma_url = get_post_meta($current_evento_collection->get_ID(), 'cne_cronograma_do_evento', true);
        $contato_suporte__url = get_post_meta($current_evento_collection->get_ID(), 'cne_contato_suporte_do_evento', true);

        ?>
        <h2 class="instituicao-atividade-heading">Atividades e Eventos</h2>

        <?php if ($current_evento_collection->get_header_image_id()) : ?>
            <img title="<?php echo $current_evento_collection->get_name(); ?>" class="instituicao-evento-banner is-hidden-mobile" src="<?php echo wp_get_attachment_image_url($current_evento_collection->get_header_image_id(), 'full'); ?>" alt="<?php echo esc_attr($current_evento_collection->get_name()); ?>" />
            <img title="<?php echo $current_evento_collection->get_name(); ?>" class="instituicao-evento-banner is-hidden-tablet" src="<?php echo wp_get_attachment_image_url($current_evento_collection->get__thumbnail_id(), 'large'); ?>" alt="<?php echo esc_attr($current_evento_collection->get_name()); ?>" />
        <?php endif; ?>

        <p><?php echo $current_evento_collection->get_description(); ?></p>

        <div class="evento-principal-kits">
            <?php if ($cronograma_url) : ?>
                <a href="<?php echo esc_url($cronograma_url); ?>" class="button wp-button-with-icon button-primary" target="_blank">
                    Cronograma &nbsp;
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3 10H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 2V6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($texto_referencia_url) : ?>
                <a href="<?php echo esc_url($texto_referencia_url); ?>" class="button wp-button-with-icon button-primary" target="_blank">
                    Texto de referência &nbsp;
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 17H8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 13H8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10 9H9H8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14 2V8H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($kit_digital_url) : ?>
                <a href="<?php echo esc_url($kit_digital_url); ?>" class="button wp-button-with-icon button-primary" target="_blank">
                    Kit digital e audiovisual &nbsp;
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3L10.07 19.97L12.58 12.58L19.97 10.07L3 3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13 13L19 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php $this->instituicao_evento_comprovante_button(); ?>
            <?php if ($contato_suporte__url) : ?>
                <a href="<?php echo esc_url($contato_suporte__url); ?>" class="button wp-button-with-icon button-whatsapp" target="_blank">
                    Suporte &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="main-grid-item-icon" fill="none">
                        <path d="M6.579 8.121c.209-.663.778-1.457 1.19-1.66.183-.09.319-.11.763-.11.522 0 .548.005.684.14.088.095.328.606.673 1.432.292.71.533 1.315.533 1.347 0 .146-.293.61-.627 1.002-.23.267-.365.47-.365.543 0 .068.167.381.376.69.506.757 1.44 1.696 2.167 2.177.568.376 1.582.867 1.785.867.152 0 .429-.272.992-.982.23-.287.434-.495.512-.511.068-.021.235.005.37.057.392.152 2.371 1.117 2.476 1.211.203.188.037 1.264-.267 1.702-.464.68-1.79 1.259-2.663 1.17-.636-.068-2.14-.564-3.117-1.029-1.253-.6-2.574-1.697-3.644-3.038-.611-.763-1.227-1.692-1.493-2.246-.36-.751-.491-1.331-.455-2 .016-.287.068-.631.11-.762Z" fill="#ffffff" />
                        <path clip-rule="evenodd" d="M.606 9.5C1.582 4.491 5.576.76 10.709.06c.705-.1 2.684-.068 3.368.046.715.126 1.66.371 2.24.59 3.832 1.426 6.663 4.72 7.466 8.683.35 1.729.272 3.755-.203 5.457-1.133 4.03-4.423 7.205-8.511 8.218-2.663.658-5.462.37-7.983-.81l-.617-.292-3.226 1.029C1.473 23.545.01 23.994 0 23.983c-.01-.01.45-1.415 1.029-3.112l1.05-3.096-.424-.84C.48 14.569.12 12.01.605 9.498Zm21.172-.408c-1.028-3.76-4.297-6.626-8.145-7.148-2.099-.282-4.078.037-5.9.956-4.417 2.234-6.522 7.341-4.93 11.957.204.59.752 1.702 1.092 2.213l.271.408-.605 1.775a69.688 69.688 0 0 0-.606 1.817c0 .026.84-.224 1.864-.548a99.767 99.767 0 0 1 1.9-.596c.022 0 .225.11.45.24 2.428 1.447 5.456 1.76 8.187.852a9.927 9.927 0 0 0 6.48-6.945 9.998 9.998 0 0 0-.058-4.98Z" fill="#ffffff" fill-rule="evenodd" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <br>

        <div class="evento-principal-dados">
            <?php if (count($items) <= 0) : ?>
                <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap;">
                    <h3 style="display: inline-block; margin-right: 5px;">Minhas atividades no evento</h3>
                </div>
                <div class="evento-atividades-empty-placeholder">
                    <p>Esta instituição ainda não está participando do evento.</p>
                    <p>Insira ao menos uma atividade para participar!</p>
                    <a class="page-title-action button button-primary cne-button-cta wp-button-with-icon" href="<?php echo admin_url('?from-instituicao=' . $this->id_instituicao . '&page=tainacan_admin#/collections/' . $current_evento_collection_id . '/items/new');  ?>">
                        Cadastrar nova atividade &nbsp;
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 8V16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 12H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            <?php else : ?>

                <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap;">
                    <h3 style="display: inline-block; margin-right: 5px;">Minhas atividades no evento</h3>

                    <a class="page-title-action wp-button-with-icon" href="<?php echo admin_url('?from-instituicao=' . $this->id_instituicao . '&page=tainacan_admin#/collections/' . $current_evento_collection_id . '/items/new');  ?>">
                        Cadastrar nova atividade &nbsp;
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#01174E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 8V16" stroke="#01174E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8 12H16" stroke="#01174E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <?php $this->render_activities_table($items, $visible_metadata_objects); ?>

            <?php endif; ?>
        </div>
    <?php
    }

    function render_activities_table($items, $metadata) {

        $visible_metadata_ids = array_map(function ($metadatum) {
            return $metadatum->get_ID();
        }, $metadata);

    ?>
        <table class="wp-list-table widefat striped table-view-list posts">
            <thead>
                <tr>
                    <th class="tainacan-text--title column-primary">
                        <strong>Título</string>
                    </th>
                    <?php
                    foreach ($metadata as $metadatum) :
                        $metadatum_component = '';
                        $metadatum_object = $metadatum->get_metadata_type_object()->_toArray();
                        $metadatum_component = $metadatum_object['component'];

                        if ($metadatum_object['related_mapped_prop'] == 'title' || $metadatum_object['related_mapped_prop'] == 'description')
                            continue;
                    ?>
                        <th class="<?php echo $metadatum_component; ?>"><?php echo $metadatum->get_name(); ?> </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody id="the-list">

                <?php foreach ($items as $atividade) : ?>

                    <tr id="<?php echo 'post-' . $atividade->get_ID(); ?>" class="format-standard hentry">
                        <td style="min-width: 300px;">
                            <strong>
                                <a class="row-title" href="<?php echo admin_url('?page=tainacan_admin#/collections/' . $atividade->get_collection_id() . '/items/' . $atividade->get_ID() . '/edit'); ?>" aria-label="“<?php echo $atividade->get_title(); ?>” (Editar)">
                                    <?php echo $atividade->get_title(); ?>
                                </a>

                                <?php if (get_post_status() && get_post_status_object(get_post_status()) && get_post_status_object(get_post_status())->label) : ?>
                                    <span class="post-state"><?php echo get_post_status_object(get_post_status())->label; ?></span>
                                <?php endif; ?>
                            </strong>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="<?php echo admin_url('?from-instituicao=' . $this->id_instituicao . '&page=tainacan_admin#/collections/' . $atividade->get_collection_id() . '/items/' . $atividade->get_ID() . '/edit'); ?>" aria-label="Editar “<?php echo $atividade->get_title(); ?>”">Editar</a> |
                                </span>
                                <span class="trash">
                                    <a href="<?php echo get_delete_post_link($atividade->get_ID()); ?>" class="submitdelete" aria-label="Mover “<?php echo $atividade->get_title(); ?>” para a lixeira">Lixeira</a> |
                                </span>
                                <span class="view">
                                    <a href="<?php echo get_permalink($atividade->get_ID()); ?>" rel="bookmark" aria-label="Ver “<?php echo $atividade->get_title(); ?>”">Ver no site</a>
                                </span>
                            </div>
                        </td>
                        <?php
                        echo tainacan_get_the_metadata(array(
                            'exclude_core' => true,
                            'metadata__in' => $visible_metadata_ids,
                            'before' => '<td class="is-hidden-mobile metadata-type-$type" $id>',
                            'after' => '</td>',
                            'before_title' => '<span class="screen-reader-text">',
                            'after_title' => '</span>',
                            'before_value' => '',
                            'after_value' => '',
                            'hide_empty' => false,
                            'empty_value_message' => ' - '
                        ), $atividade->get_ID());
                        ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    <?php
    }

    /**
     * Gera o botão que imprime o comprovante de inscrição
     */
    function instituicao_evento_comprovante_button()
    {
        global $post;
    ?>
        <a class="button wp-button-with-icon button-primary" style="cursor: pointer;" onclick="
                var iframe = document.createElement('iframe');
                iframe.className='pdfIframe'
                document.body.appendChild(iframe);
                iframe.style.display = 'none';
                iframe.onload = function () {
                    setTimeout(function () {
                        iframe.focus();
                        iframe.contentWindow.print();
                        
                    }, 1);
                };
                iframe.contentWindow.addEventListener('afterprint', (event) => {
                    window.URL.revokeObjectURL('<?php echo admin_url('admin.php?page=comprovante&id=' . $post->ID); ?>')
                    document.body.removeChild(iframe)
                });
                iframe.src = '<?php echo admin_url('admin.php?page=comprovante&id=' . $post->ID); ?>';
                
            ">
            Imprimir comprovante de inscrição &nbsp;
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M18 14H6V22H18V14Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M6 9V2H18V9" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    <?php
    }
}
