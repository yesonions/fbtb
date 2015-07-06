<?php
	require_once("Rest.inc.php");
	
	class API extends REST {
		public $data = "";
		
		//obviously would need to change to import elsewhere...
		const DB_SERVER = "localhost";
		const DB_USER = "dwadmin";
		const DB_PASSWORD = "kXs#18d6aSKdf4gH";
		const DB = "dw_msqldb";	
		
		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
		}
				
		private function GetSubThemes(){
			// Cross validation if the request method is GET else it will return "Not Acceptable" status
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0)
			{
				$sql=mysql_query("select subtheme_id, subtheme_name from test_setguide_theme_subtheme where theme_id=".$id,$this->db);
				if(mysql_num_rows($sql)>0)
				{
					$result = array();
					while($rlt = mysql_fetch_array($sql))
					{
						$result[] = $rlt;
					}
					// if success everythig is good send header as "ok" and return list of users in json format
					$this->response($this->json($result), 200);
				}
				$this->response('',204); // if no records "no content" status
			}
		}
		
		private function GetPricingForSet() {
			if($this->get_request_method()!= "GET"){
				$this->response('',406);
			}
			$id=(int)$this->_request['id'];
			if($id>0)
			{
				$sql=mysql_query("select country_code,price,currency_code,active from test_setguide_main_prices WHERE set_id=".$id,$this->db);
				if(mysql_num_rows($sql)>0)
				{
					$result = array();
					while($rlt=mysql_fetch_array($sql))
					{
						$result[] = $rlt;
					}
					$this->response($this->json($result),200);
				}
			}
			$this->response('',204);
		}
		
		private function GetLinks() {
			if($this->get_request_method()!= "GET"){
				$this->response('',406);
			}
			
		}
		
		private function GetCountries() {
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$sql = mysql_query("select country_code,currency_format,currency_symbol from test_setguide_countries", $this->db);
			if(mysql_num_rows($sql)>0)
			{
				$result = array();
				while($rlt = mysql_fetch_array($sql))
				{
					$result[] = $rlt;
				}
				$this->response($this->json($result),200);
			}
			$this->response('',204);
			
		}
		
		private function GetCurrencyFormatByCountry() {
			$country = $this->_request['country'];
			if($country != null && $country != "") {
				$sql=mysql_query("select country_code,currency_format, currency_symbol from test_setguide_countries WHERE country_code='".$country."'",$this->db);
				
				$result = mysql_fetch_row($sql) or die(mysql_error());
				$this->response($this->json($result),200);
			}
		}
		
		//Insert Methods
		private function AddPricing() {
			if($this->get_request_method() != "POST") {
				$this->response('',406);
			}
			
			$query = "";
			
			$set = $this->_request['Set'];
			$symbol = $this->_request['Symbol'];
			$price = $this->_request['Amount'];
			$active = $this->_request['Active'];
			$country = $this->_request['Country'];
			
			if ($set == '' || $set == null)
			{
				$this->response('',406);
			}
			$mysqli = new MySQLi(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB);
			
			$query = $mysqli->prepare("INSERT into test_setguide_main_prices 
				(set_id, country_code,price,currency_code,active) 
				values(?,?,?,?,?)");
			$query->bind_param('isssi',$set,$country,$price,$symbol,$active);
			
			$query->execute();			
			$mysqli->close();
			$this->response('',200);
		}
		
		private function AddLink() {
		
		}
		
		private function RemovePrice() {
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			$query = "";
			$country = $this->_request['Country'];
			$set = $this->_request['Set'];
			
			$mysqli = new MySQLi(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB);
			
			$query = $mysqli->prepare("Delete from test_setguide_main_prices 
				WHERE set_id=? AND country_code=?");
			$query->bind_param('is',$set,$country);
			
			$query->execute();			
			$mysqli->close();
			$this->response('',200);
			//$this->response($query,200);
		}
		
		private function AddSet() {
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			
			$action = $this->_request['Action'];
			$query = "";
			
			$setName = $this->_request['Name'];
			$setNumber = $this->_request['Number'];
			$revision = $this->_request['Revision'];
			$universal = $setNumber."-".$revision;
			$pieces = $this->_request['Pieces'];
			$theme = $this->_request['Theme'];
			$subtheme = $this->_request['Subtheme'];
			$wptag = $this->_request['Tag'];
			$image = $this->_request['Image'];
			$released = $this->_request['Start'];
			$retired = $this->_request['End'];
			$description = $this->_request['Description'];
			$stub = $this->stubify($setName);
			
			if($released == '') {$released = null; }
			if($retired == '') { $retired = null; }
			
			$mysqli = new MySQLi(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB);
			
			if($action == "new"){				
				// $query = $mysqli->prepare("INSERT into test_setguide_main 
					// set_number,revision,set_name,set_stub,theme_id,subtheme_id,pieces,
					// root_image,date_released,date_retired,wordpress_tag) 
					// values(?,?,?,?,?,?,?,?,?,?,?)");				
				// $query->bind_param('iisssiiisiis',$number,$revision,$name,$stub,$theme,$subtheme,
					// $pieces,$image,$released,$retired,$wptag);				
					
				$query = $mysqli->prepare("INSERT into test_setguide_main 
					(set_number,set_name,theme_id,subtheme_id,pieces,root_image,revision,
					set_stub,date_released,date_retired,wordpress_tag,universal_id,`description`) 
					values(?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$query->bind_param('isiiisisiisss',$setNumber,$setName,$theme,$subtheme,$pieces,$image,
					$revision,$stub,$released,$retired,$wptag,$universal,$description);
			}
			else{
				$query = $mysqli->prepare("UPDATE test_setguide_main SET 
					set_name=?,theme_id=?,subtheme_id=?,pieces=?,
					root_image=?,revision=?,set_stub=?,date_released=?,date_retired=?,
					wordpress_tag=?,universal_id=?,`description`=? 
					WHERE  set_number=".$setNumber);
				$query->bind_param('siiisisiisss',$setName,$theme,$subtheme,$pieces,$image,
					$revision,$stub,$released,$retired,$wptag,$universal,$description);
			}
			
			$query->execute();			
			$mysqli->close();
			$this->response('',200);
			
			
		}
		
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}	
		}
		
		private function stubify($data) {
			$data = str_replace(array('\'','"'),'',$data);
			$data = strtolower(trim(preg_replace('/[^a-zA-Z0-9\-]+/', '-', $data), '-'));
			return $data;
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>