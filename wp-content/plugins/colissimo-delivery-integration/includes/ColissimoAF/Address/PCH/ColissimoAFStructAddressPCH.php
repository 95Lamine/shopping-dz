<?php
/**
 * File for class ColissimoAFStructAddressPCH
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructAddressPCH originally named addressPCH
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructAddressPCH extends ColissimoAFWsdlClass
{
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $city;
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
     * The zipCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $zipCode;
    /**
     * Constructor method for addressPCH
     * @see parent::__construct()
     * @param string $_city
     * @param string $_line0
     * @param string $_line1
     * @param string $_line2
     * @param string $_zipCode
     * @return ColissimoAFStructAddressPCH
     */
    public function __construct($_city = NULL,$_line0 = NULL,$_line1 = NULL,$_line2 = NULL,$_zipCode = NULL)
    {
        parent::__construct(array('city'=>$_city,'line0'=>$_line0,'line1'=>$_line1,'line2'=>$_line2,'zipCode'=>$_zipCode),false);
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
     * @return ColissimoAFStructAddressPCH
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
