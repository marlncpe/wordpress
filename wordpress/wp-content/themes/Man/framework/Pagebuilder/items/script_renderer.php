<?php
	header('Content-Type: text/javascript');
	
	require_once 'items.php';
	foreach ($blox_items as $item) {
		if( isset($item['js']) && $item['js']!='' ){
			include($item['js']);
		}else {
            if(file_exists($item['item'].'/'.$item['item'].'.js'))
                    include($item['item'].'/'.$item['item'].'.js');
        }
	}
?>