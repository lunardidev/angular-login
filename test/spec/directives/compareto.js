'use strict';

describe('Directive: compareto', function () {

  // load the directive's module
  beforeEach(module('compareField'));

  var scope;

  beforeEach(inject(function($compile, $rootScope) {
    scope = $rootScope.$new();
    var element = angular.element(
      '<form name="form">' +
      '<input ng-model="model.password" type="text" name="password" id="password">' +
      '<input compare-to="model.password" ng-model="model.confirmPassword" type="text" name="confirmPassword" id="confirmPassword">' +
      '</form>'
    );

    scope.model = { password: '', confirmPassword: 'Fd565$dD' };
    $compile(element)(scope);

  }));

  describe('Compare To', function() {

    it('Should contain two elements with the same value', function() {

      // element target
      scope.form.password.$setViewValue('Fd565$dD');
      scope.$digest();
      expect(scope.form.confirmPassword.$error.errorCompareTo).toEqual(false);
    });

  });
});
