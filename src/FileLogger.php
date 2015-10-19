<?php
/**
 * Log/FileLogger.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 * @version 2.1.0
**/

namespace Phyrexia\Log;

use Psr\Log\AbstractLogger;

class FileLogger extends AbstractLogger {
	private $filePath;

	public function __construct($filePath = NULL) {
		if (! is_null($filePath))
			$this->setFilePath($filePath);
	}

	public function getFilePath() {
		return $this->filePath;
	}

	public function setFilePath($filePath) {
		if (! is_string($filePath))
			return false;

		if (! file_exists(dirname($filePath)) || (! is_writable($filePath) && ! is_writable(dirname($filePath))))
			return false;

		$this->filePath = $filePath;

		return true;
	}

	public function log($level, $message, array $context = array()) {
		if (is_null($this->filePath))
			return false;

		$buf = '';
		$buf.= date('r');
		$buf.= ' - ';
		if (isset($_SERVER) && is_array($_SERVER) && array_key_exists('REMOTE_ADDR', $_SERVER))
			$buf.= $_SERVER['REMOTE_ADDR'];
		else
			$buf.= '~';
		$buf.= ' - '.strtoupper($level);
		$buf.= ' - '.$message;

		file_put_contents($this->filePath, $buf.PHP_EOL, FILE_APPEND);

		return true;
	}
}
