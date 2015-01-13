'use strict';

/**
 * @ngdoc function
 * @name angularLoginApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the angularLoginApp
 */
angular.module('angularLoginApp')
    .controller('LoginCtrl', function($scope, $location, apiConnector, $timeout) {

        $scope.login = {
            username: null,
            password: null
        };
        $scope.loading = false;
        $scope.alerts = [];
        $scope.btLogin = 'Log In';

        // Function for logout
        $scope.logout = function() {

            apiConnector.get('api/users/logout').then(function(res) {

                if (res.status === 'error') {
                    $scope.loading = false;
                    $scope.addAlert('danger', res.message);
                }

                if (res.status === 'success') {

                    $scope.addAlert('success', res.message);

                    $timeout(function() {
                        $location.path('/');
                    }, 1000);
                }

            });
        };

        // Function for login
        $scope.submitFormLogin = function() {

            $scope.loading = true;
            $scope.btLogin = 'loading...';

            apiConnector.post('api/users/loginApi', {
                login: $scope.login
            }).then(function(res) {

                if (res.status === 'error') {
                    $scope.loading = false;
                    $scope.btLogin = 'Log In';

                    $scope.addAlert('danger', res.message);
                }

                if (res.status === 'success') {

                    $scope.addAlert('success', res.message);

                    $timeout(function() {
                        $location.path('dashboard');
                    }, 1000);
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