<?php
/**
 * File for class ColissimoPRStructPointRetrait
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructPointRetrait originally named PointRetrait
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructPointRetrait extends ColissimoPRWsdlClass
{
    /**
     * The codePays
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $codePays;
    /**
     * The langue
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $langue;
    /**
     * The libellePays
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $libellePays;
    /**
     * The loanOfHandlingTool
     * @var boolean
     */
    public $loanOfHandlingTool;
    /**
     * The parking
     * @var boolean
     */
    public $parking;
    /**
     * The reseau
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $reseau;
    /**
     * The accesPersonneMobiliteReduite
     * @var boolean
     */
    public $accesPersonneMobiliteReduite;
    /**
     * The adresse1
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $adresse1;
    /**
     * The adresse2
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $adresse2;
    /**
     * The adresse3
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $adresse3;
    /**
     * The codePostal
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $codePostal;
    /**
     * The congesPartiel
     * @var boolean
     */
    public $congesPartiel;
    /**
     * The congesTotal
     * @var boolean
     */
    public $congesTotal;
    /**
     * The coordGeolocalisationLatitude
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $coordGeolocalisationLatitude;
    /**
     * The coordGeolocalisationLongitude
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $coordGeolocalisationLongitude;
    /**
     * The distanceEnMetre
     * @var int
     */
    public $distanceEnMetre;
    /**
     * The horairesOuvertureDimanche
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureDimanche;
    /**
     * The horairesOuvertureJeudi
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureJeudi;
    /**
     * The horairesOuvertureLundi
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureLundi;
    /**
     * The horairesOuvertureMardi
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureMardi;
    /**
     * The horairesOuvertureMercredi
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureMercredi;
    /**
     * The horairesOuvertureSamedi
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureSamedi;
    /**
     * The horairesOuvertureVendredi
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $horairesOuvertureVendredi;
    /**
     * The identifiant
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $identifiant;
    /**
     * The indiceDeLocalisation
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $indiceDeLocalisation;
    /**
     * The listeConges
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var ColissimoPRStructConges
     */
    public $listeConges;
    /**
     * The localite
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $localite;
    /**
     * The nom
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $nom;
    /**
     * The periodeActiviteHoraireDeb
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $periodeActiviteHoraireDeb;
    /**
     * The periodeActiviteHoraireFin
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $periodeActiviteHoraireFin;
    /**
     * The poidsMaxi
     * @var int
     */
    public $poidsMaxi;
    /**
     * The typeDePoint
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $typeDePoint;
    /**
     * Constructor method for PointRetrait
     * @see parent::__construct()
     * @param string $_codePays
     * @param string $_langue
     * @param string $_libellePays
     * @param boolean $_loanOfHandlingTool
     * @param boolean $_parking
     * @param string $_reseau
     * @param boolean $_accesPersonneMobiliteReduite
     * @param string $_adresse1
     * @param string $_adresse2
     * @param string $_adresse3
     * @param string $_codePostal
     * @param boolean $_congesPartiel
     * @param boolean $_congesTotal
     * @param string $_coordGeolocalisationLatitude
     * @param string $_coordGeolocalisationLongitude
     * @param int $_distanceEnMetre
     * @param string $_horairesOuvertureDimanche
     * @param string $_horairesOuvertureJeudi
     * @param string $_horairesOuvertureLundi
     * @param string $_horairesOuvertureMardi
     * @param string $_horairesOuvertureMercredi
     * @param string $_horairesOuvertureSamedi
     * @param string $_horairesOuvertureVendredi
     * @param string $_identifiant
     * @param string $_indiceDeLocalisation
     * @param ColissimoPRStructConges $_listeConges
     * @param string $_localite
     * @param string $_nom
     * @param string $_periodeActiviteHoraireDeb
     * @param string $_periodeActiviteHoraireFin
     * @param int $_poidsMaxi
     * @param string $_typeDePoint
     * @return ColissimoPRStructPointRetrait
     */
    public function __construct($_codePays = NULL,$_langue = NULL,$_libellePays = NULL,$_loanOfHandlingTool = NULL,$_parking = NULL,$_reseau = NULL,$_accesPersonneMobiliteReduite = NULL,$_adresse1 = NULL,$_adresse2 = NULL,$_adresse3 = NULL,$_codePostal = NULL,$_congesPartiel = NULL,$_congesTotal = NULL,$_coordGeolocalisationLatitude = NULL,$_coordGeolocalisationLongitude = NULL,$_distanceEnMetre = NULL,$_horairesOuvertureDimanche = NULL,$_horairesOuvertureJeudi = NULL,$_horairesOuvertureLundi = NULL,$_horairesOuvertureMardi = NULL,$_horairesOuvertureMercredi = NULL,$_horairesOuvertureSamedi = NULL,$_horairesOuvertureVendredi = NULL,$_identifiant = NULL,$_indiceDeLocalisation = NULL,$_listeConges = NULL,$_localite = NULL,$_nom = NULL,$_periodeActiviteHoraireDeb = NULL,$_periodeActiviteHoraireFin = NULL,$_poidsMaxi = NULL,$_typeDePoint = NULL)
    {
        parent::__construct(array('codePays'=>$_codePays,'langue'=>$_langue,'libellePays'=>$_libellePays,'loanOfHandlingTool'=>$_loanOfHandlingTool,'parking'=>$_parking,'reseau'=>$_reseau,'accesPersonneMobiliteReduite'=>$_accesPersonneMobiliteReduite,'adresse1'=>$_adresse1,'adresse2'=>$_adresse2,'adresse3'=>$_adresse3,'codePostal'=>$_codePostal,'congesPartiel'=>$_congesPartiel,'congesTotal'=>$_congesTotal,'coordGeolocalisationLatitude'=>$_coordGeolocalisationLatitude,'coordGeolocalisationLongitude'=>$_coordGeolocalisationLongitude,'distanceEnMetre'=>$_distanceEnMetre,'horairesOuvertureDimanche'=>$_horairesOuvertureDimanche,'horairesOuvertureJeudi'=>$_horairesOuvertureJeudi,'horairesOuvertureLundi'=>$_horairesOuvertureLundi,'horairesOuvertureMardi'=>$_horairesOuvertureMardi,'horairesOuvertureMercredi'=>$_horairesOuvertureMercredi,'horairesOuvertureSamedi'=>$_horairesOuvertureSamedi,'horairesOuvertureVendredi'=>$_horairesOuvertureVendredi,'identifiant'=>$_identifiant,'indiceDeLocalisation'=>$_indiceDeLocalisation,'listeConges'=>$_listeConges,'localite'=>$_localite,'nom'=>$_nom,'periodeActiviteHoraireDeb'=>$_periodeActiviteHoraireDeb,'periodeActiviteHoraireFin'=>$_periodeActiviteHoraireFin,'poidsMaxi'=>$_poidsMaxi,'typeDePoint'=>$_typeDePoint),false);
    }
    /**
     * Get codePays value
     * @return string|null
     */
    public function getCodePays()
    {
        return $this->codePays;
    }
    /**
     * Set codePays value
     * @param string $_codePays the codePays
     * @return string
     */
    public function setCodePays($_codePays)
    {
        return ($this->codePays = $_codePays);
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
     * Get libellePays value
     * @return string|null
     */
    public function getLibellePays()
    {
        return $this->libellePays;
    }
    /**
     * Set libellePays value
     * @param string $_libellePays the libellePays
     * @return string
     */
    public function setLibellePays($_libellePays)
    {
        return ($this->libellePays = $_libellePays);
    }
    /**
     * Get loanOfHandlingTool value
     * @return boolean|null
     */
    public function getLoanOfHandlingTool()
    {
        return $this->loanOfHandlingTool;
    }
    /**
     * Set loanOfHandlingTool value
     * @param boolean $_loanOfHandlingTool the loanOfHandlingTool
     * @return boolean
     */
    public function setLoanOfHandlingTool($_loanOfHandlingTool)
    {
        return ($this->loanOfHandlingTool = $_loanOfHandlingTool);
    }
    /**
     * Get parking value
     * @return boolean|null
     */
    public function getParking()
    {
        return $this->parking;
    }
    /**
     * Set parking value
     * @param boolean $_parking the parking
     * @return boolean
     */
    public function setParking($_parking)
    {
        return ($this->parking = $_parking);
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
     * Get accesPersonneMobiliteReduite value
     * @return boolean|null
     */
    public function getAccesPersonneMobiliteReduite()
    {
        return $this->accesPersonneMobiliteReduite;
    }
    /**
     * Set accesPersonneMobiliteReduite value
     * @param boolean $_accesPersonneMobiliteReduite the accesPersonneMobiliteReduite
     * @return boolean
     */
    public function setAccesPersonneMobiliteReduite($_accesPersonneMobiliteReduite)
    {
        return ($this->accesPersonneMobiliteReduite = $_accesPersonneMobiliteReduite);
    }
    /**
     * Get adresse1 value
     * @return string|null
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }
    /**
     * Set adresse1 value
     * @param string $_adresse1 the adresse1
     * @return string
     */
    public function setAdresse1($_adresse1)
    {
        return ($this->adresse1 = $_adresse1);
    }
    /**
     * Get adresse2 value
     * @return string|null
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }
    /**
     * Set adresse2 value
     * @param string $_adresse2 the adresse2
     * @return string
     */
    public function setAdresse2($_adresse2)
    {
        return ($this->adresse2 = $_adresse2);
    }
    /**
     * Get adresse3 value
     * @return string|null
     */
    public function getAdresse3()
    {
        return $this->adresse3;
    }
    /**
     * Set adresse3 value
     * @param string $_adresse3 the adresse3
     * @return string
     */
    public function setAdresse3($_adresse3)
    {
        return ($this->adresse3 = $_adresse3);
    }
    /**
     * Get codePostal value
     * @return string|null
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }
    /**
     * Set codePostal value
     * @param string $_codePostal the codePostal
     * @return string
     */
    public function setCodePostal($_codePostal)
    {
        return ($this->codePostal = $_codePostal);
    }
    /**
     * Get congesPartiel value
     * @return boolean|null
     */
    public function getCongesPartiel()
    {
        return $this->congesPartiel;
    }
    /**
     * Set congesPartiel value
     * @param boolean $_congesPartiel the congesPartiel
     * @return boolean
     */
    public function setCongesPartiel($_congesPartiel)
    {
        return ($this->congesPartiel = $_congesPartiel);
    }
    /**
     * Get congesTotal value
     * @return boolean|null
     */
    public function getCongesTotal()
    {
        return $this->congesTotal;
    }
    /**
     * Set congesTotal value
     * @param boolean $_congesTotal the congesTotal
     * @return boolean
     */
    public function setCongesTotal($_congesTotal)
    {
        return ($this->congesTotal = $_congesTotal);
    }
    /**
     * Get coordGeolocalisationLatitude value
     * @return string|null
     */
    public function getCoordGeolocalisationLatitude()
    {
        return $this->coordGeolocalisationLatitude;
    }
    /**
     * Set coordGeolocalisationLatitude value
     * @param string $_coordGeolocalisationLatitude the coordGeolocalisationLatitude
     * @return string
     */
    public function setCoordGeolocalisationLatitude($_coordGeolocalisationLatitude)
    {
        return ($this->coordGeolocalisationLatitude = $_coordGeolocalisationLatitude);
    }
    /**
     * Get coordGeolocalisationLongitude value
     * @return string|null
     */
    public function getCoordGeolocalisationLongitude()
    {
        return $this->coordGeolocalisationLongitude;
    }
    /**
     * Set coordGeolocalisationLongitude value
     * @param string $_coordGeolocalisationLongitude the coordGeolocalisationLongitude
     * @return string
     */
    public function setCoordGeolocalisationLongitude($_coordGeolocalisationLongitude)
    {
        return ($this->coordGeolocalisationLongitude = $_coordGeolocalisationLongitude);
    }
    /**
     * Get distanceEnMetre value
     * @return int|null
     */
    public function getDistanceEnMetre()
    {
        return $this->distanceEnMetre;
    }
    /**
     * Set distanceEnMetre value
     * @param int $_distanceEnMetre the distanceEnMetre
     * @return int
     */
    public function setDistanceEnMetre($_distanceEnMetre)
    {
        return ($this->distanceEnMetre = $_distanceEnMetre);
    }
    /**
     * Get horairesOuvertureDimanche value
     * @return string|null
     */
    public function getHorairesOuvertureDimanche()
    {
        return $this->horairesOuvertureDimanche;
    }
    /**
     * Set horairesOuvertureDimanche value
     * @param string $_horairesOuvertureDimanche the horairesOuvertureDimanche
     * @return string
     */
    public function setHorairesOuvertureDimanche($_horairesOuvertureDimanche)
    {
        return ($this->horairesOuvertureDimanche = $_horairesOuvertureDimanche);
    }
    /**
     * Get horairesOuvertureJeudi value
     * @return string|null
     */
    public function getHorairesOuvertureJeudi()
    {
        return $this->horairesOuvertureJeudi;
    }
    /**
     * Set horairesOuvertureJeudi value
     * @param string $_horairesOuvertureJeudi the horairesOuvertureJeudi
     * @return string
     */
    public function setHorairesOuvertureJeudi($_horairesOuvertureJeudi)
    {
        return ($this->horairesOuvertureJeudi = $_horairesOuvertureJeudi);
    }
    /**
     * Get horairesOuvertureLundi value
     * @return string|null
     */
    public function getHorairesOuvertureLundi()
    {
        return $this->horairesOuvertureLundi;
    }
    /**
     * Set horairesOuvertureLundi value
     * @param string $_horairesOuvertureLundi the horairesOuvertureLundi
     * @return string
     */
    public function setHorairesOuvertureLundi($_horairesOuvertureLundi)
    {
        return ($this->horairesOuvertureLundi = $_horairesOuvertureLundi);
    }
    /**
     * Get horairesOuvertureMardi value
     * @return string|null
     */
    public function getHorairesOuvertureMardi()
    {
        return $this->horairesOuvertureMardi;
    }
    /**
     * Set horairesOuvertureMardi value
     * @param string $_horairesOuvertureMardi the horairesOuvertureMardi
     * @return string
     */
    public function setHorairesOuvertureMardi($_horairesOuvertureMardi)
    {
        return ($this->horairesOuvertureMardi = $_horairesOuvertureMardi);
    }
    /**
     * Get horairesOuvertureMercredi value
     * @return string|null
     */
    public function getHorairesOuvertureMercredi()
    {
        return $this->horairesOuvertureMercredi;
    }
    /**
     * Set horairesOuvertureMercredi value
     * @param string $_horairesOuvertureMercredi the horairesOuvertureMercredi
     * @return string
     */
    public function setHorairesOuvertureMercredi($_horairesOuvertureMercredi)
    {
        return ($this->horairesOuvertureMercredi = $_horairesOuvertureMercredi);
    }
    /**
     * Get horairesOuvertureSamedi value
     * @return string|null
     */
    public function getHorairesOuvertureSamedi()
    {
        return $this->horairesOuvertureSamedi;
    }
    /**
     * Set horairesOuvertureSamedi value
     * @param string $_horairesOuvertureSamedi the horairesOuvertureSamedi
     * @return string
     */
    public function setHorairesOuvertureSamedi($_horairesOuvertureSamedi)
    {
        return ($this->horairesOuvertureSamedi = $_horairesOuvertureSamedi);
    }
    /**
     * Get horairesOuvertureVendredi value
     * @return string|null
     */
    public function getHorairesOuvertureVendredi()
    {
        return $this->horairesOuvertureVendredi;
    }
    /**
     * Set horairesOuvertureVendredi value
     * @param string $_horairesOuvertureVendredi the horairesOuvertureVendredi
     * @return string
     */
    public function setHorairesOuvertureVendredi($_horairesOuvertureVendredi)
    {
        return ($this->horairesOuvertureVendredi = $_horairesOuvertureVendredi);
    }
    /**
     * Get identifiant value
     * @return string|null
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }
    /**
     * Set identifiant value
     * @param string $_identifiant the identifiant
     * @return string
     */
    public function setIdentifiant($_identifiant)
    {
        return ($this->identifiant = $_identifiant);
    }
    /**
     * Get indiceDeLocalisation value
     * @return string|null
     */
    public function getIndiceDeLocalisation()
    {
        return $this->indiceDeLocalisation;
    }
    /**
     * Set indiceDeLocalisation value
     * @param string $_indiceDeLocalisation the indiceDeLocalisation
     * @return string
     */
    public function setIndiceDeLocalisation($_indiceDeLocalisation)
    {
        return ($this->indiceDeLocalisation = $_indiceDeLocalisation);
    }
    /**
     * Get listeConges value
     * @return ColissimoPRStructConges|null
     */
    public function getListeConges()
    {
        return $this->listeConges;
    }
    /**
     * Set listeConges value
     * @param ColissimoPRStructConges $_listeConges the listeConges
     * @return ColissimoPRStructConges
     */
    public function setListeConges($_listeConges)
    {
        return ($this->listeConges = $_listeConges);
    }
    /**
     * Get localite value
     * @return string|null
     */
    public function getLocalite()
    {
        return $this->localite;
    }
    /**
     * Set localite value
     * @param string $_localite the localite
     * @return string
     */
    public function setLocalite($_localite)
    {
        return ($this->localite = $_localite);
    }
    /**
     * Get nom value
     * @return string|null
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Set nom value
     * @param string $_nom the nom
     * @return string
     */
    public function setNom($_nom)
    {
        return ($this->nom = $_nom);
    }
    /**
     * Get periodeActiviteHoraireDeb value
     * @return string|null
     */
    public function getPeriodeActiviteHoraireDeb()
    {
        return $this->periodeActiviteHoraireDeb;
    }
    /**
     * Set periodeActiviteHoraireDeb value
     * @param string $_periodeActiviteHoraireDeb the periodeActiviteHoraireDeb
     * @return string
     */
    public function setPeriodeActiviteHoraireDeb($_periodeActiviteHoraireDeb)
    {
        return ($this->periodeActiviteHoraireDeb = $_periodeActiviteHoraireDeb);
    }
    /**
     * Get periodeActiviteHoraireFin value
     * @return string|null
     */
    public function getPeriodeActiviteHoraireFin()
    {
        return $this->periodeActiviteHoraireFin;
    }
    /**
     * Set periodeActiviteHoraireFin value
     * @param string $_periodeActiviteHoraireFin the periodeActiviteHoraireFin
     * @return string
     */
    public function setPeriodeActiviteHoraireFin($_periodeActiviteHoraireFin)
    {
        return ($this->periodeActiviteHoraireFin = $_periodeActiviteHoraireFin);
    }
    /**
     * Get poidsMaxi value
     * @return int|null
     */
    public function getPoidsMaxi()
    {
        return $this->poidsMaxi;
    }
    /**
     * Set poidsMaxi value
     * @param int $_poidsMaxi the poidsMaxi
     * @return int
     */
    public function setPoidsMaxi($_poidsMaxi)
    {
        return ($this->poidsMaxi = $_poidsMaxi);
    }
    /**
     * Get typeDePoint value
     * @return string|null
     */
    public function getTypeDePoint()
    {
        return $this->typeDePoint;
    }
    /**
     * Set typeDePoint value
     * @param string $_typeDePoint the typeDePoint
     * @return string
     */
    public function setTypeDePoint($_typeDePoint)
    {
        return ($this->typeDePoint = $_typeDePoint);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructPointRetrait
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
