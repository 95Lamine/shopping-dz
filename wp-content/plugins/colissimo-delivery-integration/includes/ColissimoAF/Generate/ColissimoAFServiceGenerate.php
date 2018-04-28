<?php
/**
 * File for class ColissimoAFServiceGenerate
 * @package ColissimoAF
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFServiceGenerate originally named Generate
 * @package ColissimoAF
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFServiceGenerate extends ColissimoAFWsdlClass
{
    /**
     * Method to call the operation originally named generateLabel
     * @uses ColissimoAFWsdlClass::getSoapClient()
     * @uses ColissimoAFWsdlClass::setResult()
     * @uses ColissimoAFWsdlClass::saveLastError()
     * @param ColissimoAFStructGenerateLabel $_colissimoAFStructGenerateLabel
     * @return ColissimoAFStructGenerateLabelResponse
     */
    public function generateLabel(ColissimoAFStructGenerateLabel $_colissimoAFStructGenerateLabel)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->generateLabel($_colissimoAFStructGenerateLabel));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see ColissimoAFWsdlClass::getResult()
     * @return ColissimoAFStructGenerateLabelResponse
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
