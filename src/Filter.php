<?php

namespace CarParser;

abstract class Filter
{
    protected $uri;
    protected $optionsMap;
    protected $rawData;
    protected $filter;

    protected $method = "GET";

    /**
     * @param array $rawData
     */
    public function __construct(array $rawData)
    {
        $this->rawData = $rawData;
        $this->validate();
    }

    /**
     * @return array
     */
    public function getFilter()
    {
        $filter = [];

        foreach ($this->rawData as $key => $value) {
            $filter[$this->optionsMap[$key]['name']] = $value;

            if (!isset($this->optionsMap[$key]['validateMap']) || $this->optionsMap[$key]['validateMap']) {
                $filter[$this->optionsMap[$key]['name']] = $this->optionsMap[$key]['map'][$value];
            }
        }

        return $filter;
    }

    protected function validate()
    {
        foreach ($this->rawData as $key => $value) {
            if (!isset($this->optionsMap[$key])) {
                throw new \Exception(sprintf('Unsupported option "%s" for "%s"', $key, get_class($this)));
            }

            if (!isset($this->optionsMap[$key]['name'])) {
                throw new \Exception(sprintf('Need to set option name "%s" for "%s"', $key, get_class($this)));
            }

            if (!isset($this->optionsMap[$key]['validateMap']) || $this->optionsMap[$key]['validateMap']) {
                if (!isset($this->optionsMap[$key]['map'][$value])) {
                    throw new \Exception(sprintf('Unsupported value "%s" for option "%s" for "%s"', $value, $key, get_class($this)));
                }
            }
        }
    }

    public function getRequestUrl()
    {
        return $this->uri . '?' . http_build_query($this->getFilter());
    }

    public function getMethod()
    {
        return $this->method;
    }
}