<?php
  //File auther: Alexander Poganatz

  include_once "utility.php";

  //Function name: displayForm
  //Purpose: To return a string containing html code for a form.
  //Accepts: Nothing.
  //Returns: a string containing html code.

  function displayForm()
  {
    return '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">'
      . 'User name: <input type="text" required="true" name="user" class="w3-input"/><br />'
      . 'Password: <input type="password" required="true" name="pass" class="w3-input"/><br />'
      . '<input type="submit" name="submit" value="submit" />   </form>';
  }
  //Function name: displayMenu
  //Purpose: display the menu when the password is right.
  //Accepts: nothing.
  //Return: a string containing html code.
function displayMenu()
{
  return '
    <script src="beerManager.js"></script>

    <div class="w3-container" data-ng-app="beerManager" data-ng-controller="beerController">
      <div>
        <h1 class="w3-border-bottom w3-border-green">Beer Recommendation Manager</h1>
      </div>

      <div>
        <button data-ng-click="updateJSON()" class="w3-button w3-black">Update JSON</button>
      </div>

      <div>
        <p>{{messages}}</p>
      </div>

      <table class="w3-table w3-striped">
        <tr>
          <th>Brand Name</th>
          <th>Type</th>
          <th>Recommendation</th>
        </tr>
        <tr data-ng-click="addView()">
          <td colspan="3">Click to add...</td>
        </tr>

        <tr data-ng-repeat="beer in beers | orderBy : \'beerName\'" data-ng-click="updateView(beer.id)">
          <td>{{beer.beerName}}</td>
          <td>{{beer.beerType}}</td>
          <td>{{beer.recommendation}}</td>
        </tr>
      </table>

      <div style="display: {{modalDisplay}}" class="w3-modal">
        <div class="w3-modal-content">
          <div class="w3-container">
            <span class="w3-button w3-display-topright" data-ng-click="modalDisplay = \'none\'">&times;</span>
            <h3>Beer Form</h3>
            <form name="dataForm">

              <input type="text" name="beerName" data-ng-model="beerName" class="w3-input" required />

              <select name="beerTypeSelect" data-ng-model="beerTypeId" class="w3-select">
                <option data-ng-repeat="option in beerTypes" value="{{option.id}}">{{option.beerType}}</option>
              </select>

              <select name="recommendationSelect" data-ng-model="recommendationId" class="w3-select">
                <option data-ng-repeat="option in recommendations" value="{{option.id}}">{{option.recommendation}}</option>
              </select>

              <br />
              <div style="margin-top: 10px; margin-bottom:10px;">
                      <button class="w3-btn w3-blue" value="Add" data-ng-show="showAddButton" data-ng-click="addBeer()">Add</button>
                      <button class="w3-btn w3-green" value="Update" data-ng-show="showUpdateButton" data-ng-click="updateBeer()">Update</button>
                      <button class="w3-btn w3-pink" value="delete" data-ng-show="showDeleteButton" data-ng-click="deleteBeer()" >Delete</button>
              </div>
            </form>
          </div>

        </div><!--End modal content-->

      </div><!--End modal -->

  ';
}
?>

<!DOCTYPE html>
<html>

  <head>
    <title>Beer Manager</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="../../w3.css" rel="stylesheet" />
    <script src="../../angular.min.js"></script>
  </head>

  <body>

    <?php
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['pass'] = $_POST['pass'];

        if(isLoggedIn())
        {
          echo displayMenu();
        }
        else {
          echo displayForm();
          echo "Wrong information.";
        }
      }
      else {
        if(isLoggedIn())
        {
          echo displayMenu();
        }
        else {
          echo displayForm();
        }
      }

    ?>

  </body>

</html>
