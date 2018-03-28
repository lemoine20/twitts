<?php
	require_once('database.php');

	// Database connection
	$db =dbConnect();
	if (!$db) {
		header ('HTTP/1.1 503 Service Unavailable');
		exit;
	}

	$requestType = $_SERVER['REQUEST_METHOD'];
	$request = substr($_SERVER['PATH_INFO'],1);
	$request = explode('/',$request);
	$requestRessource = array_shift($request);

	if($requestRessource == 'twitts'){
		$id = array_shift($request);
		if ($id == '')
			$id = NULL;

		// GET twitts
		if($requestType =='GET')
		{
			if (isset($_GET['login']))
				$data = dbRequestTwitts($db,$_GET['login']);
			else
		    $data = dbRequestTwitts($db);
		}

		//POST twitts
		if($requestType =='POST')
			$data = dbAddTwitt($db, $_POST['login'], $_POST['text']);

		//PUT twitts
		if($id!=NULL && $requestType =='PUT'){
			parse_str(file_get_contents('php://input'),$_PUT);
			$data = dbModifyTwitt($db, intval($id), $_PUT['login'], $_PUT['text']);
		}

		if($id!=NULL && $requestType =='DELETE')
			$data = dbDeleteTwitt($db, intval($id), $_GET['login']);

		//send data to the client
		header ('Content-Type: text/plain; charset=utf-8');
		header('cache-controle: no-store, no-cache, must-revalidate');
		header('Pragma: no-cache');
		if($requestType == 'POST')
			header('HTTP/1.1 201 Created');
		else
			header('HTTP/1.1 200 OK');
		echo json_encode($data);
		exit;
	}

	header('HTTP/1.1 400 Bad Request');
	exit;
