<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Logo extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getSrc()
    {
        return empty($this->id) ? null : Yii::getAlias("@web/logo/{$this->id}.{$this->extension}");
    }

    public function getPath()
    {
        return empty($this->id) ? null : Yii::getAlias("@webroot/logo/{$this->id}.{$this->extension}");
    }

    public function getUser() {
        return $this->hasOne(Client::class, ['id' => 'logoId']);
    }

    public function upload($file)
    {
        $this->extension = $file->extension;
        $this->name = $file->name;
        $this->size = $file->size;
        if ($this->save() and $file->saveAs($this->path)) {
            return true;
        }
        return false;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        unlink($this->path);
    }
}
