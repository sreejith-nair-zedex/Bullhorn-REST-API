<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( "bhRestApi" ) ) {
	class bhRestApi {
		protected static $instance;
		private $authUrl        ="https://auth.bullhornstaffing.com/oauth/";
		private $client_id      ="ab321f1f-dc8c-4d4a-b588-395c04f30386";
		private $client_secret  ="FxWWhpXO1PcltLdmXcMOgpPD";
		private $username       ="PhytonTalentAdvisors.23002.API";
		private $password       ="PhytonTalent23!";
		private $restLoginUrl   ="https://rest.bullhornstaffing.com/rest-services/login?version=*&access_token=";
		private $isTokenSet     = false;
		private $GET            = ['method' => "GET"];
		private $POST           = ['method' => "POST" ];
		private $access_token   = '';
		private $refresh_token  = '';

		public function __construct() {
			add_action('init', [$this, 'bullhornRestApi']);
		}

		public function bullhornRestApi(){

			if (empty($this->auth_code)){
				$this->auth_code = $this->get_auth_code();
			}

			if (!empty($this->auth_code)) {
				$tokens = $this->get_tokens();
				$this->access_token = $tokens->access_token;
				$this->refresh_token = $tokens->refresh_token;
				$accessTokenExpiryTime = strtotime( '+1 minutes' ); // Add 10 minutes to the current time
			}
		}

		public function get_new_tokens($refreshToken){
			$refreshTokenUrl = $this->authUrl ."token?grant_type=refresh_token&refresh_token=". $refreshToken ."&client_id=". $this->client_id ."&client_secret=". $this->client_secret;
			$response = wp_remote_request($refreshTokenUrl, $this->POST);
			return json_decode( $response['body'] );
		}

		public function get_tokens(){
			$tokenUrl = $this->authUrl ."token?grant_type=authorization_code&code=". $this->auth_code . "&client_id=". $this->client_id ."&client_secret=" . $this->client_secret;
			$response = wp_remote_request( $tokenUrl, $this->POST );
			return json_decode( $response['body'] );
		}

		public function get_auth_code(){
			$authorizeUrl = $this->authUrl ."authorize?client_id=". $this->client_id ."&response_type=code&action=Login&username=" .$this->username. "&password=" . $this->password;
			$response = wp_remote_request($authorizeUrl, $this->GET);

			$http_response = $response['http_response'];
			$response_object = $http_response->get_response_object();
			$url = $response_object->url;   // Get Response url that has auth code

			$queryString = parse_url($url, PHP_URL_QUERY); //Get authentication code from response url
			parse_str($queryString, $queryArray);
			return $queryArray['code'] ?? '';
		}

		public static function getInstance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}