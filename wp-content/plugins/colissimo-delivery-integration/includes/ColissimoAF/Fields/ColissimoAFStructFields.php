<?php
/**
 * File for class ColissimoAFStructFields
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructFields originally named fields
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructFields extends ColissimoAFWsdlClass
{
    /**
     * The field
     * @var ColissimoAFStructField
     */
    public $field;
    /**
     * Constructor method for fields
     * @see parent::__construct()
     * @param ColissimoAFStructField $_field
     * @return ColissimoAFStructFields
     */
    public function __construct($_field = NULL)
    {
        parent::__construct(array('field'=>$_field),false);
    }
    /**
     * Get field value
     * @return ColissimoAFStructField|null
     */
    public function getField()
    {
        return $this->field;
    }
    /**
     * Set field value
     * @param ColissimoAFStructField $_field the field
     * @return ColissimoAFStructField
     */
    public function setField($_field)
    {
        return ($this->field = $_field);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructFields
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
