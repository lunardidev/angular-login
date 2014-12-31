'use strict';

/**
 * @ngdoc function
 * @name angularLoginApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the angularLoginApp
 */
angular.module('angularLoginApp')
  .controller('MainCtrl', function ($scope) {

    $scope.dirtyAndInvalid = function(o) {
      return o.$dirty && o.$invalid;
    }

  });
