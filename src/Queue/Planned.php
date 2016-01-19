<?php

namespace NodeRunner\Queue;

class Planned extends \NodeRunner\Queue
{
    public function __construct($DBAdapter, $queueName = 'planned')
    {
        parent::__construct($DBAdapter, $queueName);
    }

}