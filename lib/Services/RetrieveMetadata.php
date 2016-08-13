<?php
/**
 * ownCloud - mediametadata
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Jalpreet Singh Nanda (:imjalpreet) <jalpreetnanda@gmail.com>
 * @copyright Jalpreet Singh Nanda (:imjalpreet) 2016
 */

namespace OCA\MediaMetadata\Services;


use OCP\IDBConnection;

class RetrieveMetadata {

	protected $dbConnection;

	/**
	 * @param IDBConnection $connection
	 */
	public function __contruct(IDBConnection $connection){
		$this->dbConnection = $connection;
	}

	public function retrieve($fileList) {

		$retrievedData = array();
		$mapper = new ImageDimensionMapper($this->dbConnection);

		$logger = \OC::$server->getLogger();

		foreach ($fileList as $file) {
			$entity = $mapper->find($file);

			$retrievedData[''.$file] = array(
				'imageHeight' => $entity->getImageHeight(),
				'imageWidth'  => $entity->getImageWidth(),
				'dateCreated' => $entity->getDateCreated(),
				'gpsLongitude' => $entity->getGpsLongitude(),
				'gpsLatitude' => $entity->getGpsLatitude()
			);

			$logger->debug('Image Height: {height}', array('app' => 'MediaMetadata', 'height' => $retrievedData[''.$file]));
		}

		return $retrievedData;
	}
}
