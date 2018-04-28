<?php
/**
 * File for class ColissimoAFStructField
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructField originally named field
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructField extends ColissimoAFWsdlClass
{
    /**
     * The key
     * @var string
     */
    public $key;
    /**
     * The value
     * @var string
     */
    public $value;
    /**
     * Constructor method for field
     * @see parent::__construct()
     * @param string $_key
     * @param string $_value
     * @return ColissimoAFStructField
     */
    public function __construct($_key = NULL,$_value = NULL)
    {
        parent::__construct(array('key'=>$_key,'value'=>$_value),false);
    }
    /**
     * Get key value
     * @return string|null
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * Set key value
     * @param string $_key the key
     * @return string
     */
    public function setKey($_key)
    {
        return ($this->key = $_key);
    }
    /**
     * Get value value
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * Set value value
     * @param string $_value the value
     * @return string
     */
    public function setValue($_value)
    {
        return ($this->value = $_value);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructField
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
