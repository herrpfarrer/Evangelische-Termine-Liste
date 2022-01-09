<?php
/**
 * Helper class für Modul Evangelische Termine Teaser
 */
namespace EvangelischeTermine\Module\EvangelischeTermineListe\Site\Helper;

defined('_JEXEC') or die;

// Benötigt, um CSS-Dateien und JavaScript aus ET-Output in den Header der Joomla-Seite zu schreiben
use Joomla\CMS\Factory;
 
class GetListeHelper
{

	private static function setSessionVar($key, $sess, $default = NULL) {
		if( $_REQUEST[$key] != ''){		// leere Strings werden ignoriert
			$sess->{$key} = $_REQUEST[$key];
			if($key != 'pageID'){
				$sess->pageID = 1;
			}
		} else {
			if ($key == 'date'){       // leere Datumstrings dürfen nicht ignoriert werden, weil sich sonst ein einmal eingegebenes Datum nicht löschen lässt
				$sess->{$key} = '';
			}
		}
		if($sess->{$key} == ''){
			$sess->{$key} = $default;
		}
	}
	
	private static function resetSessionVars($sess, $defaults){
		$sess->vid = $defaults['vid'];
		$sess->eventtype = $defaults['eventtype'];
		$sess->highlight = $defaults['highlight'];
		$sess->people = $defaults['people'];
		$sess->pageID = 1;
		$sess->et_q = '';
		$sess->itemsPerPage = $defaults['itemsPerPage'];
		$sess->date = '';
	}

