<?php

namespace novatorgroup\brandtools;

use yii\base\Component;

/**
 * Components for obtaining brand data from the site https://price.novator-group.ru/
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
     * @param array $params
     * [
     *      'ids' => [...],
     *      'novator' => 1
     * ]
     * @return array
     */
    public function loadIndex(array $params = []): ?array
    {
        return $this->request('load-index', $params);
    }

    /**
     * Load brand info
     * @param $brandIdOrSlug
     * @return array
     */
    public function loadPage($brandIdOrSlug): ?array
    {
        return $this->request('load-page', ['id' => $brandIdOrSlug]);
    }

    private function request(string $url, array $params = []): ?array
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
            CURLOPT_POSTFIELDS => http_build_query($params)
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch) || empty($response)) {
            return null;
        }

        return json_decode($response, true);
    }
}