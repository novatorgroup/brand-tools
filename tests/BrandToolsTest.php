<?php

namespace novatorgroup\service1c\tests;

use novatorgroup\brandtools\ItemBrandsService;
use yii\helpers\ArrayHelper;

class BrandToolsTest extends \PHPUnit\Framework\TestCase
{
    private $apiUrl = 'http://price.local/brand/';

    public function testLoadIndex()
    {
        $service = new ItemBrandsService(['url' => $this->apiUrl]);
        $result = $service->loadIndex();
        $this->assertNotNull($result);
        $this->assertArrayHasKey('brands', $result);
    }

    public function testLoadIndexNovator()
    {
        $service = new ItemBrandsService(['url' => $this->apiUrl]);
        $result = $service->loadIndex(['novator' => 1]);
        $this->assertNotNull($result);
        $this->assertArrayHasKey('brands', $result);
        $this->assertContains(3323, ArrayHelper::getColumn($result['brands'], 'id'));

    }

    public function testLoadIndexByIds()
    {
        $ids = [
            3338,
            3257,
            3323,
        ];

        $service = new ItemBrandsService(['url' => $this->apiUrl]);
        $result = $service->loadIndex(['ids' => $ids]);
        $this->assertNotNull($result);
        $this->assertArrayHasKey('brands', $result);
        $this->assertCount(count($ids), $result['brands']);
    }

    public function testLoadBrandById()
    {
        $brandId = 3338;

        $service = new ItemBrandsService(['url' => $this->apiUrl]);
        $result = $service->loadPage($brandId);

        $this->assertNotNull($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($brandId, $result['id']);
    }

    public function testLoadBrandBySlug()
    {
        $brandId = 3338;

        $service = new ItemBrandsService(['url' => $this->apiUrl]);
        $result = $service->loadPage('valtec');

        $this->assertNotNull($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($brandId, $result['id']);
    }
}