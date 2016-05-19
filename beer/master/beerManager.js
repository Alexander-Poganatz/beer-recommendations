var app = angular.module("beerManager", []);

app.controller("beerController", function($scope, $http)
{
  function hideModal()
  {
    $scope.modalDisplay = "none";
  }
  function showModal()
  {
    $scope.modalDisplay = "block";
  }

  //Initilize variables.
  $scope.showAddButton = true;
  $scope.showUpdateButton = true;
  $scope.showDeleteButton = true;

  //For updating and deleting
  var currentId;

  hideModal();

  function buildTable()
  {
    $http.get("getallbeer.php").then(function(response){$scope.beers = response.data.beers;});
  }

  $http.get("getalltypes.php").then(function (response){
    $scope.beerTypes = response.data.types;
    $scope.beerTypeId = response.data.types[0].id;
  });

  $http.get("getallrecommendations.php").then(function (response){
    $scope.recommendations = response.data.recommendations;
    $scope.recommendationId = response.data.recommendations[0].id;
  });


  $scope.addView = function()
  {
    $scope.showAddButton = true;
    $scope.showUpdateButton = false;
    $scope.showDeleteButton = false;
    $scope.beerName = "";
    showModal();
  }

  $scope.updateView = function(id)
  {
    var datas = "id=" + id;

    $http({
      method: "POST",
      url: "getbeer.php",
      data: datas,
      headers: {'Content-Type' : 'application/x-www-form-urlencoded;charset="UTF-8"'}
    }).then(function (response){
      $scope.beerName = response.data.beer.beerName;
      $scope.beerTypeId = response.data.beer.beerTypeId;
      $scope.recommendationId = response.data.beer.recommendationId;

      currentId = response.data.beer.id;

      $scope.showAddButton = false;
      $scope.showUpdateButton = true;
      $scope.showDeleteButton = true;

      showModal();
    });
  }

  $scope.addBeer = function()
  {
    if($scope.dataForm.beerName.$valid)
    {
      var beerData = "beerName=" + $scope.beerName;
      beerData += "&typeId=" + $scope.beerTypeId;
      beerData += "&recommendationId=" + $scope.recommendationId;

      $http({
        method: "POST",
        url: "addbeer.php",
        data: beerData,
        headers: {'Content-Type' : 'application/x-www-form-urlencoded;charset="UTF-8"'}
      }).then(function(response){
        $scope.messages = response.data;
        buildTable();
        hideModal();
      });
    }
  }

  $scope.updateBeer = function()
  {
    if($scope.dataForm.beerName.$valid)
    {
      var beerData = "beerName=" + $scope.beerName;
      beerData += "&typeId=" + $scope.beerTypeId;
      beerData += "&recommendationId=" + $scope.recommendationId;
      beerData += "&beerId=" + currentId;

      $http({
        method: "POST",
        url: "updatebeer.php",
        data: beerData,
        headers: {'Content-Type' : 'application/x-www-form-urlencoded;charset="UTF-8"'}
      }).then(function(response){
        $scope.messages = response.data;
        buildTable();
        hideModal();
      });
    }
  }

  $scope.deleteBeer = function()
  {
    var beerData = "&beerId=" + currentId + "&beerName=" + $scope.beerName;

    $http({
      method: "POST",
      url: "deletebeer.php",
      data: beerData,
      headers: {'Content-Type' : 'application/x-www-form-urlencoded;charset="UTF-8"'}
    }).then(function(response){
      $scope.messages = response.data;
      buildTable();
      hideModal();
    });
  }

  $scope.updateJSON = function()
  {
    $http.get("createjson.php").then(function(response){
      $scope.messages = response.data;
    })
  }

  buildTable();

});
