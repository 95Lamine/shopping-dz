<?php
/**
 * File for class ColissimoAFStructGetListMailBoxPickingDates
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetListMailBoxPickingDates originally named getListMailBoxPickingDates
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetListMailBoxPickingDates extends ColissimoAFWsdlClass
{
    /**
     * The getListMailBoxPickingDatesRetourRequest
     * @var ColissimoAFStructGetListMailBoxPickingDatesRetourRequest
     */
    public $getListMailBoxPickingDatesRetourRequest;
    /**
     * Constructor method for getListMailBoxPickingDates
     * @see parent::__construct()
     * @param ColissimoAFStructGetListMailBoxPickingDatesRetourRequest $_getListMailBoxPickingDatesRetourRequest
     * @return ColissimoAFStructGetListMailBoxPickingDates
     */
    public function __construct($_getListMailBoxPickingDatesRetourRequest = NULL)
    {
        parent::__construct(array('getListMailBoxPickingDatesRetourRequest'=>$_getListMailBoxPickingDatesRetourRequest),false);
    }
    /**
     * Get getListMailBoxPickingDatesRetourRequest value
     * @return ColissimoAFStructGetListMailBoxPickingDatesRetourRequest|null
     */
    public function getGetListMailBoxPickingDatesRetourRequest()
    {
        return $this->getListMailBoxPickingDatesRetourRequest;
    }
    /**
     * Set getListMailBoxPickingDatesRetourRequest value
     * @param ColissimoAFStructGetListMailBoxPickingDatesRetourRequest $_getListMailBoxPickingDatesRetourRequest the getListMailBoxPickingDatesRetourRequest
     * @return ColissimoAFStructGetListMailBoxPickingDatesRetourRequest
     */
    public function setGetListMailBoxPickingDatesRetourRequest($_getListMailBoxPickingDatesRetourRequest)
    {
        return ($this->getListMailBoxPickingDatesRetourRequest = $_getListMailBoxPickingDatesRetourRequest);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGetListMailBoxPickingDates
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
