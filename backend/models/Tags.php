<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tags
 *
 * @property Posttags[] $posttags
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tags'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tags' => 'Tags',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosttags()
    {
        return $this->hasMany(Posttags::className(), ['tagsid' => 'id']);
    }
   
}
