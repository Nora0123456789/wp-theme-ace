<?php
/**
 * Header for Author Archive Page.
**/
$queried_object = get_queried_object();
$user_id = absint( $queried_object->ID );
AceFrontendRenderingMethods::renderAuthorCard( $user_id, false, 'h1', true, 'standard' );
