<?php

namespace NodeRunner;

interface IAdapter {
    public function __construct($dsn, $dataDatabase);
    public function connect();
}