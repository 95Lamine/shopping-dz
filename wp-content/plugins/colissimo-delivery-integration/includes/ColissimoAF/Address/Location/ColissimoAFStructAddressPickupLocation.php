<?php
/**
 * File for class ColissimoAFStructAddressPickupLocation
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructAddressPickupLocation originally named addressPickupLocation
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructAddressPickupLocation extends ColissimoAFWsdlClass
{
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
     * The countryLabel
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $countryLabel;
    /**
     * The line1
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line1;
    /**
     * The line2
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line2;
    /**
     * The line3
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line3;
    /**
     * The line4
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line4;
    /**
     * The zipCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $zipCode;
    /**
     * Constructor method for addressPickupLocation
     * @see parent::__construct()
     * @param string $_city
     * @param string $_countryCode
     * @param string $_countryLabel
     * @param string $_line1
     * @param string $_line2
     * @param string $_line3
     * @param string $_line4
     * @param string $_zipCode
     * @return ColissimoAFStructAddressPickupLocation
     */
    public function __construct($_city = NULL,$_countryCode = NULL,$_countryLabel = NULL,$_line1 = NULL,$_line2 = NULL,$_line3 = NULL,$_line4 = NULL,$_zipCode = NULL)
    {
        parent::__construct(array('city'=>$_city,'countryCode'=>$_countryCode,'countryLabel'=>$_countryLabel,'line1'=>$_line1,'line2'=>$_line2,'line3'=>$_line3,'line4'=>$_line4,'zipCode'=>$_zipCode),false);
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
     * Get countryLabel value
     * @return string|null
     */
    public function getCountryLabel()
    {
        return $this->countryLabel;
    }
    /**
     * Set countryLabel value
     * @param string $_countryLabel the countryLabel
     * @return string
     */
    public function setCountryLabel($_countryLabel)
    {
        return ($this->countryLabel = $_countryLabel);
    }
    /**
     * Get line1 value
     * @return string|null
     */
    public function getLine1()
    {
        return $this->line1;
    }
    /**
     * Set line1 value
     * @param string $_line1 the line1
     * @return string
     */
    public function setLine1($_line1)
    {
        return ($this->line1 = $_line1);
    }
    /**
     * Get line2 value
     * @return string|null
     */
    public function getLine2()
    {
        return $this->line2;
    }
    /**
     * Set line2 value
     * @param string $_line2 the line2
     * @return string
     */
    public function setLine2($_line2)
    {
        return ($this->line2 = $_line2);
    }
    /**
     * Get line3 value
     * @return string|null
     */
    public function getLine3()
    {
        return $this->line3;
    }
    /**
     * Set line3 value
     * @param string $_line3 the line3
     * @return string
     */
    public function setLine3($_line3)
    {
        return ($this->line3 = $_line3);
    }
    /**
     * Get line4 value
     * @return string|null
     */
    public function getLine4()
    {
        return $this->line4;
    }
    /**
     * Set line4 value
     * @param string $_line4 the line4
     * @return string
     */
    public function setLine4($_line4)
    {
        return ($this->line4 = $_line4);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructAddressPickupLocation
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
