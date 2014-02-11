<?php
require_once("inc/hs_core.php"); //Include Core-File for basic user-IO
class hp {
	var $pages=array("home", "user_set", "vm_ov");
	var $titles=array("Home", "Account settings", "VM Overview");
	var $links=array("Home", "Account", "VM Overview");
	var $curr=0;
	var $hs;

	function __construct()  {
		$this->hs=New hs_core;
		$this->hs->init();
		if(isset($_GET['p'])) {
			$this->parse_page($_GET['p']);
		}
	}

	function __destruct() {
		unset($this->hs);
	}

	function header_get() {
		$ret="";
		if($this->hs->is_auth()) {
			if(isset($_GET['logout'])) {
				$this->hs->logout();
			}
		} else {
			if(isset($_POST["username"])) {
				if($this->hs->login($_POST["username"],$_POST["password"])) {
					$ret.="<script type=text/javascript>alert(\"User and Password combination is wrong!\")</script>";
				}
			}
		}
		return $ret;
	}
	function parse_page($param) {
		if(is_integer($param)) {
			if($param<count($this->pages)) {
				$this->curr=$param;
				return;
			}
			$this->curr=0;
			return;
		}
		if(is_string($param)) {
			$ret=array_search($param,$this->pages);
			if($ret==NULL) {
				$this->curr=0;
				return;
			}
			$this->curr=$ret;
			return;
		}
		$this->curr=0;
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
	function sidebar_get() {
		$ret="";
		if($this->hs->is_auth()) {
			$ret.="<div class=\"sidebar\">\n<div class=\"sidebar_item\"><h2>Welcome!</h2>";
			$ret.="Hello, ".$this->hs->get_title()." ".$this->hs->get_first_name()." ".$this->hs->get_last_name()."!<br>Login Time: ".$this->hs->get_last_login()."<br><br>";
			$ret.="<a href=\"index.php?logout\">Logout</a>\n</div>\n</div>\n";
		} else {
			$ret.="<div class=\"sidebar\">";
			$ret.="<div class=\"sidebar_item\">";
			$ret.="<h2>Login</h2>";
			$ret.="<form action=\"index.php\" method=\"post\">";
			$ret.="Username: <input type=\"text\" name=\"username\" /><br>";
			$ret.="Password: <input type=\"password\" name=\"password\" /><br>";
			$ret.="<input type=\"submit\" value=\"Login!\"/>";
			$ret.="</form>";
			$ret.="</div><!--close sidebar_item-->";
			$ret.="</div><!--close sidebar-->";
		}
		return $ret;
	}
	function content_get() {
		switch($this->curr) {
			case 0: return "<h1>Welcome to EiQi!</h1>";
			default: break;
		}
	}
	function footer_get() {
		$ret="";
		$ret.=$this->hs->end();
		return $ret;
	}
}

?>
