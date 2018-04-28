<?php
/**
 * File for class ColissimoAFStructGetProductInter
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetProductInter originally named getProductInter
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetProductInter extends ColissimoAFWsdlClass
{
    /**
     * The getProductInterRequest
     * @var ColissimoAFStructGetProductInterRequest
     */
    public $getProductInterRequest;
    /**
     * Constructor method for getProductInter
     * @see parent::__construct()
     * @param ColissimoAFStructGetProductInterRequest $_getProductInterRequest
     * @return ColissimoAFStructGetProductInter
     */
    public function __construct($_getProductInterRequest = NULL)
    {
        parent::__construct(array('getProductInterRequest'=>$_getProductInterRequest),false);
    }
    /**
     * Get getProductInterRequest value
     * @return ColissimoAFStructGetProductInterRequest|null
     */
    public function getGetProductInterRequest()
    {
        return $this->getProductInterRequest;
    }
    /**
     * Set getProductInterRequest value
     * @param ColissimoAFStructGetProductInterRequest $_getProductInterRequest the getProductInterRequest
     * @return ColissimoAFStructGetProductInterRequest
     */
    public function setGetProductInterRequest($_getProductInterRequest)
    {
        return ($this->getProductInterRequest = $_getProductInterRequest);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGetProductInter
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
