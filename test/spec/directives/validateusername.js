'use strict';

describe('Directive: validateUsername', function () {

  // load the directive's module
  beforeEach(module('angularLoginApp'));

  var scope;

  beforeEach(inject(function($compile, $rootScope) {
    scope = $rootScope.$new();
    var element = angular.element(
      '<form name="form">' +
      '<input ng-model="model.username" type="text" name="username" id="username" validate-username>' +
      '</form>'
    );
    scope.model = { username: null };
    $compile(element)(scope);
  }));

  describe('Validate Username', function() {

    it('username should be the first uppercase character', function() {
      scope.form.username.$setViewValue('felipe');
      scope.$digest();
      expect(scope.form.username.$error.usernameIsNotValid).toEqual(true);
    });

    it('username should be length at least 8 characters', function() {
      scope.form.username.$setViewValue('Felipe');
      scope.$digest();
      expect(scope.form.username.$error.usernameIsNotValid).toEqual(true);
    });

    it('username should be length at least maximum of 24', function() {
      scope.form.username.$setViewValue('FelipeLunardi');
      scope.$digest();
      expect(scope.form.username.$error.usernameIsNotValid).toEqual(false);

      scope.form.username.$setViewValue('Felipe123lunardi');
      scope.$digest();
      expect(scope.form.username.$error.usernameIsNotValid).toEqual(false);
    });




  });

});
