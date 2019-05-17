<?php
// CSS
    // Admin Pages
        wp_register_style( 'ace-admin-page', ACE_DIR_URL . 'assets/css/admin/page/general.css' );

    // Theme Customizer
        wp_register_style( 'ace-theme-customier', ACE_DIR_URL . 'assets/css/theme-customizer/general.css' );

// JS
        wp_register_script( 'alpha-color-picker', ACE_DIR_URL . 'assets/js/theme-customizer/alpha-color-picker.js', array( 'jquery', 'wp-i18n' ), true, false );

    // Admin
        wp_localize_script( 'jquery', 'aceDirURLForJS', array(
            'frontPageURL' => esc_url( home_url() ),
            'adminProfileURL' => esc_url( admin_url( 'profile.php' ) ),
            'adminEditURL' => esc_url( admin_url( 'edit.php' ) ),
            'adminPostURL' => esc_url( admin_url( 'post.php' ) ),
            'adminPostNewURL' => esc_url( admin_url( 'post-new.php' ) ),
            'adminEditTagsURL' => esc_url( admin_url( 'edit-tags.php' ) ),
            'adminUploadURL' => esc_url( admin_url( 'upload.php' ) ),
            'adminAdminURL' => esc_url( admin_url( 'admin.php' ) ),
            'adminNavMenuURL' => esc_url( admin_url( 'nav-menus.php' ) ),
            'adminWidgetsURL' => esc_url( admin_url( 'widgets.php' ) ),
            'adminThemeURL' => esc_url( admin_url( 'themes.php' ) ),
            'adminFrontendSettingsPageURL' => esc_url( admin_url( 'admin.php?page=ace_frontend_settings' ) ),
            'adminCSSSettingsPageURL' => esc_url( admin_url( 'admin.php?page=ace_custom_css_settings' ) ),
            'adminFontSettingsPageURL' => esc_url( admin_url( 'admin.php?page=ace_custom_font_settings' ) ),
            'adminPixabayMediaFetcherPageURL' => esc_url( admin_url( 'upload.php?page=ace_pixabay_media_fetcher' ) ),
            'adminCustomizerURL' => esc_url( admin_url( 'customize.php' ) ),
            'assetsDirURL' => ACE_DIR_URL . 'assets/',
            'thirdDirURL' => ACE_DIR_URL . 'inc/3rd/',
        ) );

        wp_register_script( 'ace-admin-theme-page', ACE_DIR_URL . 'assets/js/admin/admin-theme-page.js', array( 'jquery', 'wp-i18n' ), true, false );
