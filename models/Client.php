<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\UploadedFile;

class Client extends ActiveRecord
{
    public $inputLogo, $deleteLogo;

    public function rules()
    {
        return [
            [
                ['name', 'phone', 'cityId'],
                'required',
            ],
            [
                ['name'],
                'string',
                'max' => 128,
            ],
            [
                ['phone'],
                'match',
                'pattern' => '/^\+7 \([0-9]{3}\) [0-9]{3} [0-9]{2} [0-9]{2}$/',
            ],
            [
                ['vat', 'deleteLogo'],
                'boolean',
            ],
            [
                ['cityId'],
                'integer',
            ],
            [
                'cityId',
                'exist',
                'targetRelation' => 'city',
            ],
            [
                ['text'],
                'string',
                'max' => 8192,
            ],
            [
                ['inputLogo'],
                'file',
                'extensions' => ['png', 'jpg', 'gif'],
                'maxSize' => 1024*1024,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->deleteLogo) {
            if ($this->logo) {
                $this->logo->delete();
            }
        }
        $inputLogo = UploadedFile::getInstance($this, 'inputLogo');
        if ($inputLogo) {
            if ($this->logo) {
                $this->logo->upload($inputLogo);
            } else {
                $logo = new Logo();
                $logo->upload($inputLogo);
                $this->logoId = $logo->id;
                $this->updateAttributes([
                    'logoId' => $this->logoId,
                ]);
            }
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->logo->delete();
    }

    public function getLogo()
    {
        return $this->hasOne(Logo::class, ['id' => 'logoId']);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'cityId']);
    }
}
