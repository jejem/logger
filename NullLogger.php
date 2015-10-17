<?php
/**
 * Log/NullLogger.php
 *
 * @author Jérémy 'Jejem' Desvages <jejem@phyrexia.org>
 * @copyright Jérémy 'Jejem' Desvages
 * @license The MIT License (MIT)
 * @version 2.1.0
**/

namespace Phyrexia\Log;

use Psr\Log\AbstractLogger;

class NullLogger extends AbstractLogger {
	public function log($level, $message, array $context = array()) {
		return true;
	}
}
