<?php

namespace app\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{
    public function rules()
    {
        return [
            [
                ['name', 'regionId'],
                'required',
            ],
            [
                ['name'],
                'trim',
            ],
            [
                ['name'],
                'string',
                'max' => 255,
            ],
            [
                ['regionId'],
                'integer',
            ],
            [
                'regionId',
                'exist',
                'targetRelation' => 'region',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function getRegion() {
        return $this->hasOne(Region::class, ['id' => 'regionId']);
    }
}
