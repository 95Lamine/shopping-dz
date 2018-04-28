===Colissimo Delivery Integration === 
Contributors: Harasse
Tags: woocommerce, colissimo, shipping, laposte, parcel, logistic, tracking
Tested up to: 4.9.4
Requires at least:  4.4
Stable tag: trunk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Une intégration complète de Colissimo dans WooCommerce.

== Description ==

= CDI et CDI+ : =

Les fonctions de Colissimo Delivery Integration se répartissent en 2 niveaux de service :

* Un service de base en utilisation libre appelé CDI,
* Un service CDI+ qui nécessite un enregistrement des utilisateurs, pour des fonctions additionnelles à plus forte valeur, avec une assistance support et conseil.

= Fonctions : =

CDI+ réalise l'intégration complète des services Colissimo (groupe La Poste) dans WooCommerce. CDI+ permet:

* L’utilisation d’une méthode de livraison Woommerce puissante et bien adaptée à Colissimo (sélection des tarifs par classes de produit, fourchette de prix du panier HT ou TTC, fourchette de poids des articles ; tarifs variables programmables ; gestion des coupons promo Woocommerce ; mode inclusion/exclusion pour les classes produit et les coupons promo ; gestion de tarifs prioritaires).
* Au client son choix de méthode de livraison. Ses données de suivi colis figurent dans les courriels et dans ses vues Woocommerce de commandes. Il dispose d’une extension de l’adresse basique Woocommerce (2 lignes) aux standards postaux 4 lignes.
* La gestion de toutes les options Colissimo: signature, assurance complémentaire, expéditions internationales, type de retour, caractéristiques CN23, … . Le service des retours de colis par le client avec pilotage/autorisation par l’Administrateur. Le traitement des points relais avec carte Google Maps.
* La gestion des colis des commandes produites par Woocommerce dans une passerelle dédiée, asynchrone du flux Woocommerce, avec 3 modes de traitement possibles :
  - Mode manuel par l’export d’un csv permettant ensuite à l’Administrateur l’automatisation de scripts pour le logiciel du transporteur qu’il utilise ;
  - Mode automatique qui exécute en ligne le Web service Colissimo affranchissement de Colissimo pour récupérer automatiquement les étiquettes et autres données émises par Colissimo ;
  - Mode personnalisé qui active un filtre Wordpress pour passer les données des colis à une application propre au gestionnaire du site, lui permettant ainsi de s’adapter au protocole de son transporteur (qui peut être différent de Colissimo).
* Une gestion automatisée au maximum des colis dans la passerelle : soumission en 1 clic des colis au transporteur, purge automatique des colis traités, vue directe des étiquettes et cn23, impression globale des étiquettes, export global des colis, historique des colis.
* Un suivi temps réel dans la console d’administration des commandes, de la situation de délivrance des colis expédiés.
* Une utilisation des grandes fonctions à la carte du gestionnaire du site selon son besoin, et si nécessaire un paramétrage des codes produit Colissimo et des pays admis aux offres du transporteur.

Le répartition actuelle des fonctions entre CDI et CDI+ est susceptible d'évolutions.

== Assistance et support : ==

* Le support du service de base CDI est assuré par les participants au forum wordpress.org . L’auteur ne fournit pas de support sur le forum wordpress.org .
* Seuls les utilisateurs du service CDI+ disposent d’un support spécifique et personnalisé

== Installation et démarrage ==

1. Installer le plugin de façon traditionnelle, et l’activer.
1. Aller dans la page  : Woocommerce -> Réglages -> Colissimo, et adapter quand nécessaire les réglages des 8 onglets : Réglages généraux, CN23, Interface client, Mode automatique, Références aux livraisons, Méthode Colissimo, Retour colis, Impression d'étiquettes. Bien veiller à enregistrer un à un chacun des onglets. Les réglages par défaut de CDI permettent déjà un fonctionnement immédiat.
1. Renseigner vos réglages de l'identifiant et du mot de passe Colissimo, ainsi que de la clé Google Maps, si vous utilisez ces fonctions.
1. Aller dans la page Woocommerce des commandes et cliquer sur l’icône «colis ouvert» d’une commande pour créer dans la passerelle CDI un colis à expédier. Si besoin avant cela, les caractéristique du colis peuvent être visualisées et modifiées en ouvrant la commande et en modifiant sa zone «Métabox CDI».
1. Aller dans la  passerelle CDI  Woocommerce -> Colissimo , pour retrouver les colis à expédier.
1. Cliquer sur le bouton «Automatique» pour soumettre au serveur Colissimo tous les colis en attente, ce qui retournera les étiquettes d’affranchissement.

