'use strict';

describe('Directive: validatePassword', function () {

  // load the directive's module
  beforeEach(module('angularLoginApp'));

  var scope;

  beforeEach(inject(function($compile, $rootScope) {
    scope = $rootScope.$new();
    var element = angular.element(
      '<form name="form">' +
      '<input ng-model="model.password" type="text" name="password" id="password" validate-password>' +
      '</form>'
    );
    scope.model = { password: null };
    $compile(element)(scope);
  }));

  describe('Validate Password', function() {

    it('password should contains at least one digit from 0-9', function() {
      scope.form.password.$setViewValue('Dfsd$Sss');
      scope.$digest();
      expect(scope.form.password.$error.passwordIsNotValid).toEqual(true);
    });

    it('password should contains at least one lowercase characters', function() {
      scope.form.password.$setViewValue('123DDD%%4');
      scope.$digest();
      expect(scope.form.password.$error.passwordIsNotValid).toEqual(true);
    });

    it('password should contains at least one uppercase characters', function() {
      scope.form.password.$setViewValue('abc123%5');
      scope.$digest();
      expect(scope.form.password.$error.passwordIsNotValid).toEqual(true);
    });

    it('password should contains at least one special symbols in the list "@#$%"', function() {
      scope.form.password.$setViewValue('Asss123423');
      scope.$digest();
      expect(scope.form.password.$error.passwordIsNotValid).toEqual(true);
    });

    it('password should contains anything with previous condition checking length at least 6 characters and maximum of 20', function() {
      scope.form.password.$setViewValue('91$dD');
      scope.$digest();
      expect(scope.form.password.$error.passwordIsNotValid).toEqual(true);
    });

    it('password should contains at least: one digit from 0-9, one lowercase and one uppercase character, one special symbol (@#$%) and 6-20 characters', function() {
      scope.form.password.$setViewValue('aPassOK123@2');
      scope.$digest();
      expect(scope.form.password.$error.passwordIsNotValid).toEqual(false);
    });
  });
});
