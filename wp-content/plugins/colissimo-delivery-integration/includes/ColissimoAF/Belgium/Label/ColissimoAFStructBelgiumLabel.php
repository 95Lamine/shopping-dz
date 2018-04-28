<?php
/**
 * File for class ColissimoAFStructBelgiumLabel
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructBelgiumLabel originally named belgiumLabel
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructBelgiumLabel extends ColissimoAFWsdlClass
{
    /**
     * The codeBarre
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $codeBarre;
    /**
     * The codeVAS
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructCodeVAS
     */
    public $codeVAS;
    /**
     * The identification
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $identification;
    /**
     * The returnAddress
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructReturnAddressBelgium
     */
    public $returnAddress;
    /**
     * Constructor method for belgiumLabel
     * @see parent::__construct()
     * @param string $_codeBarre
     * @param ColissimoAFStructCodeVAS $_codeVAS
     * @param string $_identification
     * @param ColissimoAFStructReturnAddressBelgium $_returnAddress
     * @return ColissimoAFStructBelgiumLabel
     */
    public function __construct($_codeBarre = NULL,$_codeVAS = NULL,$_identification = NULL,$_returnAddress = NULL)
    {
        parent::__construct(array('codeBarre'=>$_codeBarre,'codeVAS'=>$_codeVAS,'identification'=>$_identification,'returnAddress'=>$_returnAddress),false);
    }
    /**
     * Get codeBarre value
     * @return string|null
     */
    public function getCodeBarre()
    {
        return $this->codeBarre;
    }
    /**
     * Set codeBarre value
     * @param string $_codeBarre the codeBarre
     * @return string
     */
    public function setCodeBarre($_codeBarre)
    {
        return ($this->codeBarre = $_codeBarre);
    }
    /**
     * Get codeVAS value
     * @return ColissimoAFStructCodeVAS|null
     */
    public function getCodeVAS()
    {
        return $this->codeVAS;
    }
    /**
     * Set codeVAS value
     * @param ColissimoAFStructCodeVAS $_codeVAS the codeVAS
     * @return ColissimoAFStructCodeVAS
     */
    public function setCodeVAS($_codeVAS)
    {
        return ($this->codeVAS = $_codeVAS);
    }
    /**
     * Get identification value
     * @return string|null
     */
    public function getIdentification()
    {
        return $this->identification;
    }
    /**
     * Set identification value
     * @param string $_identification the identification
     * @return string
     */
    public function setIdentification($_identification)
    {
        return ($this->identification = $_identification);
    }
    /**
     * Get returnAddress value
     * @return ColissimoAFStructReturnAddressBelgium|null
     */
    public function getReturnAddress()
    {
        return $this->returnAddress;
    }
    /**
     * Set returnAddress value
     * @param ColissimoAFStructReturnAddressBelgium $_returnAddress the returnAddress
     * @return ColissimoAFStructReturnAddressBelgium
     */
    public function setReturnAddress($_returnAddress)
    {
        return ($this->returnAddress = $_returnAddress);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructBelgiumLabel
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
