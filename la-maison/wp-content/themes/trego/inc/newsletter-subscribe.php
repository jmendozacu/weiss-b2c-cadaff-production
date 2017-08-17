<?php
// Credits: https://gist.github.com/mfkp/1488819

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));
header('Content-type: application/json');

global $sw_vars;

if(!isset($sw_vars['sw_mailchilmp_apikey'])){
	echo json_encode(array ('response' => 'error', 'message' => 'The mailchilmp api key is empty.'));
	exit;
}

if(!isset($sw_vars['sw_mailchilmp_listid'])){
	echo json_encode(array ('response' => 'error', 'message' => 'The mailchilmp list id is empty.'));
	exit;
}

$apiKey = $sw_vars['sw_mailchilmp_apikey']; // How get your Mailchimp API KEY - http://kb.mailchimp.com/article/where-can-i-find-my-api-key
$listId = $sw_vars['sw_mailchilmp_listid']; // How to get your Mailchimp LIST ID - http://kb.mailchimp.com/article/how-can-i-find-my-list-id

if ( empty($apiKey) || strpos($apiKey, '-') === false )  {
    $data = array('response' => 'error', 'message' => __('Please enter your MailChimp API KEY in the theme options', 'swtheme'));
} else {
    $dataCenter = substr($apiKey, strpos($apiKey, '-')+1);
}
if ( empty($listId) )  {
    $data = array('response' => 'error', 'message' => __('Please enter your MailChimp API KEY in the theme options', 'swtheme'));
}
if ( !function_exists('curl_init') ) {
    $data = array('response' => 'warning', 'message' => __('Curl is not enabled on your hosting environment. Please contact your hosting company and ask them to enable CURL for your account.', 'swtheme'));
}

if ( ! empty($data) ) {
    echo json_encode($data);
    exit;
}

$submit_url	= "http://" . $dataCenter . ".api.mailchimp.com/1.3/?method=listSubscribe"; - // Replace us2 with your actual datacenter

$double_optin = false;
$send_welcome = false;
$email_type = 'html';
$email = $_POST['email'];

$data = array(
    'email_address' => $email,
    'apikey' => $apiKey,
    'id' => $listId,
    'double_optin' => $double_optin,
    'send_welcome' => $send_welcome,
    'email_type' => $email_type,
    'url' => $submit_url
);

$payload = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $submit_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
 
$result = curl_exec($ch);
curl_close ($ch);

$data = json_decode($result);

if (!empty($data->error)) {
    $arrResult = array ('response' => 'error', 'message' => $data->error);
} else {
    $arrResult = array ('response' => 'success', 'message' => __("You've been added to our email list.", 'swtheme'));
}

echo json_encode($arrResult);
exit;