'use strict';

/**
 * @ngdoc function
 * @name angularLoginApp.controller:SignupCtrl
 * @description
 * # SignupCtrl
 * Controller of the angularLoginApp
 */
angular.module('angularLoginApp')
    .controller('SignupCtrl', function($scope, $location, apiConnector) {

        $scope.signUp = {
            'deName': null,
            'username': null,
            'email': null,
            'password': null,
            'confirmPassword': null
        };
        $scope.alerts = [];
        $scope.loading = false;

        $scope.btSignUp = 'Sign Up';

        // Watch username and email for validate
        $scope.$watchCollection(

            'signUp',
            function(newValue, oldValue) {

                if (!angular.isUndefined($scope.signUpForm)) {

                    // for username
                    if ($scope.signUpForm.username.$dirty && !$scope.signUpForm.username.$invalid) {

                        if (newValue.username !== oldValue.username) {

                            apiConnector.post('api/users/verifyUsernameIsRegistered', {
                                username: newValue.username
                            }).then(function(res) {

                                if (res.status === 'error') {
                                    $scope.signUpForm.username.$error.usernameAlreadyRegistered = true;
                                } else if (res.status === 'success') {
                                    $scope.signUpForm.username.$error.usernameAlreadyRegistered = false;
                                }

                            });
                        }

                    }

                    // for password
                    if ($scope.signUpForm.email.$dirty && !$scope.signUpForm.email.$invalid) {

                        if (newValue.email !== oldValue.email) {

                            apiConnector.post('api/users/verifyEmailIsRegistered', {
                                email: newValue.email
                            }).then(function(res) {

                                if (res.status === 'error') {
                                    $scope.signUpForm.email.$error.emailAlreadyRegistered = true;
                                } else if (res.status === 'success') {
                                    $scope.signUpForm.email.$error.emailAlreadyRegistered = false;
                                }

                            });
                        }

                    }

                }
            }
        );

        /*
         * Submit form SignUp
         */
        $scope.submitFormSignUp = function() {

            apiConnector.post('api/users/signUpApi', {
                signUp: $scope.signUp
            }).then(function(res) {

                if (res.status === 'error') {
                    $scope.loading = false;
                    $scope.btLogin = 'Log In';

                    $scope.addAlert('danger', res.message);
                }

                if (res.status === 'success') {
                    $location.path('dashboard');
                }

            });

        };

        $scope.addAlert = function(type, message) {

            var icone = '';

            if (type === 'danger') {
                icone = 'glyphicon glyphicon-exclamation-sign';
            } else {
                icone = 'glyphicon glyphicon-ok-sign';
            }

            $scope.alerts = [{
                'type': type,
                'msg': message,
                'icone': icone
            }];

        };

        $scope.closeAlert = function() {
            $scope.alerts.splice(0, 1);
        };

    });