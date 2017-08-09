<?php

namespace novatorgroup\brandtools;

use yii\helpers\Html;

/**
 * Widget for listing brands (with logo)
 * Class BrandIndexWidget
 * @package novatorgroup\brandtools
 */
class BrandIndexWidget extends \yii\base\Widget
{
    /**
     * @var array
     */
    public $list;

    public $wrapperClass = 'brand-wrapper';
    public $itemClass = 'brand';

    public function run()
    {
        echo Html::beginTag('div', ['class' => $this->wrapperClass]);
        foreach ($this->list as $brand) {
            echo Html::a('', ['brand/view', 'id' => $brand['id']], [
                'tille' => $brand['title'],
                'class' => $this->itemClass,
                'style' => 'background-image: url(' . $brand['logo'] . ')'
            ]);
        }
        echo Html::endTag('div');
    }
}