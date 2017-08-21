<?php

namespace novatorgroup\brandtools;

use yii\helpers\Html;

/**
 * Widget for listing brands
 * Class BrandIndexWidget
 * @package novatorgroup\brandtools
 */
class BrandListWidget extends \yii\base\Widget
{
    /**
     * @var array
     */
    public $list;

    public $currentId;

    public $wrapperClass = 'brand-sidebar';
    public $letterClass = 'letter';
    public $listClass = 'list-unstyled';

    public function run()
    {
        $letters = [];

        foreach ($this->list as $brand) {
            $letter = strtoupper(mb_substr($brand['title'], 0, 1, 'UTF-8'));
            $letters[$letter][$brand['slug']] = $brand['title'];
        }

        echo Html::beginTag('div', ['class' => $this->wrapperClass]);

        foreach ($letters as $letter => $brands) {
            echo Html::beginTag('div', ['class' => $this->letterClass]);
            echo Html::tag('b', $letter);
            echo Html::beginTag('ul', ['class' => $this->listClass]);
            foreach ($brands as $slug => $title) {
                if ($slug == $this->currentId) {
                    echo Html::tag('li', $title, ['class' => 'brand-current']);
                } else {
                    echo Html::tag('li', Html::a($title, ['brand/page', 'slug' => $slug]));
                }
            }
            echo Html::endTag('ul');
            echo Html::endTag('div');
        }

        echo Html::endTag('div');
    }
}