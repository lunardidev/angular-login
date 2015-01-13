'use strict';

/**
 * @ngdoc directive
 * @name angularLoginApp.directive:compareto
 * @description
 * # compareto
 */
angular.module('angularLoginApp')
    .directive('compareTo', function() {
        return {
            scope: {
                otherModelValue: '=compareTo'
            },
            require: 'ngModel',
            link: function postLink(scope, element, attrs, ctrl) {

                var compare = function() {

                    var e1 = element.val();
                    var e2 = scope.otherModelValue;

                    if (e2 !== null) {
                        return e1 === e2;
                    }
                };

                scope.$watch(compare, function(newValue) {
                    ctrl.$setValidity('errorCompareTo', newValue);
                });

            }
        };
    });