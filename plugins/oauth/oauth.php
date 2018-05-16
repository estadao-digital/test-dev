<?php
#use OAuthStore;
#https: // www.sitepoint.com/creating-a-php-oauth-server/
       // `oauth_register.php` to let an user obtain a consumer key and secret.
       // `request_token.php` to return a request token.
       // `authorize.php` to let the user authorize a request token.
       // `access_token.php` to exchange an authorized request token for an access token.

require_once 'OAuthServer.php';
require_once 'OAuthStore.php';
class oauth {
	private $store;
	private $server;
	function __construct() {
		$filename = __DIR__ . "/store/mysql/mysql.sql";
		$handle = fopen ( $filename, "r" );
		$conteudo = fread ( $handle, filesize ( $filename ) );
		fclose ( $handle );
		$db = new mydataobj ();
		$db->query ( $conteudo );
		unset ( $db );
		
		header ( 'X-XRDS-Location: http://' . $_SERVER ['SERVER_NAME'] . '/services.xrds' );
		
		// OAuthStore::instance('MySQL', array('conn' => $GLOBALS['db_conn']));
		$this->store = OAuthStore::instance ( 'PDO', array (
				'conn' => database::kolibriDB () 
		) );
		
		$this->server = new OAuthServer ();
	}
	
	/**
	 * Update consumer data
	 *
	 * @param int $userId        	
	 * @param array $arrayData        	
	 *
	 */
	function updateconsumer($userId, $arrayData) {
		$key = $this->store->updateConsumer ( $arrayData, $userId, true );
		
		$c = $this->store->getConsumer ( $key, $userId );
		return $c;
		// echo 'Your consumer key is: <strong>' . $c['consumer_key'] . '</strong><br />';
		// echo 'Your consumer secret is: <strong>' . $c['consumer_secret'] . '</strong><br />';
	}
	
	/**
	 * Request Token
	 */
	function requestToken() {
		$this->server->requestToken ();
	}
	
	/**
	 * Request verify
	 */
	function OAuthRequestVerifier() {
		if (OAuthRequestVerifier::requestIsSigned ()) {
			try {
				$req = new OAuthRequestVerifier ();
				$user_id = $req->verify ();
				
				// If we have an user_id, then login as that user (for this request)
				if ($user_id) {
					$s = new auth ();
					$s->load ( $user_id );
					if ($s->getuserLogin ()) {
						session::init ();
						session::set ( "login", getVar ( 'login' ) );
						session::set ( "logged", "on" );
					}
					// **** Add your own code here ****
				}
			} catch ( OAuthException $e ) {
				// The request was signed, but failed verification
				header ( 'HTTP/1.1 401 Unauthorized' );
				header ( 'WWW-Authenticate: OAuth realm=""' );
				header ( 'Content-Type: text/plain; charset=utf8' );
				
				page::addBody($e->getMessage ());
				page::renderAjax();
				exit ();
			}
		}
	}
	
	/**
	 *
	 * register oath
	 *
	 * @param array $params
	 *        	Array containing the necessary params.
	 *        	$params = [
	 *        	'requester_name' => (string) user Name Required.
	 *        	'requester_email' => (string) user mail Required.
	 *        	'callback_uri' => (string) http://www.myconsumersite.com/oauth_callback.
	 *        	'application_uri' => (string) http://www.myconsumersite.com/.
	 *        	'application_descr' => (string) Describe aplication.
	 *        	'application_type' => (string) Type aplication.
	 *        	'application_commercial' => (int) 0 or 1 .
	 *        	
	 *        	
	 *        	
	 * @param array $consumer        	
	 * @param int $user_id        	
	 *
	 */
	function register($consumer, $user_id) {
		/*
		 * $consumer = array(
		 * // These two are required
		 * 'requester_name' => 'John Doe',
		 * 'requester_email' => 'john@example.com',
		 *
		 * // These are all optional
		 * 'callback_uri' => 'http://www.myconsumersite.com/oauth_callback',
		 * 'application_uri' => 'http://www.myconsumersite.com/',
		 * 'application_title' => 'John Doe\'s consumer site',
		 * 'application_descr' => 'Make nice graphs of all your data',
		 * 'application_notes' => 'Bladibla',
		 * 'application_type' => 'website',
		 * 'application_commercial' => 0
		 */
		
		// Register the consumer
		$key = $this->store->updateConsumer ( $consumer, $user_id );
		
		// Get the complete consumer from the store
		$consumer = $this->store->getConsumer ( $key );
		
		// Some interesting fields, the user will need the key and secret
		$consumer_id = $consumer ['id'];
		$consumer_key = $consumer ['consumer_key'];
		$consumer_secret = $consumer ['consumer_secret'];
	}
	
	/**
	 * autorize userid Access Token
	 * 
	 * @param int $user_id        	
	 */
	function authorize($user_id) {
		$this->server->authorizeVerify ();
		$authorized = array_key_exists ( 'allow', $_POST );
		$server->authorizeFinish ( $authorized, $user_id );
	}
	function accessToken() {
		$this->server->accessToken ();
	}
	
	
	/**
	 * 
	 * @return int user ID
	 */
	function verify() {
		if (OAuthRequestVerifier::requestIsSigned()) {
			try {
				$req = new OAuthRequestVerifier();
				$id = $req->verify();
				// If we have a user ID, then login as that user (for
				// this request)
				if ($id) {
					return $id;
				}
			}  catch (OAuthException $e)  {
				// The request was signed, but failed verification
				header('HTTP/1.1 401 Unauthorized');
				header('WWW-Authenticate: OAuth realm=""');
				header('Content-Type: text/plain; charset=utf8');
				page::addBody($e->getMessage());
				page::renderAjax();
				exit();
			}
		}
	}
}


