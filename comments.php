<?php 
if ( isset( $_SERVER[ 'SCRIPT_FILENAME' ] ) && 'comments.php' == basename( $_SERVER[ 'SCRIPT_FILENAME' ] ) )
    die( __( 'Please do not load this page directly. Thanks!', 'ace' ) );
if ( post_password_required() ) { ?>
    <p class="nocomments"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'ace' ); ?></p>
<?php return; } ?>

<div id="comment-ping">
    <?php $comments_cnt = absint( count( get_comments( array( 'post_id' => $post->ID, 'type' => 'comment' ) ) ) ); ?>

    <!-- Comments -->
        <?php if ( $comments_cnt > 0 ) { ?>
            <h3 class="label-comment hoverable running-underline"><?php printf( 
                _n( '%d Comment', '%d Comments', $comments_cnt, 'ace' ), 
                $comments_cnt 
            ); ?></h3>
            <ul class="comment-list">
                <?php wp_list_comments( array(
                    'type' => 'comment',
                    'callback' => 'ace_comments_list'
                ) ); ?>
            </ul>
            <div class="navigation">
                <div class="next-posts"><?php previous_comments_link(); ?></div>
                <div class="prev-posts"><?php next_comments_link(); ?></div>
            </div>
        <?php 
            # Comment Pagination
                ace_comments_pagination();
        } ?>

    <!-- Pings -->
        <?php 
            $comments_number = intval( get_comments_number() );
            if ( $comments_number - $comments_cnt > 0 ) { 
        ?>
            <h3>
                <?php 
                printf( 
                    _n( '%d Ping', '%d Pings', absint( $comments_number - $comments_cnt ), 'ace' ), 
                    absint( $comments_number - $comments_cnt ) 
                ); unset( $comments_number, $comments_cnt );
                ?>
                
            </h3>
            <ul class="ping-list">
                <?php wp_list_comments( array(
                    'type' => 'pings',
                    'callback' => 'ace_pings_list'
                ) ); ?>
            </ul>
        <?php } ?>

</div>

<div id="comment-reply-form" class="comment-reply-form">

    <?php 
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? ' aria-required="true"' : '' );
    $defaults = array(
        'title_reply' => esc_html__( 'Leave a Comment', 'ace' ),
        'comment_notes_before' => '',
        'fields' => array(
            'author' => '<p class="comment-form-author"><label for="author">' . ( $req ? '<span class="required">*</span>' : '' ) . esc_html__( 'Name', 'ace' ) . '</label><br />' .
                '<input id="author" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" size="30"' . $aria_req . ' /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . ( $req ? '<span class="required">*</span>' : '' ) . esc_html__( 'E-mail Address ( Not Displayed on public )', 'ace' ) . '</label><br />' .
                '<input id="email" name="email" type="text" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" size="30"' . $aria_req . ' /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'ace' ) . '</label><br />' .
                '<input id="url" name="url" type="text" value="' . esc_attr( $commenter[ 'comment_author_url' ] ) . '" size="30" /></p>' 
        ),
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'ace' ) . '</label><br /><textarea id="comment" name="comment" cols="' . absint( wp_is_mobile() ? 40 : 70 ) . '" rows="8" aria-required="true"></textarea></p>',
        'comment_notes_after'  => ''
    ); unset( $commenter, $req, $aria_req );
    comment_form( $defaults ); unset( $defaults );
    wp_enqueue_script( 'comment-reply' ); 
    ?>

</div>