<?php

define("APP_DIR", "/Applications/XAMPP/xamppfiles/htdocs/ffarias.dev/angular-login/app");


class usersTest extends PHPUnit_Framework_TestCase{

	public function setUp() {
		$this->users = new users("users","signUp");
		$this->users->is_test = true;
	}

	public function inputUsernames() {

		return [
			[false, 'felipe'],
			[false, 'felipelunardi12345678901234567890'],
			[false, '@elipeLunardi'],
			[false, 'felipe@lunardi'],
			[false, 'Felipe_1'],
			[true , 'Felipelunardi']
		];
	}

	public function inputPasswords() {

		return [
			[false, 'felipe'],
			[false, 'mkyong12@'],
			[false, 'mkyoNg12*'],
			[false, 'mkyonG$$'],
			[false, 'MKYONG12$'],
			[true , 'mkyong1A@'],
			[true , 'mkYOn12$']
		];
	}

	public function inputEmail() {

		return [
			[false, 'ffariasgmail.com'],
			[false, 'ffarias.dev@gmail'],
			[false, 'ffarias.dev@.com'],
			[true , 'ffarias.dev@gmail.com']
		];
	}

	public function inputSignUp() {

		return [
			[false, '', 'felipefarias', 'teste123', 'ffarias.dev@gmail.com'],
			/* [true , 'Felipe Farias', 'Felipelunardi', 'mkYOn12$', 'ffarias.dev@gmail.com']  first time*/
		];
	}

	public function inputAlreadyRegistered() {

		return [
			[false , 'Felipelunard' ,  'felipe@gmail.com'],
			[false , 'FelipeFarias' ,  'ffarias@gmail.com'],
			[true  , 'Felipelunardi',  'ffarias.dev@gmail.com']
		];
	}


	/**
	* @dataProvider inputUsernames
	*/
	public function testUsernameValidation($status, $username) {

		// validations with error
		if( $status == false ){
			$this->assertFalse($this->users->validateUsername($username));
		}

		// validations with success
		if( $status == true ){
			$this->assertTrue($this->users->validateUsername($username));
		}

	}

	/**
	* @dataProvider inputPasswords
	*/
	public function testPasswordValidation($status, $password) {

		// validations with error
		if( $status == false ){
			$this->assertFalse($this->users->validatePassword($password));
		}

		// validations with success
		if( $status == true ){
			$this->assertTrue($this->users->validatePassword($password));
		}

	}

	/**
	* @dataProvider inputEmail
	*/
	public function testEmailValidation($status, $email) {

		// validations with error
		if( $status == false ){
			$this->assertFalse($this->users->validateEmail($email));
		}

		// validations with success
		if( $status == true ){
			$this->assertTrue($this->users->validateEmail($email));
		}

	}

	/**
	* @dataProvider inputSignUp
	*/
	public function testSignUp($status, $fullName, $username, $password, $email) {

		// return of API SignUp
		$responseApi = json_decode($this->users->signUp($fullName, $username, $password, $email));
		$statusTest  = true;

		if( $responseApi->status == "error" ){
			$statusTest = false;
		}
		if( $responseApi->status == "success" ){
			$statusTest = true;
		}

		// validations with error
		if( $status == false ){
			$this->assertFalse($statusTest);
		}

		// validations with success
		if( $status == true ){
			$this->assertTrue($statusTest);
		}
	}

	/**
	* @dataProvider inputAlreadyRegistered
	*/
	public function testUsernameEmailIsAlreadyRegistered($status, $username, $email) {

		// validations with error
		if( $status == false ){
			$this->assertFalse($this->users->validateUserAlreadyRegistered($username, $email));
		}

		// validations with success
		if( $status == true ){
			$this->assertTrue($this->users->validateUserAlreadyRegistered($username, $email));
		}
	}

	/**
	* @dataProvider inputSignUp
	*/
	public function testLogin($status, $fullName, $username, $password, $email) {

		// return of API SignUp
		$responseApi = json_decode($this->users->login($username, $password));
		$statusTest  = true;

		if( $responseApi->status == "error" ){
			$statusTest = false;
		}
		if( $responseApi->status == "success" ){
			$statusTest = true;
		}

		// validations with error
		if( $status == false ){
			$this->assertFalse($statusTest);
		}

		// validations with success
		if( $status == true ){
			$this->assertTrue($statusTest);
		}
	}
}
