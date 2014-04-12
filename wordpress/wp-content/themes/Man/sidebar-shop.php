<?php

echo '<div class="col-xs-12 col-md-3 col-lg-3 col-sm-4"><div id="sidebar" class="sidebar_area right_sidebar">';

if (function_exists('dynamic_sidebar'))
    dynamic_sidebar('woocommerce-sidebar');

echo '</div></div>';
?>