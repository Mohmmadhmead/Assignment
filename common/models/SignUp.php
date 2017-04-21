<?php

namespace common\models;

use Yii;
use yii\base\Model;


class SignUp extends Model
{
    public $username;
    public $password;
    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
          ['username', 'validatePassword'],

        ];
    }


   public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->GetUser();
      

            if (!$user || !$user->validatePassword($this->username)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    public function signup()
    {
        if ($this->validate()) {
            return signup($this->GetUser());
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    
    
    public function GetUser()
    {
        if ($this->_user === null) {
            $this->_user = \app\models\UserE::findByUsername($this->username);
        }

        return $this->_user;
    }
}