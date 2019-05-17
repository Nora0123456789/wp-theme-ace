<?php
$title = $item->get_title();
$url = $item->get_permalink();
$date_published = $item->get_date();
?>

<div class="feed-list-item">
    <a class="item-link" href="<?php echo esc_url( $url ); ?>">
        <span class="item-date"><?php echo esc_html( $date_published ); ?></span>
        <span class="item-title"><?php echo esc_html( $title ); ?></span>
    </a>
</div>


