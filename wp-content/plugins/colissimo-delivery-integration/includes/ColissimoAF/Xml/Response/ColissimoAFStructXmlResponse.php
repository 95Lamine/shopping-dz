<?php
/**
 * File for class ColissimoAFStructXmlResponse
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructXmlResponse originally named xmlResponse
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructXmlResponse extends ColissimoAFWsdlClass
{
    /**
     * The cn23
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - xmime:expectedContentTypes : application/octet-stream
     * @var base64Binary
     */
    public $cn23;
    /**
     * The addressee
     * @var ColissimoAFStructAddressee
     */
    public $addressee;
    /**
     * The barCodeCityssimo
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $barCodeCityssimo;
    /**
     * The barCodePCH
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $barCodePCH;
    /**
     * The barCodeRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $barCodeRouting;
    /**
     * The belgiumLabel
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructBelgiumLabel
     */
    public $belgiumLabel;
    /**
     * The contractNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $contractNumber;
    /**
     * The elementVisual
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var ColissimoAFStructElementVisual
     */
    public $elementVisual;
    /**
     * The numberPCH
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $numberPCH;
    /**
     * The numberRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $numberRouting;
    /**
     * The parcelNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $parcelNumber;
    /**
     * The parcelNumberPartner
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $parcelNumberPartner;
    /**
     * The pickupLocation
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructPickupLocation
     */
    public $pickupLocation;
    /**
     * The routing
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructRouting
     */
    public $routing;
    /**
     * The sender
     * @var ColissimoAFStructSender
     */
    public $sender;
    /**
     * The sitePCH
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructSite
     */
    public $sitePCH;
    /**
     * The zoneRouting
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoAFStructZoneRouting
     */
    public $zoneRouting;
    /**
     * Constructor method for xmlResponse
     * @see parent::__construct()
     * @param base64Binary $_cn23
     * @param ColissimoAFStructAddressee $_addressee
     * @param string $_barCodeCityssimo
     * @param string $_barCodePCH
     * @param string $_barCodeRouting
     * @param ColissimoAFStructBelgiumLabel $_belgiumLabel
     * @param string $_contractNumber
     * @param ColissimoAFStructElementVisual $_elementVisual
     * @param string $_numberPCH
     * @param string $_numberRouting
     * @param string $_parcelNumber
     * @param string $_parcelNumberPartner
     * @param ColissimoAFStructPickupLocation $_pickupLocation
     * @param ColissimoAFStructRouting $_routing
     * @param ColissimoAFStructSender $_sender
     * @param ColissimoAFStructSite $_sitePCH
     * @param ColissimoAFStructZoneRouting $_zoneRouting
     * @return ColissimoAFStructXmlResponse
     */
    public function __construct($_cn23 = NULL,$_addressee = NULL,$_barCodeCityssimo = NULL,$_barCodePCH = NULL,$_barCodeRouting = NULL,$_belgiumLabel = NULL,$_contractNumber = NULL,$_elementVisual = NULL,$_numberPCH = NULL,$_numberRouting = NULL,$_parcelNumber = NULL,$_parcelNumberPartner = NULL,$_pickupLocation = NULL,$_routing = NULL,$_sender = NULL,$_sitePCH = NULL,$_zoneRouting = NULL)
    {
        parent::__construct(array('cn23'=>$_cn23,'addressee'=>$_addressee,'barCodeCityssimo'=>$_barCodeCityssimo,'barCodePCH'=>$_barCodePCH,'barCodeRouting'=>$_barCodeRouting,'belgiumLabel'=>$_belgiumLabel,'contractNumber'=>$_contractNumber,'elementVisual'=>$_elementVisual,'numberPCH'=>$_numberPCH,'numberRouting'=>$_numberRouting,'parcelNumber'=>$_parcelNumber,'parcelNumberPartner'=>$_parcelNumberPartner,'pickupLocation'=>$_pickupLocation,'routing'=>$_routing,'sender'=>$_sender,'sitePCH'=>$_sitePCH,'zoneRouting'=>$_zoneRouting),false);
    }
    /**
     * Get cn23 value
     * @return base64Binary|null
     */
    public function getCn23()
    {
        return $this->cn23;
    }
    /**
     * Set cn23 value
     * @param base64Binary $_cn23 the cn23
     * @return base64Binary
     */
    public function setCn23($_cn23)
    {
        return ($this->cn23 = $_cn23);
    }
    /**
     * Get addressee value
     * @return ColissimoAFStructAddressee|null
     */
    public function getAddressee()
    {
        return $this->addressee;
    }
    /**
     * Set addressee value
     * @param ColissimoAFStructAddressee $_addressee the addressee
     * @return ColissimoAFStructAddressee
     */
    public function setAddressee($_addressee)
    {
        return ($this->addressee = $_addressee);
    }
    /**
     * Get barCodeCityssimo value
     * @return string|null
     */
    public function getBarCodeCityssimo()
    {
        return $this->barCodeCityssimo;
    }
    /**
     * Set barCodeCityssimo value
     * @param string $_barCodeCityssimo the barCodeCityssimo
     * @return string
     */
    public function setBarCodeCityssimo($_barCodeCityssimo)
    {
        return ($this->barCodeCityssimo = $_barCodeCityssimo);
    }
    /**
     * Get barCodePCH value
     * @return string|null
     */
    public function getBarCodePCH()
    {
        return $this->barCodePCH;
    }
    /**
     * Set barCodePCH value
     * @param string $_barCodePCH the barCodePCH
     * @return string
     */
    public function setBarCodePCH($_barCodePCH)
    {
        return ($this->barCodePCH = $_barCodePCH);
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
     * Get belgiumLabel value
     * @return ColissimoAFStructBelgiumLabel|null
     */
    public function getBelgiumLabel()
    {
        return $this->belgiumLabel;
    }
    /**
     * Set belgiumLabel value
     * @param ColissimoAFStructBelgiumLabel $_belgiumLabel the belgiumLabel
     * @return ColissimoAFStructBelgiumLabel
     */
    public function setBelgiumLabel($_belgiumLabel)
    {
        return ($this->belgiumLabel = $_belgiumLabel);
    }
    /**
     * Get contractNumber value
     * @return string|null
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }
    /**
     * Set contractNumber value
     * @param string $_contractNumber the contractNumber
     * @return string
     */
    public function setContractNumber($_contractNumber)
    {
        return ($this->contractNumber = $_contractNumber);
    }
    /**
     * Get elementVisual value
     * @return ColissimoAFStructElementVisual|null
     */
    public function getElementVisual()
    {
        return $this->elementVisual;
    }
    /**
     * Set elementVisual value
     * @param ColissimoAFStructElementVisual $_elementVisual the elementVisual
     * @return ColissimoAFStructElementVisual
     */
    public function setElementVisual($_elementVisual)
    {
        return ($this->elementVisual = $_elementVisual);
    }
    /**
     * Get numberPCH value
     * @return string|null
     */
    public function getNumberPCH()
    {
        return $this->numberPCH;
    }
    /**
     * Set numberPCH value
     * @param string $_numberPCH the numberPCH
     * @return string
     */
    public function setNumberPCH($_numberPCH)
    {
        return ($this->numberPCH = $_numberPCH);
    }
    /**
     * Get numberRouting value
     * @return string|null
     */
    public function getNumberRouting()
    {
        return $this->numberRouting;
    }
    /**
     * Set numberRouting value
     * @param string $_numberRouting the numberRouting
     * @return string
     */
    public function setNumberRouting($_numberRouting)
    {
        return ($this->numberRouting = $_numberRouting);
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
     * Get parcelNumberPartner value
     * @return string|null
     */
    public function getParcelNumberPartner()
    {
        return $this->parcelNumberPartner;
    }
    /**
     * Set parcelNumberPartner value
     * @param string $_parcelNumberPartner the parcelNumberPartner
     * @return string
     */
    public function setParcelNumberPartner($_parcelNumberPartner)
    {
        return ($this->parcelNumberPartner = $_parcelNumberPartner);
    }
    /**
     * Get pickupLocation value
     * @return ColissimoAFStructPickupLocation|null
     */
    public function getPickupLocation()
    {
        return $this->pickupLocation;
    }
    /**
     * Set pickupLocation value
     * @param ColissimoAFStructPickupLocation $_pickupLocation the pickupLocation
     * @return ColissimoAFStructPickupLocation
     */
    public function setPickupLocation($_pickupLocation)
    {
        return ($this->pickupLocation = $_pickupLocation);
    }
    /**
     * Get routing value
     * @return ColissimoAFStructRouting|null
     */
    public function getRouting()
    {
        return $this->routing;
    }
    /**
     * Set routing value
     * @param ColissimoAFStructRouting $_routing the routing
     * @return ColissimoAFStructRouting
     */
    public function setRouting($_routing)
    {
        return ($this->routing = $_routing);
    }
    /**
     * Get sender value
     * @return ColissimoAFStructSender|null
     */
    public function getSender()
    {
        return $this->sender;
    }
    /**
     * Set sender value
     * @param ColissimoAFStructSender $_sender the sender
     * @return ColissimoAFStructSender
     */
    public function setSender($_sender)
    {
        return ($this->sender = $_sender);
    }
    /**
     * Get sitePCH value
     * @return ColissimoAFStructSite|null
     */
    public function getSitePCH()
    {
        return $this->sitePCH;
    }
    /**
     * Set sitePCH value
     * @param ColissimoAFStructSite $_sitePCH the sitePCH
     * @return ColissimoAFStructSite
     */
    public function setSitePCH($_sitePCH)
    {
        return ($this->sitePCH = $_sitePCH);
    }
    /**
     * Get zoneRouting value
     * @return ColissimoAFStructZoneRouting|null
     */
    public function getZoneRouting()
    {
        return $this->zoneRouting;
    }
    /**
     * Set zoneRouting value
     * @param ColissimoAFStructZoneRouting $_zoneRouting the zoneRouting
     * @return ColissimoAFStructZoneRouting
     */
    public function setZoneRouting($_zoneRouting)
    {
        return ($this->zoneRouting = $_zoneRouting);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructXmlResponse
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
