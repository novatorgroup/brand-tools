<?php

namespace novatorgroup\brandtools;

use Yii;
use yii\helpers\Html;

/**
 * Widget for listing brands
 */
class BrandListWidget extends \yii\base\Widget
{
    public const TEMPLATE_VERTICAL = 'vertical';
    public const TEMPLATE_HORIZONTAL = 'horizontal';

    /**
     * @var array
     */
    public $list;

    /**
     * @var string - Active brand
     */
    public $currentId;

    /**
     * @var int
     */
    public $columns = 4;

    /**
     * @var string
     */
    public $wrapperClass = 'brand-sidebar';

    public $template = self::TEMPLATE_VERTICAL;

    public function init()
    {
        parent::init();

        if (empty($this->currentId)) {
            $this->currentId = Yii::$app->request->get('slug');
        }
    }

    public function run()
    {
        $letters = $this->brandLetters();
        if ($this->template == self::TEMPLATE_VERTICAL) {
            $this->renderVertival($letters);
        } else {
            $this->renderHorizontal($letters);
        }
    }

    private function brandLetters(): array
    {
        $letters = [];
        foreach ($this->list as $brand) {
            $letter = mb_strtoupper(mb_substr($brand['title'], 0, 1, 'UTF-8'));
            $letters[$letter][$brand['slug']] = $brand['title'];
        }
        return $letters;
    }

    private function renderVertival(array $letters): void
    {
        echo Html::beginTag('table', ['class' => $this->wrapperClass]);

        $n = 0;
        $td_letters = [];
        $td_lists = '';
        foreach ($letters as $letter => $brands) {

            $td_letters[] = Html::tag('td', $letter, ['data-letter' => $letter]);

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
                echo Html::tag('tr', implode('', $td_letters));
                echo Html::tag('tr', Html::tag('td', $td_lists, ['colspan' => $this->columns]));

                $n = 0;
                $td_letters = [];
                $td_lists = '';
            }
        }

        if (count($td_letters)) {
            while (count($td_letters) < $this->columns) {
                $td_letters[] = Html::tag('td', '');
            }
            echo Html::tag('tr', implode('', $td_letters));
            echo Html::tag('tr', Html::tag('td', $td_lists, ['colspan' => $this->columns]));
        }

        echo Html::endTag('table');

        $js = <<<JS
            jQuery('.$this->wrapperClass td').on('click', function() {
                const letter = jQuery(this).data('letter');
                if (letter) {
                    jQuery('.brand-list').addClass('hidden');
                    jQuery(this).parent().next().find('.brand-list[data-letter="' + letter + '"]').removeClass('hidden');
                }
            });
JS;
        $this->view->registerJs($js);
    }

    private function renderHorizontal(array $letters): void
    {
        echo Html::beginTag('div', ['class' => $this->wrapperClass]);
        foreach ($letters as $letter => $brands) {
            echo Html::beginTag('div', ['class' => 'btn-group']);
            echo Html::button($letter, ['class' => 'btn btn-default dropdown-toggle']);
            echo Html::beginTag('ul', ['class' => 'dropdown-menu']);
            foreach ($brands as $slug => $title) {
                echo Html::tag('li', Html::a($title, ['brand/page', 'slug' => $slug]));
            }
            echo Html::endTag('ul');
            echo Html::endTag('div');
        }
        echo Html::endTag('div');

        $js = <<<JS
            jQuery('.$this->wrapperClass button').on('click', function() {
                jQuery('.btn-group.open').removeClass('open');
                jQuery(this).parent().addClass('open');
                return false;
            });
            jQuery(document).on('click', function() {
                jQuery('.btn-group.open').removeClass('open');
            });
JS;
        $this->view->registerJs($js);
    }
}