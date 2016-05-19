<?php
  require_once "utility.php";

  //File auther: Alexander Poganatz

/*
  Function name: getAllRecommendations
  Purpose: To get all the recommendation types from the database.
  Accepts: nothing.
  Return: a string in JSON format.

*/
  function getAllRecommendations()
  {

    if(!isLoggedIn())
      return $json = '{"recommendations": []}';

    $db = getDBConnection();

    $sql = "SELECT * FROM Recommendation;";

    $result = $db->query($sql);

    $json = '{"recommendations": [';

    if($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        $json .= '{"id" :"'. $row['recommendation_id'] . '", "recommendation" : "' . $row["recommendation"] . '"},';
      }
      $json = substr($json, 0, strlen($json) - 1);
    }
    $json .= "]}";

    $db->close();

    return $json;
  }

  if($_SERVER['REQUEST_METHOD'] == 'GET')
    echo getAllRecommendations();
?>
