<?php
/**
 * File for class ColissimoAFStructCustomsDeclarations
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructCustomsDeclarations originally named customsDeclarations
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructCustomsDeclarations extends ColissimoAFWsdlClass
{
    /**
     * The includeCustomsDeclarations
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $includeCustomsDeclarations;
    /**
     * The contents
     * @var ColissimoAFStructContents
     */
    public $contents;
    /**
     * The importersReference
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $importersReference;
    /**
     * The importersContact
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $importersContact;
    /**
     * The officeOrigin
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $officeOrigin;
    /**
     * The comments
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $comments;
    /**
     * The invoiceNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $invoiceNumber;
    /**
     * The licenceNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $licenceNumber;
    /**
     * The certificatNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $certificatNumber;
    /**
     * Constructor method for customsDeclarations
     * @see parent::__construct()
     * @param boolean $_includeCustomsDeclarations
     * @param ColissimoAFStructContents $_contents
     * @param string $_importersReference
     * @param string $_importersContact
     * @param string $_officeOrigin
     * @param string $_comments
     * @param string $_invoiceNumber
     * @param string $_licenceNumber
     * @param string $_certificatNumber
     * @return ColissimoAFStructCustomsDeclarations
     */
    public function __construct($_includeCustomsDeclarations = NULL,$_contents = NULL,$_importersReference = NULL,$_importersContact = NULL,$_officeOrigin = NULL,$_comments = NULL,$_invoiceNumber = NULL,$_licenceNumber = NULL,$_certificatNumber = NULL)
    {
        parent::__construct(array('includeCustomsDeclarations'=>$_includeCustomsDeclarations,'contents'=>$_contents,'importersReference'=>$_importersReference,'importersContact'=>$_importersContact,'officeOrigin'=>$_officeOrigin,'comments'=>$_comments,'invoiceNumber'=>$_invoiceNumber,'licenceNumber'=>$_licenceNumber,'certificatNumber'=>$_certificatNumber),false);
    }
    /**
     * Get includeCustomsDeclarations value
     * @return boolean|null
     */
    public function getIncludeCustomsDeclarations()
    {
        return $this->includeCustomsDeclarations;
    }
    /**
     * Set includeCustomsDeclarations value
     * @param boolean $_includeCustomsDeclarations the includeCustomsDeclarations
     * @return boolean
     */
    public function setIncludeCustomsDeclarations($_includeCustomsDeclarations)
    {
        return ($this->includeCustomsDeclarations = $_includeCustomsDeclarations);
    }
    /**
     * Get contents value
     * @return ColissimoAFStructContents|null
     */
    public function getContents()
    {
        return $this->contents;
    }
    /**
     * Set contents value
     * @param ColissimoAFStructContents $_contents the contents
     * @return ColissimoAFStructContents
     */
    public function setContents($_contents)
    {
        return ($this->contents = $_contents);
    }
    /**
     * Get importersReference value
     * @return string|null
     */
    public function getImportersReference()
    {
        return $this->importersReference;
    }
    /**
     * Set importersReference value
     * @param string $_importersReference the importersReference
     * @return string
     */
    public function setImportersReference($_importersReference)
    {
        return ($this->importersReference = $_importersReference);
    }
    /**
     * Get importersContact value
     * @return string|null
     */
    public function getImportersContact()
    {
        return $this->importersContact;
    }
    /**
     * Set importersContact value
     * @param string $_importersContact the importersContact
     * @return string
     */
    public function setImportersContact($_importersContact)
    {
        return ($this->importersContact = $_importersContact);
    }
    /**
     * Get officeOrigin value
     * @return string|null
     */
    public function getOfficeOrigin()
    {
        return $this->officeOrigin;
    }
    /**
     * Set officeOrigin value
     * @param string $_officeOrigin the officeOrigin
     * @return string
     */
    public function setOfficeOrigin($_officeOrigin)
    {
        return ($this->officeOrigin = $_officeOrigin);
    }
    /**
     * Get comments value
     * @return string|null
     */
    public function getComments()
    {
        return $this->comments;
    }
    /**
     * Set comments value
     * @param string $_comments the comments
     * @return string
     */
    public function setComments($_comments)
    {
        return ($this->comments = $_comments);
    }
    /**
     * Get invoiceNumber value
     * @return string|null
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }
    /**
     * Set invoiceNumber value
     * @param string $_invoiceNumber the invoiceNumber
     * @return string
     */
    public function setInvoiceNumber($_invoiceNumber)
    {
        return ($this->invoiceNumber = $_invoiceNumber);
    }
    /**
     * Get licenceNumber value
     * @return string|null
     */
    public function getLicenceNumber()
    {
        return $this->licenceNumber;
    }
    /**
     * Set licenceNumber value
     * @param string $_licenceNumber the licenceNumber
     * @return string
     */
    public function setLicenceNumber($_licenceNumber)
    {
        return ($this->licenceNumber = $_licenceNumber);
    }
    /**
     * Get certificatNumber value
     * @return string|null
     */
    public function getCertificatNumber()
    {
        return $this->certificatNumber;
    }
    /**
     * Set certificatNumber value
     * @param string $_certificatNumber the certificatNumber
     * @return string
     */
    public function setCertificatNumber($_certificatNumber)
    {
        return ($this->certificatNumber = $_certificatNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructCustomsDeclarations
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
