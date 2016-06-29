<?php

namespace bariew\pageAbstractModule;

class PageModule extends \yii\base\Module
{

    public $params = [
        'menu'  => [
            'label'    => 'Pages',
            'url' => ['/page/page/index'],
        ]
    ];
}
