<?php

namespace NodeRunner\Queue;

class History extends \NodeRunner\Queue
{
    public function __construct($DBAdapter, $queueName = 'history')
    {
        parent::__construct($DBAdapter, $queueName);
    }

}