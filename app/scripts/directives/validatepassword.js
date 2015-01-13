'use strict';

/**
 * @ngdoc directive
 * @name angularLoginApp.directive:validatePassword
 * @description
 * # validatePassword
 */
angular.module('angularLoginApp')
    .directive('validatePassword', function() {

        return {
            scope: true,
            require: 'ngModel',
            link: function postLink(scope, element, attrs, ctrl) {

                var regex = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})/;

                var validate = function() {

                    var stringValue = scope.$eval(attrs.ngModel);

                    if (stringValue !== null) {
                        return regex.test(stringValue);
                    }

                };

                scope.$watch(validate, function(newValue) {
                    ctrl.$setValidity('passwordIsNotValid', newValue);
                });

            }
        };

    });