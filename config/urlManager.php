<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'book',
        'pluralize' => false,
        'extraPatterns' => [
            'POST this-is-test' => 'this-is-test',
        ]
    ]
];
