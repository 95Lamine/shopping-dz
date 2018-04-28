<?php
/**
 * File for class ColissimoAFStructGenerateLabelResponseType
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGenerateLabelResponseType originally named GenerateLabelResponseType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGenerateLabelResponseType extends ColissimoAFStructBaseResponse
{
    /**
     * The labelXmlReponse
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructXmlResponse
     */
    public $labelXmlReponse;
    /**
     * The labelResponse
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructLabelResponse
     */
    public $labelResponse;
    /**
     * Constructor method for GenerateLabelResponseType
     * @see parent::__construct()
     * @param ColissimoAFStructXmlResponse $_labelXmlReponse
     * @param ColissimoAFStructLabelResponse $_labelResponse
     * @return ColissimoAFStructGenerateLabelResponseType
     */
    public function __construct($_labelXmlReponse = NULL,$_labelResponse = NULL)
    {
        ColissimoAFWsdlClass::__construct(array('labelXmlReponse'=>$_labelXmlReponse,'labelResponse'=>$_labelResponse),false);
    }
    /**
     * Get labelXmlReponse value
     * @return ColissimoAFStructXmlResponse|null
     */
    public function getLabelXmlReponse()
    {
        return $this->labelXmlReponse;
    }
    /**
     * Set labelXmlReponse value
     * @param ColissimoAFStructXmlResponse $_labelXmlReponse the labelXmlReponse
     * @return ColissimoAFStructXmlResponse
     */
    public function setLabelXmlReponse($_labelXmlReponse)
    {
        return ($this->labelXmlReponse = $_labelXmlReponse);
    }
    /**
     * Get labelResponse value
     * @return ColissimoAFStructLabelResponse|null
     */
    public function getLabelResponse()
    {
        return $this->labelResponse;
    }
    /**
     * Set labelResponse value
     * @param ColissimoAFStructLabelResponse $_labelResponse the labelResponse
     * @return ColissimoAFStructLabelResponse
     */
    public function setLabelResponse($_labelResponse)
    {
        return ($this->labelResponse = $_labelResponse);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGenerateLabelResponseType
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
