<?php


namespace ContentNegotiation\AcceptHeader;


final class Param
{

    protected $name;

    protected $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->name === 'q') {
            $this->value = sprintf("%g", $this->value);
        }
        return sprintf("%s=%s", $this->name, $this->value);
    }
}
