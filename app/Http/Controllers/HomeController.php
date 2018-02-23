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
    	$response = $this->api->get_balance();
    	dd($response);
    	$data = $response->data->list;

    	$info = [];
    	foreach ($data as $v) {
    		if ($v->balance > 0) {
    			$info[] = $v;
			}
		}
		dump($info);
	}
}
