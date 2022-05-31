<?php

require_once dirname(__FILE__).'/baseEntity.php';

class admin_users extends baseEntity
{


	private $id;
	private $user_name;
	private $password;
	private $access_role;
	private $user_type;
	private $user_distributor;
	private $full_name;
	private $email;
	private $language;
    private $timezone;
	private $mobile;
	private $verification_number;
	private $is_enable;
	private $global_user_id;
	private $create_date;
	private $create_user;
	private $last_update;
	private $activation_date;

    /**
     * admin_users constructor.
     * @param $id
     * @param $user_name
     * @param $password
     * @param $access_role
     * @param $user_type
     * @param $user_distributor
     * @param $full_name
     * @param $email
     * @param $language
     * @param $mobile
     * @param $verification_number
     * @param $is_enable
     * @param $global_user_id
     * @param $create_date
     * @param $create_user
     * @param $last_update
     * @param $activation_date
     */
    public function __construct($id, $user_name, $password, $access_role, $user_type, $user_distributor, $full_name, $email, $language, $timezone, $mobile, $verification_number, $is_enable, $global_user_id, $create_date, $create_user, $last_update, $activation_date)
    {
        $this->id = $id;
        $this->user_name = $user_name;
        $this->password = $password;
        $this->access_role = $access_role;
        $this->user_type = $user_type;
        $this->user_distributor = $user_distributor;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->language = $language;
        $this->timezone = $timezone;
        $this->mobile = $mobile;
        $this->verification_number = $verification_number;
        $this->is_enable = $is_enable;
        $this->global_user_id = $global_user_id;
        $this->create_date = $create_date;
        $this->create_user = $create_user;
        $this->last_update = $last_update;
        $this->activation_date = $activation_date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAccessRole()
    {
        return $this->access_role;
    }

    /**
     * @param mixed $access_role
     */
    public function setAccessRole($access_role)
    {
        $this->access_role = $access_role;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    /**
     * @return mixed
     */
    public function getUserDistributor()
    {
        return $this->user_distributor;
    }

    /**
     * @param mixed $user_distributor
     */
    public function setUserDistributor($user_distributor)
    {
        $this->user_distributor = $user_distributor;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getTimezones()
    {
        return $this->timezone;
    }

    /**
     * @param mixed $language
     */
    public function setTimezones($timezone)
    {
        $this->language = $timezone;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getVerificationNumber()
    {
        return $this->verification_number;
    }

    /**
     * @param mixed $verification_number
     */
    public function setVerificationNumber($verification_number)
    {
        $this->verification_number = $verification_number;
    }

    /**
     * @return mixed
     */
    public function getisEnable()
    {
        return $this->is_enable;
    }

    /**
     * @param mixed $is_enable
     */
    public function setIsEnable($is_enable)
    {
        $this->is_enable = $is_enable;
    }

    /**
     * @return mixed
     */
    public function getGlobalUserId()
    {
        return $this->global_user_id;
    }

    /**
     * @param mixed $global_user_id
     */
    public function setGlobalUserId($global_user_id)
    {
        $this->global_user_id = $global_user_id;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param mixed $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return mixed
     */
    public function getCreateUser()
    {
        return $this->create_user;
    }

    /**
     * @param mixed $create_user
     */
    public function setCreateUser($create_user)
    {
        $this->create_user = $create_user;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * @param mixed $last_update
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;
    }

    /**
     * @return mixed
     */
    public function getActivationDate()
    {
        return $this->activation_date;
    }

    /**
     * @param mixed $activation_date
     */
    public function setActivationDate($activation_date)
    {
        $this->activation_date = $activation_date;
    }
	
	
}

