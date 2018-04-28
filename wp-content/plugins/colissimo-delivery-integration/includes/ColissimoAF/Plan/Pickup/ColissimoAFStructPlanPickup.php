<?php
/**
 * File for class ColissimoAFStructPlanPickup
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructPlanPickup originally named planPickup
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructPlanPickup extends ColissimoAFWsdlClass
{
    /**
     * The planPickupRequest
     * @var ColissimoAFStructPlanPickupRequest
     */
    public $planPickupRequest;
    /**
     * Constructor method for planPickup
     * @see parent::__construct()
     * @param ColissimoAFStructPlanPickupRequest $_planPickupRequest
     * @return ColissimoAFStructPlanPickup
     */
    public function __construct($_planPickupRequest = NULL)
    {
        parent::__construct(array('planPickupRequest'=>$_planPickupRequest),false);
    }
    /**
     * Get planPickupRequest value
     * @return ColissimoAFStructPlanPickupRequest|null
     */
    public function getPlanPickupRequest()
    {
        return $this->planPickupRequest;
    }
    /**
     * Set planPickupRequest value
     * @param ColissimoAFStructPlanPickupRequest $_planPickupRequest the planPickupRequest
     * @return ColissimoAFStructPlanPickupRequest
     */
    public function setPlanPickupRequest($_planPickupRequest)
    {
        return ($this->planPickupRequest = $_planPickupRequest);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructPlanPickup
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
