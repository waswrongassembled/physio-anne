# Datenschutzerklärung – Textbausteine ab Theme 1.0.18

Mit 1.0.18 hat sich verändert, welche Daten die Website an Dritte überträgt.
Die Datenschutzerklärung liegt als Seiteninhalt in der Datenbank und muss
deshalb im WordPress-Editor angepasst werden – ein Theme-Update ändert sie nicht.

**Kein Rechtsrat.** Die Bausteine beschreiben den technischen Stand nach 1.0.18
möglichst genau. Ob die Erklärung insgesamt vollständig ist, gehört von Anne
oder ihrer Rechtsberatung geprüft.

---

## 1. Abschnitt „6. Karten (OpenStreetMap / Leaflet)" ersetzen

Der bestehende Text sagt, die Kacheln würden beim Aufruf der Kontaktseite
geladen. Das stimmt seit 1.0.18 nicht mehr: Ohne Klick geht keine Anfrage raus.
Eine Datenschutzerklärung, die mehr Übermittlung beschreibt als stattfindet,
ist zwar nicht gefährlich – falsch ist sie trotzdem.

**Neuer Text:**

> ### 6. Karten (OpenStreetMap / Leaflet)
>
> Auf der Kontaktseite ist eine Karte eingebunden, die den Standort der Praxis
> zeigt. Verwendet wird die Open-Source-Bibliothek Leaflet zusammen mit
> Kartenkacheln von OpenStreetMap (betrieben von der OpenStreetMap Foundation,
> St John's Innovation Centre, Cowley Road, Cambridge, CB4 0WS,
> Großbritannien).
>
> Die Karte wird **nicht automatisch geladen**. Beim Aufruf der Kontaktseite
> sehen Sie zunächst nur einen Hinweis mit der Schaltfläche „Karte laden". Erst
> wenn Sie darauf klicken, werden Kartenkacheln von den Servern der
> OpenStreetMap Foundation abgerufen und dabei Ihre IP-Adresse an diese
> übertragen. Klicken Sie nicht, findet keine Übertragung statt.
>
> Rechtsgrundlage für die Übertragung ist Ihre Einwilligung gemäß
> Art. 6 Abs. 1 lit. a DSGVO, die Sie mit dem Klick auf die Schaltfläche
> erteilen. Die Einwilligung gilt für den jeweiligen Seitenaufruf; nach dem
> Neuladen der Seite ist die Karte wieder deaktiviert.
>
> Die Leaflet-Bibliothek selbst wird von unserem eigenen Server ausgeliefert.
> Es besteht insoweit keine Verbindung zu Drittanbietern.
>
> OpenStreetMap setzt für das Laden der Kacheln keine Cookies. Einzelheiten zur
> Datenverarbeitung finden Sie in der
> [Datenschutzerklärung der OpenStreetMap Foundation](https://osmfoundation.org/wiki/Privacy_Policy).
>
> Alternativ zur eingebetteten Karte können Sie den Standort direkt bei
> OpenStreetMap aufrufen; dafür ist auf der Kontaktseite ein Link hinterlegt.

---

## 2. Neuer Abschnitt „Schriftarten" einfügen

Bis 1.0.17 lud die Website bei **jedem** Seitenaufruf Schriften von
`fonts.googleapis.com` und `fonts.gstatic.com` und übertrug dabei die
IP-Adresse an Google – ohne Einwilligung und ohne Erwähnung in der
Datenschutzerklärung. Seit 1.0.18 liegen die Schriften lokal im Theme.

Der Abschnitt ist nicht zwingend, aber sinnvoll: Er dokumentiert, dass hier
gerade *keine* Übermittlung stattfindet.

> ### Schriftarten
>
> Diese Website verwendet die Schriftarten „Cormorant Garamond" und „DM Sans".
> Beide werden von unserem eigenen Server ausgeliefert. Beim Aufruf der Seite
> wird keine Verbindung zu Servern von Google oder anderen Anbietern
> aufgebaut, es werden also auch keine Daten dorthin übertragen.

---

## 3. Prüfen: Aussagen zu Cookies und Kontaktformular

Nicht durch 1.0.18 verändert, aber beim Überarbeiten mitprüfen:

- **Cookies:** Ohne Kartenklick setzt die Seite von sich aus keine Cookies.
  Contact Form 7 kann welche setzen; das ist gesondert zu prüfen.
- **Kontaktformular:** Wo laufen die Nachrichten auf, wie lange werden sie
  aufbewahrt, gibt es eine Weiterleitung an ein externes Postfach?
- **Hosting:** Die Website läuft über Cloudflare. Ob und wie das in der
  Erklärung auftaucht, gehört geprüft – Cloudflare verarbeitet als
  Auftragsverarbeiter unter anderem IP-Adressen.

---

## 4. Nach der Änderung

Datum der letzten Aktualisierung am Ende der Datenschutzerklärung anpassen.
Die Seite trägt seit 1.0.18 ein `dateModified` im strukturierten Datenblock,
das aus dem WordPress-Änderungsdatum kommt – das aktualisiert sich beim
Speichern von selbst.
