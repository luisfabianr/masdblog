<?php get_header(); ?>

<?php genesis_before_content_sidebar_wrap(); ?>
<div id="content-sidebar-wrap">

	<?php genesis_before_content(); ?>
	<div id="genesis-content" class="content">

		<!-- HISTORIAS RELACIONADAS CON LA PRINCIPAL -->
		<div id="front-page-historias-relacionadas-p" class="front-page-relacionadas-p section">
			<div class="project add-animation animation-1">
	            <div class="one-third first">
	            	<?php if (!dynamic_sidebar('Principal Relacionada Left')) : ?>
						<div class="widget">
							<?php _e("Historia relacionada con la principal ubicada en la parte Izquierda", 'genesis'); ?></p>
						</div><!-- end .widget -->
					<?php endif; ?>
				</div>
	            <div class="one-third">
	            	<?php if (!dynamic_sidebar('Principal Relacionada Center')) : ?>
						<div class="widget">
							<?php _e("Historia relacionada con la principal ubicada en la parte Central", 'genesis'); ?></p>
						</div><!-- end .widget -->
					<?php endif; ?>            	
	            </div>
	            <div class="one-third">
	            	<?php if (!dynamic_sidebar('Principal Relacionada Right')) : ?>
						<div class="widget">
							<?php _e("Historia relacionada con la principal ubicada en la parte Derecha", 'genesis'); ?></p>
						</div><!-- end .widget -->
					<?php endif; ?>    
				</div>
			</div>
        </div>
		<div class="clearfix"></div>
		<!-- HISTORIAS SECUNDARIAS -->
		<div id="front-page-historias-secundarias" class="front-page-secundarias section first">
			<div class="project add-animation animation-1">
	            <div class="full">
					<?php if (!dynamic_sidebar('Historia Secundaria')) : ?>
						<div class="widget">
							<?php _e("Historia Secundaria del node", 'genesis'); ?></p>
						</div><!-- end .widget -->
					<?php endif; ?>  
	            </div>
	            <div class="two-sixths first subir">
	            	<?php if (!dynamic_sidebar('Secundaria Relacionada Left')) : ?>
						<div class="widget">
								<?php _e("Historia relacionada con la secundaria ubicada en la parte Izquierda", 'genesis'); ?></p>
						</div><!-- end .widget -->
					<?php endif; ?>  
	            </div>
	            <div class="two-sixths subir">
	                <?php if (!dynamic_sidebar('Secundaria Relacionada Right')) : ?>
						<div class="widget">
								<?php _e("Historia relacionada con la secundaria ubicada en la parte Derecha", 'genesis'); ?></p>
						</div><!-- end .widget -->
					<?php endif; ?>              	
	            </div>
	        </div>
        </div>
        <!-- HISTORIA DESTACAD MASD-->
        <?php genesis_after_content(); ?>        
    </div><!-- end #content -->
</div><!-- end #content-sidebar-wrap -->
<?php genesis_after_content_sidebar_wrap(); ?>
<div class="clearfix"></div>
<div id="front-page-historia-masd first" class="front-page-historia-masd section">
    <div class="full wrap">
        <?php if (!dynamic_sidebar('Principal masD ')) : ?>
            <div class="widget">
                    <?php _e("Historia destacada revista académica masD", 'genesis'); ?></p>
            </div><!-- end .widget -->
        <?php endif; ?>    
    </div>
    <div class="wrap-historia-masd"></div>
</div> 

<?php get_footer(); ?>







