<?php

namespace app\models;

use yii\db\ActiveRecord;

class Region extends ActiveRecord
{
    public function rules()
    {
        return [
            [
                ['name'],
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
        ];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function getCities() {
        return $this->hasMany(City::class, ['regionId' => 'id']);
    }
}
