<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property integer $status
 * @property string $password
 */
class UserE extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{ 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['status'], 'integer'],
            [['username', 'password'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'status' => 'Status',
            'password' => 'Password',
        ];
    }
    
    	public static function findIdentity($id){
		return static::findOne($id);
	}
 
	public static function findIdentityByAccessToken($token, $type = null){
	}
 
	public function getId(){
		return $this->id;
	}
        
 
	public function getAuthKey(){

            }
 
	public function validateAuthKey($authKey){
	}
	public static function findByUsername($username){
		return self::findOne(['username'=>$username]);
	}
 
	public function validatePassword($password){
		return $this->password === $password;
	}
	public static function getusername($id){
		return self::findOne(['id'=>$id]);
	}
}
