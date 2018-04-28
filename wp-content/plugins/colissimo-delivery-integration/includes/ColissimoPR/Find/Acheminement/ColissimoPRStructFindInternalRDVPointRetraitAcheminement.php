<?php
/**
 * File for class ColissimoPRStructFindInternalRDVPointRetraitAcheminement
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructFindInternalRDVPointRetraitAcheminement originally named findInternalRDVPointRetraitAcheminement
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructFindInternalRDVPointRetraitAcheminement extends ColissimoPRWsdlClass
{
    /**
     * The accountNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $accountNumber;
    /**
     * The password
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $password;
    /**
     * The address
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $address;
    /**
     * The zipCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $zipCode;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $city;
    /**
     * The countryCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $countryCode;
    /**
     * The weight
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $weight;
    /**
     * The shippingDate
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $shippingDate;
    /**
     * The filterRelay
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $filterRelay;
    /**
     * The requestId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $requestId;
    /**
     * The lang
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $lang;
    /**
     * The optionInter
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $optionInter;
    /**
     * Constructor method for findInternalRDVPointRetraitAcheminement
     * @see parent::__construct()
     * @param string $_accountNumber
     * @param string $_password
     * @param string $_address
     * @param string $_zipCode
     * @param string $_city
     * @param string $_countryCode
     * @param string $_weight
     * @param string $_shippingDate
     * @param string $_filterRelay
     * @param string $_requestId
     * @param string $_lang
     * @param string $_optionInter
     * @return ColissimoPRStructFindInternalRDVPointRetraitAcheminement
     */
    public function __construct($_accountNumber = NULL,$_password = NULL,$_address = NULL,$_zipCode = NULL,$_city = NULL,$_countryCode = NULL,$_weight = NULL,$_shippingDate = NULL,$_filterRelay = NULL,$_requestId = NULL,$_lang = NULL,$_optionInter = NULL)
    {
        parent::__construct(array('accountNumber'=>$_accountNumber,'password'=>$_password,'address'=>$_address,'zipCode'=>$_zipCode,'city'=>$_city,'countryCode'=>$_countryCode,'weight'=>$_weight,'shippingDate'=>$_shippingDate,'filterRelay'=>$_filterRelay,'requestId'=>$_requestId,'lang'=>$_lang,'optionInter'=>$_optionInter),false);
    }
    /**
     * Get accountNumber value
     * @return string|null
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    /**
     * Set accountNumber value
     * @param string $_accountNumber the accountNumber
     * @return string
     */
    public function setAccountNumber($_accountNumber)
    {
        return ($this->accountNumber = $_accountNumber);
    }
    /**
     * Get password value
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password value
     * @param string $_password the password
     * @return string
     */
    public function setPassword($_password)
    {
        return ($this->password = $_password);
    }
    /**
     * Get address value
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param string $_address the address
     * @return string
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Get zipCode value
     * @return string|null
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    /**
     * Set zipCode value
     * @param string $_zipCode the zipCode
     * @return string
     */
    public function setZipCode($_zipCode)
    {
        return ($this->zipCode = $_zipCode);
    }
    /**
     * Get city value
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set city value
     * @param string $_city the city
     * @return string
     */
    public function setCity($_city)
    {
        return ($this->city = $_city);
    }
    /**
     * Get countryCode value
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }
    /**
     * Set countryCode value
     * @param string $_countryCode the countryCode
     * @return string
     */
    public function setCountryCode($_countryCode)
    {
        return ($this->countryCode = $_countryCode);
    }
    /**
     * Get weight value
     * @return string|null
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * Set weight value
     * @param string $_weight the weight
     * @return string
     */
    public function setWeight($_weight)
    {
        return ($this->weight = $_weight);
    }
    /**
     * Get shippingDate value
     * @return string|null
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }
    /**
     * Set shippingDate value
     * @param string $_shippingDate the shippingDate
     * @return string
     */
    public function setShippingDate($_shippingDate)
    {
        return ($this->shippingDate = $_shippingDate);
    }
    /**
     * Get filterRelay value
     * @return string|null
     */
    public function getFilterRelay()
    {
        return $this->filterRelay;
    }
    /**
     * Set filterRelay value
     * @param string $_filterRelay the filterRelay
     * @return string
     */
    public function setFilterRelay($_filterRelay)
    {
        return ($this->filterRelay = $_filterRelay);
    }
    /**
     * Get requestId value
     * @return string|null
     */
    public function getRequestId()
    {
        return $this->requestId;
    }
    /**
     * Set requestId value
     * @param string $_requestId the requestId
     * @return string
     */
    public function setRequestId($_requestId)
    {
        return ($this->requestId = $_requestId);
    }
    /**
     * Get lang value
     * @return string|null
     */
    public function getLang()
    {
        return $this->lang;
    }
    /**
     * Set lang value
     * @param string $_lang the lang
     * @return string
     */
    public function setLang($_lang)
    {
        return ($this->lang = $_lang);
    }
    /**
     * Get optionInter value
     * @return string|null
     */
    public function getOptionInter()
    {
        return $this->optionInter;
    }
    /**
     * Set optionInter value
     * @param string $_optionInter the optionInter
     * @return string
     */
    public function setOptionInter($_optionInter)
    {
        return ($this->optionInter = $_optionInter);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructFindInternalRDVPointRetraitAcheminement
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
