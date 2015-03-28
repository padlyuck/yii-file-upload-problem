<?php

namespace app\models;

use app\behaviors\FileUploadBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $path
 * @property string $alt
 * @property string $title
 */
class File extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'alt', 'title'], 'required'],
            [['path', 'alt', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'alt' => 'Alt',
            'title' => 'Title',
        ];
    }

    public function behaviors()
    {
        return [
            'files' => [
                'class' => FileUploadBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => ['path'],
                    ActiveRecord::EVENT_BEFORE_DELETE => ['path'],
                ]
            ]
        ];
    }
}
