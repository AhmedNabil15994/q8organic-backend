<?php

return [
    'options' => [
        'form' => [
            'color' => 'Color',
            'status' => 'Status',
            'type' => 'Type',
            'title' => 'Title',
            'option_as_filter' => 'Option as filter',
            'tabs' => [
                'general' => 'General Info.',
                'option_values' => 'Option Values',
            ],
            'types' => [
                'text' => 'text',
                'color' => 'Color',
            ]
        ],
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Options Products',
            'index' => 'Options Products',
            'update' => 'Update Option Products',
        ],
        'validation' => [
            'option_have_product_options' => 'Sorry, this option is included with other products',
            'title' => [
                'required' => 'Please enter the title of option',
                'unique' => 'This title option is taken before',
            ],
        ],
    ],
    'option_values' => [
        'validation' => [
            'title' => [
                'required' => 'Please enter the title of option value',
            ],
            'option_value' => [
                'required' => 'Please enter the option values',
            ],
        ],
    ],
];
