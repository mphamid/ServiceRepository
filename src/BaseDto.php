<?php

namespace vandarpay\ServiceRepository;

class BaseDto
{
    protected int $variablePosition = 0;
    protected array $variableArray = [];

    /**
     * @param $method
     * @param $params
     * @return $this
     */
    public function __call($method, $params)
    {
        $var = lcfirst(substr($method, 3));
        if (strncasecmp($method, "get", 3) === 0) {
            return $this->$var;
        }
        if (strncasecmp($method, "set", 3) === 0) {
            $this->$var = $params[0];
        }
        return $this;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $filterVariable = ['variableArray', 'variablePosition'];
        $this->variableArray = array_filter(
            get_object_vars($this),
            function ($key) use ($filterVariable) {
                return !in_array($key, $filterVariable);
            },
            ARRAY_FILTER_USE_KEY
        );
        $this->variablePosition = 0;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->{$this->key()};
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->variableArray[$this->variablePosition];
    }

    /**
     * @return void
     */
    public function next()
    {
        ++$this->variablePosition;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->variableArray[$this->variablePosition]);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->rewind();
        return $this->variableArray;
    }

    /**
     * @return string
     */
    function toJson(): string
    {
        $this->rewind();
        return json_encode($this->variableArray);
    }
}
