<?php
	$eiqi_pages=array("home", "user_set", "vm_set");
	$eiqi_titles=array("Home", "Account settings", "VM Settings");
	
	function eiqi_parse_page($param) {
		echo "Count=".count($eiqi_pages);
		print_r($eiqi_pages);
		if(is_integer($param)) {
			if($param<count($eiqi_pages)) {
				return $param;
			}
			return 0;
		}
		if(is_string($param)) {
			$ret=array_search($param,$eiqi_pages);
			if($ret==NULL) {
				return 0;
			}
			return $ret;
		}
		return 0;
	}
	function eiqi_title_get($page) {
		if($page<count($eiqi_pages)) {
			return $eiqi_titles[$page];
		}
		return "Home";
	}

?>
