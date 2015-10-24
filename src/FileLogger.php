<?php
/**
 * Log/FileLogger.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 * @version 2.2.0
**/

namespace Phyrexia\Log;

class FileLogger extends \Psr\Log\AbstractLogger {
	private $filePath;

	public function __construct($filePath = NULL) {
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
		if (! in_array($level, array(\Psr\Log\LogLevel::EMERGENCY, \Psr\Log\LogLevel::ALERT, \Psr\Log\LogLevel::CRITICAL, \Psr\Log\LogLevel::ERROR, \Psr\Log\LogLevel::WARNING, \Psr\Log\LogLevel::NOTICE, \Psr\Log\LogLevel::INFO, \Psr\Log\LogLevel::DEBUG)))
			throw new \Psr\Log\InvalidArgumentException('Invalid or unsupported log level '.$level);

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
		$buf.= ' - '.$this->interpolate((string)$message, $context);

		file_put_contents($this->getFilePath(), $buf.PHP_EOL, FILE_APPEND);

		return true;
	}

	private function interpolate($message, array $context = array()) {
		$replace = array();
		foreach ($context as $k => $v)
			$replace['{'.$k.'}'] = $v;

		return strtr((string)$message, $replace);
	}
}
