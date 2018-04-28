<?php
/**
 * File for class ColissimoAFStructAddress
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructAddress originally named address
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructAddress extends ColissimoAFWsdlClass
{
    /**
     * The companyName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $companyName;
    /**
     * The lastName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $lastName;
    /**
     * The firstName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $firstName;
    /**
     * The line0
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line0;
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
     * The countryCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $countryCode;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $city;
    /**
     * The zipCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $zipCode;
    /**
     * The phoneNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $phoneNumber;
    /**
     * The mobileNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $mobileNumber;
    /**
     * The doorCode1
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $doorCode1;
    /**
     * The doorCode2
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $doorCode2;
    /**
     * The email
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $email;
    /**
     * The intercom
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $intercom;
    /**
     * The language
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $language;
    /**
     * Constructor method for address
     * @see parent::__construct()
     * @param string $_companyName
     * @param string $_lastName
     * @param string $_firstName
     * @param string $_line0
     * @param string $_line1
     * @param string $_line2
     * @param string $_line3
     * @param string $_countryCode
     * @param string $_city
     * @param string $_zipCode
     * @param string $_phoneNumber
     * @param string $_mobileNumber
     * @param string $_doorCode1
     * @param string $_doorCode2
     * @param string $_email
     * @param string $_intercom
     * @param string $_language
     * @return ColissimoAFStructAddress
     */
    public function __construct($_companyName = NULL,$_lastName = NULL,$_firstName = NULL,$_line0 = NULL,$_line1 = NULL,$_line2 = NULL,$_line3 = NULL,$_countryCode = NULL,$_city = NULL,$_zipCode = NULL,$_phoneNumber = NULL,$_mobileNumber = NULL,$_doorCode1 = NULL,$_doorCode2 = NULL,$_email = NULL,$_intercom = NULL,$_language = NULL)
    {
        parent::__construct(array('companyName'=>$_companyName,'lastName'=>$_lastName,'firstName'=>$_firstName,'line0'=>$_line0,'line1'=>$_line1,'line2'=>$_line2,'line3'=>$_line3,'countryCode'=>$_countryCode,'city'=>$_city,'zipCode'=>$_zipCode,'phoneNumber'=>$_phoneNumber,'mobileNumber'=>$_mobileNumber,'doorCode1'=>$_doorCode1,'doorCode2'=>$_doorCode2,'email'=>$_email,'intercom'=>$_intercom,'language'=>$_language),false);
    }
    /**
     * Get companyName value
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    /**
     * Set companyName value
     * @param string $_companyName the companyName
     * @return string
     */
    public function setCompanyName($_companyName)
    {
        return ($this->companyName = $_companyName);
    }
    /**
     * Get lastName value
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * Set lastName value
     * @param string $_lastName the lastName
     * @return string
     */
    public function setLastName($_lastName)
    {
        return ($this->lastName = $_lastName);
    }
    /**
     * Get firstName value
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * Set firstName value
     * @param string $_firstName the firstName
     * @return string
     */
    public function setFirstName($_firstName)
    {
        return ($this->firstName = $_firstName);
    }
    /**
     * Get line0 value
     * @return string|null
     */
    public function getLine0()
    {
        return $this->line0;
    }
    /**
     * Set line0 value
     * @param string $_line0 the line0
     * @return string
     */
    public function setLine0($_line0)
    {
        return ($this->line0 = $_line0);
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
     * Get phoneNumber value
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    /**
     * Set phoneNumber value
     * @param string $_phoneNumber the phoneNumber
     * @return string
     */
    public function setPhoneNumber($_phoneNumber)
    {
        return ($this->phoneNumber = $_phoneNumber);
    }
    /**
     * Get mobileNumber value
     * @return string|null
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }
    /**
     * Set mobileNumber value
     * @param string $_mobileNumber the mobileNumber
     * @return string
     */
    public function setMobileNumber($_mobileNumber)
    {
        return ($this->mobileNumber = $_mobileNumber);
    }
    /**
     * Get doorCode1 value
     * @return string|null
     */
    public function getDoorCode1()
    {
        return $this->doorCode1;
    }
    /**
     * Set doorCode1 value
     * @param string $_doorCode1 the doorCode1
     * @return string
     */
    public function setDoorCode1($_doorCode1)
    {
        return ($this->doorCode1 = $_doorCode1);
    }
    /**
     * Get doorCode2 value
     * @return string|null
     */
    public function getDoorCode2()
    {
        return $this->doorCode2;
    }
    /**
     * Set doorCode2 value
     * @param string $_doorCode2 the doorCode2
     * @return string
     */
    public function setDoorCode2($_doorCode2)
    {
        return ($this->doorCode2 = $_doorCode2);
    }
    /**
     * Get email value
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set email value
     * @param string $_email the email
     * @return string
     */
    public function setEmail($_email)
    {
        return ($this->email = $_email);
    }
    /**
     * Get intercom value
     * @return string|null
     */
    public function getIntercom()
    {
        return $this->intercom;
    }
    /**
     * Set intercom value
     * @param string $_intercom the intercom
     * @return string
     */
    public function setIntercom($_intercom)
    {
        return ($this->intercom = $_intercom);
    }
    /**
     * Get language value
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }
    /**
     * Set language value
     * @param string $_language the language
     * @return string
     */
    public function setLanguage($_language)
    {
        return ($this->language = $_language);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructAddress
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
