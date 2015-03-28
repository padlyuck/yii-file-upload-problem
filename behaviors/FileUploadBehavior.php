<?php
/**
 * Created by PhpStorm.
 * User: padlyuck
 * Date: 28.03.15
 * Time: 22:05
 */

namespace app\behaviors;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileUploadBehavior extends AttributeBehavior
{
    public $attributes = [];
    public $uploadPath = '@webroot/upload';
    public $baseUrl = '@web/upload';
    public $directoryLevel = 3;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'uploadFile',
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeFile',
        ];
    }

public function uploadFile($event)
{
    $base = Yii::getAlias($this->uploadPath);
    foreach ($this->attributes[$event->name] as $attribute) {
        $value = UploadedFile::getInstance($event->sender, $attribute);
        if ($value) {
            $name = md5(microtime() . $value->name) . '.' . $value->getExtension();
            $path = $this->getSavePath($name, $base);
            $value->saveAs($base . $path . DIRECTORY_SEPARATOR . $name, false);
            //remove old file
            if ($this->owner->{$attribute}) {
                @unlink($this->getFileRealPath($this->owner->{$attribute}));
            }
            $this->owner->{$attribute} = Yii::getAlias($this->baseUrl) . $path . DIRECTORY_SEPARATOR . $name;
        }
    }
}

    public function removeFile($event)
    {
        foreach ($this->attributes[$event->name] as $attribute) {
            if ($this->owner->{$attribute}) {
                @unlink($this->getFileRealPath($this->owner->{$attribute}));
            }
        }
    }

    /**
     * @param $name string File name
     * @param $base string upload path root dir
     * @return string full path to upload without filename
     */
    private function getSavePath($name, $base)
    {
        $path = '';
        if ($this->directoryLevel > 0) {
            for ($i = 0; $i < $this->directoryLevel; ++$i) {
                if (($prefix = substr($name, $i + $i, 2)) !== false) {
                    $path .= DIRECTORY_SEPARATOR . $prefix;
                }
            }
        }
        FileHelper::createDirectory($base . $path);
        return $path;
    }

    /**
     * @param $fileUrl
     * @return mixed
     */
    private function getFileRealPath($fileUrl)
    {
        return preg_replace('#^' . preg_quote(Yii::getAlias($this->baseUrl)) . '/#', Yii::getAlias($this->uploadPath) . '/', $fileUrl);
    }
}