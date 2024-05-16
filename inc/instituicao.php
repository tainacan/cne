<?php

if ( is_admin() ) {
    new CNE_Instituicao_Page();
}

/**
 * CNE_Instituicao_Page classe para criar e exibir a página de uma instituição
 */
class CNE_Instituicao_Page {

    private $id_instituicao = '';
    private $tainacan_collections_repository = null;
    private $tainacan_metadata_repository = null;
    private $tainacan_items_repository = null;

    /**
     * Constructor will create the menu item
     */
    public function __construct() {
        add_action( 'admin_menu', array($this, 'add_menu_instituicao_page' ));
        $this->tainacan_collections_repository = \Tainacan\Repositories\Collections::get_instance();
        $this->tainacan_metadata_repository = \Tainacan\Repositories\Metadata::get_instance();
        $this->tainacan_items_repository = \Tainacan\Repositories\Items::get_instance();
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_instituicao_page() {
        add_submenu_page(
            '', // Definindo o parent como nulo para não criar um menu, apenas registrar a página
            __('Instituição', 'cne'),
            __('Instituição', 'cne'),
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
    public function render_instituicao_page() {

        if ( !isset($_GET['id']) ) {
            ?>  
                <div class="wrap">
                    <h1><?php _e( 'Instituicao', 'cne'); ?></h1>
                    <p><?php _e( 'ID da instituição não informado.', 'cne' ); ?></p>
                </div>
            <?php
            
            return; 
        }

        $this->id_instituicao = $_GET['id'];
        
        $instituicao_items = $this->tainacan_items_repository->fetch( array( 'id' => $this->id_instituicao ), cne_get_instituicoes_collection_id() );

        if ( !$instituicao_items->have_posts() ) {
            ?>
                <div class="wrap">
                    <h1><?php _e( 'Instituicao', 'cne'); ?></h1>
                    <p><?php _e( 'Instituição não encontrada', 'cne' ); ?></p>
                </div>
            <?php 

            return;
        }

        $instituicao_items->the_post();

        ?>
            <div class="wrap">
                
                <h1 class="wp-heading-inline">
                    <?php _e('Instituição', 'cne'); ?>: <strong><?php the_title(); ?></strong>
                </h1>

                <?php tainacan_the_item_edit_link( __('Editar dados da instituição', 'cne') . '<span style="padding: 5px;" class="dashicons dashicons-edit"></span>', '', '', $this->id_instituicao, 'page-title-action' ); ?>
                <a class="page-title-action" href="<?php echo get_permalink();  ?>">
                    <?php _e('Ver no VisiteMuseus', 'cne'); ?>
                    <span style="padding: 5px;" class="dashicons dashicons-external"></span>
                </a>

                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('tainacan-medium', array('class' => 'instituicao-banner')); ?>
                <?php endif; ?>
                
                <?php the_excerpt(); ?>
                
                <hr>
                
                <?php $this->render_instituicao_section(); ?>
                
                <hr>
                
                <?php $this->render_current_evento_section(); ?>
            </div>
        <?php
    }

    function render_instituicao_section() {
        ?>
            <div class="instituicao-dados">
                <?php 
                    tainacan_the_metadata(array(
                        'exclude_core' => true,
                        'before_title' => '<strong class="tainacan-metadata-label">',
                        'after_title' => '</strong>',
                    ));
                ?>
            </div>
        <?php
    }

    function render_current_evento_section() {
        $current_evento_collection_id = cne_get_evento_collection_id();
        $current_evento_collection = $this->tainacan_collections_repository->fetch($current_evento_collection_id);

        if ( !( $current_evento_collection instanceof \Tainacan\Entities\Collection ) ) {
            ?>
                <h2><?php _e('Evento', 'cne'); ?></h2>
                <p><?php _e('Nenhum evento configurado', 'cne'); ?></p>
            <?php
            return;
        }

        $metadata_objects = $this->tainacan_metadata_repository->fetch_by_collection(
            $current_evento_collection,
            [],
            'OBJECT'
        );
        $visible_metadata_objects = array_filter($metadata_objects, function($metadatum) {
            return $metadatum->get_display() === 'yes' && cne_get_instituicoes_relationship_metadata_id() != $metadatum->get_ID() ;
        });

        $items = cne_get_atividades(array(), $this->id_instituicao, [ $current_evento_collection_id ], get_current_user() );

        $kit_digital_url = get_post_meta($current_evento_collection->get_ID(), 'cne_kit_digital_do_evento', true);

        ?>
            <h2><?php echo $current_evento_collection->get_name(); ?></h2>
            
            <?php if ( $current_evento_collection->get_header_image_id() ) : ?>
                <img class="instituicao-evento-banner" alt="<?php echo wp_get_attachment_caption( $current_evento_collection->get_header_image_id() ); ?>" src="<?php echo $current_evento_collection->get_header_image(); ?>">
            <?php endif; ?>
            
            <p><?php echo $current_evento_collection->get_description();?></p>
            
            <div class="evento-principal-kits">
                <?php if ( $kit_digital_url ) : ?>
                    <a href="<?php echo $kit_digital_url;?>" class="button" download>
                        <?php _e('Acesse o kit digital audiovisual do evento', 'cne'); ?>
                        <span style="padding: 5px;" class="dashicons dashicons-download"></span>
                    </a>
                <?php endif; ?>
            </div>
            
            <br>

            <div class="evento-principal-dados">

                <h3 style="display: inline-block; margin-right: 5px;"><?php _e('Minhas atividades', 'cne'); ?></h3>
            
                <a class="page-title-action" href="<?php echo admin_url( '?from-instituicao=' . $this->id_instituicao . '&page=tainacan_admin#/collections/' . $current_evento_collection_id . '/items/new' );  ?>">
                    <?php _e('Cadastrar atividade', 'cne'); ?>
                    <span style="padding: 5px;" class="dashicons dashicons-plus"></span>
                </a>
            
                <?php 
                    if ( count($items) <= 0 ) {
                        echo '<p>' . __('Nenhuma atividade cadastrada ainda', 'cne') . '</p>';
                    } else {
                        $this->render_activities_table($items, $visible_metadata_objects);
                    }
                ?>
            </div>
        <?php
    }

    function render_activities_table($items, $metadata) {

        $visible_metadata_ids = array_map( function($metadatum) {
            return $metadatum->get_ID();
        }, $metadata );

        ?>
            <table class="wp-list-table widefat striped table-view-list posts">
                <thead>
                    <tr>
                        <th class="tainacan-text--title column-primary"><strong><?php echo __('Título', 'cne'); ?></string></th>
                        <?php 
                            foreach( $metadata as $metadatum ) : 
                                $metadatum_component = '';
                                $metadatum_object = $metadatum->get_metadata_type_object()->_toArray();
                                $metadatum_component = $metadatum_object['component'];
                                
                                if ( $metadatum_object['related_mapped_prop'] == 'title' )
                                    continue;
                        ?>
                            <th class="<?php echo $metadatum_component; ?>"><?php echo $metadatum->get_name(); ?> </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody id="the-list">
                        
                <?php foreach($items as $atividade) : ?>

                    <tr id="<?php echo 'post-' . $atividade->get_ID(); ?>" class="format-standard hentry">
                        <td style="min-width: 120px;">
                            <strong>
                                <a class="row-title" href="<?php echo admin_url( '?page=tainacan_admin#/collections/' . $atividade->get_collection_id() . '/items/' . $atividade->get_ID() . '/edit' ); ?>" aria-label="“<?php echo $atividade->get_title(); ?>” (Editar)">
                                    <?php echo $atividade->get_title(); ?>
                                </a>
                            </strong>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="<?php echo admin_url( '?from-instituicao=' . $this->id_instituicao . '&page=tainacan_admin#/collections/' . $atividade->get_collection_id() . '/items/' . $atividade->get_ID() . '/edit' ); ?>" aria-label="Editar “<?php echo $atividade->get_title(); ?>”"><?php _e('Editar', 'cne'); ?></a> |
                                </span>
                                <span class="trash">
                                    <a href="<?php echo get_delete_post_link( $atividade->get_ID() ); ?>" class="submitdelete" aria-label="Mover “<?php echo $atividade->get_title(); ?>” para a lixeira"><?php _e('Lixeira', 'cne'); ?></a> |
                                </span>
                                <span class="view">
                                    <a href="<?php echo get_permalink( $atividade->get_ID() ); ?>" rel="bookmark" aria-label="Ver “<?php echo $atividade->get_title(); ?>”"><?php _e('Ver', 'cne'); ?></a>
                                </span>
                            </div>
                        </td>
                        <?php
                            echo tainacan_get_the_metadata(array(
                                'exclude_title' => true,
                                'metadata__in' => $visible_metadata_ids,
                                'before' => '<td class="metadata-type-$type" $id>',
                                'after' => '</td>',
                                'before_title' => '<span class="screen-reader-text">',
                                'after_title' => '</span>',
                                'before_value' => '',
                                'after_value' => '',
                                'hide_empty' => false,
                                'empty_value_message' => ' - '
                            ), $atividade->get_ID() );
                        ?>
                    </tr>
                 <?php endforeach; ?>

                </tbody>
            </table>
        <?php
    }
    
}
