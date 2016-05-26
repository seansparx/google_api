<?php
require_once '../google-api-php-client/autoload.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");

// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
 $client->setClientId('691869190217-74krll8tdn5pkd9tidv3budkob2mih8h.apps.googleusercontent.com');
 $client->setClientSecret('wLkpaOZ1DngKXVmwSXQ6V9Q0');
 $client->setRedirectUri('http://localhost/google_api/CalendarAPI/index.php');
 $client->setDeveloperKey('insert_your_developer_key');

 $cal = new Google_Service_Calendar($client);

if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $calList = $cal->calendarList->listCalendarList();
  print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";


$_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
