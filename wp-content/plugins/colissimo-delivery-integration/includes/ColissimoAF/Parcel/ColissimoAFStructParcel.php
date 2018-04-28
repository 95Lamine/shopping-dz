<?php
/**
 * File for class ColissimoAFStructParcel
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructParcel originally named parcel
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructParcel extends ColissimoAFWsdlClass
{
    /**
     * The parcelNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $parcelNumber;
    /**
     * The insuranceAmount
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $insuranceAmount;
    /**
     * The insuranceValue
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $insuranceValue;
    /**
     * The recommendationLevel
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $recommendationLevel;
    /**
     * The weight
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var float
     */
    public $weight;
    /**
     * The nonMachinable
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $nonMachinable;
    /**
     * The COD
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $COD;
    /**
     * The CODAmount
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $CODAmount;
    /**
     * The returnReceipt
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $returnReceipt;
    /**
     * The instructions
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $instructions;
    /**
     * The pickupLocationId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $pickupLocationId;
    /**
     * The ftd
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $ftd;
    /**
     * Constructor method for parcel
     * @see parent::__construct()
     * @param string $_parcelNumber
     * @param int $_insuranceAmount
     * @param int $_insuranceValue
     * @param string $_recommendationLevel
     * @param float $_weight
     * @param boolean $_nonMachinable
     * @param boolean $_cOD
     * @param int $_cODAmount
     * @param boolean $_returnReceipt
     * @param string $_instructions
     * @param string $_pickupLocationId
     * @param boolean $_ftd
     * @return ColissimoAFStructParcel
     */
    public function __construct($_parcelNumber = NULL,$_insuranceAmount = NULL,$_insuranceValue = NULL,$_recommendationLevel = NULL,$_weight = NULL,$_nonMachinable = NULL,$_cOD = NULL,$_cODAmount = NULL,$_returnReceipt = NULL,$_instructions = NULL,$_pickupLocationId = NULL,$_ftd = NULL)
    {
        parent::__construct(array('parcelNumber'=>$_parcelNumber,'insuranceAmount'=>$_insuranceAmount,'insuranceValue'=>$_insuranceValue,'recommendationLevel'=>$_recommendationLevel,'weight'=>$_weight,'nonMachinable'=>$_nonMachinable,'COD'=>$_cOD,'CODAmount'=>$_cODAmount,'returnReceipt'=>$_returnReceipt,'instructions'=>$_instructions,'pickupLocationId'=>$_pickupLocationId,'ftd'=>$_ftd),false);
    }
    /**
     * Get parcelNumber value
     * @return string|null
     */
    public function getParcelNumber()
    {
        return $this->parcelNumber;
    }
    /**
     * Set parcelNumber value
     * @param string $_parcelNumber the parcelNumber
     * @return string
     */
    public function setParcelNumber($_parcelNumber)
    {
        return ($this->parcelNumber = $_parcelNumber);
    }
    /**
     * Get insuranceAmount value
     * @return int|null
     */
    public function getInsuranceAmount()
    {
        return $this->insuranceAmount;
    }
    /**
     * Set insuranceAmount value
     * @param int $_insuranceAmount the insuranceAmount
     * @return int
     */
    public function setInsuranceAmount($_insuranceAmount)
    {
        return ($this->insuranceAmount = $_insuranceAmount);
    }
    /**
     * Get insuranceValue value
     * @return int|null
     */
    public function getInsuranceValue()
    {
        return $this->insuranceValue;
    }
    /**
     * Set insuranceValue value
     * @param int $_insuranceValue the insuranceValue
     * @return int
     */
    public function setInsuranceValue($_insuranceValue)
    {
        return ($this->insuranceValue = $_insuranceValue);
    }
    /**
     * Get recommendationLevel value
     * @return string|null
     */
    public function getRecommendationLevel()
    {
        return $this->recommendationLevel;
    }
    /**
     * Set recommendationLevel value
     * @param string $_recommendationLevel the recommendationLevel
     * @return string
     */
    public function setRecommendationLevel($_recommendationLevel)
    {
        return ($this->recommendationLevel = $_recommendationLevel);
    }
    /**
     * Get weight value
     * @return float|null
     */
    public function getWeight()
    {
        return $this->weight;
    }
    /**
     * Set weight value
     * @param float $_weight the weight
     * @return float
     */
    public function setWeight($_weight)
    {
        return ($this->weight = $_weight);
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
     * Get COD value
     * @return boolean|null
     */
    public function getCOD()
    {
        return $this->COD;
    }
    /**
     * Set COD value
     * @param boolean $_cOD the COD
     * @return boolean
     */
    public function setCOD($_cOD)
    {
        return ($this->COD = $_cOD);
    }
    /**
     * Get CODAmount value
     * @return int|null
     */
    public function getCODAmount()
    {
        return $this->CODAmount;
    }
    /**
     * Set CODAmount value
     * @param int $_cODAmount the CODAmount
     * @return int
     */
    public function setCODAmount($_cODAmount)
    {
        return ($this->CODAmount = $_cODAmount);
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
     * Get instructions value
     * @return string|null
     */
    public function getInstructions()
    {
        return $this->instructions;
    }
    /**
     * Set instructions value
     * @param string $_instructions the instructions
     * @return string
     */
    public function setInstructions($_instructions)
    {
        return ($this->instructions = $_instructions);
    }
    /**
     * Get pickupLocationId value
     * @return string|null
     */
    public function getPickupLocationId()
    {
        return $this->pickupLocationId;
    }
    /**
     * Set pickupLocationId value
     * @param string $_pickupLocationId the pickupLocationId
     * @return string
     */
    public function setPickupLocationId($_pickupLocationId)
    {
        return ($this->pickupLocationId = $_pickupLocationId);
    }
    /**
     * Get ftd value
     * @return boolean|null
     */
    public function getFtd()
    {
        return $this->ftd;
    }
    /**
     * Set ftd value
     * @param boolean $_ftd the ftd
     * @return boolean
     */
    public function setFtd($_ftd)
    {
        return ($this->ftd = $_ftd);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructParcel
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
