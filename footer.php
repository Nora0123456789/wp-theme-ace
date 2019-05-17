							<?php do_action( ace()->getPrefixedActionHook( 'render_after_content' ) ); ?>
						</div>
					</div>
					<?php do_action( ace()->getPrefixedActionHook( 'render_in_column_right' ) ); ?>
				</div>
			</div>

			<noscript>
				<?php
				$designed_section_type = get_theme_mod( 'designed_section_type', 'two-tone' );
				if ( 'two-tone' === $designed_section_type ) {
					echo '<div class="designed-section-inner ' . $designed_section_type . ' side-top"></div><div class="designed-section-inner ' . $designed_section_type . ' side-bottom"></div>';
				} else {
					echo '<div class="designed-section-inner side-top"></div><div class="designed-section-inner side-right"></div><div class="designed-section-inner side-bottom"></div><div class="designed-section-inner side-left"></div>';
				}
				?>
			</noscript>

			<?php do_action( ace()->getPrefixedActionHook( 'render_after_primary' ) ); ?>
		</main>

		<footer class="<?php echo esc_attr( implode( ' ', ace()->getFrontendManager()->getHTMLClasses( 'footer' ) ) ); ?>">
			<div class="footer-inner">
				
				<?php if ( ! wp_is_mobile() ) { ?>
					<div class="footer-nav-menu">
						<?php
							/**
							 * Displays a navigation menu.
							 * @since 3.0.0
							**/
							$footer_nav = array(
								'theme_location' => 'footer',
								'menu' => '',
								'container' => 'div',
								'container_class' => 'menu-wrapper standard',
								'container_id' => '',
								'menu_class' => 'menu-list',
								'menu_id' => '',
								'echo' => true,
								'fallback_cb' => null,
								'before' => '<div class="menu-item-inner hoverable running-underline">',
								'after' => '</div>',
								'link_before' => '<div class="menu-link-texts"><span class="menu-link-text">',
								'link_after' => '</span><span class="menu-link-icon"></span></div>',
								'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth' => 0,
								//'walker' => ''
							);
							wp_nav_menu( $footer_nav );
						?>
					</div>
				<?php } ?>

				<?php do_action( ace()->getPrefixedActionHook( 'render_in_footer' ) ); ?>


				<div class="footer-items">
					<div class="footer-item-inner">
					<?php
						/* Site Name Description
						 * Display License
						 * Theme Display
						------------------------------------------------*/
						do_action( ace()->getPrefixedActionHook( 'render_footer_items' ) );
					?>
					</div>

				</div>

				<div class="footer-tools-menu">
					<div class="footer-tools-inner">
					<?php
						if ( wp_is_mobile() ) {
							do_action( ace()->getPrefixedActionHook( 'render_in_mobile_tools' ) );
						} else {
							do_action( ace()->getPrefixedActionHook( 'render_in_footer_tools' ) );
						}
					?>
					</div>
				</div>
				
			</div>
		</footer>
	</div>
	<?php wp_footer(); ?>

</body>
</html>