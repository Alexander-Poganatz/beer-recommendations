<?php
require_once "utility.php";

//File auther: Alexander Poganatz

/*
  Function Name: createJSON()
  Purpose: Creates a json file for the client to update.
  Accepts: nothing
  Return: a boolean

*/
function createJSON()
{

  if(!isLoggedIn())
    return false;

  $db = getDBConnection();

  $sql = 'SELECT beer_brand_name, beer_type, recommendation '
  . 'FROM Beer INNER JOIN Beer_Type on Beer.beer_type_id = Beer_Type.beer_type_id '
  .'INNER JOIN Recommendation on Beer.recommendation_id = Recommendation.recommendation_id;';

  $result = $db->query($sql);

  $json = 'beers = [';

  if($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $json .= '{"beerName" : "' . $row["beer_brand_name"] . '", "beerType" : "'
        . $row["beer_type"] . '", "recommendation" : "' . $row["recommendation"] . '"},';
    }
    $json = substr($json, 0, strlen($json) - 1);
  }
  $json .= "];";

  $db->close();

  //Open a file and add the contents of json then close it.
  $file = fopen('../data.js', 'w');

  if($file == false)
  {
    return false;
  }

  fwrite($file, $json);

  fclose($file);

  return true;
}

if($_SERVER['REQUEST_METHOD'] == "GET")
  {
    if(createJSON())
    {
      echo "Client should be updated.";
    }
    else
    {
      echo "Failed to update client.";
    }
  }
?>
