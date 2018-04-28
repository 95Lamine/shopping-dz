<?php
/**
 * File for class ColissimoAFStructZoneCABRoutage
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructZoneCABRoutage originally named zoneCABRoutage
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructZoneCABRoutage extends ColissimoAFWsdlClass
{
    /**
     * The barCodeRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $barCodeRouting;
    /**
     * The parcelNumberRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $parcelNumberRouting;
    /**
     * Constructor method for zoneCABRoutage
     * @see parent::__construct()
     * @param string $_barCodeRouting
     * @param string $_parcelNumberRouting
     * @return ColissimoAFStructZoneCABRoutage
     */
    public function __construct($_barCodeRouting = NULL,$_parcelNumberRouting = NULL)
    {
        parent::__construct(array('barCodeRouting'=>$_barCodeRouting,'parcelNumberRouting'=>$_parcelNumberRouting),false);
    }
    /**
     * Get barCodeRouting value
     * @return string|null
     */
    public function getBarCodeRouting()
    {
        return $this->barCodeRouting;
    }
    /**
     * Set barCodeRouting value
     * @param string $_barCodeRouting the barCodeRouting
     * @return string
     */
    public function setBarCodeRouting($_barCodeRouting)
    {
        return ($this->barCodeRouting = $_barCodeRouting);
    }
    /**
     * Get parcelNumberRouting value
     * @return string|null
     */
    public function getParcelNumberRouting()
    {
        return $this->parcelNumberRouting;
    }
    /**
     * Set parcelNumberRouting value
     * @param string $_parcelNumberRouting the parcelNumberRouting
     * @return string
     */
    public function setParcelNumberRouting($_parcelNumberRouting)
    {
        return ($this->parcelNumberRouting = $_parcelNumberRouting);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructZoneCABRoutage
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
