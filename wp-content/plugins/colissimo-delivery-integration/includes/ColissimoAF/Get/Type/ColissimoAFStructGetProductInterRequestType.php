<?php
/**
 * File for class ColissimoAFStructGetProductInterRequestType
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGetProductInterRequestType originally named GetProductInterRequestType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGetProductInterRequestType extends ColissimoAFWsdlClass
{
    /**
     * The contractNumber
     * @var string
     */
    public $contractNumber;
    /**
     * The password
     * @var string
     */
    public $password;
    /**
     * The productCode
     * @var string
     */
    public $productCode;
    /**
     * The insurance
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $insurance;
    /**
     * The nonMachinable
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $nonMachinable;
    /**
     * The returnReceipt
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $returnReceipt;
    /**
     * The countryCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $countryCode;
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
     * Constructor method for GetProductInterRequestType
     * @see parent::__construct()
     * @param string $_contractNumber
     * @param string $_password
     * @param string $_productCode
     * @param boolean $_insurance
     * @param boolean $_nonMachinable
     * @param boolean $_returnReceipt
     * @param string $_countryCode
     * @param string $_zipCode
     * @param string $_city
     * @return ColissimoAFStructGetProductInterRequestType
     */
    public function __construct($_contractNumber = NULL,$_password = NULL,$_productCode = NULL,$_insurance = NULL,$_nonMachinable = NULL,$_returnReceipt = NULL,$_countryCode = NULL,$_zipCode = NULL,$_city = NULL)
    {
        parent::__construct(array('contractNumber'=>$_contractNumber,'password'=>$_password,'productCode'=>$_productCode,'insurance'=>$_insurance,'nonMachinable'=>$_nonMachinable,'returnReceipt'=>$_returnReceipt,'countryCode'=>$_countryCode,'zipCode'=>$_zipCode,'city'=>$_city),false);
    }
    /**
     * Get contractNumber value
     * @return string|null
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }
    /**
     * Set contractNumber value
     * @param string $_contractNumber the contractNumber
     * @return string
     */
    public function setContractNumber($_contractNumber)
    {
        return ($this->contractNumber = $_contractNumber);
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
     * Get insurance value
     * @return boolean|null
     */
    public function getInsurance()
    {
        return $this->insurance;
    }
    /**
     * Set insurance value
     * @param boolean $_insurance the insurance
     * @return boolean
     */
    public function setInsurance($_insurance)
    {
        return ($this->insurance = $_insurance);
    }
    /**
     * Get nonMachinable value
     * @return boolean|null
     */
    public function getNonMachinable()
    {
        return $this->nonMachinable;
    }
    /**
     * Set nonMachinable value
     * @param boolean $_nonMachinable the nonMachinable
     * @return boolean
     */
    public function setNonMachinable($_nonMachinable)
    {
        return ($this->nonMachinable = $_nonMachinable);
    }
    /**
     * Get returnReceipt value
     * @return boolean|null
     */
    public function getReturnReceipt()
    {
        return $this->returnReceipt;
    }
    /**
     * Set returnReceipt value
     * @param boolean $_returnReceipt the returnReceipt
     * @return boolean
     */
    public function setReturnReceipt($_returnReceipt)
    {
        return ($this->returnReceipt = $_returnReceipt);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGetProductInterRequestType
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
