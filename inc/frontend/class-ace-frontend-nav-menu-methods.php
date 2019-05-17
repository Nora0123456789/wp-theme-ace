<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class AceFrontendNavMenuMethods {

	public static function getWalkerNavMenuInstance( $theme_location ) {
		return apply_filters( ace()->getPrefixedFilterHook( 'walker_nav_menu_instance' ), new Walker_Nav_Menu(), $theme_location );
	}

	/**
	 * Print Header Nav Menu Template
	 * 
	 * @see $this->get_header_nav_menu()
	**/
	public static function renderHeaderNavMenu() {
		echo self::getHeaderNavMenu();
	}

	/**
	 * Get Header Nav Menu Template
	 * @see $this->getWalkerNavMenuInstance( $theme_location )
	 * @return string
	**/
	public static function getHeaderNavMenu() {

		$depth = 0;
		if ( ! wp_is_mobile() ) {
			$depth = 0;
		}

		$header_nav_menu_args = array( 
			'theme_location' => 'primary',
			'menu' => '',
			'container' => 'div',
			'container_class' => 'menu-wrapper standard',
			'container_id' => '',
			'menu_class' => 'menu-list',
			'menu_id' => '',
			'echo' => false,
			'fallback_cb' => null,
			'before' => '<div class="menu-item-inner hoverable running-underline">',
			'after' => '</div>',
			'link_before' => '<div class="menu-link-texts"><span class="menu-link-text">',
			'link_after' => '</span></div><span class="menu-link-icon"></span>',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth' => $depth,
			'walker' => self::getWalkerNavMenuInstance( 'primary' ),
		);

		return apply_filters( ace()->getPrefixedFilterHook( 'header_nav_menu' ), wp_nav_menu( $header_nav_menu_args ) );

	}

	/**
	 * Print Template for Footer Nav Menu
	 * 
	 * @see self::getFooterNavMenu()
	**/
	public static function renderFooterNavMenu() {
		echo self::getFooterNavMenu();
	}

	/**
	 * Get Template for Footer Nav Menu
	 * 
	 * @see $this->getWalkerNavMenuInstance( $theme_location );
	 * 
	 * @return string
	**/
	public static function getFooterNavMenu() {

		$footer_nav_menu_args = array( 
			'theme_location' => 'footer',
			'menu' => '',
			'container' => 'div',
			'container_class' => 'menu-wrapper standard',
			'container_id' => '',
			'menu_class' => 'menu-list',
			'menu_id' => '',
			'echo' => false,
			'fallback_cb' => null,
			'before' => '<div class="menu-item-inner hoverable running-underline">',
			'after' => '</div>',
			'link_before' => '<div class="menu-link-texts"><span class="menu-link-text">',
			'link_after' => '</span><span class="menu-link-icon"></span></div>',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth' => 0,
			'walker' => self::getWalkerNavMenuInstance( 'footer' ),
		);

		return apply_filters( ace()->getPrefixedFilterHook( 'footer_nav_menu' ), wp_nav_menu( $footer_nav_menu_args ) );

	}

}



