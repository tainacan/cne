<?php

	$metadata_ids = [
		// Atividades
		'38411', // Tipo da Atividade
		'38430', // Instituição
		'38421', // Horário de Início
		'38416', // Horário de Término
		'38396', // Estado
		'38390', // Cidade
	];
	$data_metadata_ids = [
		'38424', // Data de Início
		'38419', // Data de Término
	];
	$instituicao_metadata_ids = [
		// Instituições
		'38396', // Estado
		'38390', // Cidade
		'20' 	 // Descrição
	];

	$allowed_attrs = array(
		'class' => true,
		'id' => true,
		'style' => true,
		'aria-hidden' => true,
		'name' => true,
		'value' => true,
		'type' => true,
		'role' => true,
		'aria-label' => true,
		'aria-labelledby' => true,
		'aria-describedby' => true
	);
	$valid_elements = array(
		'h2' => $allowed_attrs,
		'h3' => $allowed_attrs,
		'h4' => $allowed_attrs,
		'h5' => $allowed_attrs,
		'h6' => $allowed_attrs,
		'p' => $allowed_attrs,
		'span'	=> $allowed_attrs,
		'div' => $allowed_attrs,
		'strong' => $allowed_attrs,
		'em' => $allowed_attrs
	);

	function cne_view_mode_grid_date_without_year($date_format) {
		return 'd/m';
	}
	add_filter( 'pre_option_date_format', 'cne_view_mode_grid_date_without_year');
?>

<?php if ( have_posts() ) : ?>

	<ul class="tainacan-cne-grid-container">

		<?php $item_index = 0; while ( have_posts() ) : the_post(); ?>
			
			<li class="tainacan-cne-grid-item <?php echo get_post_type() == cne_get_instituicoes_collection_post_type() ? 'tainacan-cne-grid-item--2' : ''; ?>">
				<a href="<?php echo cne_get_item_link_for_navigation(get_permalink(), $item_index); ?>">
					
					<?php if ( get_post_type() == cne_get_instituicoes_collection_post_type() ) : ?>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="cne-grid-item-title-and-thumbnail">
								<?php the_post_thumbnail( 'tainacan-large-full' ); ?>
								<h4><?php the_title(); ?></h4>
							</div>
						<?php else : ?>
							<div class="cne-grid-item-title-and-thumbnail placeholder">
								<?php echo '<img src="' . get_stylesheet_directory_uri() .'/assets/images/placeholder_instituicao.png" alt="' . esc_attr('Imagem não definida', 'cne') . '" />'?>
								<h4><?php the_title(); ?></h4>
							</div>
						<?php endif; ?>
					<?php else: ?>
						<?php 
							$datas_item_medatata = tainacan_get_the_metadata([
								'metadata__in' => $data_metadata_ids,
								'display_slug_as_class' => true,
								'before_title' => '<h3 class="screen-reader-text">',
							]); 
							
							if ( $datas_item_medatata ) :?>
								<div class="cne-grid-item-date">
									<?php echo wp_kses($datas_item_medatata, $valid_elements); ?>
								</div>
							<?php endif;
						?>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="cne-grid-item-thumbnail">
								<?php the_post_thumbnail( 'tainacan-large-full' ); ?>
							</div>
						<?php else : ?>
							<div class="cne-grid-item-thumbnail placeholder">
								<?php echo '<img src="' . get_stylesheet_directory_uri() .'/assets/images/placeholder.png" alt="' . esc_attr('Imagem não definida', 'cne') . '" />'?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					
					<div class="cne-grid-metadata">
						<?php
							$item_metadata = tainacan_get_the_metadata([
								'metadata__in' => get_post_type() == cne_get_instituicoes_collection_post_type() ? $instituicao_metadata_ids : $metadata_ids,
								'display_slug_as_class' => true,
								'before_title' => '<h3 class="screen-reader-text">',
							]);
							
							if ( get_post_type() !== cne_get_instituicoes_collection_post_type() )
								echo '<div class="metadata-type-core_title"><p>' . get_the_title() . '</p></div>';

							echo wp_kses($item_metadata, $valid_elements);
						?>
					</div>
				</a>
			</li>	
		
		<?php $item_index++; endwhile; ?>
	
	</ul>

<?php else : ?>
	<div class="tainacan-cne-grid-container">
		<section class="section">
			<div class="content has-text-gray-4 has-text-centered">
				<p>
					<span class="icon is-large">
						<i class="tainacan-icon tainacan-icon-48px tainacan-icon-items"></i>
					</span>
				</p>
				<p><?php echo __( 'Nenhum item encontrado.','cne' ); ?></p>
			</div>
		</section>
	</div>
<?php endif;

remove_filter( 'pre_option_date_format', 'cne_view_mode_grid_date_without_year');

?>
