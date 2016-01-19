<?php

namespace NodeRunner\Job;

class Command extends \NodeRunner\Job {

    const CONCURRENCY_MODE_ALLOW = 'allow';
    const CONCURRENCY_MODE_SKIP = 'skip';

    // NOT SUPPORTED YET
    // const CONCURRENCY_MODE_KILL = '';

    /** @var  string command to be executed by noderunner */
    protected $command;

    /** @var int lowest is higher priority in proccess planning */
    protected $nice = NULL;

    /** @var int highest is soonly fetched from queue */
    protected $priority = NULL;

    /** @var string CONCURRENCY_MODE_ALLOW|CONCURRENCY_MODE_SKIP */
    protected $concurrencyMode = self::CONCURRENCY_MODE_ALLOW;

    /** @var string default job status */
    protected $_status = 'planed';

    /**
     * Create job to be executed in noderunner.
     *
     * @param $command
     */
    public function __construct($command)
    {
        $this->command = $command;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getNice()
    {
        return $this->nice;
    }

    /**
     * @param mixed $nice
     * @return $this
     */
    public function setNice($nice)
    {
        $this->nice = $nice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return string
     */
    public function getConcurrencyMode()
    {
        return $this->concurrencyMode;
    }

    /**
     * @param string $concurrencyMode
     * @return $this
     */
    public function setConcurrencyMode($concurrencyMode)
    {
        $this->concurrencyMode = $concurrencyMode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

}