<?php
/**
 * Title: Leistungen – Vollseite
 * Slug: physio-anne/services-full
 * Categories: physio-anne
 * Description: Intro + 4 Leistungen + Weitere Leistungen + Preistabelle + Hinweise (Leistungen-Seite)
 */
?>
<!-- wp:html -->

<section class="section" aria-labelledby="services-intro-heading">
  <div class="container">
    <div class="section-header" style="margin-bottom: 0;">
      <p class="eyebrow">Mein Angebot</p>
      <h2 id="services-intro-heading">Physiotherapie, die wirkt.</h2>
      <p>Jede Behandlung beginnt mit einem ausführlichen Gespräch. Ich nehme mir die Zeit, Ihre Situation zu verstehen – und entwickle dann einen individuellen Therapieplan.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top: 0;" aria-label="Leistungen im Detail">
  <div class="container">

    <div class="service-category">
      <p class="eyebrow">Hands-on</p>
      <p>Passive Behandlung – ich arbeite direkt an Ihrem Körper.</p>
    </div>

    <div class="service-detail">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-manuelle.jpg" alt="Manuelle Therapie" loading="eager" fetchpriority="high" width="2048" height="1363">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 01</p>
        <h3>Manuelle Therapie</h3>
        <p>Die Manuelle Therapie ist eine spezialisierte Form der Physiotherapie, bei der gezielte Handgriffe eingesetzt werden, um Bewegungseinschränkungen zu lösen und Schmerzen zu lindern.</p>
        <p>Ich arbeite mit sanften Mobilisierungstechniken an Gelenken und Weichteilen. Ziel ist es, die natürliche Beweglichkeit wiederherzustellen und Muskelspannungen zu reduzieren.</p>
        <p><strong>Geeignet bei:</strong> Rückenschmerzen, Nackenschmerzen, Schulter- und Knieproblemen, nach Operationen, Sportverletzungen.</p>
      </div>
    </div>

    <div class="service-category service-category--primary service-category--spacer">
      <p class="eyebrow">Hands-off</p>
      <p>Aktive Therapie – Sie arbeiten selbst, ich begleite und leite an.</p>
    </div>

    <div class="service-detail reverse">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-uebungen.jpg" alt="Aktive Übungen" loading="lazy" width="2048" height="1363">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 02</p>
        <h3>Aktive Übungen</h3>
        <p>Aktive Übungen sind ein wesentlicher Bestandteil der Physiotherapie. Durch gezieltes Training stärken wir die Muskulatur, verbessern die Koordination und unterstützen den Heilungsprozess.</p>
        <p>Ich erstelle für Sie ein individuelles Übungsprogramm, das Sie auch zu Hause weiterführen können. So bleiben Sie aktiv und erzielen nachhaltige Ergebnisse.</p>
        <p><strong>Geeignet bei:</strong> Muskelaufbau nach Verletzungen, Haltungskorrektur, Sturzprophylaxe, Rückenproblematiken.</p>
      </div>
    </div>

    <div class="service-detail">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-atem.jpg" alt="Atemtherapie" loading="lazy" width="2048" height="1363" style="object-position: right center;">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 03</p>
        <h3>Atemtherapie</h3>
        <p>Atmen ist die grundlegendste Funktion unseres Körpers – und doch atmen viele von uns unbewusst und ineffizient. Die Atemtherapie hilft, die Atmung neu zu entdecken und zu verbessern.</p>
        <p>Durch bewusste Atemtechniken lassen sich Lungenkapazität, Entspannungsfähigkeit und allgemeines Wohlbefinden deutlich steigern.</p>
        <p><strong>Geeignet bei:</strong> Lungenproblemen, Asthma, Stress, Atemwegserkrankungen, postoperativer Nachsorge.</p>
      </div>
    </div>

    <div class="service-detail reverse">
      <div class="service-detail-img">
        <picture>
          <source type="image/webp" srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden-sm.webp 800w, <?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden.webp 2048w" sizes="(max-width: 900px) 100vw, 50vw">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/service-beckenboden.jpg" alt="Beckenbodentherapie" loading="lazy" width="2048" height="1362">
        </picture>
      </div>
      <div class="service-detail-text">
        <p class="eyebrow">Leistung 04</p>
        <h3>Beckenbodentherapie</h3>
        <p>Der Beckenboden ist eine oft unterschätzte Muskelgruppe, die eine zentrale Rolle für unsere Gesundheit, Stabilität und Lebensqualität spielt.</p>
        <p>In der Beckenbodentherapie erarbeiten wir gemeinsam ein Bewusstsein für diese Muskulatur und trainieren gezielt Kräftigung oder – wo nötig – Entspannung.</p>
        <p><strong>Geeignet bei:</strong> Inkontinenz, nach der Geburt, bei Beckenschmerzen, Senkungsbeschwerden, für Frauen und Männer.</p>
      </div>
    </div>

  </div>
