<?php
/**
 * File for class ColissimoAFStructGetProductInterResponseType
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetProductInterResponseType originally named GetProductInterResponseType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetProductInterResponseType extends ColissimoAFStructBaseResponse
{
    /**
     * The product
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $product;
    /**
     * The partnerType
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $partnerType;
    /**
     * The returnTypeChoice
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $returnTypeChoice;
    /**
     * Constructor method for GetProductInterResponseType
     * @see parent::__construct()
     * @param string $_product
     * @param string $_partnerType
     * @param string $_returnTypeChoice
     * @return ColissimoAFStructGetProductInterResponseType
     */
    public function __construct($_product = NULL,$_partnerType = NULL,$_returnTypeChoice = NULL)
    {
        ColissimoAFWsdlClass::__construct(array('product'=>$_product,'partnerType'=>$_partnerType,'returnTypeChoice'=>$_returnTypeChoice),false);
    }
    /**
     * Get product value
     * @return string|null
     */
    public function getProduct()
    {
        return $this->product;
    }
    /**
     * Set product value
     * @param string $_product the product
     * @return string
     */
    public function setProduct($_product)
    {
        return ($this->product = $_product);
    }
    /**
     * Get partnerType value
     * @return string|null
     */
    public function getPartnerType()
    {
        return $this->partnerType;
    }
    /**
     * Set partnerType value
     * @param string $_partnerType the partnerType
     * @return string
     */
    public function setPartnerType($_partnerType)
    {
        return ($this->partnerType = $_partnerType);
    }
    /**
     * Get returnTypeChoice value
     * @return string|null
     */
    public function getReturnTypeChoice()
    {
        return $this->returnTypeChoice;
    }
    /**
     * Set returnTypeChoice value
     * @param string $_returnTypeChoice the returnTypeChoice
     * @return string
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
     * @return ColissimoAFStructGetProductInterResponseType
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
