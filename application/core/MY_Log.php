<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Monolog\Logger;

/**
 * Codeigniter Logger Extention
 *
 * @package    CodeIgniter
 * @subpackage    Core Extention
 * @category    Logging
 * @author    BrianPark <theblack1025@gmail.com>
 * @link    https://github.com/UnRyongPark/codeigniter-3-monolog
 * @link    https://github.com/Seldaek/monolog
 * @link    https://codeigniter.com/user_guide/general/errors.html
 */

class MY_Log Extends CI_Log
{
    // The channel follows the setting of Codeigniter.
    private $channel = ENVIRONMENT;
    // you can use any handlers
    // https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md
    private $target_handlers = ['raven', 'slackWebhook'];
    // min log level is debug
    private $log_level = 100;
    // log obj
    private $log;

    /*
    * option variables
    * if you need initialize some library?
    * I had raven settings and slack webhook settings.
    * If you need the setting of codeigniter, you can use the $ this->config method.
    */
    private $raven_dsn = 'RAVEN_DSN'; 
    private $raven_options = ['curl_method' => 'exec']; // this option for sentry(https://docs.sentry.io/clients/php/config/)
    private $slack_webhook_url = 'SLACK_WEBHOOK_URL'; // incomming webhook url

    /**
     * MY_Log constructor.
     * 1. Logger initialization
     * 2. Register the handler
     */
    public function __construct()
    {
        parent::__construct();

        $this->log = new Logger($this->channel);
        Monolog\ErrorHandler::register($this->log);

        // Synchronizing codeigniter threshold and logger level.
        switch ($this->_threshold) {
            case 4:
            case 2:
                $this->log_level = Logger::DEBUG;
                break;
            case 1:
                $this->log_level = Logger::ERROR;
                break;
            case 0:
            default:
                $this->log_level = Logger::EMERGENCY;
                break;
        }

        // Add Handlers
        foreach ($this->target_handlers as $handler) {
            $name = $handler . 'Handler';
            // eg) fileHandler, ravenHandler
            $this->$name();
        }
    }

    private function fileHandler()
    {
        $this->addHandler(
            new Monolog\Handler\RotatingFileHandler("$this->_log_path/log.$this->_file_ext", 0,
                $this->log_level, true, $this->_file_permissions),
            new Monolog\Formatter\LineFormatter(null, null, true)
        );
    }

    private function ravenHandler()
    {
        $client = new Raven_Client($this->raven_dsn, $this->raven_options);
        $this->addHandler(
            new Monolog\Handler\RavenHandler($client),
            new Monolog\Formatter\LineFormatter("%message% %context% %extra%\n")
        );
    }

    private function slackWebhookHandler()
    {
        $this->addHandler(
            new Monolog\Handler\SlackWebhookHandler($this->slack_webhook_url, "#api-errors", "Monolog", true, null,
                false, true, Logger::ERROR),
            new Monolog\Formatter\LineFormatter(null, null, true)
        );
    }

    private function addHandler($handler, $formatter = null)
    {
        if ($formatter != null) {
            $handler->setFormatter($formatter);
        }
        $this->log->pushHandler($handler);
    }

    public function write_log($level, $msg)
    {
        if ($this->_enabled === false) {
            return false;
        }

        $level = strtoupper($level);
        // level checking
        if ((!isset($this->_levels[$level]) ||
                ($this->_levels[$level] > $this->_threshold)) && array_key_exists($level,
                $this->_levels) && !isset($this->_threshold_array[$this->_levels[$level]])) {
            return false;
        }

        // migrate level
        $migrate_level = !in_array($level, [
            'DEBUG',
            'INFO',
            'NOTICE',
            'WARNING',
            'ERROR',
            'CRITICAL',
            'ALERT',
            'EMERGENCY',
        ]) ? 'debug' : strtolower($level);

        $this->log->$migrate_level($msg);

        return true;
    }
}