<?php
namespace Auth\Model;

class User
{
	public $id;
	
	public $user_name;
	
	public $user_password;
	
	
	public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->user_name = (isset($data['username'])) ? $data['username'] : null;
        $this->user_password = (isset($data['password'])) ? $data['password'] : null;
    }
}