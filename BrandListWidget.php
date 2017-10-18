<?php

namespace novatorgroup\brandtools;

use Yii;
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

    /**
     * @var string active brand
     */
    public $currentId;

    public $columns = 4;

    public $wrapperClass = 'brand-sidebar';

    public function init()
    {
        parent::init();

        if (empty($this->currentId)) {
            $this->currentId = Yii::$app->request->get('slug');
        }
    }

    public function run()
    {
        $letters = [];

        foreach ($this->list as $brand) {
            $letter = strtoupper(mb_substr($brand['title'], 0, 1, 'UTF-8'));
            $letters[$letter][$brand['slug']] = $brand['title'];
        }

        echo Html::beginTag('table', ['class' => $this->wrapperClass]);

        $n = 0;
        $td_letters = '';
        $td_lists = '';
        foreach ($letters as $letter => $brands) {

            $td_letters .= Html::tag('td', $letter, ['data-letter' => $letter]);

            $list = Html::beginTag('ul', ['class' => 'list-unstyled']);
            $hidden = ' hidden';
            foreach ($brands as $slug => $title) {
                if ($slug == $this->currentId) {
                    $list .= Html::tag('li', $title, ['class' => 'brand-current', 'data-letter' => $letter]);
                    $hidden = '';
                } else {
                    $list .= Html::tag('li', Html::a($title, ['brand/page', 'slug' => $slug]));
                }
            }
            $list .= Html::endTag('ul');

            $td_lists .= Html::tag('div', $list, ['class' => 'brand-list' . $hidden, 'data-letter' => $letter]);

            $n++;
            if ($n % $this->columns == 0) {
                echo Html::tag('tr', $td_letters);
                echo Html::tag('tr', Html::tag('td', $td_lists, ['colspan' => $this->columns]));

                $n = 0;
                $td_letters = '';
                $td_lists = '';
            }
        }

        echo Html::endTag('table');

        $this->registerJs();
    }

    private function registerJs()
    {
        $js = <<<JS
            $('.$this->wrapperClass td').click(function() {
                var letter = $(this).data('letter');
                if (letter) {
                $('.brand-list').addClass('hidden');
                    $(this).parent().next().find('.brand-list[data-letter="' + letter + '"]').removeClass('hidden');
                }
            });
JS;
        $this->view->registerJs($js);
    }
}