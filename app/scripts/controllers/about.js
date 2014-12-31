'use strict';

/**
 * @ngdoc function
 * @name angularLoginApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the angularLoginApp
 */
angular.module('angularLoginApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
