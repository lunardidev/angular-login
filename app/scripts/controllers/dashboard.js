'use strict';

/**
 * @ngdoc function
 * @name angularLoginApp.controller:DashboardCtrl
 * @description
 * # DashboardCtrl
 * Controller of the angularLoginApp
 */
angular.module('angularLoginApp')
    .controller('DashboardCtrl', function($scope) {

        $scope.alerts = [];

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