<?php
/**
 * File for class ColissimoAFStructSite
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructSite originally named site
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructSite extends ColissimoAFWsdlClass
{
    /**
     * The address
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructAddressPCH
     */
    public $address;
    /**
     * The code
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $code;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $name;
    /**
     * Constructor method for site
     * @see parent::__construct()
     * @param ColissimoAFStructAddressPCH $_address
     * @param string $_code
     * @param string $_name
     * @return ColissimoAFStructSite
     */
    public function __construct($_address = NULL,$_code = NULL,$_name = NULL)
    {
        parent::__construct(array('address'=>$_address,'code'=>$_code,'name'=>$_name),false);
    }
    /**
     * Get address value
     * @return ColissimoAFStructAddressPCH|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param ColissimoAFStructAddressPCH $_address the address
     * @return ColissimoAFStructAddressPCH
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Get code value
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Set code value
     * @param string $_code the code
     * @return string
     */
    public function setCode($_code)
    {
        return ($this->code = $_code);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructSite
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
