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
		$this->serviceName = 'civicinfo';

		$client->addService($this->serviceName, $this->version);
		$this->elections = new ElectionsServiceResource($this, $this->serviceName, 'elections', array());
	}
}

class ElectionsServiceResource extends ServiceResource {
	public function get() {
		$data = $this->__call('get', array());
		if ($this->useObjects()) {
			return new Elections($data);
		} else {
			return $data;
		}
	}
}

class Elections extends Model {
	protected $__itemsType = 'Election';
	protected $__itemsDataType = 'array';
	public $items;
	public $kind;
	public function setItems(/* array(Bookshelf) */ $items) {
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




