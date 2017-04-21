<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posttags".
 *
 * @property integer $id
 * @property integer $postid
 * @property integer $tagsid
 *
 * @property Post $post
 * @property Tags $tags
 */
class Posttags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posttags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postid', 'tagsid'], 'required'],
            [['postid', 'tagsid'], 'integer'],
            [['postid'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['postid' => 'id']],
            [['tagsid'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tagsid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postid' => 'Postid',
            'tagsid' => 'Tagsid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'postid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tagsid']);
    }
}
