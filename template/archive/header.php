<?php
/**
 * Router for Archive Header
**/

$queried_object = get_queried_object();

$archive_description = get_the_archive_description();

//var_dump( $queried_object );
//var_dump( 'WP_Term' === get_class( $queried_object ) );
//var_dump( is_subclass_of( $queried_object, 'WP_Term' ) );

$archive_type = '';
if ( is_home() && ! is_front_page() ) {

    $archive_type = 'blog';

} elseif ( is_search() ) {

    $archive_type = 'search';
    echo '<h1 class="archive-title"><span class="archive-title-text hoverable hover-text-shadow">'; printf( esc_html__( 'Search Result: %s', 'ace' ), isset( $_GET['s'] ) ? $_GET['s'] : '' ); echo '</span></h1>';

} elseif ( is_author() ) {

	get_template_part( 'template/archive/header/author' );

} elseif ( is_category() || is_tag() || is_tax() ) {

	get_template_part( 'template/archive/header/taxonomy-term' );

} elseif ( is_date() ) {
    $archive_type = 'date';
    $archive_description_content = '<h1 class="archive-title"><span class="archive-title-text hoverable hover-text-shadow">'; the_archive_title(); echo '</span></h1>';

} else {
	get_template_part( 'template/archive/header/others' );
}



