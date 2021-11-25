<?php

/**
 * Generated by phpSPO model generator 2020-05-25T06:42:59+00:00 
 */
namespace Office365\Graph;


use Office365\Runtime\ClientValue;
class IdentitySet extends ClientValue
{
    /**
     * @var Identity
     */
    public $Application;
    /**
     * @var Identity
     */
    public $Device;
    /**
     * @var Identity
     */
    public $User;

    function setProperty($name, $value)
    {
        $name = ucfirst($name);
        parent::setProperty($name, $value);
    }
}