# Evangelische Termine Liste
Integrieren Sie Ihre Termine bei Evangelische Termine in Ihre Joomla-Seite mit dem Modul 'Evangelische Termine Liste'.
## Installation
1. Laden Sie die aktuelle Version des Moduls herunter (https://github.com/herrpfarrer/Evangelische-Termine-Liste/releases/latest/download/mod_etlistev1.0.zip). Sie brauchen die heruntergeladene Datei nicht zu entpacken.
2. Melden Sie sich auf Ihrer Joomla-Seite an.
3. Klicken Sie auf Erweiterungen -> Verwalten -> Installieren -> Paketdatei hochladen.
4. Ziehen Sie die .zip-Datei von Ihrem Download-Ordner in das Feld 'Dateien zum Hochladen hier hereinziehen und ablegen'.
5. Klicken Sie auf Erweiterungen -> Module -> Evangelische Termine Liste.
6. Geben Sie im Hauptbereich des Reiters 'Modul' Ihre Veranstalternummer von Evangelische Termine ein und wählen Sie aus, welche Termine angezeigt werden sollen.
7. Wählen Sie auf der rechten Seite des Reiters 'Modul' eine Position auf Ihrer Joomla-Seite aus an der das Modul erscheinen soll, z.B. eine Sidebar. Beachten Sie dazu unbedingt auch Punkt 8! 
8. Wählen Sie unter dem Reiter 'Menüzuweisung' aus, auf welchen Seiten das Modul tatsächlich angezeigt werden soll. Falls Sie die Standardeinstellung ('Auf keinen Seiten') beibehalten, wird das Modul nicht auf ihrer Joomla-Seite angezeigt.
9. Passen Sie unter dem Reiter 'Layout' das Aussehen des Moduls Ihren Bedürfnissen an.
10. Wählen Sie unter dem Reiter 'Erweitert' eine Zeichenkodierung aus. Die Zeichenkodierung des Moduls muss der Zeichenkodierung Ihrer Joomla-Seit entsprechen (i.d.R. 'UTF-8').
11. Falls Sie auf Ihrer Joomla-Seite nicht Font-Awesome installiert haben, geben Sie unter dem Reiter 'Erweitert' eine URL zu einer Font-Awesome-Installation an (z.B. https://www.evangelische-termine.de/bundles/vket/css/font-awesome.min.css).
12. Falls Sie das Modul mehrfach mit unterschiedlichen Terminen auf Ihrer Joomla-Seite anzeigen möchten, wählen Sie unter dem Reiter 'Erweitert' 'Ja, URL-Parameter zulassen' und machen Sie sich mit der Beschreibung der Einstellung 'URL-Parameter?' vertraut.

## Probleme, Fragen, Tipps
### Ich habe das Modul installiert, es wird aber auf meiner Joomla-Seite nicht angezeigt.
Stellen Sie sicher, dass Sie in den Einstellungen des Moduls unter dem Reiter 'Menüzuweisung' das Modul auch der entsprechenden Unterseite oder allen Seiten Ihrer Joomla-Seite zugewiesen haben.
### Wie kann ich das Modul in einen Beitrag einbetten?
Öffnen Sie den Beitrag, in den Sie das Modul einfügen wollen, im Editor. Unterhalb des Editors sollte der Button '+Modul' angezeigt werden. Klicken Sie auf den Button und wählen Sie das Modul 'Evangelische Termine Liste' aus.
### Mir gefällt die grüne Farbe nicht. Wie kann ich das Farbschema ändern?
Um die Farben zu ändern, öffnen Sie die Einstellungen des Moduls. Unter dem Reiter 'Layout' finden Sie das Textfeld 'Custom-CSS'. Hier können Sie einzelne oder alle Formate der mitgelieferten CSS-Datei https://github.com/herrpfarrer/Evangelische-Termine-Liste/blob/main/media/css/etliste.css überschreiben. Wenn Sie nur die Farben ändern wollen, kopieren Sie diesen Code in das Textfeld 'Custom-CSS' und passen Sie die jeweiligen Farben Ihren Wünschen an:
``#etliste_filter_container button{
	background-color:rgba(180,222,154,1);
	border-color:rgba(180,222,154,1);
	color:white;
}

#etliste_filter_container  button:hover{
	background-color:rgba(240,255,230,1);
	color:rgba(180,222,154,1);}

