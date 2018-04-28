<?php
/**
 * File for class ColissimoAFStructZoneInfosRoutage
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructZoneInfosRoutage originally named zoneInfosRoutage
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructZoneInfosRoutage extends ColissimoAFWsdlClass
{
    /**
     * The controlKeyTrackingNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $controlKeyTrackingNumber;
    /**
     * The datePrinting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $datePrinting;
    /**
     * The hourPrinting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $hourPrinting;
    /**
     * The identificationDestination1
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $identificationDestination1;
    /**
     * The identificationDestination2
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $identificationDestination2;
    /**
     * The numberVersionWS
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $numberVersionWS;
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
     * The trackingNumberRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $trackingNumberRouting;
    /**
     * The typeServiceLivraison
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $typeServiceLivraison;
    /**
     * The rDepot
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $rDepot;
    /**
     * Constructor method for zoneInfosRoutage
     * @see parent::__construct()
     * @param string $_controlKeyTrackingNumber
     * @param string $_datePrinting
     * @param string $_hourPrinting
     * @param string $_identificationDestination1
     * @param string $_identificationDestination2
     * @param string $_numberVersionWS
     * @param string $_routingVersion
     * @param string $_serviceMark
     * @param string $_sortDest
     * @param string $_sortOrigin
     * @param string $_trackingNumberRouting
     * @param string $_typeServiceLivraison
     * @param string $_rDepot
     * @return ColissimoAFStructZoneInfosRoutage
     */
    public function __construct($_controlKeyTrackingNumber = NULL,$_datePrinting = NULL,$_hourPrinting = NULL,$_identificationDestination1 = NULL,$_identificationDestination2 = NULL,$_numberVersionWS = NULL,$_routingVersion = NULL,$_serviceMark = NULL,$_sortDest = NULL,$_sortOrigin = NULL,$_trackingNumberRouting = NULL,$_typeServiceLivraison = NULL,$_rDepot = NULL)
    {
        parent::__construct(array('controlKeyTrackingNumber'=>$_controlKeyTrackingNumber,'datePrinting'=>$_datePrinting,'hourPrinting'=>$_hourPrinting,'identificationDestination1'=>$_identificationDestination1,'identificationDestination2'=>$_identificationDestination2,'numberVersionWS'=>$_numberVersionWS,'routingVersion'=>$_routingVersion,'serviceMark'=>$_serviceMark,'sortDest'=>$_sortDest,'sortOrigin'=>$_sortOrigin,'trackingNumberRouting'=>$_trackingNumberRouting,'typeServiceLivraison'=>$_typeServiceLivraison,'rDepot'=>$_rDepot),false);
    }
    /**
     * Get controlKeyTrackingNumber value
     * @return string|null
     */
    public function getControlKeyTrackingNumber()
    {
        return $this->controlKeyTrackingNumber;
    }
    /**
     * Set controlKeyTrackingNumber value
     * @param string $_controlKeyTrackingNumber the controlKeyTrackingNumber
     * @return string
     */
    public function setControlKeyTrackingNumber($_controlKeyTrackingNumber)
    {
        return ($this->controlKeyTrackingNumber = $_controlKeyTrackingNumber);
    }
    /**
     * Get datePrinting value
     * @return string|null
     */
    public function getDatePrinting()
    {
        return $this->datePrinting;
    }
    /**
     * Set datePrinting value
     * @param string $_datePrinting the datePrinting
     * @return string
     */
    public function setDatePrinting($_datePrinting)
    {
        return ($this->datePrinting = $_datePrinting);
    }
    /**
     * Get hourPrinting value
     * @return string|null
     */
    public function getHourPrinting()
    {
        return $this->hourPrinting;
    }
    /**
     * Set hourPrinting value
     * @param string $_hourPrinting the hourPrinting
     * @return string
     */
    public function setHourPrinting($_hourPrinting)
    {
        return ($this->hourPrinting = $_hourPrinting);
    }
    /**
     * Get identificationDestination1 value
     * @return string|null
     */
    public function getIdentificationDestination1()
    {
        return $this->identificationDestination1;
    }
    /**
     * Set identificationDestination1 value
     * @param string $_identificationDestination1 the identificationDestination1
     * @return string
     */
    public function setIdentificationDestination1($_identificationDestination1)
    {
        return ($this->identificationDestination1 = $_identificationDestination1);
    }
    /**
     * Get identificationDestination2 value
     * @return string|null
     */
    public function getIdentificationDestination2()
    {
        return $this->identificationDestination2;
    }
    /**
     * Set identificationDestination2 value
     * @param string $_identificationDestination2 the identificationDestination2
     * @return string
     */
    public function setIdentificationDestination2($_identificationDestination2)
    {
        return ($this->identificationDestination2 = $_identificationDestination2);
    }
    /**
     * Get numberVersionWS value
     * @return string|null
     */
    public function getNumberVersionWS()
    {
        return $this->numberVersionWS;
    }
    /**
     * Set numberVersionWS value
     * @param string $_numberVersionWS the numberVersionWS
     * @return string
     */
    public function setNumberVersionWS($_numberVersionWS)
    {
        return ($this->numberVersionWS = $_numberVersionWS);
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
     * Get trackingNumberRouting value
     * @return string|null
     */
    public function getTrackingNumberRouting()
    {
        return $this->trackingNumberRouting;
    }
    /**
     * Set trackingNumberRouting value
     * @param string $_trackingNumberRouting the trackingNumberRouting
     * @return string
     */
    public function setTrackingNumberRouting($_trackingNumberRouting)
    {
        return ($this->trackingNumberRouting = $_trackingNumberRouting);
    }
    /**
     * Get typeServiceLivraison value
     * @return string|null
     */
    public function getTypeServiceLivraison()
    {
        return $this->typeServiceLivraison;
    }
    /**
     * Set typeServiceLivraison value
     * @param string $_typeServiceLivraison the typeServiceLivraison
     * @return string
     */
    public function setTypeServiceLivraison($_typeServiceLivraison)
    {
        return ($this->typeServiceLivraison = $_typeServiceLivraison);
    }
    /**
     * Get rDepot value
     * @return string|null
     */
    public function getRDepot()
    {
        return $this->rDepot;
    }
    /**
     * Set rDepot value
     * @param string $_rDepot the rDepot
     * @return string
     */
    public function setRDepot($_rDepot)
    {
        return ($this->rDepot = $_rDepot);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructZoneInfosRoutage
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
