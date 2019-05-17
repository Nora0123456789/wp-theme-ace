<?php

do_action( ace()->getPrefixedActionHook( 'render_archive_start' ) );

AceFrontendRenderingMethods::loadTemplatePart( 'archive/header/blog', get_theme_mod( 'main_archive_article_type', 'card' ) );

do_action( ace()->getPrefixedActionHook( 'render_before_archive' ) );

do_action( ace()->getPrefixedActionHook( 'render_blog_articles' ) );

do_action( ace()->getPrefixedActionHook( 'render_archive_end' ) );

