<?php
  require_once "utility.php";

  //File auther: Alexander Poganatz

/*
  Function name: getAllTypes()
  Purpose: get all beer types from the database.
  Accepts: nothing
  Returns: a string in JSON format.

*/

  function getAllTypes()
  {

    if(!isLoggedIn())
      return $json = '{"types": []}';

    $db = getDBConnection();

    $sql = "SELECT * FROM Beer_Type;";

    $result = $db->query($sql);

    $json = '{"types": [';

    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        $json .= '{"id" :"'. $row['beer_type_id'] . '", "beerType" : "' . $row["beer_type"] . '"},';
      }
      $json = substr($json, 0, strlen($json) - 1);
    }
    $json .= "]}";

    $db->close();

    return $json;
  }

  if($_SERVER['REQUEST_METHOD'] == 'GET')
    echo getAllTypes();
?>
