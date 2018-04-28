<?php
/**
 * File for class ColissimoAFStructOriginal
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructOriginal originally named original
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructOriginal extends ColissimoAFWsdlClass
{
    /**
     * The originalIdent
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $originalIdent;
    /**
     * The originalInvoiceNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $originalInvoiceNumber;
    /**
     * The originalInvoiceDate
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var date
     */
    public $originalInvoiceDate;
    /**
     * The originalParcelNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $originalParcelNumber;
    /**
     * Constructor method for original
     * @see parent::__construct()
     * @param string $_originalIdent
     * @param string $_originalInvoiceNumber
     * @param date $_originalInvoiceDate
     * @param string $_originalParcelNumber
     * @return ColissimoAFStructOriginal
     */
    public function __construct($_originalIdent = NULL,$_originalInvoiceNumber = NULL,$_originalInvoiceDate = NULL,$_originalParcelNumber = NULL)
    {
        parent::__construct(array('originalIdent'=>$_originalIdent,'originalInvoiceNumber'=>$_originalInvoiceNumber,'originalInvoiceDate'=>$_originalInvoiceDate,'originalParcelNumber'=>$_originalParcelNumber),false);
    }
    /**
     * Get originalIdent value
     * @return string|null
     */
    public function getOriginalIdent()
    {
        return $this->originalIdent;
    }
    /**
     * Set originalIdent value
     * @param string $_originalIdent the originalIdent
     * @return string
     */
    public function setOriginalIdent($_originalIdent)
    {
        return ($this->originalIdent = $_originalIdent);
    }
    /**
     * Get originalInvoiceNumber value
     * @return string|null
     */
    public function getOriginalInvoiceNumber()
    {
        return $this->originalInvoiceNumber;
    }
    /**
     * Set originalInvoiceNumber value
     * @param string $_originalInvoiceNumber the originalInvoiceNumber
     * @return string
     */
    public function setOriginalInvoiceNumber($_originalInvoiceNumber)
    {
        return ($this->originalInvoiceNumber = $_originalInvoiceNumber);
    }
    /**
     * Get originalInvoiceDate value
     * @return date|null
     */
    public function getOriginalInvoiceDate()
    {
        return $this->originalInvoiceDate;
    }
    /**
     * Set originalInvoiceDate value
     * @param date $_originalInvoiceDate the originalInvoiceDate
     * @return date
     */
    public function setOriginalInvoiceDate($_originalInvoiceDate)
    {
        return ($this->originalInvoiceDate = $_originalInvoiceDate);
    }
    /**
     * Get originalParcelNumber value
     * @return string|null
     */
    public function getOriginalParcelNumber()
    {
        return $this->originalParcelNumber;
    }
    /**
     * Set originalParcelNumber value
     * @param string $_originalParcelNumber the originalParcelNumber
     * @return string
     */
    public function setOriginalParcelNumber($_originalParcelNumber)
    {
        return ($this->originalParcelNumber = $_originalParcelNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructOriginal
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
