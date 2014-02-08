<?php
require("./inc/hs_settings.php");
class hs_core_set {
	var $user="";
	var $pass="";
	var $user_id=0;

	var $email="";
	var $title="";
	var $first_name="";
	var $last_name="";
	var $address="";
	var $postcode="";
	var $city="";
	var $country="";

	var $language="";

	var $reg_ip="";
	var $last_ip="";
	var $reg_time=0;
	var $last_login=0;
	
	var $group_ids;
	var $group_names;
	var $groupsett;

	var $auth=NULL;
	var $usersett;

	var $temp_vars;	

	function init() {
		global $hs_temp_name,$hs_temp_group;
		$this->user=$hs_temp_name;
		$this->group_id=$hs_temp_group;
	}

}

function es($string) { return mysql_real_escape_string($string); }
function check_email($email) {
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return 0;
	}
	return 1;
}

class hs_core {
	var $db_conn=NULL;
	var $state=NULL;
	private $settings;
	private $start_time;
	private $end_time;
	var $run_time;





	//Unabhängige Funktionen (init,end,is_auth(), get_user(), get_pass())

	function init() {
		global $hs_db_name, $hs_db_user, $hs_db_pass, $hs_db_host;
		if ($this->state!=NULL) { return HS_ERR; }
		$this->start_time=microtime(true);
		if($hs_db_name=="" || $hs_db_user=="" || $hs_db_pass=="" || $hs_db_host=="") {
			return HS_ERR_DB;
		}
		session_start();
		$this->db_conn=mysql_pconnect($hs_db_host, $hs_db_user, $hs_db_pass);
		if($this->db_conn==NULL) { echo mysql_error(); return HS_ERR_DB; }
		if(!mysql_select_db($hs_db_name)) {  return HS_ERR_DB; }
		
                if(isset($_SESSION["hs_core_set"])) {
                        $this->settings=unserialize($_SESSION["hs_core_set"]);
			if(HS_LOGIN_TIMEOUT && $this->settings->auth && (time()-strtotime($this->settings->last_login))>HS_LOGIN_TIMEOUT) {
				echo "Logged out by timeout! ".strtotime($this->settings->last_login)." ".time()." ".$this->settings->last_login."<br>";
				unset($this->settings);
				$this->settings= new hs_core_set;
				$this->settings->init();
			}		
	        } else {
        	        $this->settings= new hs_core_set;
			$this->settings->init();
			echo "creating new session!<br>";
        	}

		echo "init done!<br>";
		$this->state=1; //State 1 means initialised and ready
		return 0;
	}
	function end() {
		if($this->state!=1) {
			return HS_ERR;
		}
		$_SESSION["hs_core_set"]=serialize($this->settings);
		mysql_close($this->db_conn);
		$state=-1; //Means  deactivated.
		$this->end_time=microtime(true);
		$this->run_time=$this->end_time-$this->start_time;
		echo "Runtime: ".$this->run_time."s.<br>";
	}

	function is_auth() {
		return $this->settings->auth;
	}
	function get_user() {
		return $this->settings->user;
	}
	function get_email() {
		return $this->settings->email;
	}
	function get_title() {	
		return $this->settings->title;
	}
	function get_first_name() {
		return $this->settings->first_name;
	}
	function get_last_name() {
		return $this->settings->last_name;
	}
	function get_address() {
		return $this->settings->address;
	}
	function get_postcode() {
		return $this->settings->postcode;
	}
	function get_city() {
		return $this->settings->city;
	}
	function get_country() {
		return $this->settings->country;
	}
	function get_user_id() {
		return $this->settings->user_id;
	}
	function get_reg_ip() {
		return $this->settings->reg_ip;
	}
	function get_last_ip() {
		return $this->settings->last_ip;
	}
	function get_reg_time() {
		return $this->settings->reg_time;
	}
	function get_last_login() {
		return $this->settings->last_login;
	}
	function get_language() {
		return $this->settings->language;
	}

