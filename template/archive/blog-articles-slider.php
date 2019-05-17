<?php
/**
 * Articles with theme customizer style slider
**/

$article_type = get_theme_mod( 'main_archive_article_type', 'card' );
AceFrontendRenderingMethods::renderBlogArticles( $article_type );

