'use strict';

describe('Controller: DashboardCtrl', function () {

  // load the controller's module
  beforeEach(module('angularLoginApp'));

  var DashboardCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    DashboardCtrl = $controller('DashboardCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of messages to the scope', function () {
    scope.addAlert('error', 'Error 001');
    expect(scope.alerts.length).toBe(1);
  });

  it('should remove the messages to the scope', function () {
    scope.closeAlert();
    expect(scope.alerts.length).toBe(0);
  });


});