== Activation de CDI+ ==

1. Le plugin est le même pour le service de base CDI et CDI+, les droits étant affectés dynamiquement.
1. Dans un premier temps, installer le plugin CDI depuis Wordpress ce qui donnera accès au service de base CDI.
1. Ensuite, s'abonner à CDI+ depuis les réglages du plugin CDI ou de la passerelle CDI.

== Frequently Asked Questions ==

= Où puis-je obtenir de l'aide ou  parler à d'autres utilisateurs ?  =

* Le support gratuit est disponible à l'aide de la communauté dans le [Forum de Colissimo Delivery Intégration](https://wordpress.org/support/plugin/colissimo-delivery-integration).
C'est le meilleur moyen parce que toute la communauté profite des solutions données dans le forum. Vous pouvez utiliser indifféremment l'anglais ou le français. 
Si vous étés enregistré à CDI+ , vous bénéficiez en plus d’un support premium pour vous assister. 

= Puis-je obtenir une personnalisation poussée de CDI ? =

Une personnalisation de base peut être obtenue par les paramètres CDI. Mais vous pouvez allez plus loin et avoir une personnalisation beaucoup plus fine lorsque vous utilisez des filtres Wordpress installés dans les fichiers  CDI. La règle d'utilisation de chacun de ces filtres est donnée par son utilisation dans les fichiers php activant ces filtres. Des exemples d'utilisation sont donnés dans le fichier includes/WC-filter-examples.php.

= En mode automatique (service web), quelle est la règle d'affectation du code de produit Colissimo ? =

* Le code produit affiché dans la Metabox Colissimo de la commande a toujours la priorité. Il peut être forcé manuellement dans la Metabox Colissimo. Si le code produit n'existe pas dans la Metabox Colissimo, le mode automatique utilisera les paramètres par défaut définis dans Woocommerce-> Réglages-> Colissimo (France, Outre-mer, Europe, International)
* Le code produit inséré dans la Metabox Colissimo  peut être initialisé lors de l'analyse d'une méthode d'expédition: soit il correspond à une méthode d'expédition définie dans Woocommerce-> Réglages-> expédition-> Colissimo; soit un code produit est retourné dynamiquement par Colissimo "Point de livraison - Pickup locations" service web.

= Où sont les panneaux de réglages/controle de CDI ? =

* Les panneaux sont en 3 endroits:
   -Dans Woocommerce-> Réglages-> Colissimo pour les réglages généraux, cn23, infos clients, mode automatique, références aux livraisons, méthode Colissimo, retour colis, impression d'étiquettes
   -Dans Woocommerce-> Réglages-> Expédition et dans chaque instance en zone d'expédition pour les paramètres relatifs à une méthode d'expédition Colissimo.
   -Dans Woocommerce-> Colissimo pour contrôler la passerelle pour la production d'étiquettes de colis et la gestion des colis.

= Comment effectuer des tests et se mettre en mode log/debug ? =

* Configurez votre fichier wp-config.php en mode débogage en insérant, à la place de la ligne "define ('WP_DEBUG', false);" , ces 3 lignes : define ('WP_DEBUG', true); Define ('WP_DEBUG_LOG', true); Define ('WP_DEBUG_DISPLAY', false); 
* Activez le paramètre "log for debugging purpose" dans les paramètres de CDI, et choississez les modules pour lesquels vous voulez un log. Après exécution de votre séquence à tester, affichez le fichier wp-content/debug.log pour voir les traces. Si vous afficher votre fichier debug.log dans le forum: a) supprimez le fichier debug.log avant votre test pour réduire sa longueur b) pour votre sécurité supprimez dans votre fichier toutes vos données contractNumber et password.
* N'oubliez pas lorsque votre site passe de test en exploitation de restaurer votre fichier wp-config.php avec "define ('WP_DEBUG', false);".

= Puis-je utiliser un transporteur différent de Colissimo ? =

* Non pour le mode automatique (Web Service). Ainsi que pour les fonctions spécifiques comme point de retrait.
* Oui, c'est une possibilité pour le mode manuel et le mode personnalisé, pour la méthode de livraison, et pour les infos rendues au client. Toutefois, les données passées dans la passerelle respecteront les normes Colissimo (signature, montant du remboursement, ...).