    public static function getListe($params)
    {
		// =========================
		// E I N S T E L L U N G E N
		// =========================
	
	
	
		// A. MODUL-EINSTELLUNGEN
		// ======================
		
		// Zeichenkodierung
		// Passen Sie die Zeichenkodierung des Moduls der Zeichenkodierung Ihrer Webseite an. Unterstützt werden 'latin-1 (ISO 8859-1)' und 'utf8'.
		$encoding = $params->get('encoding');
		if($encoding == '' || $encoding == 'utf8'){
			$encoding = 'utf8';
			$encodingXML = 'utf8';
		} elseif ($encoding == 'latin-1'){
			$encodingXML = 'ISO 8859-1';
		}
		
		// Font-Awesome
		// Falls Sie Font-Awesome nicht installiert haben, geben Sie einen Pfad zur Datei 'font-awesome.css' oder 'font-awesome.min.css' auf einem anderen Server an (z.B. 'https://www.evangelische-termine.de/bundles/vket/css/font-awesome.min.css').
		$fa = $params->get('fa');
		
		// Moderne Funktion 'In Zwischenablage kopieren'
		// Der von Evangelische Termine verwendete JavaScript-Code der Funktion 'In Zwischenablage kopieren' ist veraltet. Soll stattdessen eine moderne Alternative benutzt werden? (Es sollte nur 'nein' ausgewählt werden, wenn die moderne Alternative nicht funktionieren sollte.)
		$bettercopyURL = $params->get('bettercopyURL');
		if($bettercopyURL == ''){
			$bettercopyURL = 'true';
		}

		
		
		// B. KALENDEREINSTELLUNGEN
		// ========================
 
		// Veranstalter-ID
		// Geben Sie hier Ihre Veranstalter-ID von www.evangelische-termine.de ein. Mehrere IDs können durch Komma getrennt angegeben werden.
		// Für die Dekanatsausgabe geben Sie als Veranstalter-ID 'all' ein.
		$veranstalterID = $params->get('veranstalterid');
		if($veranstalterID == ''){
			$veranstalterID = '2220';
		}

		// Dekanats-Nummer
		// Für die Dekanatsausgabe geben Sie hier Ihre 3-stellige Dekanatsnummer ein. Denken Sie daran, als Veranstalter-ID 'all' einzugeben.
		// Mehrere Dekanatsnummern können durch Kommata getrennt angegeben werden.
		$region = $params->get('dekanatsnummer');

		// Anzahl
		// Wie viele Veranstaltungen sollen pro Seite angezeigt werden?
		$itemsPerPage = $params->get('itemsperpage');
		if($itemsPerPage == ''){
			$itemsPerPage = '20';
		}

		// Nur Highlights?
		// Sollen nur Highlights oder alle Veranstaltungen angezeigt werden?
		$highlight = $params->get('highlights');
		if($highlight == ''){
			$highlight = 'all';
		}

		// Kategorien
		// Legen Sie fest, welche Kategorien berücksichtigt werden sollen:
		//	all => alle 
		//	1 => Gottesdienste
		//	2 => Gruppen / Kreise
		//	3 => Fortbildungen / Seminare / Vorträge
		//	4 => Konzerte / Theater / Musik
		//	5 => Freizeiten / Reisen
		//	6 => Ausstellungen / Kunst
		//	7 => Feste / Feiern
		//	8 => Sport/Spiel
		//	9 => Sonstiges
		//	Ein vorangestelltes '-' negiert die Auswahl, z.B. -1 => alles außer Gottesdienste. 
		//	Mehrere Kategorien können durch Komma getrennt angegeben werden (=ODER Verknüpfung).
        //  Mehrere Kategorien können durch Punkt getrennt angegeben werden (= UND Verknüpfung).
		$eventtype = $params->get('eventtype');
		if ($eventtype == ''){
			$eventtype =='all';
		}


		// Zielgruppe
		// Legen Sie fest, welche Zielgruppen berücksichtigt werden sollen:
        //  0 => Alle
        //  5 => Kinder
        //  40 => Konfirmanden
        //  10 => Jugendliche
        //  15 => Junge Erwachsene
        //  16 => Frauen
        //  17 => Männer
        //  20 => Familien
        //  25 => Erwachsene
        //  30 => Senioren
        //  35 => besondere Zielgruppe
        //  Mehrere Zielgruppen können durch Komma getrennt angegeben werden.
		$people = $params->get('people');
		if($people == ''){
			$people = 'all';
		}

		// Veranstaltungsort
		// ID des Veranstaltungsortes. Mehrere Veranstaltungsorte können durch Komma getrennt angegeben werden. 'all' für alle Veranstaltungsorte eingeben.
		$place = $params->get('place');
		if($place == ''){
			$place = 'all';
		}

		// Ansprechpartner
		// ID des Ansprechpartners. Mehrere Ansprechpartner können durch Komma getrennt angegeben werden. 'all' für alle Ansprechpartner eingeben.
		$person = $params->get('person');
		if($person == ''){
			$person = 'all';
		}

		// Veranstaltungstyp
		// ID des Veranstaltungstyps. Mehrere Veranstaltungstypen können mit Komma getrennt angegeben werden. 'all' für alle Veranstaltungstypen eingeben.
		$ipm = $params->get('ipm');
		if($ipm == ''){
			$ipm = 'all';
		}

		// Kanal
		// ID des Kanals. Mehrere Kanäle können mit Komma getrennt angegeben werden. 'all' für alle Kanäle eingeben.
		$cha = $params->get('cha');
		if($$cha == ''){
			$cha = 'all';
		}

        // URL-Parameter?
		// Sollen die in den Moduleinstellungen angegebenen Parameter durch URL-Parameterüberschrieben werden können?
		// Falls Sie ja auswählen, stehen Ihnen folgende URL-Parameter zur Verfügung: 
		//	vidIMP => überschreibt die Veranstalter-ID (z.B. '&vidIMP=25')
		//	regionIMP => überschreibt die Dekanats-Nummer (z.B. '&regionIMP='201')
		//	itemsPerPageIMP => überschreibt die Angaben für angezeigte Veranstaltungen pro Seite (z.B. '&itemsPerPageIMP=10')
		//	highlightIMP => überschreibt die Angaben für Higlights (z.B. '&highlightIMP=high')
		// 	eventtypeIMP => überschreibt die Katergorie (z.B. '&eventtypeIMP=-1')
		//	placeIMP => überschreibt die Angaben für Veranstaltungsorte (z.B. '&placeIMP=45,32')
		//	peopleIMP => überschreibt die Angaben für Zielgruppen  (z.B. '&peopleIMP=25')
		//	personIMP => überschreibt die Angaben für Ansprechpartnr (z.B. '&personIMP=568'))
		//	ipmIMP => überschreibt die Angaben für Veranstaltungstypen (z.B. '&ipmIMP=60')
		//	chaIMP => überschreibt die Angaben für Kanäle (z.B. '&chaIMP=2')
		// Bitte beachten Sie, dass Sie zusätzlich den Parameter '&override=true' anhängen müssen!
		// Ihre URL könnte so aussehen: '&eventtypeIMP=1&placeIMP=13&itemsPerPageIMP=5&override=true'
		
		$urlparams = array('vidIMP','regionIMP','itemsPerPageIMP','highlightIMP','eventtypeIMP','placeIMP','peopleIMP',
						'personIMP','ipmIMP','chaIMP');
		
		$urlparam = $params->get('urlparam');
		if ($urlparam==''){
			$urlparam='true';
		}
		if ($urlparam=='true'){
			
			$reset = filter_var($_GET['override'], FILTER_SANITIZE_STRING);
			if ($reset==''){
				$reset='false';
			}			
			
			$veranstalterIDIMP = filter_var($_GET['vidIMP'], FILTER_SANITIZE_STRING);
			if ($veranstalterIDIMP != ''){
				$veranstalterID = $veranstalterIDIMP;
			}		
			$regionIMP = filter_var($_GET['regionIMP'], FILTER_SANITIZE_STRING);
			if ($regionIMP  != ''){
				$region = $regionIMP;
			}		
			$itemsPerPageIMP = filter_var($_GET['itemsPerPageIMP'], FILTER_SANITIZE_STRING);
			if ($itemsPerPageIMP  != ''){
				$itemsPerPage = $itemsPerPageIMP;
			}
			$highlightIMP = filter_var($_GET['highlightIMP'], FILTER_SANITIZE_STRING);
			if ($highlightIMP  != ''){
				$highlight = $highlightIMP;
			}
			$eventtypeIMP = filter_var($_GET['eventtypeIMP'], FILTER_SANITIZE_STRING);
			if ($eventtypeIMP != ''){
				$eventtype = $eventtypeIMP;
			}			
			$placeIMP = filter_var($_GET['placeIMP'], FILTER_SANITIZE_STRING);
			if ($placeIMP != ''){
				$place = $placeIMP;
			}	
			$peopleIMP = filter_var($_GET['peopleIMP'], FILTER_SANITIZE_STRING);
			if ($peopleIMP != ''){
				$people = $peopleIMP;
			}
			$personIMP = filter_var($_GET['personIMP'], FILTER_SANITIZE_STRING);
			if ($personIMP != ''){
				$person = $personIMP;
			}
			$ipmIMP = filter_var($_GET['ipmIMP'], FILTER_SANITIZE_STRING);
			if ($ipmIMP != ''){
				$ipm = $ipmIMP;
			}
			$chaIMP = filter_var($_GET['chaIMP'], FILTER_SANITIZE_STRING);
			if ($chaIMP != ''){
				$cha = $chaIMP;
			}
		}


		// C. LAYOUTEINSTELLUNGEN
		// ======================
		
		
		//  C1. Allgemeine Layouteinstellungen
		// = = = = = = = = = = = = = = = = = = =
		
		// HTML-Tag der Überschrift
		// Welches HTML-Tag soll die Überschrift erhalten? Achtung: Sie formatieren die Überschrift innerhalb des Moduls (z.B. 'Veranstaltungen' oder 'Gottesdienst am Altjahresabend'), nicht die Überschrift des Moduls (siehe dazu im Registertab 'Erweitert' die Einstellung 'Header-Tag').
		$headlinetag = $params->get('headlinetag');
		if ($headlinetag == '' ){
			$headlinetag = 'h2';
		}
		
		// Custom-CSS
		// Passen Sie das aussehen des Moduls mit Hilfe von individuellem CSS-Code an.
		$customstyle = $params->get('customstyle');		
		
		
		//  C2. Layouteinstellungen für Übersichtsseite/Liste
		// = = = = = = = = = = = = = = = = = = = = = = = = = = 
		
		// Zeige Highlights?
		// Soll die Eingabe- bzw. Filtermethode 'Highlights' angezeigt werden?
		$showhighlight = $params->get('showhighlight');
		if ($showhighlight == '' ){
			$showhighlight = 'true';
		}

		// Zeige Kategorien?
		// Soll die Eingabe- bzw. Filtermethode 'Kategorien' angezeigt werden?
		$showeventtype = $params->get('showeventtype');
		if ($showeventtype == '' ){
			$showeventtype = 'true';
		}

		// Zeige Zielgruppen?
		// Soll die Eingabe- bzw. Filtermethode 'Zielgruppen' angezeigt werden?
		$showpeople = $params->get('showpeople');
		if ($showpeople == '' ){
			$showpeople = 'true';
		}

		// Zeige Suche?
		// Soll ein Suchfeld angezeigt werden?
		$showsearch = $params->get('showsearch');
		if ($showsearch == '' ){
			$showsearch = 'true';
		}

		// Zeige Datumsauswahl?
		// Soll Kalenderfeld angezeigt werden, mit dem ein Datum ausgewählt werden kann?
		$showdate = $params->get('showdate');
		if ($showdate == '' ){
			$showdate = 'true';
		}

		// Zeige Auswahl 'Ergebnisse pro Seite'?
		// Soll ein Feld angezeigt werden, mit dem ausgewählt werden kann, wie viele Termine/Suchergebnisse pro Seite angezeigt werden sollen?
		$showipp= $params->get('showipp');
		if ($showipp == '' ){
			$showipp = 'true';
		}
		
		
		//  C3 Layouteinstellungen für Detailseite
		// = = = = = = = = = = = = = = = = = = = = =
		
		// Überschrift in Detailansicht ersetzen?
		// Soll die Überschrift in der Detailansicht durch eine Überschrift ohne Spaltenformat ersetzt werden?
		$replaceheader = $params->get('replaceheader');
		if ($replaceheader == '' ){
			$replaceheader = 'true';
		}
	
		// E-Mail-Adresse verschleiern?
		// Joomla verschleiert standardmäßig E-Mail-Adressen. Dadurch wird der Output von Evangelische Termine korrumpiert und die Seite nicht richtig angezeigt.
		// Um das zu verhindern, ersetzt dieses Modul standardmäßig die korrumpierte E-Mail-Adresse im betroffenen JSON-LD-Feld durch einen leeren String.
		// Wenn Sie die E-Mail-Adresse stattdessen behalten wollen, muss das Verschleiern der Adresse auf der betroffenen Seite deaktiviert werden.
		$usecloak = $params->get('usecloak');
		if ($usecloak == '' ){
			$usecloak = 'true';
		}

		// Zeige Button 'Zurück'?
		// Soll ein Button eingeblendet werden, mit dem man zurück zur Terminübersicht gelangt? Der Button entspricht dem Klick auf den 'Zurück'-Button im Browser.
		$showback = $params->get('showback');
		if ($showback == '' ){
			$showback = 'false';
		}
		
		// Zeige 'In eigenen Kalender übernehmen'?
		// Soll ein Icon für den Download einer Kalenderdatei im ical-Format angezeigt werden?
		$showical = $params->get('showical');
		if ($showical == '' ){
			$showical = 'true';
		}
		
		// Zeige 'Per E-Mail einladen'?
		// Soll ein Icon angezeigt werden, das zu einer Seite führt, von der aus der Termin via E-Mail an andere mitgeteilt werden kann?
		$showmail = $params->get('showmail');
		if ($showmail == '' ){
			$showmail = 'false';
		}
		
		// Zeige 'Auf Facebook teilen'?
		// Soll ein Icon angezeigt werden, das zu Facebook führt, wo die Veranstaltung geteilt werden kann?
		$showfb = $params->get('showfb');
		if ($showfb == '' ){
			$showfb = 'true';
		}
		
		// Zeige 'Auf Twitter teilen'?
		// Soll ein Icon angezeigt werden, das zu Twitter führt, wo die Veranstaltung geteilt werden kann?
		$showtw = $params->get('showtw');
		if ($showtw == '' ){
			$showtw = 'true';
		}
		
		// Zeige 'In Zwischenablage kopieren'?
		// Soll ein Icon angezeigt werden, das die URL der Veranstaltung per Klick in die Zwischenablage kopiert?
		$showcopy = $params->get('showcopy');
		if ($showcopy == '' ){
			$showcopy = 'true';
		}
		
		// Zeige 'Seite Drucken'?
		// Soll ein Icon angezeigt werden, mit dem per Klick die Funktion 'Seite Drucken' aufgerufen werden kann?
		$showprint = $params->get('showprint');
		if ($showprint == '' ){
			$showprint = 'false';
		}



		// ==========================================================================
		// K O M M U N I K A TI O N   M I T   E V A N G E L I S C H E   T E R M I N E
		// ==========================================================================
		
				 
		// Vorbelegungen beim ersten Aufruf
		$ET_defaults = array(
			'vid' =>  $veranstalterID,
			'region' => $region,
			'aid' => $aid,
			'eventtype' => $eventtype,
			'highlight' => $highlight,
			'people' => $people,
			'itemsPerPage' => $itemsPerPage,
			'place' => $place,
			'person' => $person,
			'ipm' => $ipm,
			'cha' => $cha,
			'until' => 'yes',
			'css' => ''
		);
		
		
		session_start();
		if(!isset($_SESSION['session'])) {
			$session = new \stdClass;    
			$_SESSION['session'] = $session;
		} else {
			$session = $_SESSION['session'];
		}  
 
 
		// Reset Session, falls Seite mit URL-Parametern aufgerufen wurde
		if ( $reset == 'true' ){
			self::resetSessionVars($session, $ET_defaults);
		}

		 
		if($_REQUEST['reset'] == '1'){
			self::resetSessionVars($session, $ET_defaults);
		} else {
			self::setSessionVar('vid', $session ,$ET_defaults['vid']);
			self::setSessionVar('region', $session ,$ET_defaults['region']);
			self::setSessionVar('aid', $session ,$ET_defaults['aid']);
			self::setSessionVar('date', $session ,'');
			self::setSessionVar('eventtype', $session , $ET_defaults['eventtype']);
			self::setSessionVar('highlight', $session , $ET_defaults['highlight']);
			self::setSessionVar('people', $session ,$ET_defaults['people']);
			self::setSessionVar('itemsPerPage', $session ,$ET_defaults['itemsPerPage']);
			self::setSessionVar('pageID', $session ,'1');
			 
			if($_REQUEST['et_q'] != ''){
				$session->et_q = $_REQUEST['et_q'];
				if($_REQUEST['reset'] == '1'){
					$session->et_q = '';
				}
			} else {
				if($_REQUEST['action'] == 'search'){
					$session->et_q = '';
				}
			}
		}
		
		
		$queryString =  'vid=' . $session->vid .
						'&region=' . $session->region .
						'&aid=' . $session->aid .
						'&date='.$session->date .
						'&highlight=' . $session->highlight .
						'&eventtype=' . $session->eventtype .
						'&people=' . $session->people .
						'&et_q=' . $session->et_q .
						'&place=' . $ET_defaults['place'] .
						'&person=' . $ET_defaults['person'] .
						'&ipm=' . $ET_defaults['ipm'] .
						'&cha=' . $ET_defaults['cha'] .
						'&until=' . $ET_defaults['until'] .
						'&itemsPerPage='.$session->itemsPerPage .
						'&pageID='.$session->pageID . 
						'&encoding=' . $encoding.
						'&css=' . $ET_defaults['css'] ;


		$etVars = array('vid','region','aid','date','highlight','eventtype','people','et_q','place',
						'person','ipm','cha','until','itemsPerPage','pageID','encoding','css','etID','action',session_name(),'_token','reset');
		foreach($_REQUEST as $key => $val){
			if(!in_array($key,$etVars) && $key!='override'){
				// Der URL-Parameter 'override' darf nur Teil der URL beim ersten Aufruf der Seite sein. Der URL-Parameter legt dann fest, dass die gesetzten Parameter überschrieben werden.
				// Der URL-Parameter muss aus allen weiteren URLs gelöscht werden, da er sonst immer die vom Nutzer geänderten Parameter überschreibt.
				$queryString .= '&' . $key . '='. $val;
			}
		}
		$filename = 'veranstaltungen-php';
		if ($_GET['etID'] != '') {
			$queryString .= '&ID='. $_GET['etID'];
			$filename = 'detail-php';
		}
		$host = 'evangelische-termine.de';
		$url =  "https://$host/$filename?$queryString"; //http!
		 
		 
		if(function_exists('curl_init')){
			$sobl = curl_init($url);
			curl_setopt($sobl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($sobl, CURLOPT_USERAGENT, 'Veranstalter-Script 2.0');
			curl_setopt($sobl, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
			curl_setopt($sobl, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($sobl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
			$pageContent = curl_exec ($sobl);
			$sobl_info = curl_getinfo ( $sobl);
			if($sobl_info['http_code'] == '200'){
				$pageContent = str_replace("/Upload/","https://$host/Upload/",$pageContent); //http!
				$pageContent = str_replace("http://_HOST_/","https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] ,$pageContent);	//http!
        
			} else {
				# Fehlermeldung:
				$liste = '<div>Der Veranstaltungskalender ist derzeit nicht verfügbar.</div>';
			}
		} else {
			# Fehlermeldung:
			$liste = '<div>Das benötigte PHP-Modul curl ist nicht installiert.</div>';   
		}



		// ======================================================================================
		// O U T P U T   V O N    E V A N G E L I S C H E   T E R M I N E   F O R M A T I E R E N
		// ======================================================================================

		if (isset($pageContent)){

			$dom = new \DOMDocument();
			$dom->loadHTML('<?xml encoding="' . $encodingXML . '" ?>' . $pageContent);

			// A. ALLGEMEINE FORMATIERUNGEN
			// ============================
			
			
			// Tausche das Präfix der Klassen aller div-, span, a- und button-Elemente von 'et_' zu 'et_liste'
			// und das Präfix der IDs aller div- und span--Elemente von 'et_' zu 'et_liste',
			// um die Elemente einfach unabhängig von anderen ET-Implementierungen (z.B. ET Teaser) in CSS formatieren zu können
			foreach($dom->getElementsByTagName('*') as $element ){
				$tagname = $element->nodeName;
				$classname = $element->getAttribute('class');
				if (($tagname=='div' || $tagname=='span' || $tagname =='a' || $tagname == 'button') && $classname !=''){
					if (substr($classname,0,3)=='et_'){
						$classname = str_replace('et_', 'etliste_', $classname);
					} else {
						$classname = str_replace(' ', ' etliste_', $classname);
						$classname = 'etliste_' . $classname;
					}
					$element->setAttribute('class', $classname);
				}
				$idname = $element->getAttribute('id');
				if (($tagname=='div' || $tagname=='span') && $idname !=''){
					if (substr($idname,0,3)=='et_'){
						$idname = str_replace('et_', 'etliste_', $idname);
					} else {
						$idname = str_replace(' ', ' etliste_', $idname);
						$idname = 'etliste_' . $idname;
					}
					$element->setAttribute('id', $idname);
				}
			}
			

			// Ersetze Überschriften-Tag
			$headingsList = $dom->getElementsByTagName('h1');
			for ($indexHeadings = $headingsList->length - 1; $indexHeadings >= 0; $indexHeadings --) {
				$oldHeading = $headingsList->item($indexHeadings);
				$newHeading = $dom->createElement($headlinetag, $oldHeading->nodeValue);
				foreach ($oldHeading->attributes as $attr) {
					$newHeading->setAttribute($attr->nodeName,$attr->nodeValue);
				}
				$oldHeading->parentNode->replaceChild($newHeading, $oldHeading);
			}			
			
			
			// Ermittle alle mitgelieferten CSS-Files, um sie später an den Header der Joomla-Seite zu übergeben
			$linkList = $dom->getElementsByTagName('link');
			foreach ($linkList as $linknode) {
				$href = $linknode->getAttribute('href');
				if (!str_contains($href,'publicintegration.css')){	// Ignoriere das CSS-File 'publicintegration.css', das von Evangelische Termine ausgeliefert wird, da eigene Formatierungen sonst nur mit dem Zusatz '!important' möglich sind.
					$linksCSS[]=$href;
				}
			}


			// Ermittle alle mitgelieferten Script-Files, um sie später an den Header der Joomla-Seite zu übergeben
			$scriptList = $dom->getElementsByTagName('script');
			foreach ($scriptList as $scriptnode) {
				$src = $scriptnode->getAttribute('src');
				if (isset($src)){
					if ($src != ''){
						$srcScripts[]=$src;
					} else {
						$textScripts[] = $scriptnode->nodeValue;
					}
				}
			}

					
					
			// B. ÜBERSICHTSSEITE/LISTE FORMATIEREN
			// ====================================
			
			if ($_GET['etID'] == '') {
			
			
				//  B1. Füge aktuellen Suchbegriff in Suchfeld ein
				// = = = = = = = = = = = = = = = = = = = = = = = = =
				if ($_REQUEST['et_q'] != '' && $_REQUEST['reset'] != '1') {
					$inputfield = $dom->getElementById('et_q');
					$inputfield->setAttribute('value', $_REQUEST['et_q']);
				}

								
				//  B2. Zeige nur die ausgewählten Eingabe- und Filtermethoden an
				// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
				
				// Falls gar keine Filtermethode angezeigt werden soll, lösche das übergeordnete div aller Filter ('etliste_filter_container')
				if ($showhighlight == 'false' && $showeventtype == 'false' && $showpeople == 'false' && $showsearch == 'false' && $showdate == 'false' && $showipp == 'false'){
					$div_filter_container = $dom->getElementById('etliste_filter_container');
					if (isset($div_filter_container)){
						$div_filter_container->parentNode->removeChild($div_filter_container);
					}
				} else {
					
					$divList = $dom->getElementsByTagName('div');

					// Falls Highlights, Kategorien und Zielgruppen nicht angezeigt werden sollen, lösche ihr übergeordnetes div ('etliste_filter_block_left')
					if ($showhighlight == 'false' && $showeventtype == 'false' && $showpeople == 'false') {
						foreach ($divList as $div) {
							if ($div->getAttribute('class')=='etliste_filter_block_left'){
								$div->parentNode->removeChild($div);
							}
						}	
					} else {
					// Ansonsten lösche nur die einzelnen divs
						// ACHTUNG: '->parentNode' funktioniert nicht für 'form field'-Elemente wie '<input>' oder '<select>'. parentNode ist immer Null!
						// Aber wir kennen die Reihenfolge der div-Elemente und wissen welches div welches form field enthält.
						// Also können wir sie einfach zählen und die Nummern löschen, die wir nicht wollen.
						$i_filters = 0;
						foreach ($divList as $div) {
							if ($div->getAttribute('class')=='etliste_filter_row_left'){
								$arr_filter_row_left[$i_filters] = $div;
								$i_filters += 1;
							}
						}		
						if ($showhighlight == 'false'){
							$arr_filter_row_left[0]->parentNode->removeChild($arr_filter_row_left[0]);
						}
						if ($showeventtype == 'false'){
							$arr_filter_row_left[1]->parentNode->removeChild($arr_filter_row_left[1]);
						}
						if ($showpeople == 'false'){
							$arr_filter_row_left[2]->parentNode->removeChild($arr_filter_row_left[2]);
						}
					}
					
					// Falls Suchbegriff, Datumsauswahl und 'Ergebnisse pro Seite' nicht angezeigt werden sollen, lösche ihr übergeordnetes div ('etliste_filter_block_right')
					if ($showsearch == 'false' && $showdate == 'false' && $showipp == 'false') {
						foreach ($divList as $div) {
							if ($div->getAttribute('class')=='etliste_filter_block_right'){
								$div->parentNode->removeChild($div);
							}
						}
					} else {
					// Ansonsten lösche nur die einzelnen divs (zur umständlichen Methode siehe zwei Kommenatre weiter oben)
						$i_filters = 0;
						foreach ($divList as $div) {
							if ($div->getAttribute('class')=='etliste_filter_row_right'){
								$arr_filter_row_right[$i_filters] = $div;
								$i_filters += 1;
							}
						}
						if ($showsearch == 'false'){
							$arr_filter_row_right[0]->parentNode->removeChild($arr_filter_row_right[0]);
						}
						if ($showdate == 'false'){
							$arr_filter_row_right[1]->parentNode->removeChild($arr_filter_row_right[1]);
						}
						if ($showipp == 'false'){
							$arr_filter_row_right[2]->parentNode->removeChild($arr_filter_row_right[2]);
						}
					}
				}


				//  B3. Ergänze Kategorie 'Außer Gottesdienste'
				// = = = = = = = = = = = = = = = = = = = = = = =
				$eventtypenode = $dom->getElementById('eventtype');
				$aussergdnode = $dom->createElement('option', 'Außer Gottesdienste');
				$aussergdnode->setAttribute('value','-1');
				$eventtypenode->insertBefore($aussergdnode, $eventtypenode->firstChild->nextSibling);
				if ($session->eventtype == '-1') {
					// Mache 'Außer Gotesdienste' zum ausgewählten Element
					foreach ($eventtypenode->childNodes as $node){
						$node->removeAttribute('selected');
					}
					$aussergdnode->setAttribute('selected','selected');
					// Ergänze Überschrift
					$headingsList = $dom->getElementsByTagName($headlinetag);
					foreach ($headingsList  as $headingnode){
						$headingnode->nodeValue = 'Außer Gottesdienste';
					}					
				}
				
				
			} else {
				
				
			// C. DETAILSEITE/EINZELTERMIN FORMATIEREN
			// =======================================
			
			
				//  C1. ÜBERSCHRIFT OHNE SPALTENFORMAT
				// = = = = = = = = = = = = = = = = = = =
				
				if($replaceheader=='true'){
					
					// Ermittle Veranstaltungsname (=Überschrift)
					$detailtitleelement = $dom->getElementById('et_detail_title');
					if (isset($detailtitleelement)) {
						$detailtitle = $detailtitleelement->nodeValue;
						$parentNode = $detailtitleelement->parentNode->parentNode;
					} else {
						$detailtitle = 'Veranstaltung';
					}
					$titlenode = $dom->createElement($headlinetag, $detailtitle);
					$titlenode->setAttribute('id','etliste_detail_title');
					
					// Ermittle Datum und Uhrzeit (=Unterüberschrift)
					$detaildateelement = $dom->getElementById('etliste_detail_date');
					if (isset($detaildateelement)) {
						if ($detaildateelement->hasChildNodes()){
							$dataildatename = trim($detaildateelement->childNodes->item(1)->nodeValue);
							$dataildatename = str_replace('(','/ ',$dataildatename); // Ersetze Klammern durch Schrägstriche
							$dataildatename = str_replace(')','',$dataildatename);
							$detaildate = trim($detaildateelement->firstChild->nodeValue);
							if ($dataildatename!=''){
								$detaildate .= ' (' . $dataildatename . ')';
							}
						}else{
							$detaildate = trim($detaildateelement->nodeValue);
						}
						if (!isset($parentNode)){
							$parentNode = $detaildateelement->parentNode->parentNode;
						}
					}
					if (isset($detaildate)) {
						$detaildatenode = $dom->createElement('h3', $detaildate);
						$detaildatenode->setAttribute('id','etliste_detail_date');
					}

					// Lösche <div> der ursprünglichen Überschrift
					if (isset($parentNode)) {
						$parentNode->parentNode->removeChild($parentNode);
					}
					
					// Füge neues <div> mit neuer Überschrift hinzu
					$newheadlinediv = $dom->createElement('div', '');
					$newheadlinediv->setAttribute('id','etliste_headline');
					$newheadlinediv->appendChild($titlenode);
					if (isset($detaildatenode)){
						$newheadlinediv->appendChild($detaildatenode);
					}
					
					$headerdiv = $dom->getElementById('etliste_detail_header');
					if (isset($headerdiv)){
						$headerdiv->insertBefore($newheadlinediv,$headerdiv->childNodes->item(0));
					}
				}
			
			
				//  C2. Umgang mit Cloak / Korruptes JSON-LD reparieren
				// = = = = = = = = = = = = = = = = = = = = = = = = = = =
				if ($usecloak == 'true'){
					$scriptList = $dom->getElementsByTagName('script');
					foreach($scriptList as $scriptnode){
						if ($scriptnode->getAttribute('type')=='application/ld+json'){
							$scriptnodevalue = $scriptnode->nodeValue;
							$startpos = strpos($scriptnodevalue, '"email":"');
							$endpos = strpos($scriptnodevalue, '","address"', $startpos);
							$email = substr($scriptnodevalue, $startpos, $endpos - $startpos);
							$scriptnodevalue = str_replace($email,'"email":"',$scriptnodevalue);
							$scriptnode->nodeValue = $scriptnodevalue;
							$setcloak='';
						}
					}
				} else{
					$setcloak = '{emailcloak=off} ';
				}

				
				//  C3. Nur ausgewählte Sharefuctions anzeigen
				// = = = = = = = = = = = = = = = = = = = = = = =
				$divList = $dom->getElementsByTagName('div');
				foreach ($divList as $div) {
					$class = $div->getAttribute('class');
					if ($class=='etliste_sharefunctions'){
						$sharelinkcontainer = $div;
						
						$sharelinkList = $sharelinkcontainer->getElementsByTagName('a');
						$newsharelinkcontainer = $dom->createElement('div', '');
						$newsharelinkcontainer->setAttribute('class','etliste_sharefunctions');
						
						if ($showical=='true'){
							$sharelinkArray['etfunc_ical']='etfunc_ical';
						}
						if ($showmail=='true'){
							$sharelinkArray['etfunc_email']='etfunc_email';
						}
						if ($showfb=='true'){
							$sharelinkArray['etfunc_fb']='etfunc_fb';
						}
						if ($showtw=='true'){
							$sharelinkArray['etfunc_tw']='etfunc_tw';
						}
						if ($showcopy=='true'){
							$sharelinkArray['etfunc_copy']='etfunc_copy';
						}
						if ($showprint=='true'){
							$sharelinkArray['etfunc_print']='etfunc_print';
						}
						
						$i = $sharelinkList->length - 1;
						while ($i >= 0) {
							
							$sharelinkdiv = $sharelinkList->item($i);
							$sharelinkid = $sharelinkdiv->getAttribute('id');

							if (isset($sharelinkArray)){
								if (in_array($sharelinkid, $sharelinkArray)) {
									if (!isset($prevsharelinkdiv)){
										$newsharelinkcontainer->appendChild($sharelinkdiv);	
									}else{
										$newsharelinkcontainer->insertBefore($sharelinkdiv,$prevsharelinkdiv);
									}
									$prevsharelinkdiv = $sharelinkdiv;
								}
							}
							
							$i--;
						}
						
						$sharelinkcontainer->parentNode->replaceChild($newsharelinkcontainer, $sharelinkcontainer);
						break;
					}
				}
				
				
				//  C4. Moderner Code für 'In Zwischenablage kopieren'
				// = = = = = = = = = = = = = = = = = = = = = = = = = = =
				if ($bettercopyURL == 'true'){
					$copylinkdiv = $dom->getElementById('etfunc_copy');
					$href = $copylinkdiv->getAttribute('data-href');
					$copylinkdiv->setAttribute('onclick','navigator.clipboard.writeText("'.$href.'").then(function(){alert("URL kopiert");},function(err){alert("URL nicht kopiert: ", err);});');
				}
				
				
				//  C5. Zeige 'Zurück'-Button 
				// = = = = = = = = = = = = = =
				if ($showback == 'false'){
					$divList = $dom->getElementsByTagName('div');
					$i = $divList->length - 1;
					while ($i >= 0) {
						$div = $divList->item($i);
						$class = $div->getAttribute('class');
						if ($class=='etliste_detail_backlink'){
							$div->parentNode->removeChild($div);
						}
						$i--;
					}
				}
			}
			
			
			// D. INTEGRATION IN JOOMLA-SEITE
			// ===============================
			
			//  D1. Nur <body>-Element ausgeben
			// = = = = = = = = = = = = = = = = =		
			// Evangelische Termine gibt ein komlettes HTML-File, inkl. <html>-, <head>- und <body>-Tag aus.
			// Für das Modul ET-Liste wird nur der Inhalt des <body>-Elements benötigt
			$body = $dom->getElementsByTagName('body')->item(0);
			$pageContent=$body->ownerDocument->saveHTML($body);
			$pageContent = str_replace('<body>', '', $pageContent);
			$pageContent = str_replace('</body>', '', $pageContent);
			$pageContent = '<!--Integrieren Sie Ihre Termine bei Evangelische Termine in Ihre Joomla-Seite mit dem Modul Evangelische Termine Liste.-->' . $pageContent . '<!-- Ende Modul Evangelische Termine Liste -->';
			$liste = $setcloak . $pageContent;
			
			
			//  D2. <head> der Joomlaseite anpassen
			// = = = = = = = = = = = = = = = = = = = 
			
			$jdocument = Factory::getDocument();
			
			// Ergänze Font-Awsome im Header der Joomla-Seite
			if ($fa != ''){
				$jdocument->addStyleSheet($fa);
			}
			
			// Ergänze Custom-CSS im Header der Joomla-Seite
			if ($customstyle != ''){
				$jdocument->addStyleDeclaration($customstyle);
			}		
			
			// Ergänze alle Style-Sheets, die von Evangelische Termine stammen
			// Style-Sheets, die im <head>-Breich des HTML-Files von Evangelische Termine standen, kommen in den <head>-Breich der Joomlaseite
			if (isset($linksCSS)){
				foreach ($linksCSS as $link){
					$jdocument->addStyleSheet($link);
				}
			}

			// Ergänze alle Scripts, die von Evangelische Termine stammen
			// Scripts, die im <head>-Breich des HTML-Files von Evangelische Termine standen, kommen in den <head>-Breich der Joomlaseite
			if (isset($srcScripts)){
				foreach ($srcScripts as $src){
					$jdocument->addScript($src);
				}
			}
			if (isset($textScripts)){
				foreach ($textScripts as $text){
					$jdocument->addScriptDeclaration($text);
				}
			}
			
		}

        //Debug-Information:
		// $liste .= "Akt. Kategorie: " . $session->eventtype . " Default-Kategorie" . $ET_defaults['eventtype'];
		
        return $liste;
    }
	
}