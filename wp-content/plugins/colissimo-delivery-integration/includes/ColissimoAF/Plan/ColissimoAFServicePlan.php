<?php
/**
 * File for class ColissimoAFServicePlan
 * @package ColissimoAF
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFServicePlan originally named Plan
 * @package ColissimoAF
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFServicePlan extends ColissimoAFWsdlClass
{
    /**
     * Method to call the operation originally named planPickup
     * @uses ColissimoAFWsdlClass::getSoapClient()
     * @uses ColissimoAFWsdlClass::setResult()
     * @uses ColissimoAFWsdlClass::saveLastError()
     * @param ColissimoAFStructPlanPickup $_colissimoAFStructPlanPickup
     * @return ColissimoAFStructPlanPickupResponse
     */
    public function planPickup(ColissimoAFStructPlanPickup $_colissimoAFStructPlanPickup)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->planPickup($_colissimoAFStructPlanPickup));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see ColissimoAFWsdlClass::getResult()
     * @return ColissimoAFStructPlanPickupResponse
     */
    public function getResult()
    {
        return parent::getResult();
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
