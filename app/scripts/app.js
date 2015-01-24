'use strict';

/**
 * @ngdoc overview
 * @name angularLoginApp
 * @description
 * # angularLoginApp
 *
 * Main module of the application.
 */
angular
    .module('angularLoginApp', [
        'ngAnimate',
        'ngCookies',
        'ngResource',
        'ngRoute',
        'ngSanitize',
        'ngTouch',
        'ui.bootstrap',
        'compareField'
    ])
    .config(function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/login.html',
                controller: 'LoginCtrl'
            })
            .when('/login', {
                templateUrl: 'views/login.html',
                controller: 'LoginCtrl'
            })
            .when('/signUp', {
                templateUrl: 'views/signup.html',
                controller: 'SignupCtrl'
            })
            .when('/dashboard', {
                templateUrl: 'views/dashboard.html',
                controller: 'DashboardCtrl'
            })
            .otherwise({
                templateUrl: 'views/404.html'
            });
    })

.run(function($rootScope, $timeout, $location, apiConnector) {

    $rootScope.$on('$routeChangeSuccess', function() {

        $timeout(function() {
            $rootScope.isViewLoading = false;
        }, 1000);

    });

    $rootScope.$on('$routeChangeStart', function(e, current) {

        $rootScope.isViewLoading = true;

        apiConnector.get('api/users/authenticated').then(function(res) {

            if (res.data.authenticated === true) {
                $rootScope.authenticated = res.data.authenticated;
                $rootScope.deName = res.data.deName;
                $rootScope.deUser = res.data.deUser;
                $rootScope.deMail = res.data.deMail;

            } else {

                // pages that don't need authentication
                if (angular.isObject(current.$$route)) {
                    if (current.$$route.originalPath !== '/signUp' && current.$$route.originalPath !== '/login') {
                        $location.path('/');
                    }
                }
            }
        });
    });
});