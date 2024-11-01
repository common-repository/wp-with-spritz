<?php

class MojoLoader{
	
	function url_path($filename){
		return plugin_dir_url( __FILE__ )."../".$filename;
	}

	function check_arr($arr){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

}

?>