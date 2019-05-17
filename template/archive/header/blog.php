<?php
/**
 * Header for Blog Page.
**/

$post_id = intval( get_option( 'page_for_posts' ) );
if ( 0 < $post_id ) {

    $post = get_post( $post_id );

    $blog_title = get_the_title( $post_id );

?>
<div class="archive-articles-header">
    <div class="archive-articles-header-inner">

        <h1 class="archive-title">
            <span class="archive-title-text hoverable hover-text-shadow">
                <?php echo esc_html( $blog_title ); ?>
            </span>
        </h1>

    </div>
</div>
<?php
} else {
    echo '<h1 class="archive-title"><span class="archive-title-text hoverable hover-text-shadow">'; esc_html_e( 'Blog', 'ace' ); echo '</span></h1>';
    return;
}

