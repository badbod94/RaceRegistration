<?php


//validate & sanitize inputs
if(!empty($_POST)){

	$result = form_validator($_POST);

	if($result['status']){
		//code

		//connect to DB
		$pdo=connect_db();

		//check for duplicate emails - We allow only one registration per email
		$duplicate=check_duplicate_email($_POST["email"],$pdo);
		if($duplicate!=null){
			echo  json_encode( array('message' => 'Email Already registered','state'=>4));
			return;
		}

		//check if there is more available seats for the category
		$range=get_category_range($_POST["category"],$pdo);

		if($range["status"]==false){
			echo  json_encode( array('message' => 'Category doesn\'t exist','state'=>4));
			return;

		}
		else{
			$begin_slot=$range["begin"];
			$end_slot=$range["end"];
		}

		//get max bib for selected category
		$max_bib=check_valid_bib($begin_slot,$end_slot,$pdo);
		if($max_bib<$end_slot && $max_bib>=$begin_slot){
			$max_bib=$max_bib+1;
		}
		else if($max_bib==0)
			$max_bib=$begin_slot;
		else {
			echo  json_encode( array('message' => 'All seats reserved for this category','state'=>4));
			return;
		}
		//insert user and generate bib
		$user_id=insert_user($_POST,$pdo);
		if($user_id!=null){
			insert_race($user_id,$max_bib,$pdo);
		}


		echo json_encode(array("message"=>"You have succefully registered</br> Your bib : ".$max_bib,"state"=>1));
		
	}else{
		echo  json_encode( array('message' => 'Missing Fields','error'=>$result,'status'=>0));
	}
}else{
	echo  json_encode( array('message' => 'Missing Post','status'=>3));
}








/* Functions */

function form_validator($inputs){

	$error = array();
	$error='';
	$name_pattern = "/^[a-z][a-z ]*$/i";
	$email_pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";

	$email    = strtolower(trim($_POST['email']));
	$name     = trim($_POST['name']);
	$dob      = trim($_POST['dob']);
	$category = '';
	if(isset($_POST['category'])){$category = trim($_POST['category']);}
	 
		if (isset($inputs['email'])   &&  $email   ==''  ) {$error = 'Please fill Email field';$errors['email'] = 'error';}else{
			if (!preg_match(strtolower($email_pattern), $email)) {
				$error = 'Please Use a valid Email';$errors['email'] = 'error'.$email;
			}else{$errors['email'] = '';}
		}

		if (isset($inputs['dob']) 	 &&  $dob   =='') { $error .= 'Please fill First Name field';$errors['dob'] = 'error';}else{$errors['dob'] = '';}
		if (isset($inputs['name']) 	 &&  $name   =='') { $error .= 'Please fill First Name field';$errors['name'] = 'error';}else{$errors['name'] = '';}

		if (!isset($_POST['category']) ||  $category =='') { $error .= 'Please Select Country';$errors['category'] = 'error';}else{$errors['category'] = '';}

		if ($error =='') {
			return array('status'=>true);
		}else{
			return array('status'=>false,'missing_fields'=>$errors);
		}

	}
function connect_db(){
	$host = 'HOST';
	$db   = 'marathon';
	$user = 'USER';
	$pass = 'PASSWORD';
	$charset = 'utf8mb4';
	$driver="mysql";

	$dsn = "$driver:host=$host;dbname=$db;charset=$charset";
	$options = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
	];
	try {
	     $pdo = new PDO($dsn, $user, $pass, $options);
	} catch (\PDOException $e) {
	     throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
	return $pdo;
}

function insert_user($data,$pdo){

	try {
	    $stmt=$pdo->prepare("INSERT INTO users VALUES (NULL,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)");
	    $stmt->execute([$data["name"], date("Y-m-d", strtotime($data["dob"])),$data["email"],$data["category"]]);
	} catch (PDOException $e) {

	        throw $e;
	    
	}
	
 return $pdo->lastInsertId();
}
function insert_race($user_id,$bib,$pdo){

	try {
	    $stmt=$pdo->prepare("INSERT INTO race_number VALUES (NULL,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)");
	    $stmt->execute([$user_id,$bib]);
	} catch (PDOException $e) {

	        throw $e;
	    
	}

 return $pdo->lastInsertId();
}

function check_valid_bib($begin,$end,$pdo){
	$stmt = $pdo->prepare('SELECT max(bib) as bib FROM race_number where bib>=? and bib<=?');
	$stmt->execute([$begin,$end]);
	$bib = $stmt->fetchColumn();
	return $bib;
}

function check_duplicate_email($email,$pdo){
	$stmt = $pdo->prepare('SELECT id  FROM users where email=?');
	$stmt->execute([$email]);
	$id = $stmt->fetchColumn();
	return $id;
}

function get_category_range($category,$pdo){
	$stmt = $pdo->prepare('SELECT begin_slot,end_slot  FROM categories where id=?');
	$stmt->execute([$category]);
	$data=$stmt->fetchAll();
	if($data)
	return array("status"=>true,"begin"=>$data[0]["begin_slot"],"end"=>$data[0]["end_slot"]);
	else
		return array("status"=>false,"begin"=>0,"end"=>0);
}