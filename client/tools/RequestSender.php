<?php

	class RequestSender {

		// envoi de la requête avec GET (récupération de données)
		public static function sendGetRequest($url_request) {
			
			$curl = curl_init($url_request);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json')                                                                       
			);   

			$reponse = curl_exec($curl);

			return $reponse;
		}
		
		// envoi de la requête avec POST (ajout de données), format des données : objet ou tableau php
		public static function sendPostRequest($url_request, $data_to_send)	{
			
			$data_encoded = null;
			if ($data_to_send != null && (is_array($data_to_send) || is_object($data_to_send) )) {
				$data_encoded = json_encode($data_to_send);  
			}
			
			$curl = curl_init($url_request);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_encoded);	
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($data_encoded))                                                                       
			);   

			$reponse = curl_exec($curl);
			
			return $reponse;
		}
		
		// envoi de la requête avec DELETE (suppression)
		public static function sendDeleteRequest($url_request)	{
			
			$curl = curl_init($url_request);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json')                                                           
			);   

			$reponse = curl_exec($curl);

			return $reponse;
		}
		
		// envoi de la requête avec PUT (mise à jour), format des données : objet ou tableau php
		public static function sendPutRequest($url_request, $data_to_send)	{
			
			$data_encoded = null;
			if ($data_to_send != null && (is_array($data_to_send) || is_object($data_to_send) )) {
				$data_encoded = json_encode($data_to_send);  
			}
			
			$curl = curl_init($url_request);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_encoded);	
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json')                                                                       
			);  

			$reponse = curl_exec($curl);

			return $reponse;
		}
	}
