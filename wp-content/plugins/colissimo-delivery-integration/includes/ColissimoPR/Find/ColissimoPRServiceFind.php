<?php
/**
 * File for class ColissimoPRServiceFind
 * @package ColissimoPR
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRServiceFind originally named Find
 * @package ColissimoPR
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRServiceFind extends ColissimoPRWsdlClass
{
    /**
     * Method to call the operation originally named findInternalPointRetraitAcheminementByID
     * @uses ColissimoPRWsdlClass::getSoapClient()
     * @uses ColissimoPRWsdlClass::setResult()
     * @uses ColissimoPRWsdlClass::saveLastError()
     * @param ColissimoPRStructFindInternalPointRetraitAcheminementByID $_colissimoPRStructFindInternalPointRetraitAcheminementByID
     * @return ColissimoPRStructFindInternalPointRetraitAcheminementByIDResponse
     */
    public function findInternalPointRetraitAcheminementByID(ColissimoPRStructFindInternalPointRetraitAcheminementByID $_colissimoPRStructFindInternalPointRetraitAcheminementByID)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->findInternalPointRetraitAcheminementByID($_colissimoPRStructFindInternalPointRetraitAcheminementByID));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named findRDVPointRetraitAcheminement
     * @uses ColissimoPRWsdlClass::getSoapClient()
     * @uses ColissimoPRWsdlClass::setResult()
     * @uses ColissimoPRWsdlClass::saveLastError()
     * @param ColissimoPRStructFindRDVPointRetraitAcheminement $_colissimoPRStructFindRDVPointRetraitAcheminement
     * @return ColissimoPRStructFindRDVPointRetraitAcheminementResponse
     */
    public function findRDVPointRetraitAcheminement(ColissimoPRStructFindRDVPointRetraitAcheminement $_colissimoPRStructFindRDVPointRetraitAcheminement)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->findRDVPointRetraitAcheminement($_colissimoPRStructFindRDVPointRetraitAcheminement));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named findInternalRDVPointRetraitAcheminement
     * @uses ColissimoPRWsdlClass::getSoapClient()
     * @uses ColissimoPRWsdlClass::setResult()
     * @uses ColissimoPRWsdlClass::saveLastError()
     * @param ColissimoPRStructFindInternalRDVPointRetraitAcheminement $_colissimoPRStructFindInternalRDVPointRetraitAcheminement
     * @return ColissimoPRStructFindInternalRDVPointRetraitAcheminementResponse
     */
    public function findInternalRDVPointRetraitAcheminement(ColissimoPRStructFindInternalRDVPointRetraitAcheminement $_colissimoPRStructFindInternalRDVPointRetraitAcheminement)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->findInternalRDVPointRetraitAcheminement($_colissimoPRStructFindInternalRDVPointRetraitAcheminement));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named findInternalRDVPointRetraitAcheminementByID
     * @uses ColissimoPRWsdlClass::getSoapClient()
     * @uses ColissimoPRWsdlClass::setResult()
     * @uses ColissimoPRWsdlClass::saveLastError()
     * @param ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID $_colissimoPRStructFindInternalRDVPointRetraitAcheminementByID
     * @return ColissimoPRStructFindInternalRDVPointRetraitAcheminementByIDResponse
     */
    public function findInternalRDVPointRetraitAcheminementByID(ColissimoPRStructFindInternalRDVPointRetraitAcheminementByID $_colissimoPRStructFindInternalRDVPointRetraitAcheminementByID)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->findInternalRDVPointRetraitAcheminementByID($_colissimoPRStructFindInternalRDVPointRetraitAcheminementByID));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Method to call the operation originally named findPointRetraitAcheminementByID
     * @uses ColissimoPRWsdlClass::getSoapClient()
     * @uses ColissimoPRWsdlClass::setResult()
     * @uses ColissimoPRWsdlClass::saveLastError()
     * @param ColissimoPRStructFindPointRetraitAcheminementByID $_colissimoPRStructFindPointRetraitAcheminementByID
     * @return ColissimoPRStructFindPointRetraitAcheminementByIDResponse
     */
    public function findPointRetraitAcheminementByID(ColissimoPRStructFindPointRetraitAcheminementByID $_colissimoPRStructFindPointRetraitAcheminementByID)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->findPointRetraitAcheminementByID($_colissimoPRStructFindPointRetraitAcheminementByID));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see ColissimoPRWsdlClass::getResult()
     * @return ColissimoPRStructFindInternalPointRetraitAcheminementByIDResponse|ColissimoPRStructFindInternalRDVPointRetraitAcheminementByIDResponse|ColissimoPRStructFindInternalRDVPointRetraitAcheminementResponse|ColissimoPRStructFindPointRetraitAcheminementByIDResponse|ColissimoPRStructFindRDVPointRetraitAcheminementResponse
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