</section>

<section class="section section--alt" aria-label="Weitere Leistungen">
  <div class="container">
    <div class="section-narrow">
      <p class="eyebrow">Weitere Leistungen</p>
      <h2>Ergänzende Therapieformen</h2>
      <div class="info-cards">
        <div class="info-card">
          <h3>KPE – Komplexe Physikalische Entstauungstherapie</h3>
          <p>Die KPE, auch bekannt als manuelle Lymphdrainage, ist eine sanfte Massagetechnik zur Entstauung des Lymphsystems. Sie wird eingesetzt bei Lymphödem, postoperativen Schwellungen sowie chronischen Stauungsbeschwerden und kann Schmerzen und Schweregefühl deutlich lindern.</p>
        </div>
        <div class="info-card">
          <h3>Heilmassage</h3>
          <p>Die klassische Heilmassage löst Muskelverspannungen, fördert die Durchblutung und regt den Stoffwechsel an. Sie wirkt entspannend und schmerzlindernd – ideal als Ergänzung zur aktiven Physiotherapie oder bei akuten Verspannungen.</p>
        </div>
        <div class="info-card">
          <h3>Elektrotherapie</h3>
          <p>Bei der Elektrotherapie werden gezielte elektrische Impulse eingesetzt, um Schmerzen zu lindern, die Muskulatur zu stimulieren und den Heilungsprozess zu unterstützen – häufig ergänzend zur manuellen Therapie.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" aria-labelledby="pricing-services-heading">
  <div class="container">
    <div class="section-header">
      <p class="eyebrow">Honorare</p>
      <h2 id="pricing-services-heading">Transparente Preise</h2>
      <p>Als Wahltherapeutin rechne ich direkt mit Ihnen ab. Alle Kassen erstatten einen Teil der Behandlungskosten – alle Rückerstattungstarife finden Sie in der Tabelle.</p>
    </div>
    <div class="pricing-table-wrap">
      <table class="pricing-table">
        <thead>
          <tr>
            <th rowspan="2">Leistung</th>
            <th colspan="2"></th>
            <th colspan="3">Rückvergütung Krankenkasse</th>
          </tr>
          <tr>
            <th class="col-dauer">Dauer</th>
            <th>Preis</th>
            <th>ÖGK</th>
            <th>BVAEB</th>
            <th>SVS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="3">Heilgymnastik</td>
            <td class="col-dauer">30 Min.</td>
            <td class="price-highlight">€ 53,00</td>
            <td>€ 30,40</td>
            <td>€ 38,00</td>
            <td>€ 33,65</td>
          </tr>
          <tr>
            <td class="col-dauer">45 Min.</td>
            <td class="price-highlight">€ 80,00</td>
            <td>€ 45,62</td>
            <td>€ 57,02</td>
            <td>€ 50,47</td>
          </tr>
          <tr>
            <td class="col-dauer">60 Min.</td>
            <td class="price-highlight">€ 106,00</td>
            <td>€ 60,82</td>
            <td>€ 76,03</td>
            <td>€ 67,29</td>
          </tr>
          <tr>
            <td rowspan="3">KPE (Lymphdrainage)</td>
            <td class="col-dauer">30 Min.</td>
            <td class="price-highlight">€ 53,00</td>
            <td>—</td>
            <td>—</td>
            <td>€ 33,65</td>
          </tr>
          <tr>
            <td class="col-dauer">45 Min.</td>
            <td class="price-highlight">€ 80,00</td>
            <td>€ 45,62</td>
            <td>€ 57,02</td>
            <td>€ 50,47</td>
          </tr>
          <tr>
            <td class="col-dauer">60 Min.</td>
            <td class="price-highlight">€ 106,00</td>
            <td>€ 60,82</td>
            <td>€ 76,03</td>
            <td>€ 67,29</td>
          </tr>
          <tr>
            <td>Heilmassage</td>
            <td class="col-dauer">15 Min.</td>
            <td class="price-highlight">€ 27,00</td>
            <td>€ 8,10</td>
            <td>€ 10,12</td>
            <td>€ 9,13</td>
          </tr>
          <tr>
            <td>Elektrotherapie</td>
            <td class="col-dauer">15 Min.</td>
            <td class="price-highlight">€ 7,50</td>
            <td>* € 4,06</td>
            <td>* € 5,07</td>
            <td>€ 4,57</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p class="pricing-note">
      Alle Preise ohne Umsatzsteuer (USt-befreit gem. § 6 Abs. 1 Z 19 UStG) · Die Rückerstattungsbeträge für ÖGK, BVAEB und SVS sind Richtwerte – bitte erkundigen Sie sich bei Ihrer Kasse.<br>
      * Elektrotherapie ist bei ÖGK und BVAEB nur additiv (zusätzlich zu einer Hauptleistung) und eingeschränkt erstattbar.<br>
      <strong>KFA-versichert?</strong> Rückerstattungstarife der Krankenfürsorgeanstalt (KFA) auf Anfrage – <a href="/kontakt/">einfach melden.</a><br>
      <strong>SVS-Versicherte:</strong> Vor dem ersten Termin ist eine Bewilligung der SVS erforderlich.
    </p>
  </div>
