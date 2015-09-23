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

class Logger {
	protected static $path = NULL;

	public static function setPath($path) {
		if (! is_string($path))
			return false;

		self::$path = realpath($path);

		return true;
	}

	public static function log($loglevel, $filename, $message, $file=NULL, $line=NULL) {
		if (is_null(self::$path))
			return false;

		$buf = '';
		$buf.= date('M j Y H:i:s');
		if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '')
			$buf.= ' - '.$_SERVER['REMOTE_ADDR'];
		else
			$buf.= ' - 127.0.0.1';
		$buf.= ' - '.strtoupper($loglevel);
		$buf.= ' - '.$message;
		if (! is_null($file)) {
			$buf.= ' in '.$file;
			if (! is_null($line))
				$buf.= ' at line '.$line;
		}

		file_put_contents(self::$path.'/'.$filename.'.log', $buf."\r\n", FILE_APPEND);

		return true;
	}

	public static function emergency($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::EMERGENCY, $filename, $message, $file, $line);
	}

	public static function alert($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::ALERT, $filename, $message, $file, $line);
	}

	public static function critical($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::CRITICAL, $filename, $message, $file, $line);
	}

	public static function error($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::ERROR, $filename, $message, $file, $line);
	}

	public static function warning($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::WARNING, $filename, $message, $file, $line);
	}

	public static function notice($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::NOTICE, $filename, $message, $file, $line);
	}

	public static function info($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::INFO, $filename, $message, $file, $line);
	}

	public static function debug($filename, $message, $file=NULL, $line=NULL) {
		Logger::log(LogLevel::DEBUG, $filename, $message, $file, $line);
	}
}
