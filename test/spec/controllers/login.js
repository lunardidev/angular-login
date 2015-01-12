'use strict';

describe('Controller: LoginCtrl', function () {

  // load the controller's module
  beforeEach(module('angularLoginApp'));


  var LoginCtrl,
    httpBackend,
    apiConnector,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope, _apiConnector_, $httpBackend) {
    scope         = $rootScope.$new();
    httpBackend   = $httpBackend;
    apiConnector  = _apiConnector_;
    LoginCtrl     = $controller('LoginCtrl', {
      $scope: scope
    });
  }));

  it('should have the object for login with username and password', function() {
    expect(scope.login).toEqual({username:null, password:null});
  });

  it('should do login of users', function () {

    httpBackend.whenPOST('api/users/loginApi', {login: scope.login}).respond({
       'status' :'success',
       'api'    :'users|loginapi',
       'message':'Login success!',
       'data':{  
          'de_user':'FelipeLunardi',
          'de_mail':'ffarias.dev@gmail.com',
          'de_name':'Felipe Lunardi'
       }
    });

    apiConnector.post('api/users/loginApi', {login: scope.login}).then(function (res) {
      expect(res.status).toEqual('success');
    });

    httpBackend.flush();
  });

  it('should do logout of users', function () {

    httpBackend.whenGET('api/users/logout').respond({
       'status':'success',
       'api':'users|authenticated',
       'message':'',
       'data':{  
          'deUser':'',
          'deMail':'',
          'authenticated':false
       }
    });

    apiConnector.get('api/users/logout').then(function (res) {
      expect(res.data.authenticated).toBe(false);
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
