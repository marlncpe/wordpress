<?php

echo '<div class="col-xs-12 col-md-3 col-lg-3 col-sm-4"><div id="sidebar" class="sidebar_area left_sidebar">';

if (function_exists('dynamic_sidebar'))
    if ((is_single() || is_page()) && tt_getmeta('sidebar')) {
        dynamic_sidebar(tt_getmeta('sidebar'));
    } else {
        global $smof_data;
        $sidebar = 'post-sidebar';
        if (is_category())
            $sidebar = $smof_data['category_sidebar'];
        elseif (is_archive())
            $sidebar = $smof_data['archive_sidebar'];
        elseif (is_tag())
            $sidebar = $smof_data['tag_sidebar'];
        elseif (is_search())
            $sidebar = $smof_data['search_sidebar'];
        dynamic_sidebar($sidebar);
    }

echo '</div></div>';
?>