.warning {
	color:red;
	font-weight:bold;
}

  .etliste_filter_headline {
	background:#E6FFD7;
	background:-moz-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
	background:-webkit-gradient(linear, left top, right top, color-stop(0%, #E6FFD7), color-stop(100%, #B4DE9A));
	background:-webkit-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
	background:-o-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
	background:-ms-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
	background:linear-gradient(to right, #E6FFD7 0%, #B4DE9A 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#E6FFD7', endColorstr='#B4DE9A',GradientType=1 );
}

.etliste_filter_main {
	background-color:rgb(240, 255, 230);
}

.etliste_filter_block div,
.etliste_filter_block_left div,
.etliste_filter_block_right div {
	background:rgba(240,255,230,1);
}

#etliste_filter_container input[type=text] {
	border:1px solid #666;
}
  
.etliste_filter_subrow {
	background:rgba(240,255,230,1);
}


.etliste_content_row.odd {
  background:rgba(240,255,230,1);
}
    
.etliste_content_title a.etliste_link_title {
	color:#333;
}

.etliste_content_title a.etliste_link_title:hover {
	color:#000;
  }

.etliste_content_user {
	color:#666;
}
  
.etliste_gottesdienste,
.etliste_gottesdienste a.etliste_link_title,
.etliste_gottesdienste a.etliste_link_title:hover {
  color:rgba(201,2,29,1);
}

.etliste_monthbar {
  background:#E6FFD7;
  background:-moz-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
  background:-webkit-gradient(linear, left top, right top, color-stop(0%, #E6FFD7), color-stop(100%, #B4DE9A));
  background:-webkit-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
  background:-o-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
  background:-ms-linear-gradient(left, #E6FFD7 0%, #B4DE9A 100%);
  background:linear-gradient(to right, #E6FFD7 0%, #B4DE9A 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#E6FFD7', endColorstr='#B4DE9A',GradientType=1 );
}

.etliste_content_detaillabel {
	color:#555;
}

.etliste_user {
	border-top:1px dotted #999;
}

#footer {
	color:#999;
}

#footer a {
	color:#999;
  }


.etliste_light-theme a, .etliste_light-theme span {
	color:#666;
	border:1px solid #BBB;
	box-shadow:0 1px 2px rgba(0,0,0,0.2);
	background:#efefef; 
	background:-moz-linear-gradient(top, #ffffff 0%, #efefef 100%); 
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#efefef)); 
	background:-webkit-linear-gradient(top, #ffffff 0%,#efefef 100%); 
	background:-o-linear-gradient(top, #ffffff 0%,#efefef 100%); 
	background:-ms-linear-gradient(top, #ffffff 0%,#efefef 100%); 
	background:linear-gradient(top, #ffffff 0%,#efefef 100%); 
}

.etliste_light-theme a:hover {
	background:#FCFCFC; 
}

.etliste_light-theme .etliste_current {
	background:#666;
	color:#FFF;
	border-color:#444;
	box-shadow:0 1px 0 rgba(255,255,255,1), 0 0 2px rgba(0, 0, 0, 0.3) inset;
}
  
.ui-widget.ui-widget-content{
    border-color:#b4de9a;
    box-shadow:1px 5px 5px #b4de9a;
}

.ui-widget-content{
    border-color:#b4de9a;
    background:#ffffff;
    color:#000000;
}

.ui-widget-content a{
    color:#000000;
}

.ui-widget-header{
    border-color:#b4de9a;
    background:#b4de9a;
    color:#ffffff
}

.ui-widget-header a{
    color:#ffffff;
}

.ui-state-default,.ui-widget-content .ui-state-default{
    border-color:#b4de9a;
    background:#E6FFD7;
    font-weight:normal;
    color:#000000;
}

.ui-state-highlight,.ui-widget-content .ui-state-highlight{
    border-color:#b4de9a;
    background:#b4de9a;
    color:#ffffff;
}``