<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get All Categories
$app->get('/api/categories', function(Request $request, Response $response){
	$sql = "SELECT * FROM category";
	
	try{
		//Get Database Object
		$db = new db();
		//Connect
		$db = $db->connect();
		
		$stmt = $db->query($sql);
		$category = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($category);
		
	}catch(PDOException $e){
		echo '{"error": {"text":' .$e->getMessage().'}}';
	}
});

//Get Single category
$app->get('/api/categories/{id}', function(Request $request,Response $response){
	$id = $request->getAttribute('id');
	
	$sql = "SELECT * FROM category WHERE id = $id";
	
	try{
		//Get Database Object
		$db = new db();
		//Connect
		$db = $db->connect();
		
		$stmt = $db->query($sql);
		$category = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($category);
		
	}catch(PDOException $e){
		echo '{"error": {"text":' .$e->getMessage().'}}';
	}
	
});

//Add category
$app->post('/api/categories/add', function(Request $request, Response $response){
	$name = $request->getParam('name');
	
	
	$sql = "INSERT INTO category (name) VALUES (:name)";
		
	try{
		//Get Database Object
		$db = new db();
		//Connect
		$db = $db->connect();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':name', $name);
		
		$stmt->execute();
		
		echo '{"notice": {"text":"Category Added"}}';
		
	}catch(PDOException $e){
		echo '{"error": {"text":' .$e->getMessage().'}}';
	}
	
	
});

//Update category
$app->put('/api/categories/update/{id}', function(Request $request, Response $response){
	
	$id = $request->getAttribute('id');
	
	$name = $request->getParam('name');
	
	$sql = "UPDATE category SET
							name = :name
							
							
						WHERE id = $id";
							
		
	try{
		//Get Database Object
		$db = new db();
		//Connect
		$db = $db->connect();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindParam(':name', $name);
		
		
		$stmt->execute();
		
		echo '{"notice": {"text":"category '.$id.' Updated"}}';
		
	}catch(PDOException $e){
		echo '{"error": {"text":' .$e->getMessage().'}}';
	}
	
	
});

//Delete category
$app->delete('/api/categories/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	
	$sql = "DELETE FROM category WHERE id = $id";
		
	
	try{
		//Get Database Object
		$db = new db();
		//Connect
		$db = $db->connect();
	
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;
		echo '{"notice": {"text":"Category '.$id.' Deleted"}}';
		
	} catch(PDOException $e){
		echo '{"error": {"text":' .$e->getMessage().'}}';
	}
});

