'use strict';

describe('Controller: SignupCtrl', function () {

  // load the controller's module
  beforeEach(module('angularLoginApp'));

  var SignupCtrl,
    httpBackend,
    apiConnector,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope, _apiConnector_, $httpBackend) {
    scope         = $rootScope.$new();
    httpBackend   = $httpBackend;
    apiConnector  = _apiConnector_;
    SignupCtrl = $controller('SignupCtrl', {
      $scope: scope
    });
  }));

  it('should sign up', function () {

    httpBackend.whenPOST('api/users/signUpApi', {signUp: scope.signUp}).respond({
       'status' :'success',
       'api'    :'users|signupapi',
       'data':{  
          'de_user':'FelipeLunardi',
          'de_mail':'ffarias.dev@gmail.com',
          'de_name':'Felipe Lunardi'
       }
    });

    apiConnector.post('api/users/signUpApi', {signUp: scope.signUp}).then(function (res) {
      expect(res.status).toEqual('success');
    });

    httpBackend.flush();
  });

  it('should attach a list of messages to the scope', function () {
    scope.addAlert('error', 'Error 001');
    expect(scope.alerts.length).toBe(1);
  });

  it('should remove the messages to the scope', function () {
    scope.closeAlert();
    expect(scope.alerts.length).toBe(0);
  });

});
