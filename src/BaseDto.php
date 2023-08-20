<?php

namespace vandarpay\ServiceRepository;

use Exception;
use UnitEnum;

class BaseDto
{
    protected int $variablePosition = 0;
    protected bool $throwExceptionInSetFromArray = false;
    protected array $variableArray = [];

    /**
     * @param array|null $dataArray
     * @throws Exception
     */
    public function __construct(array $dataArray = null, bool $throwException = null)
    {
        if (is_array($dataArray) && !empty($dataArray)) {
            $this->fromArray($dataArray, $throwException);
        }
    }

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
        $this->variableArray = array_map(function ($value) {
            if ($value instanceof UnitEnum) {
                return $value->value;
            }
            return $value;
        }, array_filter(
            get_object_vars($this),
            function ($key) use ($filterVariable) {
                return !in_array($key, $filterVariable);
            },
            ARRAY_FILTER_USE_KEY
        ));
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

    /**
     * @param array $data
     * @param bool|null $throwException
     * @return $this
     * @throws Exception
     */
    public function fromArray(array $data, bool $throwException = null): static
    {
        if (!is_null($throwException)) {
            $this->throwExceptionInSetFromArray = $throwException;
        }
        foreach ($data as $variableName => $value) {
            try {
                $methodName = 'set' . ucfirst($variableName);
                $this->$methodName($value);
            } catch (Exception $exception) {
                if ($this->throwExceptionInSetFromArray) {
                    throw $exception;
                }
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function equals(self $compareDto): bool
    {
        return empty(array_diff($this->toArray(), $compareDto->toArray()));
    }
}
