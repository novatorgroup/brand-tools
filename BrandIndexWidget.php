<?php

namespace novatorgroup\brandtools;

use yii\helpers\Html;

/**
 * Widget for listing brands
 * Class BrandIndexWidget
 * @package novatorgroup\brandtools
 */
class BrandIndexWidget extends \yii\base\Widget
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

        foreach ($this->list as $id => $title) {
            $letter = strtoupper(mb_substr($title, 0, 1, 'UTF-8'));
            $letters[$letter][$id] = $title;
        }

        echo Html::beginTag('div', ['class' => $this->wrapperClass]);

        foreach ($letters as $letter => $brands) {
            echo Html::beginTag('div', ['class' => $this->letterClass]);
            echo Html::tag('b', $letter);
            echo Html::beginTag('ul', ['class' => $this->listClass]);
            foreach ($brands as $id => $title) {
                if ($id == $this->currentId) {
                    echo Html::tag('li', $title, ['class' => 'brand-current']);
                } else {
                    echo Html::tag('li', Html::a($title, ['brand/view', 'id' => $id]));
                }
            }
            echo Html::endTag('ul');
            echo Html::endTag('div');
        }

        echo Html::endTag('div');
    }
}