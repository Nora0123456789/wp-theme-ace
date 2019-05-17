<?php
/**
 * Header for Taxonomy Term Archive Page.
**/

$queried_object = get_queried_object();

$taxonomy_name = $queried_object->taxonomy;

$tax_term_label = $queried_object->name;

$tax_term_post_count = absint( $queried_object->count );

//$archive_description = $queried_object->description;
$archive_description = get_the_archive_description();
$has_description = is_string( $archive_description ) && '' !== $archive_description;


// Classes
$classes_header = array( 'archive-articles-header' );
if ( $has_description ) array_push( $classes_header, 'has-description' );

?>

<div class="<?php echo esc_attr( implode( ' ', $classes_header ) ); ?>">
    <div class="archive-articles-header-inner">

        <h1 class="archive-title">
            <span class="archive-title-text hoverable hover-text-shadow">
                <?php the_archive_title(); ?>
            </span>
        </h1>

        <?php if ( $has_description ) { ?>
            <div class="archive-description">
                <?php echo $archive_description; ?>
            </div>
        <?php } ?>

    </div>
</div>
