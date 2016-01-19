<?php

namespace NodeRunner\Job;

class Data extends \NodeRunner\Job {

    /** @var  array data passed to noderunner attributes */
    protected $data = [];

    /**
     * Create job to be executed in noderunner.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        parent::__construct();
    }

    /**
     * Instead of other jobs, return data prop content instead of all props composed to one array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

}