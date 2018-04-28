<?php
/**
 * File for class ColissimoAFStructZoneRouting
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructZoneRouting originally named zoneRouting
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructZoneRouting extends ColissimoAFWsdlClass
{
    /**
     * The zoneCABRoutage
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructZoneCABRoutage
     */
    public $zoneCABRoutage;
    /**
     * The zoneInfosRoutage
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructZoneInfosRoutage
     */
    public $zoneInfosRoutage;
    /**
     * Constructor method for zoneRouting
     * @see parent::__construct()
     * @param ColissimoAFStructZoneCABRoutage $_zoneCABRoutage
     * @param ColissimoAFStructZoneInfosRoutage $_zoneInfosRoutage
     * @return ColissimoAFStructZoneRouting
     */
    public function __construct($_zoneCABRoutage = NULL,$_zoneInfosRoutage = NULL)
    {
        parent::__construct(array('zoneCABRoutage'=>$_zoneCABRoutage,'zoneInfosRoutage'=>$_zoneInfosRoutage),false);
    }
    /**
     * Get zoneCABRoutage value
     * @return ColissimoAFStructZoneCABRoutage|null
     */
    public function getZoneCABRoutage()
    {
        return $this->zoneCABRoutage;
    }
    /**
     * Set zoneCABRoutage value
     * @param ColissimoAFStructZoneCABRoutage $_zoneCABRoutage the zoneCABRoutage
     * @return ColissimoAFStructZoneCABRoutage
     */
    public function setZoneCABRoutage($_zoneCABRoutage)
    {
        return ($this->zoneCABRoutage = $_zoneCABRoutage);
    }
    /**
     * Get zoneInfosRoutage value
     * @return ColissimoAFStructZoneInfosRoutage|null
     */
    public function getZoneInfosRoutage()
    {
        return $this->zoneInfosRoutage;
    }
    /**
     * Set zoneInfosRoutage value
     * @param ColissimoAFStructZoneInfosRoutage $_zoneInfosRoutage the zoneInfosRoutage
     * @return ColissimoAFStructZoneInfosRoutage
     */
    public function setZoneInfosRoutage($_zoneInfosRoutage)
    {
        return ($this->zoneInfosRoutage = $_zoneInfosRoutage);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructZoneRouting
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
