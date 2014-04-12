<?php

        $jsFiles = array(
                'respond.min.js',
                'skrollr.min.js',
                'jquery.isotope.min.js',
                'jqueryslidemenu.js',
                'jquery.fitvids.js',
                'scripts.js'
        );

        $buffer = "";
        foreach ($jsFiles as $jsfile) {
                $buffer .= file_get_contents($jsfile);
        }

        // Remove comments
        //$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

        // Remove space after colons
        //$buffer = str_replace(': ', ':', $buffer);
         
        // Remove whitespace
        //$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
         
        // Enable GZip encoding.
        ob_start("ob_gzhandler");

        // Enable caching
        header('Cache-Control: public');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
         
        // Set the correct MIME type, because Apache won't set it for us
        header("Content-type: text/javascript");
         
        // Write everything out
        echo $buffer;
?>