= A quoi sert le paramètre "Nettoyage automatique des colis dans la passerelle Colissimo" des paramètres généraux? =

* La Metabox Colissimo des commandes WooCommerce sont automatiquement mises à jour des code de suivi et autres informations depuis la passerelle. Le commutateur d'état est positionner à "Dans le camion" dans la Metabox. Cependant, les paquets Colissimo présents dans la passerelle sont supprimés automatiquement après ces opérations, uniquement si le paramètre "Nettoyage automatique des colis dans la passerelle Colissimo" est activé. C’est le mode de fonctionnement recommandé.
* Ne pas positionner ce paramètre peut être toutefois utile lorsque l'administrateur souhaite gérer manuellement les colis par des sessions à sa main; Le nettoyage de la passerelle doit alors être effectué manuellement.




== Screenshots == 

1. CDI global architecture.
1. CDI parameters in Woocommerce settings panel.
1. Orders page of Woocommerce.
1. Colissimo box in order details panel.
1. Colissimo gateway panel.
1. Colissimo shipping settings (shipping methods).
1. Colissimo shipping settings (Points de livraison - Pickup location).
1. Checkout page with Pickup locations list.
1. Checkout page, zoom on a locations.

== Changelog == 

= 3.2.4 (2018-04-25) =
* Fix Correct HS tariff url
* Fix Suppress Dpl and Zpl formats in settings
* Fix virtual product compatibility in shipping method
* Some typo and fix

= 3.2.3 (2018-04-06) =
* Tweak Suppress screen_icon() warning
* Tweak Pdf-A4 format forced for all Return labels; more adapted for consumers
* CDI+ : Fix Sanitize Shipping address shown in gateway ckeck address box 
* CDI+ : Fix label Bulk printing in Gateway 
* CDI+ : Fix format Pdf-10x15 Bulk printing in Gateway 
* Some typo and fix

= 3.2.2 (2018-04-04) =
* Tweak Avoid woocommerce crashing when WooCommerce PDF Invoices & Packing Slips used
* CDI+ : Fix label Bulk printing in Gateway (keep A4 and rotate pdf)
* CDI+ : Add Option to select pickup by click on map
* CDI+ : Add Option to choose map location in checkout page

= 3.2.1 (2018-03-29) =
* Fix Fatal error WC-Frontend-Colissimo

= 3.2.0 (2018-03-29) =
* Fix Warning non-numeric value for product without weight
* Fix Content-Disposition and Content-Type for pdf
* CDI+ : Fix Content-Disposition and Content-Type for bulk pdf
* CDI+ : Add empty parcel weight option in shipping method 
* CDI+ : Add full Z10-011 standard (4 lines address) in Woocommerce
* CDI+ : Add Order preview in gateway
* CDI+ : Add CDI Metabox preview in gateway
* CDI+ : Add LaPoste address check/update in gateway
* Some typo and fix

= 3.1.0 (2018-03-11) =
* Fix Auto protect if FPDF class already exist
* CDI+ : Typo and fix 

= 3.0.0 (2018-03-06) =
* Tweak Optimizing  secondary key lenght in cdi table
* Add Ftd (Outre-mer) parameter
* Add Return-receipt parameter
* Add Order private status capacity to update CDI Metabox from gateway (new filter)
* Tweak Control pattern on sender zipcode
* Add Option setting to refresh GMap in checkout
* Tweak Checkout idle status change from 20s to 300s
* Add More settings available for string translation
* Add Examples for insurances
* Add Example for order private status
* Add Order customer message in gateway outputs
* Fix Css adaptation with WC 3.3.1
* Fix Shipping icon display in cart and checkout
* CDI+ : Start of the new option 
* CDI+ : Premium support for CDI+ registered users
* CDI+ : Colissimo shipping methods can be selected or excluded with WC Promo codes 
* CDI+ : Customizable extended Termid list for Colissimo shipping method
* CDI+ : Gateway view of attached pdf label and cn23 (and no more from url)
* CDI+ : Bulk printing of label and CN23 in process in the gateway
* CDI+ : Export csv of parcels in process in gateway
* CDI+ : Export csv history of parcels already send 
* CDI+ : Online postal tracking in CDI Metabox
* CDI+ : Extend WC customer address to 4 lines postal standarts (beta)
* Some typo and fix