	function set_userinfo($email="",$title="", $first_name="", $last_name="", $address="", $postcode="", $city="", $country="",$language="", $timezone="") {
		if($this->state!=1) {
			return HS_ERR;
		}
		if($this->settings->auth) {
			$query="UPDATE users SET ";
			$do=0;
			if($email!="") {
				$do=1;
				$email=es($email);
				$query=$query."email = '".$email."'";
				$this->settings->email=$email;
			} else if(HS_REG_EMAIL) {
				return HS_ERR_EMAIL;
			}
			if($title!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$title=es($title);
				$query=$query."title = '".$title."'";
				$this->settings->title=$title;
			}
			if($first_name!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$first_name=es($first_name);
				$query=$query."first_name = '".$first_name."'";
				$this->settings->first_name=$first_name;
			} else if(HS_REG_REAL_NAME) {
				return HS_ERR_NAME;
			}
			if($last_name!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$last_name=es($last_name);
				$query=$query."last_name = '".$last_name."'";
				$this->settings->last_name=$last_name;
			} else if(HS_REG_REAL_NAME) {
				return HS_ERR_NAME;
			}
			if($address!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$address=es($address);
				$query=$query."address = '".$address."'";
				$this->settings->address=$address;
			} else if(HS_REG_ADDRESS) {
				return HS_ERR_ADDR;
			}
			if($postcode!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$postcode=es($postcode);
				$query=$query."postcode = '".$postcode."'";
				$this->settings->postcode=$postcode;
			} else if(HS_REG_ADDRESS) {
				return HS_ERR_ADDR;
			}
			if($city!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$city=es($city);
				$query=$query."city = '".$city."'";
				$this->settings->city=$city;
			} else if(HS_REG_ADDRESS) {
				return HS_ERR_ADDR;
			}
			if($country!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$country=es($country);
				$query=$query."country = '".$country."'";
				$this->settings->country=$country;
			} else if(HS_REG_ADDRESS) {
				return HS_ERR_ADDR;
			}
			if($language!="") {
				if($do) {
					$query.=", ";
				}
				$do=1;
				$language=es($language);
				$query=$query."language = '".$language."'";
				$this->settings->language=$language;
			}
			if($timezone!="") {
				if(intval($timezone)>12  || intval($timezone) < -12) {
					return HS_ERR_TIMEZONE;
				}
				if($do) {
					$query.=", ";
				}
				$do=1;
				$timezone=es($timezone);
				$query.="timezone = '".$timezone."'";
				$this->settings->timezone=$timezone;
			}
			if($do) {
				$query= $query." WHERE id=".$this->settings->user_id;
				$res=mysql_query($query);
				if($res==0) {
					return HS_ERR_DB;
				}
				return 0;  
			}
		}
		return HS_ERR;
	}




	//Benutzer-Authentifikation (login, logout, register)
		
	function login($username,$password) {
		if($this->state!=1) {
			return HS_ERR;
		}
		if($this->settings->auth==1) {
			return 0;
		}
		$query="SELECT * FROM users WHERE username='".es($username)."'";	
		$res=mysql_query($query,$this->db_conn);	    
		if($res==NULL) {
			return HS_ERR_DB;
		}
		$res=mysql_fetch_assoc($res);
		if($res["password"]!=hash("sha512",$username.$password)) {
			return HS_ERR_USER;
		}
			
		if($res["id"]==0 || $res["active"]==0) {
			return HS_ERR_USER;
		}
		$this->settings->user=$res["username"];
		$this->settings->pass=$res["password"];
		$this->settings->email=$res["email"];
		$this->settings->title=$res["title"];
		$this->settings->first_name=$res["first_name"];
		$this->settings->last_name=$res["last_name"];
		$this->settings->address=$res["address"];
		$this->settings->postcode=$res["postcode"];
		$this->settings->city=$res["city"];
		$this->settings->country=$res["country"];
		$this->settings->user_id=$res["id"];

		$this->settings->group_id=$res["group_id"];

		$this->settings->reg_ip=$res["reg_ip"];
		$this->settings->last_ip=$res["last_ip"];
		$this->settings->reg_time=$res["reg_time"];

		$this->settings->language=$res["language"];

		$query="UPDATE users SET last_login=NOW(), last_login_ip='".$_SERVER["REMOTE_ADDR"]."'  WHERE id=".$this->settings->user_id.";";
		$res=mysql_query($query);
		if($res==NULL) {
			return HS_ERR_DB;
		}
		$query="SELECT last_login FROM users WHERE id=".$this->settings->user_id.";";
		$res=mysql_query($query);
		if($res==NULL) {
			return HS_ERR_DB;
		}
		$res=mysql_fetch_assoc($res);
		$this->settings->last_login=$res["last_login"];
		$query="SELECT * FROM user_settings WHERE user_id=".$this->settings->user_id;
		$res=mysql_query($query);
		while(($help=mysql_fetch_assoc($res))!=NULL) {
			switch($help["type"]) {
				case "int": $this->settings->usersett[$help["name"]]=intval($help["value"]); 
					break;
				case "string": $this->settings->usersett[$help["name"]]=$help["value"];
					break;
				case "float": $this->settings->usersett[$help["name"]]=floatval($help["value"]);
					break;
				default: break;
			}
		}
		$this->settings->auth=1;
		return 0;
	}

