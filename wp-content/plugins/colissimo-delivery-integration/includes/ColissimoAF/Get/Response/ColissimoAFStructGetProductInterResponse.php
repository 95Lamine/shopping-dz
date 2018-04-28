<?php
/**
 * File for class ColissimoAFStructGetProductInterResponse
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetProductInterResponse originally named getProductInterResponse
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetProductInterResponse extends ColissimoAFWsdlClass
{
    /**
     * The return
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructGetProductInterResponseType
     */
    public $return;
    /**
     * Constructor method for getProductInterResponse
     * @see parent::__construct()
     * @param ColissimoAFStructGetProductInterResponseType $_return
     * @return ColissimoAFStructGetProductInterResponse
     */
    public function __construct($_return = NULL)
    {
        parent::__construct(array('return'=>$_return),false);
    }
    /**
     * Get return value
     * @return ColissimoAFStructGetProductInterResponseType|null
     */
    public function getReturn()
    {
        return $this->return;
    }
    /**
     * Set return value
     * @param ColissimoAFStructGetProductInterResponseType $_return the return
     * @return ColissimoAFStructGetProductInterResponseType
     */
    public function setReturn($_return)
    {
        return ($this->return = $_return);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGetProductInterResponse
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
