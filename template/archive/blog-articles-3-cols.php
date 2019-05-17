<?php
/**
 * Articles with theme customizer style 3-cols
**/

$article_type = get_theme_mod( 'main_archive_article_type', 'card' );
AceFrontendRenderingMethods::renderBlogArticles( $article_type );


