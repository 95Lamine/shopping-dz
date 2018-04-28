<?php
/**
 * File for class ColissimoAFServiceGet
 * @package ColissimoAF
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFServiceGet originally named Get
 * @package ColissimoAF
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFServiceGet extends ColissimoAFWsdlClass
{
    /**
     * Method to call the operation originally named getListMailBoxPickingDates
     * @uses ColissimoAFWsdlClass::getSoapClient()
     * @uses ColissimoAFWsdlClass::setResult()
     * @uses ColissimoAFWsdlClass::saveLastError()
     * @param ColissimoAFStructGetListMailBoxPickingDates $_colissimoAFStructGetListMailBoxPickingDates
     * @return ColissimoAFStructGetListMailBoxPickingDatesResponse
     */
    public function getListMailBoxPickingDates(ColissimoAFStructGetListMailBoxPickingDates $_colissimoAFStructGetListMailBoxPickingDates)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getListMailBoxPickingDates($_colissimoAFStructGetListMailBoxPickingDates));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named getProductInter
     * @uses ColissimoAFWsdlClass::getSoapClient()
     * @uses ColissimoAFWsdlClass::setResult()
     * @uses ColissimoAFWsdlClass::saveLastError()
     * @param ColissimoAFStructGetProductInter $_colissimoAFStructGetProductInter
     * @return ColissimoAFStructGetProductInterResponse
     */
    public function getProductInter(ColissimoAFStructGetProductInter $_colissimoAFStructGetProductInter)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->getProductInter($_colissimoAFStructGetProductInter));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see ColissimoAFWsdlClass::getResult()
     * @return ColissimoAFStructGetListMailBoxPickingDatesResponse|ColissimoAFStructGetProductInterResponse
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
