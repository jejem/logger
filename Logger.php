<?php
/**
 * Log/Logger.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 * @version 1.0.0
**/

namespace Phyrexia\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Logger implements LoggerInterface {
	private $filepath;

	public function __construct($filepath = NULL) {
		if (! is_null($filepath))
			$this->setFilePath($filepath);
	}

	public function getFilePath() {
		return $this->filepath;
	}

	public function setFilePath($filepath) {
		if (! is_string($filepath))
			return false;

		if (! file_exists(dirname($filepath)) || (! is_writable($filepath) && ! is_writable(dirname($filepath))))
			return false;

		$this->filepath = $filepath;

		return true;
	}

	public function log($level, $message, array $context = array()) {
		if (is_null($this->getFilePath()))
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

		file_put_contents($this->getFilePath(), $buf.PHP_EOL, FILE_APPEND);

		return true;
	}

	public function emergency($message, array $context = array()) {
		$this->log(LogLevel::EMERGENCY, $message, $context);
	}

	public function alert($message, array $context = array()) {
		$this->log(LogLevel::ALERT, $message, $context);
	}

	public function critical($message, array $context = array()) {
		$this->log(LogLevel::CRITICAL, $message, $context);
	}

	public function error($message, array $context = array()) {
		$this->log(LogLevel::ERROR, $message, $context);
	}

	public function warning($message, array $context = array()) {
		$this->log(LogLevel::WARNING, $message, $context);
	}

	public function notice($message, array $context = array()) {
		$this->log(LogLevel::NOTICE, $message, $context);
	}

	public function info($message, array $context = array()) {
		$this->log(LogLevel::INFO, $message, $context);
	}

	public function debug($message, array $context = array()) {
		$this->log(LogLevel::DEBUG, $message, $context);
	}
}
