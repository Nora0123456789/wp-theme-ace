<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes">
	<meta name="format-detection" content="telephone=no" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( ace()->getFrontendManager()->getHTMLClasses( 'body' ) ); ?>>
	<?php do_action( 'wp_body_open' ); ?>
	<script>document.body.classList.remove( 'ace-no-js' );</script>
	<?php do_action( ace()->getPrefixedActionHook( 'render_before_page_loaded' ) ); ?>
	<div class="full-wrapper">
		<header class="<?php echo esc_attr( implode( ' ', ace()->getFrontendManager()->getHTMLClasses( 'header' ) ) ); ?>">
			<div class="header-inner">
				<div class="<?php echo esc_attr( implode( ' ', array( 'header-parts-fixable', ace()->getThemeMod( 'header_layout_pattern' ) ) ) ); ?>">
					<?php ace_print_edit_shortcut_for_theme_customizer( 'blogname' );
						$element = 'div';
						if ( ( is_home() && is_front_page() )
							|| ( is_front_page() ) 
						) {
							$element = 'h1';
						}
						$custom_logo_id = get_theme_mod( 'custom_logo', 0 );
					?>
					<div id="header-site-info">
						<<?php echo $element; ?> id="header-site-name-description" class="header-site-name-description">
							<a href="<?php echo esc_url( ACE_SITE_URL ); ?>">
								<?php if ( 0 < intval( $custom_logo_id ) ) { 
									$logo_image_url = wp_get_attachment_image_src( $custom_logo_id , 'full' );
									echo AceFrontendRenderingMethods::getImageTagWithNoScript( $logo_image_url[0], 'img', array(
										'alt' => ACE_SITE_NAME . ' - ' . ACE_SITE_DESCRIPTION,
										'class' => 'header-site-logo',
										'width' => 400,
										'height' => 50,
									) );
									//<img id ="header-site-logo" class="header-site-logo" alt="<?php echo esc_html( ACE_SITE_NAME ) . ' - ' . esc_html( ACE_SITE_DESCRIPTION ); " src="<?php echo esc_url( $logo_image_url[0] ); " />
								} else { ?>
									<span id="header-site-name" class="header-site-name"><?php echo esc_html( ACE_SITE_NAME ); ?></span>
									<span id="header-site-description" class="header-site-description"><?php echo esc_html( ACE_SITE_DESCRIPTION ); ?></span>
								<?php } ?>
							</a>
						</<?php echo $element; ?>>

						<?php
							$header_contact_info_display = boolval( ace()->getThemeMod( 'header_contact_info_display' ) );
							if ( $header_contact_info_display || is_customize_preview() ) {
								AceFrontendRenderingMethods::headerContactInfo();
							}
						?>
					</div>

					<?php do_action( ace()->getPrefixedActionHook( 'render_in_header_parts_fixable' ) ); ?>
				</div>

				<?php do_action( ace()->getPrefixedActionHook( 'render_in_header' ) ); ?>

			</div>
		</header>

		<main class="main">
			<?php do_action( ace()->getPrefixedActionHook( 'render_before_primary' ) ); ?>
			<div class="<?php echo esc_attr( implode( ' ', ace()->getFrontendManager()->getHTMLClasses( 'main-area' ) ) ); ?>">
				<div class="main-inner">
					<?php do_action( ace()->getPrefixedActionHook( 'render_in_column_left' ) ); ?>
					<div id="primary" role="main">
						<div class="primary-inner">
						<?php do_action( ace()->getPrefixedActionHook( 'render_before_content' ) ); ?>
