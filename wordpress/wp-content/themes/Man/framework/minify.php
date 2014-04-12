<?php

class TTMinify{
	var $css = array();
	var $js = array();

	function minify_style($files){
		$this->css = $files;
		add_action('wp_head', array($this, 'print_header_styles'), 9);
	}

	function minify_script($files){
		$this->js = $files;
		add_action('wp_footer', array($this, 'print_footer_scripts'), 100);
	}

	function get_path(){
		return trailingslashit(get_template_directory_uri()).'framework/min/';
	}

	function build_file_name($filename){
		$file = $filename;
		$split = explode('/wp-content/', $file, 2);
		$file = isset($split[1]) ? '/wp-content/'.$split[1] : $file;
		if( is_multisite() ){
			$domain_str = explode($_SERVER['HTTP_HOST'], network_home_url());
			$domain = isset($domain_str[1]) ? $domain_str[1] : '';
			$file = $domain.$file;
		}
		else{
			$domain_str = explode($_SERVER['HTTP_HOST'], site_url());
			$domain = isset($domain_str[1]) ? $domain_str[1] : '';
			$file = $domain.$file;
		}
		$file = str_replace('//', '/', $file);
		return $file;
	}

	function print_header_styles(){
		$files = '';
	    $index = 0;
	    foreach ($this->css as $item) {
	    	$file = $this->build_file_name($item);
	        $files .= $index==0 ? $file : ",".$file;
	        $index++;
	    }
		echo "<link rel='stylesheet' type='text/css' href='".$this->get_path()."?f=".$files."' />\n";
	}

	function print_footer_scripts(){
		$files = '';
	    $index = 0;
	    foreach ($this->js as $item) {
	    	$file = $this->build_file_name($item);
	        $files .= $index==0 ? $file : ",".$file;
	        $index++;
	    }
		echo "<script type='text/javascript' src='".$this->get_path()."?f=".$files."'></script>\n";
	}

}

?>