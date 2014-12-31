'use strict';

describe('Filter: login', function () {

  // load the filter's module
  beforeEach(module('angularLoginApp'));

  // initialize a new instance of the filter before each test
  var login;
  beforeEach(inject(function ($filter) {
    login = $filter('login');
  }));

  it('should return the input prefixed with "login filter:"', function () {
    var text = 'angularjs';
    expect(login(text)).toBe('login filter: ' + text);
  });

});
