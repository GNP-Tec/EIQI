<?php
class eiqi {
	var $pages=array("home", "user_set", "vm_ov");
	var $titles=array("Home", "Account settings", "VM Overview");
	var $links=array("Home", "Account", "VM Overview");
	var $curr=0;
	
	function parse_page($param) {
		if(is_integer($param)) {
			if($param<count($this->pages)) {
				$this->curr=$param;
				return $curr;
			}
			$this->curr=0;
			return 0;
		}
		if(is_string($param)) {
			$ret=array_search($param,$this->pages);
			if($ret==NULL) {
				$this->curr=0;
				return 0;
			}
			$this->curr=$ret;
			return $ret;
		}
		$this->curr=0;
		return 0;
	}
	function title_get() {
		return $this->titles[$this->curr];
	}
	function menu_get() {
		$help=0;
		$cnt=count($this->pages);
		$ret="";
		while($help<$cnt) {
			$ret.="<li ";
			if($this->curr==$help) {
				$ret.=" class=\"current\"";
			}
			$ret.="><a href=\"index.php?p=".$this->pages[$help]."\">".$this->links[$help]."</a></li>\n";
			$help++;
		}
		return $ret;
	}
	function content_get() {
		switch($this->curr) {
			case 0: return "<h1>Welcome to EiQi!</h1>";
			default: break;
		}
	}
}

?>
