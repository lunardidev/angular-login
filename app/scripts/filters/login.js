'use strict';

/**
 * @ngdoc filter
 * @name angularLoginApp.filter:login
 * @function
 * @description
 * # login
 * Filter in the angularLoginApp.
 */
angular.module('angularLoginApp')
    .filter('login', function() {
        return function(input) {
            return 'login filter: ' + input;
        };
    });