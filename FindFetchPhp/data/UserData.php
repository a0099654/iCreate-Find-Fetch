<?php
namespace data;

use data\User;
use data\DataManager;
use exception\DataException;

class UserData{
	private $_dataManagerInstance = NULL;
	
	const USER_DATA_TABLE = "users";
	const PARAM_NAME = "USERNAME";
	const PARAM_PASS = "PASSWORD";
	const PARAM_PHONE = "PHONE";
		
	public function __construct(){
		self::initializeUserData();
	}
	
	private function initializeUserData(){
		$this->_dataManagerInstance = new DataManager();
	}

	/**
	 * 
	 * @param String $username
	 * @throws DataException
	 * @return \data\User|NULL
	 */
	public function getUser($username){
		$param = self::PARAM_NAME;
		
		try {
			$curUserData = $this->_dataManagerInstance->retrieveSingleData($username, $param, self::USER_DATA_TABLE);
		} catch (DataException $ex){
			throw $ex;
		}
		
		if ($curUserData){
			$name = $curUserData[self::PARAM_NAME];
			$pass = $curUserData[self::PARAM_PASS];
			$phone = $curUserData[self::PARAM_PHONE];
			
			$curUser = new User($name, $pass, $phone);
			
			return $curUser;
		} else {
			return NULL;
		}
	}

	/**
	 * 
	 * @param String $username
	 * @throws DataException
	 * @return boolean
	 */
	public function hasUser($username){
		try {
			$curUser = self::getUser($username);
		} catch (DataException $ex){
			throw $ex;
		}
		
		if ($curUser == NULL){
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * 
	 * @param \data\User $curUser
	 * @throws DataException
	 */
	public function saveUserToDatabase(User $curUser){
		$dataParams = array(self::PARAM_NAME, self::PARAM_PASS, self::PARAM_PHONE);
		$dataValues = $curUser->getAllInfo();
		$dest = self::USER_DATA_TABLE;
		
		try {
			$this->_dataManagerInstance->insertData($dataParams, $dataValues, $dest);
		} catch (DataException $ex){
			throw $ex;
		}
	}
	
	public function closeUserData(){
		$this->_dataManagerInstance->closeDatabase();
	}
}
?>