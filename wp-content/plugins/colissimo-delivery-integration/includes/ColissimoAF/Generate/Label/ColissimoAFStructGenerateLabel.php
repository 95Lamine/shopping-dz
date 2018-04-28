<?php
/**
 * File for class ColissimoAFStructGenerateLabel
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGenerateLabel originally named generateLabel
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGenerateLabel extends ColissimoAFWsdlClass
{
    /**
     * The generateLabelRequest
     * @var ColissimoAFStructGenerateLabelRequest
     */
    public $generateLabelRequest;
    /**
     * Constructor method for generateLabel
     * @see parent::__construct()
     * @param ColissimoAFStructGenerateLabelRequest $_generateLabelRequest
     * @return ColissimoAFStructGenerateLabel
     */
    public function __construct($_generateLabelRequest = NULL)
    {
        parent::__construct(array('generateLabelRequest'=>$_generateLabelRequest),false);
    }
    /**
     * Get generateLabelRequest value
     * @return ColissimoAFStructGenerateLabelRequest|null
     */
    public function getGenerateLabelRequest()
    {
        return $this->generateLabelRequest;
    }
    /**
     * Set generateLabelRequest value
     * @param ColissimoAFStructGenerateLabelRequest $_generateLabelRequest the generateLabelRequest
     * @return ColissimoAFStructGenerateLabelRequest
     */
    public function setGenerateLabelRequest($_generateLabelRequest)
    {
        return ($this->generateLabelRequest = $_generateLabelRequest);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGenerateLabel
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
