<?php
/**
 * File for class ColissimoAFStructService
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructService originally named service
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructService extends ColissimoAFWsdlClass
{
    /**
     * The productCode
     * @var string
     */
    public $productCode;
    /**
     * The depositDate
     * @var date
     */
    public $depositDate;
    /**
     * The mailBoxPicking
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $mailBoxPicking;
    /**
     * The mailBoxPickingDate
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var date
     */
    public $mailBoxPickingDate;
    /**
     * The vatCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $vatCode;
    /**
     * The vatPercentage
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $vatPercentage;
    /**
     * The vatAmount
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $vatAmount;
    /**
     * The transportationAmount
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $transportationAmount;
    /**
     * The totalAmount
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $totalAmount;
    /**
     * The orderNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $orderNumber;
    /**
     * The commercialName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $commercialName;
    /**
     * The returnTypeChoice
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $returnTypeChoice;
    /**
     * Constructor method for service
     * @see parent::__construct()
     * @param string $_productCode
     * @param date $_depositDate
     * @param boolean $_mailBoxPicking
     * @param date $_mailBoxPickingDate
     * @param int $_vatCode
     * @param int $_vatPercentage
     * @param int $_vatAmount
     * @param int $_transportationAmount
     * @param int $_totalAmount
     * @param string $_orderNumber
     * @param string $_commercialName
     * @param int $_returnTypeChoice
     * @return ColissimoAFStructService
     */
    public function __construct($_productCode = NULL,$_depositDate = NULL,$_mailBoxPicking = NULL,$_mailBoxPickingDate = NULL,$_vatCode = NULL,$_vatPercentage = NULL,$_vatAmount = NULL,$_transportationAmount = NULL,$_totalAmount = NULL,$_orderNumber = NULL,$_commercialName = NULL,$_returnTypeChoice = NULL)
    {
        parent::__construct(array('productCode'=>$_productCode,'depositDate'=>$_depositDate,'mailBoxPicking'=>$_mailBoxPicking,'mailBoxPickingDate'=>$_mailBoxPickingDate,'vatCode'=>$_vatCode,'vatPercentage'=>$_vatPercentage,'vatAmount'=>$_vatAmount,'transportationAmount'=>$_transportationAmount,'totalAmount'=>$_totalAmount,'orderNumber'=>$_orderNumber,'commercialName'=>$_commercialName,'returnTypeChoice'=>$_returnTypeChoice),false);
    }
    /**
     * Get productCode value
     * @return string|null
     */
    public function getProductCode()
    {
        return $this->productCode;
    }
    /**
     * Set productCode value
     * @param string $_productCode the productCode
     * @return string
     */
    public function setProductCode($_productCode)
    {
        return ($this->productCode = $_productCode);
    }
    /**
     * Get depositDate value
     * @return date|null
     */
    public function getDepositDate()
    {
        return $this->depositDate;
    }
    /**
     * Set depositDate value
     * @param date $_depositDate the depositDate
     * @return date
     */
    public function setDepositDate($_depositDate)
    {
        return ($this->depositDate = $_depositDate);
    }
    /**
     * Get mailBoxPicking value
     * @return boolean|null
     */
    public function getMailBoxPicking()
    {
        return $this->mailBoxPicking;
    }
    /**
     * Set mailBoxPicking value
     * @param boolean $_mailBoxPicking the mailBoxPicking
     * @return boolean
     */
    public function setMailBoxPicking($_mailBoxPicking)
    {
        return ($this->mailBoxPicking = $_mailBoxPicking);
    }
    /**
     * Get mailBoxPickingDate value
     * @return date|null
     */
    public function getMailBoxPickingDate()
    {
        return $this->mailBoxPickingDate;
    }
    /**
     * Set mailBoxPickingDate value
     * @param date $_mailBoxPickingDate the mailBoxPickingDate
     * @return date
     */
    public function setMailBoxPickingDate($_mailBoxPickingDate)
    {
        return ($this->mailBoxPickingDate = $_mailBoxPickingDate);
    }
    /**
     * Get vatCode value
     * @return int|null
     */
    public function getVatCode()
    {
        return $this->vatCode;
    }
    /**
     * Set vatCode value
     * @param int $_vatCode the vatCode
     * @return int
     */
    public function setVatCode($_vatCode)
    {
        return ($this->vatCode = $_vatCode);
    }
    /**
     * Get vatPercentage value
     * @return int|null
     */
    public function getVatPercentage()
    {
        return $this->vatPercentage;
    }
    /**
     * Set vatPercentage value
     * @param int $_vatPercentage the vatPercentage
     * @return int
     */
    public function setVatPercentage($_vatPercentage)
    {
        return ($this->vatPercentage = $_vatPercentage);
    }
    /**
     * Get vatAmount value
     * @return int|null
     */
    public function getVatAmount()
    {
        return $this->vatAmount;
    }
    /**
     * Set vatAmount value
     * @param int $_vatAmount the vatAmount
     * @return int
     */
    public function setVatAmount($_vatAmount)
    {
        return ($this->vatAmount = $_vatAmount);
    }
    /**
     * Get transportationAmount value
     * @return int|null
     */
    public function getTransportationAmount()
    {
        return $this->transportationAmount;
    }
    /**
     * Set transportationAmount value
     * @param int $_transportationAmount the transportationAmount
     * @return int
     */
    public function setTransportationAmount($_transportationAmount)
    {
        return ($this->transportationAmount = $_transportationAmount);
    }
    /**
     * Get totalAmount value
     * @return int|null
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
    /**
     * Set totalAmount value
     * @param int $_totalAmount the totalAmount
     * @return int
     */
    public function setTotalAmount($_totalAmount)
    {
        return ($this->totalAmount = $_totalAmount);
    }
    /**
     * Get orderNumber value
     * @return string|null
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }
    /**
     * Set orderNumber value
     * @param string $_orderNumber the orderNumber
     * @return string
     */
    public function setOrderNumber($_orderNumber)
    {
        return ($this->orderNumber = $_orderNumber);
    }
    /**
     * Get commercialName value
     * @return string|null
     */
    public function getCommercialName()
    {
        return $this->commercialName;
    }
    /**
     * Set commercialName value
     * @param string $_commercialName the commercialName
     * @return string
     */
    public function setCommercialName($_commercialName)
    {
        return ($this->commercialName = $_commercialName);
    }
    /**
     * Get returnTypeChoice value
     * @return int|null
     */
    public function getReturnTypeChoice()
    {
        return $this->returnTypeChoice;
    }
    /**
     * Set returnTypeChoice value
     * @param int $_returnTypeChoice the returnTypeChoice
     * @return int
     */
    public function setReturnTypeChoice($_returnTypeChoice)
    {
        return ($this->returnTypeChoice = $_returnTypeChoice);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructService
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
