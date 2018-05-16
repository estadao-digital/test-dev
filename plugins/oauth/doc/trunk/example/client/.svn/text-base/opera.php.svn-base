<?php

/**
 * oauth-php: Example OAuth client for accessing my opera
 *
 * @author Ryan
 *
 * 
 * The MIT License
 * 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * Request your consumer key/secret here:
 * http://auth.opera.com/service/oauth/applications/
 * Make sure to set the Application callback URL
 * 
 * To make this example work change the following files
 *
 * OAuthRequestSigner.php	// Opera oAuth doesn't accept twice encoded signature
 * $this->setParam('oauth_signature',	$signature, true);
 * to:
 * $this->setParam('oauth_signature',		 urldecode($signature), true);
 */

include_once "../../library/OAuthStore.php";
include_once "../../library/OAuthRequester.php";

define("OPERA_CONSUMER_KEY", "---");
define("OPERA_CONSUMER_SECRET", "---");

define("OPERA_REQUEST_TOKEN_URL", "https://auth.opera.com/service/oauth/request_token");
define("OPERA_AUTHORIZE_URL", "https://auth.opera.com/service/oauth/authorize");
define("OPERA_ACCESS_TOKEN_URL", "https://auth.opera.com/service/oauth/access_token");

define('OAUTH_TMP_DIR', function_exists('sys_get_temp_dir') ? sys_get_temp_dir() : realpath($_ENV["TMP"]));

// Start the session
session_start();

//  Init the OAuthStore
$options = array(
	'consumer_key' => OPERA_CONSUMER_KEY, 
	'consumer_secret' => OPERA_CONSUMER_SECRET,
	'server_uri' => 'http://my.opera.com/community/api/',
	'request_token_uri' => OPERA_REQUEST_TOKEN_URL,
	'authorize_uri' => OPERA_AUTHORIZE_URL,
	'access_token_uri' => OPERA_ACCESS_TOKEN_URL
);
// Note: do not use "Session" storage in production. Prefer a database
// storage, such as MySQL.
OAuthStore::instance("Session", $options);

try
{
	//  STEP 1:  If we do not have an OAuth token yet, go get one
	if (empty($_GET["oauth_verifier"]))
	{
		$getAuthTokenParams = array(
			'oauth_callback'=>'oob'
		);
		$options = array (
			'oauth_as_header' => false
		);
		
		// get a request token
		$tokenResultParams = OAuthRequester::requestRequestToken(OPERA_CONSUMER_KEY, 0, $getAuthTokenParams, 'POST', $options);
		$_SESSION['oauth_token'] = $tokenResultParams['token'];

		//  redirect to the opera authorization page, they will redirect back
		header("Location: " . OPERA_AUTHORIZE_URL . "?oauth_token=" . $tokenResultParams['token']);
	}
	else {
		//  STEP 2:  Get an access token
		try {
		    OAuthRequester::requestAccessToken(OPERA_CONSUMER_KEY, $_SESSION['oauth_token'], 0, 'POST', $options=array(
				'oauth_verifier'=>$_GET['oauth_verifier']
			));
		}
		catch (OAuthException2 $e)
		{
			var_dump($e);
		    // Something wrong with the oauth_token.
		    // Could be:
		    // 1. Was already ok
		    // 2. We were not authorized
		    return;
		}
		
		// make the docs requestrequest.
		$request = new OAuthRequester("http://my.opera.com/community/api/users/status.pl", 'GET');
		$result = $request->doRequest(0,array(
			CURLOPT_HTTPHEADER=>array(
				'Accept: application/json',
			),
		));
		if ($result['code'] == 200) {
			var_dump($result['body']);
		}
		else {
			echo 'Error';
		}
	}
}
catch(OAuthException2 $e) {
	echo "OAuthException:  " . $e->getMessage();
	var_dump($e);
}
?>
