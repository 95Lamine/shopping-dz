<?php
/**
 * File for class ColissimoAFStructLabelResponse
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructLabelResponse originally named labelResponse
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructLabelResponse extends ColissimoAFWsdlClass
{
    /**
     * The label
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - xmime:expectedContentTypes : application/octet-stream
     * @var base64Binary
     */
    public $label;
    /**
     * The cn23
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - xmime:expectedContentTypes : application/octet-stream
     * @var base64Binary
     */
    public $cn23;
    /**
     * The parcelNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $parcelNumber;
    /**
     * The parcelNumberPartner
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $parcelNumberPartner;
    /**
     * The pdfUrl
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $pdfUrl;
    /**
     * Constructor method for labelResponse
     * @see parent::__construct()
     * @param base64Binary $_label
     * @param base64Binary $_cn23
     * @param string $_parcelNumber
     * @param string $_parcelNumberPartner
     * @param string $_pdfUrl
     * @return ColissimoAFStructLabelResponse
     */
    public function __construct($_label = NULL,$_cn23 = NULL,$_parcelNumber = NULL,$_parcelNumberPartner = NULL,$_pdfUrl = NULL)
    {
        parent::__construct(array('label'=>$_label,'cn23'=>$_cn23,'parcelNumber'=>$_parcelNumber,'parcelNumberPartner'=>$_parcelNumberPartner,'pdfUrl'=>$_pdfUrl),false);
    }
    /**
     * Get label value
     * @return base64Binary|null
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * Set label value
     * @param base64Binary $_label the label
     * @return base64Binary
     */
    public function setLabel($_label)
    {
        return ($this->label = $_label);
    }
    /**
     * Get cn23 value
     * @return base64Binary|null
     */
    public function getCn23()
    {
        return $this->cn23;
    }
    /**
     * Set cn23 value
     * @param base64Binary $_cn23 the cn23
     * @return base64Binary
     */
    public function setCn23($_cn23)
    {
        return ($this->cn23 = $_cn23);
    }
    /**
     * Get parcelNumber value
     * @return string|null
     */
    public function getParcelNumber()
    {
        return $this->parcelNumber;
    }
    /**
     * Set parcelNumber value
     * @param string $_parcelNumber the parcelNumber
     * @return string
     */
    public function setParcelNumber($_parcelNumber)
    {
        return ($this->parcelNumber = $_parcelNumber);
    }
    /**
     * Get parcelNumberPartner value
     * @return string|null
     */
    public function getParcelNumberPartner()
    {
        return $this->parcelNumberPartner;
    }
    /**
     * Set parcelNumberPartner value
     * @param string $_parcelNumberPartner the parcelNumberPartner
     * @return string
     */
    public function setParcelNumberPartner($_parcelNumberPartner)
    {
        return ($this->parcelNumberPartner = $_parcelNumberPartner);
    }
    /**
     * Get pdfUrl value
     * @return string|null
     */
    public function getPdfUrl()
    {
        return $this->pdfUrl;
    }
    /**
     * Set pdfUrl value
     * @param string $_pdfUrl the pdfUrl
     * @return string
     */
    public function setPdfUrl($_pdfUrl)
    {
        return ($this->pdfUrl = $_pdfUrl);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructLabelResponse
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
