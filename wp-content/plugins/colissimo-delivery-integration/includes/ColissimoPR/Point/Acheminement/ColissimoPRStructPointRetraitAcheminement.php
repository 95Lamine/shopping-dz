<?php
/**
 * File for class ColissimoPRStructPointRetraitAcheminement
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructPointRetraitAcheminement originally named pointRetraitAcheminement
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructPointRetraitAcheminement extends ColissimoPRStructPointRetrait
{
    /**
     * The distributionSort
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $distributionSort;
    /**
     * The lotAcheminement
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $lotAcheminement;
    /**
     * The versionPlanTri
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $versionPlanTri;
    /**
     * Constructor method for pointRetraitAcheminement
     * @see parent::__construct()
     * @param string $_distributionSort
     * @param string $_lotAcheminement
     * @param string $_versionPlanTri
     * @return ColissimoPRStructPointRetraitAcheminement
     */
    public function __construct($_distributionSort = NULL,$_lotAcheminement = NULL,$_versionPlanTri = NULL)
    {
        ColissimoPRWsdlClass::__construct(array('distributionSort'=>$_distributionSort,'lotAcheminement'=>$_lotAcheminement,'versionPlanTri'=>$_versionPlanTri),false);
    }
    /**
     * Get distributionSort value
     * @return string|null
     */
    public function getDistributionSort()
    {
        return $this->distributionSort;
    }
    /**
     * Set distributionSort value
     * @param string $_distributionSort the distributionSort
     * @return string
     */
    public function setDistributionSort($_distributionSort)
    {
        return ($this->distributionSort = $_distributionSort);
    }
    /**
     * Get lotAcheminement value
     * @return string|null
     */
    public function getLotAcheminement()
    {
        return $this->lotAcheminement;
    }
    /**
     * Set lotAcheminement value
     * @param string $_lotAcheminement the lotAcheminement
     * @return string
     */
    public function setLotAcheminement($_lotAcheminement)
    {
        return ($this->lotAcheminement = $_lotAcheminement);
    }
    /**
     * Get versionPlanTri value
     * @return string|null
     */
    public function getVersionPlanTri()
    {
        return $this->versionPlanTri;
    }
    /**
     * Set versionPlanTri value
     * @param string $_versionPlanTri the versionPlanTri
     * @return string
     */
    public function setVersionPlanTri($_versionPlanTri)
    {
        return ($this->versionPlanTri = $_versionPlanTri);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructPointRetraitAcheminement
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
