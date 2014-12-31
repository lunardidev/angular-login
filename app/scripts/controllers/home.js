'use strict';

/**
 * @ngdoc function
 * @name angularLoginApp.controller:HomeCtrl
 * @description
 * # HomeCtrl
 * Controller of the angularLoginApp
 */
angular.module('angularLoginApp')
  .controller('HomeCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
