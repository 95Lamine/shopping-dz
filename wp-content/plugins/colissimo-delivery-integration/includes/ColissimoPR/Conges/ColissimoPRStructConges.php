<?php
/**
 * File for class ColissimoPRStructConges
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructConges originally named Conges
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructConges extends ColissimoPRWsdlClass
{
    /**
     * The calendarDeDebut
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var dateTime
     */
    public $calendarDeDebut;
    /**
     * The calendarDeFin
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var dateTime
     */
    public $calendarDeFin;
    /**
     * The numero
     * @var int
     */
    public $numero;
    /**
     * Constructor method for Conges
     * @see parent::__construct()
     * @param dateTime $_calendarDeDebut
     * @param dateTime $_calendarDeFin
     * @param int $_numero
     * @return ColissimoPRStructConges
     */
    public function __construct($_calendarDeDebut = NULL,$_calendarDeFin = NULL,$_numero = NULL)
    {
        parent::__construct(array('calendarDeDebut'=>$_calendarDeDebut,'calendarDeFin'=>$_calendarDeFin,'numero'=>$_numero),false);
    }
    /**
     * Get calendarDeDebut value
     * @return dateTime|null
     */
    public function getCalendarDeDebut()
    {
        return $this->calendarDeDebut;
    }
    /**
     * Set calendarDeDebut value
     * @param dateTime $_calendarDeDebut the calendarDeDebut
     * @return dateTime
     */
    public function setCalendarDeDebut($_calendarDeDebut)
    {
        return ($this->calendarDeDebut = $_calendarDeDebut);
    }
    /**
     * Get calendarDeFin value
     * @return dateTime|null
     */
    public function getCalendarDeFin()
    {
        return $this->calendarDeFin;
    }
    /**
     * Set calendarDeFin value
     * @param dateTime $_calendarDeFin the calendarDeFin
     * @return dateTime
     */
    public function setCalendarDeFin($_calendarDeFin)
    {
        return ($this->calendarDeFin = $_calendarDeFin);
    }
    /**
     * Get numero value
     * @return int|null
     */
    public function getNumero()
    {
        return $this->numero;
    }
    /**
     * Set numero value
     * @param int $_numero the numero
     * @return int
     */
    public function setNumero($_numero)
    {
        return ($this->numero = $_numero);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructConges
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
