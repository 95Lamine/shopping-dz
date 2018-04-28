<?php
/**
 * File for class ColissimoPRStructFindInternalPointRetraitAcheminementByID
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructFindInternalPointRetraitAcheminementByID originally named findInternalPointRetraitAcheminementByID
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructFindInternalPointRetraitAcheminementByID extends ColissimoPRWsdlClass
{
    /**
     * The id
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $id;
    /**
     * The reseau
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $reseau;
    /**
     * The langue
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $langue;
    /**
     * Constructor method for findInternalPointRetraitAcheminementByID
     * @see parent::__construct()
     * @param string $_id
     * @param string $_reseau
     * @param string $_langue
     * @return ColissimoPRStructFindInternalPointRetraitAcheminementByID
     */
    public function __construct($_id = NULL,$_reseau = NULL,$_langue = NULL)
    {
        parent::__construct(array('id'=>$_id,'reseau'=>$_reseau,'langue'=>$_langue),false);
    }
    /**
     * Get id value
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id value
     * @param string $_id the id
     * @return string
     */
    public function setId($_id)
    {
        return ($this->id = $_id);
    }
    /**
     * Get reseau value
     * @return string|null
     */
    public function getReseau()
    {
        return $this->reseau;
    }
    /**
     * Set reseau value
     * @param string $_reseau the reseau
     * @return string
     */
    public function setReseau($_reseau)
    {
        return ($this->reseau = $_reseau);
    }
    /**
     * Get langue value
     * @return string|null
     */
    public function getLangue()
    {
        return $this->langue;
    }
    /**
     * Set langue value
     * @param string $_langue the langue
     * @return string
     */
    public function setLangue($_langue)
    {
        return ($this->langue = $_langue);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructFindInternalPointRetraitAcheminementByID
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
