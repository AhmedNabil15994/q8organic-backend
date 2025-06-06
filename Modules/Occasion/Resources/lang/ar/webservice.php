<?php
return [
    'occasion'  => [
        'oops_error'        =>  'حدث خطأ ما',
        'validation'    =>  [
            'name' => [
                'required'          => 'اسم المناسبة مطلوب',
                'string'            => 'اسم المناسبة يجب ان يكون نصى',
                'max'               => 'اسم المناسبة يجب ألا يتجاوز 190 حرفاً',
            ],
            'category_id' => [
                'required'          => 'القسم مطلوب',
                'exists'            => 'هذا القسم غير موجود',
            ],
            'occasion_date' => [
                'required'          => 'تاريخ المناسبة مطلوب',
                'date'              => 'تاريخ المناسبة يجب ان يكون من نوع تاريخ',
            ],
        ],
    ],
];