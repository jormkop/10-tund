<?php

class InterestsManager {
	
	private $connection;
	private $user_id;
	
	// kui tekitan new, siis käivitatakse see funktsioon
	function __construct($mysqli, $user_id_from_session){
		//selle klassi muutuja
		$this->connection = $mysqli;
		$this->user_id = $user_id_from_session;
		
		echo "huvialade haldus käivitatud, kasutaja=".$this->user_id;
	}
	
	function addInterest($new_interest){		
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id FROM interests WHERE name=?");
		$stmt->bind_param("s", $new_interest);
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()){
			$error = new StdClass();
			$error->id = 0;
			$error->message = "huviala <strong>".$new_interest."</strong> on juba olemas!";
			$response->error = $error;
			return $response;
		}
		$stmt->close();
		$stmt = $this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
		$stmt->bind_param("s", $new_interest);
		if($stmt->execute()){
			$success = new StdClass();
			$success->message = "huviala edukalt lisatud";
			$response->success = $success;
		}else{
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			$response->error = $error;
		}
		$stmt->close();
		return $response;
	}
	
	function createDropdown(){
		
		$html = '';
		$html .= '<select name="new_dd_selection">';
		
		//$html .= '<option selected>1</option>';
		$stmt = $this->connection->prepare("SELECT id, name FROM interests");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		while($stmt->fetch()){
			
			$html .= '<option value="'.$id.'">'.$name.'</option>';
			
		}
		
		
		$html .= '</select>';
		return $html;		
	}
	function addUserInterest(){
		//1. kontrollin ega ei ole olemas
		//2. lisan juurde
		//user_interests
		//iterests_id see mis kasutaja sisestas
		//user_id on muutujas $this->user_id
		
		
	}
	
	
	
	
	
}
?>