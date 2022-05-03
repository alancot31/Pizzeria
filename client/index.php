<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Client web</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" media="all"/>
		<link rel="icon" type="image/png" href="images/favicon.png" />
	</head>
	<body>

<?php
	
	$url = null;
	$method = "POST";
	$parameters = null;
	
	if (!empty($_POST["url"])) $url = $_POST["url"];
	if (!empty($_POST["method"])) $method = $_POST["method"];
	if (!empty($_POST["parameters"])) $parameters = $_POST["parameters"];
		
?>
		
        <div class="container-form">
			<form method="POST" action="index.php">
				<div class="form-line">
					<label class="form-label">URL :</label>
					<input name="url" type="text" class="form-field" value="<?php echo $url;?>">
				</div>
				<div class="form-line">
					<label class="form-label">Méthode d'envoi :</label>
					<select name="method" class="form-field">
						<option value="POST" <?php if ($method == "POST") echo "selected";?> >POST</option>
						<option value="GET" <?php if ($method == "GET") echo "selected";?> >GET</option>
						<option value="DELETE" <?php if ($method == "DELETE") echo "selected";?> >DELETE</option>
						<option value="PUT" <?php if ($method == "PUT") echo "selected";?> >PUT</option>
					</select>
				</div>
				 <div class="form-line">
					<label class="form-label">Paramètres corps requête :</label>
					<textarea name="parameters" class="form-field form-textarea"><?php echo $parameters;?></textarea>
				</div>
				<div class="container-submit">
					<input class="submit-button" type="submit">
				</div>
			</form>
        </div>
	
		<div class="container-form">
			<div class="http_reponse">
		
<?php

	include_once("tools/RequestSender.php");

	if (!empty($_POST["url"]) && !empty($_POST["method"])) {

		switch($_POST["method"]) {
			case "GET" :
				$response = RequestSender::sendGetRequest($_POST["url"]);
				break;

			case "POST" :
				$data = null;
				if (!empty($_POST["parameters"])) {
				   $data = $_POST["parameters"]; 
				}
				$data = json_decode($data);
				$response = RequestSender::sendPostRequest($_POST["url"], $data);
				break;

			case "PUT" :
				$data = null;
				if (!empty($_POST["parameters"])) {
				   $data = $_POST["parameters"]; 
				}
				$data = json_decode($data);
				$response = RequestSender::sendPutRequest($_POST["url"], $data);
				break;

			case "DELETE" :
				$response = RequestSender::sendDeleteRequest($_POST["url"]);
				break;

			default :
				break;
		}

		echo $response;	
	}
	else {
		echo "Rien à afficher";
	}
?>
			</div>
		</div>
	</body>
</html>