	function logout() {
		if($this->settings->auth==0) {
			return HS_ERR_AUTH;
		}
		unset($this->settings);
		$this->settings= new hs_core_set;
		$this->settings->init();
		return 0;
	}
	function register($username, $password, $email, $title="", $first_name="", $last_name="", $address="", $postcode="", $city="", $country="", $language="") {
		global $hs_reg_timeout,$hs_default_group,$hs_reg_timeout;
		if($this->state!=1) {
			return HS_ERR;
		}
		if($this->settings->auth) {
			return HS_ERR_AUTH;
		}
		if($username=="" || $password=="") {
			return HS_ERR_USER;
		}
		if($email=="" || check_email($email)) {
			return HS_ERR_EMAIL;
		}
		if($language=="") {
			return HS_ERR_LANG;
		}
		if(HS_REG_TIMEOUT>0) {
			$query="SELECT reg_time FROM users WHERE reg_ip='".$_SERVER["REMOTE_ADDR"]."'";
			$res=mysql_query($query);
			$curr=time()-HS_REG_TIMEOUT;
			while(($arr=mysql_fetch_row($res))!=NULL) {
				if(strtotime($arr[0])>=$curr) {
					return HS_ERR_TIMEOUT;
				}
			}
		}
		if(HS_REG_REAL_NAME && ($first_name=="" || $last_name=="")) {
			return HS_ERR_NAME;
		}
		if(HS_REG_ADDRESS && ($address=="" || $postcode=="" || $city=="" || $country=="")) {
			return HS_ERR_ADDR;
		}
			
		$username=es($username);
		$password=hash("sha512",$username.$password);
		$query="SELECT id FROM users WHERE username='".$username."' OR email='".$email."'";
		$res=mysql_query($query);
		$res=mysql_fetch_assoc($res);
		if(isset($res["id"])) {
			return HS_ERR;
		}
		$unlock=0;
		if(HS_REG_UNLOCK!="email") {
			if(HS_REG_UNLOCK==1) {
				$unlock=1;
			}
			//ADD EMAIL UNLOCK HERE, create unlock-id
		}
		$query="INSERT INTO users (group_id,username,password,email,reg_ip,reg_time,title,first_name,last_name,address,postcode,city,country,language,active) VALUES (".HS_REG_DEFAULT_GROUP.", '".$username."', '".$password."', '".es($email)."', '".$_SERVER["REMOTE_ADDR"]."', NOW(), '".es($title)."', '".es($first_name)."', '".es($last_name)."', '".es($address)."', '".es($postcode)."', '".es($city)."', '".es($country)."', '".es($language)."', '".$unlock."');";
		if(mysql_query($query)==NULL) {
			echo mysql_error();
			return HS_ERR_DB;
		}
		return 0;
	}






	//Benutzer-Einstellungen (user_getvalue,user_setvalue,user_deletevalue)


	function user_value_get($valuename) {
		$valuename=es($valuename);
		if(isset($this->settings->usersett[$valuename])) {
			return $this->settings->usersett[$valuename];
		} else {
			return NULL;
		}
	}
	function user_value_set($valuename, $type, $value) {
		if($type!="int" && $type!="float" && $type!="string") {
			return HS_ERR;
		}
		$valuename = es($valuename);
		$value = es($value);
		if($this->settings->auth==NULL) {
			$this->settings->usersett[$valuename]=$value;
			return 0;
		}
		if(isset($this->settings->usersett[$valuename])) {
			$this->settings->usersett[$valuename]=$value;
			$query="UPDATE user_settings SET value ='".$value."', type='".$type."'  WHERE user_id =".$this->settings->user_id." AND name='".$valuename."'";
			if(mysql_query($query)==NULL) {
				return HS_ERR;
			}
			return 0;
		} else {
			$this->settings->usersett[$valuename]=$value;
			$query="INSERT INTO user_settings (user_id,name,type,value) VALUES (".$this->settings->user_id.", '".$valuename."', '".$type."', '".$value."');";
			if(mysql_query($query)==NULL) {
				return HS_ERR;
			}
			return 0;
		}
	}

	function user_value_delete($valuename) {
		$valuename=es($valuename);
		if(isset($this->settings->usersett[$valuename])) {
			unset($this->settings->usersett[$valuename]);
			if($this->settings->auth!=NULL) {
				$query="DELETE FROM user_settings WHERE user_id=".$this->settings->user_id." AND name='".$valuename."'";
				if(mysql_query($query)==NULL) {
					return HS_ERR;
				}
			}
			return 0;
		}
		return HS_ERR;
	}
	function user_temp_get($valuename) {
		if(isset($this->settings->temp_vars[$valuename])) {
			return $this->settings->temp_vars[$valuename];
		} else {
			return NULL;
		}
	}
	function user_temp_set($valuename,$value) {
		if($valuename!="") {
			$this->settings->temp_vars[$valuename]=$value;
			return 0;
		} else {
			return HS_ERR;
		}
	}
	function user_temp_delete($valuename) {
		if(isset($this->settings->temp_vars[$valuename])) {
			unset($this->settings->temp_vars[$valuename]);
			return 0;
		} else {
			return HS_ERR;
		}
	}



	//Gruppen Einstellungen
	function group_get() {
		return $this->settings->group_id;
	}
	function group_get_name() {
		return $this->settings->group_name;
	}
	function group_get_right($rightname) {
		if(isset($this->settings->groupsett[$rightname])) {
			return $this->settings->groupsett[$rightname];
		} else {
			return NULL;
		}
	}
	
		

}
?>
