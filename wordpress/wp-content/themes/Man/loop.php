<?php
global $post;
$overlay = 'both';
$content = 'excerpt';
?>
<article itemscope itemtype="http://schema.org/BlogPosting" id="post-<?php the_ID(); ?>" class="entry <?php echo format_class(get_the_ID()); post_class(); ?> blog_medium medium_top_image clearfix">
    <?php echo hover_featured_image(get_the_ID(), $overlay, 868); ?>
    <div class="entry_title">
        <h2 itemprop="headline"><a itemprop="url" href="' . get_permalink() . '"><?php the_title(); ?></a></h2>
    </div>
    <div class="entry_meta">
        <ul class="top_meta">
            <li class="meta_author"><?php echo __("BY ", "themeton") . get_author_posts_link(); ?></li>
            <li itemprop="keywords" class="entry_category"><?php echo __("IN ", "themeton") . get_the_category_list(', '); ?></li>
        </ul>
        <ul class="bottom_meta">
            <li itemprop="dateCreated" class="meta_date"><i class="icon-time"></i><?php echo __("Posted: ", "themeton") . date_i18n("M j, Y", strtotime(get_the_date())); ?></li>
            <li itemprop="comment" class="meta_comment"><i class="icon-comment"></i><?php echo __("Comments: ", "themeton") . comment_count(); ?></li>
            <li class="meta_like"><i class="icon-heart"></i> 47 likes</li>
        </ul>
        <a href="' . get_post_format_link(get_post_format(get_the_ID())) . '" title="" class="entry_format"></a>
    </div>
    <?php if ($content == 'both') { ?>
        <div class="entry_content">
            <?php the_excerpt(); ?>
            <p><a href="<?php the_permalink(); ?>" class="entry_more blox_elem_button blox_elem_button_medium blox_elem_color_background blox_elem_button_default"><i class="icon-arrow-right"></i><?php echo __('Read more', 'themeton'); ?></a></p>
        </div>
    <?php } elseif ($content == 'content') { ?>
        <div class="entry_content">
            <?php the_content(); ?>
        </div>
    <?php } elseif ($content == 'excerpt') { ?>
        <div class="entry_content">
            <?php the_excerpt(); ?>
        </div>
    <?php } ?>
</article>