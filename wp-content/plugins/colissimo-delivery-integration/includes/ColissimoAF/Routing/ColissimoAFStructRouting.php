<?php
/**
 * File for class ColissimoAFStructRouting
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructRouting originally named routing
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructRouting extends ColissimoAFWsdlClass
{
    /**
     * The barcodeId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $barcodeId;
    /**
     * The depotDest
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $depotDest;
    /**
     * The destinationCountry
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $destinationCountry;
    /**
     * The destinationCountryText
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $destinationCountryText;
    /**
     * The groupingPriorityLabel
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $groupingPriorityLabel;
    /**
     * The partnerType
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $partnerType;
    /**
     * The routingVersion
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $routingVersion;
    /**
     * The serviceMark
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $serviceMark;
    /**
     * The serviceText
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $serviceText;
    /**
     * The sortDest
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $sortDest;
    /**
     * The sortOrigin
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $sortOrigin;
    /**
     * Constructor method for routing
     * @see parent::__construct()
     * @param string $_barcodeId
     * @param string $_depotDest
     * @param string $_destinationCountry
     * @param string $_destinationCountryText
     * @param string $_groupingPriorityLabel
     * @param string $_partnerType
     * @param string $_routingVersion
     * @param string $_serviceMark
     * @param string $_serviceText
     * @param string $_sortDest
     * @param string $_sortOrigin
     * @return ColissimoAFStructRouting
     */
    public function __construct($_barcodeId = NULL,$_depotDest = NULL,$_destinationCountry = NULL,$_destinationCountryText = NULL,$_groupingPriorityLabel = NULL,$_partnerType = NULL,$_routingVersion = NULL,$_serviceMark = NULL,$_serviceText = NULL,$_sortDest = NULL,$_sortOrigin = NULL)
    {
        parent::__construct(array('barcodeId'=>$_barcodeId,'depotDest'=>$_depotDest,'destinationCountry'=>$_destinationCountry,'destinationCountryText'=>$_destinationCountryText,'groupingPriorityLabel'=>$_groupingPriorityLabel,'partnerType'=>$_partnerType,'routingVersion'=>$_routingVersion,'serviceMark'=>$_serviceMark,'serviceText'=>$_serviceText,'sortDest'=>$_sortDest,'sortOrigin'=>$_sortOrigin),false);
    }
    /**
     * Get barcodeId value
     * @return string|null
     */
    public function getBarcodeId()
    {
        return $this->barcodeId;
    }
    /**
     * Set barcodeId value
     * @param string $_barcodeId the barcodeId
     * @return string
     */
    public function setBarcodeId($_barcodeId)
    {
        return ($this->barcodeId = $_barcodeId);
    }
    /**
     * Get depotDest value
     * @return string|null
     */
    public function getDepotDest()
    {
        return $this->depotDest;
    }
    /**
     * Set depotDest value
     * @param string $_depotDest the depotDest
     * @return string
     */
    public function setDepotDest($_depotDest)
    {
        return ($this->depotDest = $_depotDest);
    }
    /**
     * Get destinationCountry value
     * @return string|null
     */
    public function getDestinationCountry()
    {
        return $this->destinationCountry;
    }
    /**
     * Set destinationCountry value
     * @param string $_destinationCountry the destinationCountry
     * @return string
     */
    public function setDestinationCountry($_destinationCountry)
    {
        return ($this->destinationCountry = $_destinationCountry);
    }
    /**
     * Get destinationCountryText value
     * @return string|null
     */
    public function getDestinationCountryText()
    {
        return $this->destinationCountryText;
    }
    /**
     * Set destinationCountryText value
     * @param string $_destinationCountryText the destinationCountryText
     * @return string
     */
    public function setDestinationCountryText($_destinationCountryText)
    {
        return ($this->destinationCountryText = $_destinationCountryText);
    }
    /**
     * Get groupingPriorityLabel value
     * @return string|null
     */
    public function getGroupingPriorityLabel()
    {
        return $this->groupingPriorityLabel;
    }
    /**
     * Set groupingPriorityLabel value
     * @param string $_groupingPriorityLabel the groupingPriorityLabel
     * @return string
     */
    public function setGroupingPriorityLabel($_groupingPriorityLabel)
    {
        return ($this->groupingPriorityLabel = $_groupingPriorityLabel);
    }
    /**
     * Get partnerType value
     * @return string|null
     */
    public function getPartnerType()
    {
        return $this->partnerType;
    }
    /**
     * Set partnerType value
     * @param string $_partnerType the partnerType
     * @return string
     */
    public function setPartnerType($_partnerType)
    {
        return ($this->partnerType = $_partnerType);
    }
    /**
     * Get routingVersion value
     * @return string|null
     */
    public function getRoutingVersion()
    {
        return $this->routingVersion;
    }
    /**
     * Set routingVersion value
     * @param string $_routingVersion the routingVersion
     * @return string
     */
    public function setRoutingVersion($_routingVersion)
    {
        return ($this->routingVersion = $_routingVersion);
    }
    /**
     * Get serviceMark value
     * @return string|null
     */
    public function getServiceMark()
    {
        return $this->serviceMark;
    }
    /**
     * Set serviceMark value
     * @param string $_serviceMark the serviceMark
     * @return string
     */
    public function setServiceMark($_serviceMark)
    {
        return ($this->serviceMark = $_serviceMark);
    }
    /**
     * Get serviceText value
     * @return string|null
     */
    public function getServiceText()
    {
        return $this->serviceText;
    }
    /**
     * Set serviceText value
     * @param string $_serviceText the serviceText
     * @return string
     */
    public function setServiceText($_serviceText)
    {
        return ($this->serviceText = $_serviceText);
    }
    /**
     * Get sortDest value
     * @return string|null
     */
    public function getSortDest()
    {
        return $this->sortDest;
    }
    /**
     * Set sortDest value
     * @param string $_sortDest the sortDest
     * @return string
     */
    public function setSortDest($_sortDest)
    {
        return ($this->sortDest = $_sortDest);
    }
    /**
     * Get sortOrigin value
     * @return string|null
     */
    public function getSortOrigin()
    {
        return $this->sortOrigin;
    }
    /**
     * Set sortOrigin value
     * @param string $_sortOrigin the sortOrigin
     * @return string
     */
    public function setSortOrigin($_sortOrigin)
    {
        return ($this->sortOrigin = $_sortOrigin);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructRouting
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
