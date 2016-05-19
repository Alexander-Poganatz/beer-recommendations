//Author: Alexander Poganatz

//Purpose: To set up angular with json data.
//And initilize the query variable to a blank string.

var app = angular.module("dataManager", []);

app.controller("dataController", function($scope){
  $scope.query = "";
  $scope.beers = beers;
});
