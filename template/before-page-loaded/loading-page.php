<div class="loading-page" data-type="<?php echo ace()->getThemeMod( 'loading_page_type' ); ?>"><div class="loading-page-inner spinner"><i class="spinner-icon"></i></div></div>
<script>document.dispatchEvent(new Event('aceLoadingPage',{'bubbles':true,'cancelable':false}));</script>
<?php do_action( ace()->getPrefixedActionHook( 'frontend_page_load' ) ); ?>