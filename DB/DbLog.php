<?php
/**
 * Created by PhpStorm.
 * Author: Adrian Dumitru
 * Date: 6/3/2017 8:51 PM
 */

namespace Adi\QueryBuilder\DB;


class DbLog
{

	private static $instance;



	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var \DateTimeZone
	 */
	private $dateTimeZone;



	private function __construct()
	{
		$this->dateTimeZone = new \DateTimeZone('Europe/Bucharest');
	}


	public function write( $message )
	{

		$date = new \DateTime();
		$date->setTimezone($this->dateTimeZone);

		$log = $this->path . $date->format('Y-m-d').".txt";

		if(is_dir($this->path)) {
			if(!file_exists($log)) {
				$fh  = fopen($log, 'a+') or die("Fatal Error !");
				$logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n";
				fwrite($fh, $logcontent);
				fclose($fh);
			}
			else {
				$this->edit($log,$date, $message);
			}
		}
		else {
			if(mkdir($this->path,0777) === true)
			{
				$this->write($message);
			}
		}
	}


	private function getLogFilePath( \DateTime $date )
	{
		$logFile = $_SERVER['DOCUMENT_ROOT'];
		$logFile .= DbConfig::getInstance()->getLogConfig()['/tmp/db/errors/'];
	}


	private function edit( $log, $date, $message )
	{

	}


	/**
	 * @return DbLog
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}
		return static::$instance;
	}

}