</section>

<section class="section section--alt" aria-label="Wichtige Hinweise">
  <div class="container">
    <div class="section-narrow">
      <p class="eyebrow">Wichtiges zur Abrechnung</p>
      <h2>Was Sie vor dem ersten Termin wissen sollten</h2>
      <div class="info-cards">
        <div class="info-card info-card--primary">
          <h3>Ärztliche Zuweisung (Überweisung) erforderlich</h3>
          <p>Ich bin weisungsgebunden. Ohne ärztliche Zuweisung (Überweisung) darf ich keine physiotherapeutischen Leistungen anbieten und durchführen. Bitte bringen Sie die Zuweisung zum ersten Termin mit.</p>
        </div>
        <div class="info-card info-card--teal">
          <h3>SVS-Versicherte: Bewilligung erforderlich</h3>
          <p>Wenn Sie bei der <strong>SVS (Sozialversicherungsanstalt der Selbständigen)</strong> versichert sind, müssen Sie vor dem ersten Behandlungstermin eine <strong>Bewilligung</strong> bei der SVS einholen. Bitte klären Sie das vor Ihrer Buchung – ohne Bewilligung ist keine Kostenerstattung möglich.</p>
        </div>
        <div class="info-card info-card--lilac">
          <h3>Wahltherapie – direkte Abrechnung</h3>
          <p>Als Wahltherapeutin rechne ich direkt mit Ihnen ab. Sie bezahlen nach der Behandlung und reichen die Honorarnote bei Ihrer Kasse ein. ÖGK, BVAEB und SVS erstatten einen Teil der Kosten.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- /wp:html -->
