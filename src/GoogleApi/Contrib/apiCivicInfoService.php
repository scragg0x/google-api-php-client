<?php
/*
 * Copyright (c) 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace GoogleApi\Contrib;

use GoogleApi\Client;
use GoogleApi\Service\Model;
use GoogleApi\Service\Service;
use GoogleApi\Service\ServiceResource;


class apiCivicInfoService extends Service {

	public $elections;

	public function __construct(Client $client){
		$this->restBasePath = "/civicinfo/us_v1/";
		$this->version = 'us_v1';
		$this->serviceName = 'civicInfo';

		$client->addService($this->serviceName, $this->version);
		$this->elections = new ElectionsServiceResource($this, $this->serviceName, 'elections', array(
			'methods'=> array(
				'electionQuery' => array(
					'id' => 'civicInfo.elections.electionQuery',
					'httpMethod' => 'GET',
					'path' => 'elections',
					'response' => array(
						'$ref' => 'Election'
					)
				),
				'voterInfoQuery' => array(
					'id' => 'civicInfo.elections.voterInfoQuery',
					'httpMethod' => 'POST',
					'path' => 'voterinfo/{electionId}/lookup',
					'parameters' => array(
						'electionId' => array('required' => true, 'type'=> 'long', 'location' => 'path'),
						'officialOnly' => array('type' => 'boolean', 'location' => 'query')
					)
				)
			)
		));
	}
}

class ElectionsServiceResource extends ServiceResource {
	public function electionQuery() {
		$params = array();
		$data = $this->__call('electionQuery', array($params));
		if ($this->useObjects()) {
			return new Elections($data);
		} else {
			return $data;
		}
	}

	public function voterInfoQuery($electionId, $address, $optParams=array()) {
		$params = array('electionId' => $electionId, 'postBody' => array('address' => $address));
		$params = array_merge($params, $optParams);
		$data = $this->__call('voterInfoQuery', array($params));
		return $data;
	}
}

class Elections extends Model {
	protected $__itemsType = 'Election';
	protected $__itemsDataType = 'array';
	public $items;
	public $kind;
	public function setItems($items) {
		$this->assertIsArray($items, 'Election', __METHOD__);
		$this->items = $items;
	}
	public function getItems() {
		return $this->items;
	}
	public function setKind($kind) {
		$this->kind = $kind;
	}
	public function getKind() {
		return $this->kind;
	}
}

class Election extends Model {
	public $id;
	public $name;
	public $electionDay;
}




