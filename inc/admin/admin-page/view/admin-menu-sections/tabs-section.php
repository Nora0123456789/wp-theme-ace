
<div class="tab-list-wrapper">
    <div class="tab-list">
        <div class="tab" data-tab="setting-guide">
            <a class="tab-button" href="javascript: void(0);" data-tab="setting-guide">
                <span class="tab-text"><?php esc_html_e( 'Setting Guide', 'ace' ); ?></span>
            </a>
        </div>
        <div class="tab" data-tab="guide-to-ace-plus">
            <a class="tab-button" href="javascript: void(0);" data-tab="guide-to-ace-plus">
                <span class="tab-text"><?php esc_html_e( 'Introduction to Ace+', 'ace' ); ?></span>
            </a>
        </div>
    </div>
</div>

<div class="tab-menu-list">
    <div class="tab-menu-item" data-tab="setting-guide">
        <?php require_once( ACE_DIR_PATH . 'inc/admin/admin-page/view/tab-menu-list/setting-guide.php' ); ?>
    </div>
    <div class="tab-menu-item" data-tab="guide-to-ace-plus">
        <?php require_once( ACE_DIR_PATH . 'inc/admin/admin-page/view/tab-menu-list/guide-to-ace-plus.php' ); ?>
    </div>
</div>

