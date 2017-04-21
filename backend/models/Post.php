<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $category
 * @property integer $owner
 * @property string $date
 *
 * @property Categories $category0
 * @property User $owner0
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $ManyTags;
    public $ManyTags2;
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'category', 'owner', 'date'], 'required'],
            [['category', 'owner'], 'integer'],
            [['date'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category' => 'id']],
            [['owner'], 'exist', 'skipOnError' => true, 'targetClass' => UserE::className(), 'targetAttribute' => ['owner' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'category' => 'Category',
            'owner' => 'Owner',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   public function getCategories()
{
    return $this->hasOne(Categories::className(), ['id' => 'category']);
}


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserE()
{
    return $this->hasOne(UserE::className(), ['id' => 'owner']);
}



}
