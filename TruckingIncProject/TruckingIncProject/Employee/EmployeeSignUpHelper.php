<!--

-->

<?php

session_start();
include ('../mysqli_connect.php');
require ('CheckSignedOut.php');

$user = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeUsername'])));
$pass = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeePassword'])));
$fn = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeFirstName'])));
$mi = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeMiddleInitial'])));
$ln = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeLastName'])));
$str = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeStreet'])));
$cty = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeCity'])));
$stt = $_POST['EmployeeState'];
$zp = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeZip'])));
$phn = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeePhone'])));
$eml = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeEmail'])));
$rptPass = mysqli_real_escape_string($dbc, htmlentities(trim($_POST['EmployeeRepeatPassword'])));

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  if ($_POST['EmployeeSubmitButton'] == 'RegisterEmployee')
  {

    if (empty($user) || empty($pass) || empty($rptPass) || empty($fn) || empty($mi) || empty($ln) || empty($str) || empty($cty) ||
        empty($stt) || empty($zp) || empty($phn) || empty($eml))
    {
      echo '<form action="EmployeeSignUp.php">';
      echo '<p>ERROR! You must to fill out all fields!</p>';
      echo '<button>Ok</button>';
      echo '</form>';
    }
    else if ($pass != $rptPass)
    {
      echo '<form action="EmployeeSignUp.php">';
      echo '<p>ERROR! The passwords do not match!</p>';
      echo '<button>Ok</button>';
      echo '</form>';
    }
    else
    {
      $createEmployeeQuery =
  		"Insert Into Employee (firstName, middleInitial, lastName, street, city, state, zip, phone, email, WebsiteUsername, WebsitePassword)
  		 Values ('$fn', '$mi', '$ln', '$str', '$cty', '$stt', '$zp', '$phn', '$eml', '$user', AES_ENCRYPT('$pass', 'NACL'))";
      $createEmployeeExecution = @mysqli_query($dbc, $createEmployeeQuery);
      if ($createEmployeeExecution)
      {
        $_SESSION['EmployeeUsername'] = $user;
        $_SESSION['EmployeePassword'] = $pass;
        header('Location: EmployeeHome.php');
      }
      else
      {
        echo '<h1>System Error</h1>';
        echo '<form action="EmployeeSignUp.php">';
        echo '<p>Something went wrong...</p>';
        echo '<button>Ok</button>';
        echo '</form>';

      }
      mysqli_close($dbc);
    }
  }
}
