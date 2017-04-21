<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $categories
 *
 * @property Post[] $posts
 */
class Categories extends \yii\db\ActiveRecord
{    private  $_user;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categories'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categories' => 'Categories',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
 public static function getcatt($id){
return self::findOne(['id'=>$id]);
	}

}
