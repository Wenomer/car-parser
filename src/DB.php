<?php

namespace CarParser;

class DB
{
    private $dbpath = __DIR__.DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db';
    protected $data;

    public function __construct()
    {
        if (!is_file($this->dbpath)) {
            touch($this->dbpath);
        }

        $this->read();
    }

    protected function read()
    {
        $this->data = unserialize(file_get_contents($this->dbpath));
    }

    public function write($group, $id)
    {
        if (!isset($this->data[$group])) {
            $this->data[$group] = [];
        }
        $this->data[$group][] = $id;

        file_put_contents($this->dbpath, serialize($this->data));
    }

    public function getData($group)
    {
        if (!isset($this->data[$group])) {
            return [];
        }

        return $this->data[$group];
    }
}