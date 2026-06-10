<?php
/**
 * Title: Über mich – Vollseite
 * Slug: physio-anne/about-full
 * Categories: physio-anne
 * Description: Zweispaltiges Layout mit sticky Foto links und ausführlichem Text + Qualifikationen rechts (Über-mich-Seite)
 */
?>
<!-- wp:html -->
<section class="section" aria-labelledby="about-full-heading">
  <div class="container">
    <div class="about-full">

      <div class="about-full-img">
        <picture>
          <source srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about-col.webp" type="image/webp">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/about-col.jpg" alt="Anne Günthner, Physiotherapeutin" loading="eager" width="768" height="1200">
        </picture>
      </div>

      <div class="about-full-text">
        <p class="eyebrow">Mein Weg</p>
        <h2 id="about-full-heading">Physiotherapeutin<br>aus Leidenschaft</h2>

        <p>Ich bin Anne Günthner, staatlich geprüfte Physiotherapeutin seit 2012. Nach meiner Ausbildung in Deutschland zog ich 2014 nach Vorarlberg, wo ich seither lebe und arbeite – als freiberufliche Physiotherapeutin und als Mutter.</p>
        <p>In meiner Arbeit ist mir vor allem eines wichtig: den Menschen, der zu mir kommt, wirklich zu sehen. Nicht nur das Symptom, nicht nur die Diagnose – sondern den ganzen Menschen mit seiner Geschichte, seinen Bedürfnissen und seinem Alltag.</p>

        <h3>Mein Ansatz</h3>
        <p>Physiotherapie ist für mich ein Dialog. Ich erkläre, was ich tue und warum. Ich höre zu und passe meine Behandlungen individuell an – denn kein Körper ist wie der andere.</p>
        <p>Mein Ziel ist es nicht nur, akute Beschwerden zu lindern, sondern gemeinsam mit Ihnen langfristige Lösungen zu finden. Ich arbeite mit einfühlsamen Handgriffen, gezielten Übungen und erkläre Ihnen, wie Sie zu Hause aktiv bleiben können.</p>

        <h3>Meine Qualifikationen</h3>
        <ul class="credentials">
          <li class="credential-item">
            <span class="credential-dot"></span>
            <span>Staatlich geprüfte Physiotherapeutin (MTD-Gesetz, BGBL Nr. 460/1992)</span>
          </li>
          <li class="credential-item">
            <span class="credential-dot"></span>
            <span>Berufsausübung seit 2012</span>
          </li>
          <li class="credential-item">
            <span class="credential-dot"></span>
            <span>Mitglied bei Physio Austria – Bundesverband der PhysiotherapeutInnen Österreichs (seit 2026)</span>
          </li>
          <li class="credential-item">
            <span class="credential-dot"></span>
            <span>Freiberuflich tätig seit Juni 2024 in Feldkirch</span>
          </li>
          <li class="credential-item">
            <span class="credential-dot"></span>
            <span>Wahltherapeutin – Kassenerstattung möglich</span>
          </li>
          <li class="credential-item">
            <span class="credential-dot"></span>
            <span>Spezialisierung: Manuelle Therapie, Beckenbodentherapie, Atemtherapie</span>
          </li>
        </ul>

        <div style="display:flex; gap: 16px; flex-wrap: wrap; margin-top: 40px;">
          <a href="/leistungen/" class="btn btn-primary">Meine Leistungen</a>
          <a href="/kontakt/" class="btn btn-outline">Termin vereinbaren</a>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- /wp:html -->
