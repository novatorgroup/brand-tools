<?php

namespace novatorgroup\brandtools;

use yii\helpers\Html;

/**
 * Widget for listing brands (with logo)
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
            echo Html::a('', ['brand/page', 'slug' => $brand['slug']], [
                'title' => $brand['title'],
                'class' => $this->itemClass,
                'data-src' => $brand['logo']
            ]);
        }
        echo Html::endTag('div');

        $this->view->registerAssetBundle(LazyAsset::class);
        $this->view->registerJs('jQuery(".' . $this->itemClass . '").Lazy();');
    }
}