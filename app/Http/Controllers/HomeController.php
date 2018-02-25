<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	private $api;

	/**
	 * HomeController constructor.
	 *
	 * @param \App\Http\Controllers\Api\ApiRequest $api
	 */
	public function __construct (ApiRequest $api) {
		$this->api = $api;
	}

	public function index () {
    	$response = $this->api->get_account_balance();
    	$data = $response->data->list;
    	dump($data);

    	// 查询所有的币种
		$coins = [];
    	foreach ($data as $v) {
    		if ($v->balance > 0) {
    			$coins[] = $v->currency;
			}
		}
		$coins = array_unique($coins);// 币种去重
		dump($coins);

		// 获取当前账户的所有币的余额
		$info = [];
		foreach ($coins as $v) {
			$info[$v]['count'] = 0;
			$info[$v]['frozen'] = 0;
			$info[$v]['trade'] = 0;
		}
		foreach ($data as $v) {
			if (in_array($v->currency,$coins)) {
				$info[$v->currency]['count'] += $v->balance;

				if ($v->type === 'trade') {
					$info[$v->currency]['trade'] += $v->balance;
				}
				if ($v->type === 'froze') {
					$info[$v->currency]['frozen'] += $v->balance;
				}
			}
		}

		dump($info);
	}

	// 获取当前一分钟内 某币种的k线
	public function getCoinK ($coin = 'ethusdt') {

		$data = $this->api->get_history_kline($coin,'1min',2000);
		dump($data);
	}



	#
	public function getAccount () {

		$accountId = $this->api->get_account_accounts();
		dump($accountId);
		return '';
	}


	public function test() {
		$a = [];
		$a['count'] = 1;
		$a['count'] += 1;
		dump($a);
		$a['count'] += 2;
		dump($a);
	}
}
