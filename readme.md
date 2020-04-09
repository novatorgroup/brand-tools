Novator Price Service Brand Tools
=================================
This is the code for a particular project.

### Usage
```php
    // Load index
    $brands = [ list of site brands ];
    Yii::$app->itemBrandsService->loadIndex($brands);
    
    // Load brand info
    Yii::$app->itemBrandsService->loadPage($brandId);
    
    // Widget
    echo BrandIndexWidget::widget([
        'list' => $this->listBrandIndex(),
        'currentId' => $id,
        'wrapperClass' => 'brand-sidebar',
        'letterClass' => 'letter',
        'listClass' => 'list-unstyled hidden'
    ]);
    
    // Widget
    echo BrandListWidget::widget([
        'list' => $this->listBrandIndex(),
        'wrapperClass' => 'brand-wrapper',
        'itemClass' => 'brand',
        'template' => BrandListWidget::TEMPLATE_VERTICAL,
    ]);
```