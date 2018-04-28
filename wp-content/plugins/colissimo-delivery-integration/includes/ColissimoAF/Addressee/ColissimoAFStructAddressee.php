<?php
/**
 * File for class ColissimoAFStructAddressee
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructAddressee originally named addressee
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructAddressee extends ColissimoAFWsdlClass
{
    /**
     * The addresseeParcelRef
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $addresseeParcelRef;
    /**
     * The codeBarForReference
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $codeBarForReference;
    /**
     * The serviceInfo
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $serviceInfo;
    /**
     * The promotionCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $promotionCode;
    /**
     * The address
     * @var ColissimoAFStructAddress
     */
    public $address;
    /**
     * Constructor method for addressee
     * @see parent::__construct()
     * @param string $_addresseeParcelRef
     * @param boolean $_codeBarForReference
     * @param string $_serviceInfo
     * @param string $_promotionCode
     * @param ColissimoAFStructAddress $_address
     * @return ColissimoAFStructAddressee
     */
    public function __construct($_addresseeParcelRef = NULL,$_codeBarForReference = NULL,$_serviceInfo = NULL,$_promotionCode = NULL,$_address = NULL)
    {
        parent::__construct(array('addresseeParcelRef'=>$_addresseeParcelRef,'codeBarForReference'=>$_codeBarForReference,'serviceInfo'=>$_serviceInfo,'promotionCode'=>$_promotionCode,'address'=>$_address),false);
    }
    /**
     * Get addresseeParcelRef value
     * @return string|null
     */
    public function getAddresseeParcelRef()
    {
        return $this->addresseeParcelRef;
    }
    /**
     * Set addresseeParcelRef value
     * @param string $_addresseeParcelRef the addresseeParcelRef
     * @return string
     */
    public function setAddresseeParcelRef($_addresseeParcelRef)
    {
        return ($this->addresseeParcelRef = $_addresseeParcelRef);
    }
    /**
     * Get codeBarForReference value
     * @return boolean|null
     */
    public function getCodeBarForReference()
    {
        return $this->codeBarForReference;
    }
    /**
     * Set codeBarForReference value
     * @param boolean $_codeBarForReference the codeBarForReference
     * @return boolean
     */
    public function setCodeBarForReference($_codeBarForReference)
    {
        return ($this->codeBarForReference = $_codeBarForReference);
    }
    /**
     * Get serviceInfo value
     * @return string|null
     */
    public function getServiceInfo()
    {
        return $this->serviceInfo;
    }
    /**
     * Set serviceInfo value
     * @param string $_serviceInfo the serviceInfo
     * @return string
     */
    public function setServiceInfo($_serviceInfo)
    {
        return ($this->serviceInfo = $_serviceInfo);
    }
    /**
     * Get promotionCode value
     * @return string|null
     */
    public function getPromotionCode()
    {
        return $this->promotionCode;
    }
    /**
     * Set promotionCode value
     * @param string $_promotionCode the promotionCode
     * @return string
     */
    public function setPromotionCode($_promotionCode)
    {
        return ($this->promotionCode = $_promotionCode);
    }
    /**
     * Get address value
     * @return ColissimoAFStructAddress|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param ColissimoAFStructAddress $_address the address
     * @return ColissimoAFStructAddress
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructAddressee
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
