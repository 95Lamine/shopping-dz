<?php
/**
 * File for class ColissimoAFStructLetter
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructLetter originally named letter
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructLetter extends ColissimoAFWsdlClass
{
    /**
     * The service
     * @var ColissimoAFStructService
     */
    public $service;
    /**
     * The parcel
     * @var ColissimoAFStructParcel
     */
    public $parcel;
    /**
     * The customsDeclarations
     * @var ColissimoAFStructCustomsDeclarations
     */
    public $customsDeclarations;
    /**
     * The sender
     * @var ColissimoAFStructSender
     */
    public $sender;
    /**
     * The addressee
     * @var ColissimoAFStructAddressee
     */
    public $addressee;
    /**
     * Constructor method for letter
     * @see parent::__construct()
     * @param ColissimoAFStructService $_service
     * @param ColissimoAFStructParcel $_parcel
     * @param ColissimoAFStructCustomsDeclarations $_customsDeclarations
     * @param ColissimoAFStructSender $_sender
     * @param ColissimoAFStructAddressee $_addressee
     * @return ColissimoAFStructLetter
     */
    public function __construct($_service = NULL,$_parcel = NULL,$_customsDeclarations = NULL,$_sender = NULL,$_addressee = NULL)
    {
        parent::__construct(array('service'=>$_service,'parcel'=>$_parcel,'customsDeclarations'=>$_customsDeclarations,'sender'=>$_sender,'addressee'=>$_addressee),false);
    }
    /**
     * Get service value
     * @return ColissimoAFStructService|null
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * Set service value
     * @param ColissimoAFStructService $_service the service
     * @return ColissimoAFStructService
     */
    public function setService($_service)
    {
        return ($this->service = $_service);
    }
    /**
     * Get parcel value
     * @return ColissimoAFStructParcel|null
     */
    public function getParcel()
    {
        return $this->parcel;
    }
    /**
     * Set parcel value
     * @param ColissimoAFStructParcel $_parcel the parcel
     * @return ColissimoAFStructParcel
     */
    public function setParcel($_parcel)
    {
        return ($this->parcel = $_parcel);
    }
    /**
     * Get customsDeclarations value
     * @return ColissimoAFStructCustomsDeclarations|null
     */
    public function getCustomsDeclarations()
    {
        return $this->customsDeclarations;
    }
    /**
     * Set customsDeclarations value
     * @param ColissimoAFStructCustomsDeclarations $_customsDeclarations the customsDeclarations
     * @return ColissimoAFStructCustomsDeclarations
     */
    public function setCustomsDeclarations($_customsDeclarations)
    {
        return ($this->customsDeclarations = $_customsDeclarations);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructLetter
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
