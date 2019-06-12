<?php
if ( is_home() 
	|| is_front_page()
) {
	return;
}

global $post;
echo '<div class="breadcrumb-wrapper">';
echo '<ul id="breadcrumb" class="breadcrumb" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
	
	AceFrontendRenderingMethods::renderBreadcrumbItem( esc_html__( 'Home', 'ace' ), 'home', ACE_SITE_URL );

	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

		// Shop
		if ( is_shop() ) {
			AceFrontendRenderingMethods::renderBreadcrumbItem( esc_html__( 'Shop', 'ace' ), 'shop' );
		}
		// Product
		elseif ( is_product() ) {

			$product_cat = get_the_terms( $post->ID, 'product_cat' );
			if( isset( $product_cat[ 0 ] ) ) {
	
				$product_cat = $product_cat[ 0 ];
	
				if ( $product_cat->parent !== 0 ) {
	
					$ancestors = array_reverse( get_ancestors( absint( $product_cat->term_id ), 'product_cat' ) );
					if ( is_array( $ancestors ) && 0 < count( $ancestors ) ) { foreach( $ancestors as $ancestor ) {
						$term = get_term( $ancestor, 'product_cat', ARRAY_A );
						if ( null === $term || is_wp_error( $term ) ) {
							break;
						}
						AceFrontendRenderingMethods::renderBreadcrumbItem( $term['name'], 'taxonomy', get_category_link( $ancestor ) );
	
					} }
					unset( $ancestors );
	
				}
	
				AceFrontendRenderingMethods::renderBreadcrumbItem( $product_cat->name, 'taxonomy', get_category_link( absint( $product_cat->term_id ) ) );
	
				unset( $product_cat );
	
			}
			unset( $product_cat );
	
			AceFrontendRenderingMethods::renderBreadcrumbItem( get_the_title( $post ), 'product' );
	
		}

		// Product Archive
		elseif ( is_product_taxonomy() ) {

			$queried_object = get_queried_object();
			$term_id = $queried_object->term_id;
			$taxonomy = $queried_object->taxonomy;

			$ancestors = array_reverse( get_ancestors( absint( $term_id ), $taxonomy ) );
			if ( is_array( $ancestors ) && 0 < count( $ancestors ) ) { foreach( $ancestors as $ancestor ) {
				$term = get_term( $ancestor, $taxonomy, ARRAY_A );
				if ( null === $term || is_wp_error( $term ) ) {
					break;
				}
				AceFrontendRenderingMethods::renderBreadcrumbItem( $term['name'], 'taxonomy', get_category_link( $ancestor ) );

			} }
			unset( $ancestors );

			AceFrontendRenderingMethods::renderBreadcrumbItem( $queried_object->name, 'taxonomy' );

		}

	} elseif ( is_category() ) {

		$cat = get_queried_object();

		if ( $cat->parent != 0 ) {

			$ancestors = array_reverse( get_ancestors( absint( $cat->cat_ID ), 'category' ) );
			if ( is_array( $ancestors ) && 0 < count( $ancestors ) ) { foreach( $ancestors as $ancestor ) {

				AceFrontendRenderingMethods::renderBreadcrumbItem( get_cat_name( $ancestor ), 'taxonomy', get_category_link( $ancestor ) );

			} } unset( $ancestors );
		}

		AceFrontendRenderingMethods::renderBreadcrumbItem( $cat->cat_name, 'taxonomy', get_category_link( absint( $cat->term_id ) ) );
		unset( $cat );

	} elseif ( is_page() ) {

		if ( $post->post_parent != 0 ){

			$ancestors = array_reverse( get_post_ancestors( absint( $post->ID ) ) );

			if ( is_array( $ancestors ) && 0 < count( $ancestors ) ) { foreach( $ancestors as $ancestor ) {

				AceFrontendRenderingMethods::renderBreadcrumbItem( get_the_title( $ancestor ), 'page', get_permalink( $ancestor ) );

			} } $ancestors = null;

		}

		$title = $post->post_title;

		AceFrontendRenderingMethods::renderBreadcrumbItem( get_the_title( $post ), 'page' );

	} elseif ( is_singular() ) {

		$categories = get_the_category( absint( $post->ID ) );
		if( isset( $categories[ 0 ] ) ) {

			$cat = $categories[ 0 ];

			if ( $cat->parent != 0 ) {

				$ancestors = array_reverse( get_ancestors( absint( $cat->cat_ID ), 'category' ) );

				if ( is_array( $ancestors ) && 0 < count( $ancestors ) ) { foreach( $ancestors as $ancestor ) {

					AceFrontendRenderingMethods::renderBreadcrumbItem( get_cat_name( $ancestor ), 'taxonomy', get_category_link( $ancestor ) );

				} }
				unset( $ancestors );

			}

			AceFrontendRenderingMethods::renderBreadcrumbItem( $cat->cat_name, 'taxonomy', get_category_link( absint( $cat->term_id ) ) );

			unset( $cat );

		}
		unset( $categories );

		AceFrontendRenderingMethods::renderBreadcrumbItem( get_the_title( $post ), 'page' );

	} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {



	}

echo '</ul>';
echo '</div>';

