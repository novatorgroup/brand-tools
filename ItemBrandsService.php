<?php

namespace novatorgroup\brandtools;

use yii\base\Component;

/**
 * Components for obtaining brand data from the site https://price.novator-group.ru/
 * Class ItemBrandsService
 * @package novatorgroup\brandtools
 */
class ItemBrandsService extends Component
{
    /**
     * API url
     * @var string
     */
    public $url = 'https://price.novator-group.ru/brand/';

    /**
     * Load brand index
     * @param array $brandIds
     * @return array
     */
    public function loadIndex(array $brandIds)
    {
        return $this->request('load-index', [
            'brands' => $brandIds
        ]);
    }

    /**
     * Load brand info
     * @param $brandId
     * @return array
     */
    public function loadPage($brandId)
    {
        return $this->request('load-page', [
            'id' => $brandId
        ]);
    }

    private function request($url, $data)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->url . $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_PROXY => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTREDIR => 3,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch) || empty($response)) {
            return false;
        }

        return @json_decode($response, true);
    }
}