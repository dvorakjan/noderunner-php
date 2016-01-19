<?php

namespace NodeRunner\Queue;

class Immediate extends \NodeRunner\Queue
{
    public function __construct($DBAdapter, $queueName = 'immediate')
    {
        parent::__construct($DBAdapter, $queueName);
    }

}