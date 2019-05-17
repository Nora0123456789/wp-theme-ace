<?php
?>
<div class="admin-menu-page-inner">
    <h2 class="admin-menu-title"><?php esc_html_e( 'Setting Guide', 'ace' ); ?></h2>
</div>


<div class="admin-menu-page-inner content updates-description">

    <p class="update-message">
        <?php esc_html_e( 'All settings by theme Ace are in theme customizer.', 'ace' ); ?>
    <p>

    <p class="update-message">
        <?php esc_html_e( 'You can modify following parts:', 'ace' ); ?>
    <p>

    <dl>
        <dt><p><strong><?php esc_html_e( 'Page Layout', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set width for main content and both sidebars.', 'ace' ); ?></p></dd>

        <dt><p><strong><?php esc_html_e( 'Header', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set "Layout", "Colors", "Fonts", "Edge" and "Contact Info".', 'ace' ); ?></p></dd>

        <dt><p><strong><?php esc_html_e( 'Main Area', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set "Colors", "Fonts" and "Edge".', 'ace' ); ?></p></dd>

        <dt><p><strong><?php esc_html_e( 'Content Page', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set "Colors" and "Fonts".', 'ace' ); ?></p></dd>

        <dt><p><strong><?php esc_html_e( 'Archive Page', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set "Layout", "Colors" and "Fonts".', 'ace' ); ?></p></dd>

        <dt><p><strong><?php esc_html_e( 'Footer', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set "Layout", "Colors", "Fonts" and "Edge".', 'ace' ); ?></p></dd>

        <dt><p><strong><?php esc_html_e( 'Widget Areas', 'ace' ); ?></strong></p></dt>
        <dd><p><?php esc_html_e( 'You can set styles for each widget area and the widgets.', 'ace' ); ?></p></dd>

    </dl>
        

</div>

<div class="admin-menu-page-inner">
    <h2 class="admin-menu-title"><?php esc_html_e( 'Updates and Customizations', 'ace' ); ?></h2>
</div>


<div class="admin-menu-page-inner content messages">

    <p class="update-message">
        <?php esc_html_e( 'Here is WP Works Blog. ', 'ace' ); ?>
    <p>

    <p class="update-message">
        <?php esc_html_e( 'It writes mainly about customizations, some tutorials and updates for Products by WP Works. ', 'ace' ); ?>
        <?php esc_html_e( 'Please take it as some reference info when you want to make some customizations. ', 'ace' ); ?>
    <p>

    <p class="update-message">
        <?php esc_html_e( 'If you have any questions and error reports on products, they will be helpful and make products better. ', 'ace' ); ?>
    <p>

    <p class="update-message">
        <?php esc_html_e( 'You can report in WP forum or directly in WP Works. ', 'ace' ); ?>
    <p>

</div>

<div class="admin-menu-page-inner content update-feeds">
    <?php $this->renderFeed( esc_html__( 'WP Works Blog', 'ace' ), 'https://wp-works.com/blog/feed/' ); ?>
</div>


<div class="admin-menu-page-inner">
    <h2 class="admin-menu-title"><?php esc_html_e( 'About Child Theme', 'ace' ); ?></h2>
</div>


<div class="admin-menu-page-inner content about-child-theme">
    <p class="about-child-theme-text"><?php esc_html_e( 'In theme "Ace", template files are also placed in directory "templates". ', 'ace' ); ?></p>
    <p class="about-child-theme-text"><?php esc_html_e( 'When you want to make child theme and customize it, it is recommended to copy and modify them. ', 'ace' ); ?></p>
    <p class="about-child-theme-text"><?php esc_html_e( '* As theme info writes, Ace includes Bootstrap as 3rd party library but actually it includes only "bootstrap_reboot". ', 'ace' ); ?></p>
    <p class="about-child-theme-text"><?php esc_html_e( 'So when you want to make a child theme or do some customization using bootstrap classes or its JavaScript, you have to include it by yourself. ', 'ace' ); ?></p>

</div>



