// script.js

    // create the module and name it scotchApp
        // also include ngRoute for all our routing needs
    var scotchApp = angular.module('scotchApp', ['ngRoute', 'ui.bootstrap']);

    // configure our routes
    scotchApp.config(function($routeProvider) {
        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl : 'pages/home.html',
                controller  : 'CarouselCtrl'
            })

            // route for the services page
            .when('/services', {
                templateUrl : 'pages/services.html',
                controller  : 'servicesController'
            })

            // route for the contact page
            .when('/contact', {
                templateUrl : 'pages/contact.php',
                controller  : 'ContactController'
            })

            // route for the donate page
            .when('/donate', {
                templateUrl : 'pages/donate.html',
                controller  : 'donateController'
            })

            // route for the direction page
            .when('/direction', {
                templateUrl : 'pages/direction.html',
                controller  : 'directionController'
            })

            // route for the direction page
            .when('/facebook', {
                templateUrl : 'pages/facebook.html',
                controller  : 'facebookController'
            })

    });

    // create the controller and inject Angular's $scope
    scotchApp.controller('mainController', function($scope) {
        // create a message to display in our view
        $scope.message = 'Everyone come and see how good I look!';
    });

    scotchApp.controller('servicesController', function($scope) {
        $scope.message = 'Look! I am an about page.';
    });

    scotchApp.controller('contactController', function($scope) {
        $scope.message = 'Contact us! JK. This is just a demo.';
    });

    scotchApp.controller('donateController', function($scope) {
      $scope.message = 'Contact us! JK. This is just a demo.';
    });

    scotchApp.controller('directionController', function($scope) {
        $scope.message = 'Contact us! JK. This is just a demo.';
    });

    scotchApp.controller('facebookController', function($scope) {
        $scope.message = 'Contact us! JK. This is just a demo.';
    });
