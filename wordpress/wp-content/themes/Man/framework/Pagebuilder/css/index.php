<?php

    $cssFiles = array(
            'font-awesome.min.css',
            'bootstrap-grid.css',
            'prettyPhoto.css',
            'device-mockups/device-mockups.css',
            'device-mockups/device-mockups2.css',
            'blox-frontend.css',
            'blox-buttons.css',
            'blox-icons.css',
            'blox-callouts.css',
            'blox-content-box.css',
            'blox-notification-box.css',
            'blox-placeholder.css',
            'blox-image-frame.css',
            'blox-audio.css',
            'blox-price-table.css',
            'blox-colors.css',
            'blox-blog.css',
            'blox-animations.css'
    );

    $buffer = "";
    foreach ($cssFiles as $cssFile) {
        $buffer .= file_get_contents($cssFile);
    }

    // Remove comments
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

    // Remove space after colons
    $buffer = str_replace(': ', ':', $buffer);
     
    // Remove whitespace
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
     
    // Enable GZip encoding.
    ob_start("ob_gzhandler");

    // Enable caching
    header('Cache-Control: public');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
     
    // Set the correct MIME type, because Apache won't set it for us
    header("Content-type: text/css");
     
    // Write everything out
    echo $buffer;
?>