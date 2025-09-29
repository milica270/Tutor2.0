<template>
  <div class="container my-4">
    <!-- Glavni naslov -->
    <div class="card shadow-sm mb-4" style="border-left: 6px solid var(--blue);">
      <div class="card-body">
        <h1 class="fw-bold mb-3" style="color: var(--blue);">
          Tutor2.0 – Aplikacija za povezivanje učenika i tutora
        </h1>
        <p>
          <strong>Tutor2.0</strong> je aplikacija koja spaja učenike kojima je potrebna pomoć
          sa vršnjacima koji su odlični iz određenog predmeta i mogu im pomoći.
        </p>
        <!-- Dugme za otvaranje/collapse svih uputstava -->
        <button
          class="btn btn-primary mt-3"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#allInstructions"
          aria-expanded="false"
          aria-controls="allInstructions"
        >
          Prikaži uputstva
        </button>
      </div>
    </div>

    <!-- Collapse panel za sve sekcije -->
    <div class="collapse" id="allInstructions">
      <div class="card card-body">
        <!-- 1. Registracija i login -->
        <h5 class="fw-bold">1. Registracija i login</h5>
        <ul>
          <li>Učenici se registruju unosom: imena, prezimena, slike, razreda, smjera, e-maila i lozinke.</li>
          <li>Ako profil već postoji, moguće je ulogovati se.</li>
        </ul>

        <!-- 2. Početna stranica -->
        <h5 class="fw-bold mt-3">2. Početna stranica</h5>
        <p>Na početnoj stranici učenik vidi svoj profil (slika i podaci).</p>
        <ul>
          <li><strong>Zakazani termini</strong> – prikaz nadolazećih časova i zahtjeva koje je učenik poslao tutorima.</li>
          <li><strong>Zakaži termin</strong> – mogućnost zakazivanja novog časa.</li>
        </ul>

        <!-- 3. Proces zakazivanja termina -->
        <h5 class="fw-bold mt-3">3. Proces zakazivanja termina</h5>
        <ol class="ps-3">
          <li>Učenik izabere predmet u kojem mu je potrebna pomoć.</li>
          <li>Dodaje opis kako bi precizirao oblast problema.</li>
          <li>Klikom na dugme <em>Pronađi tutore</em> dobija listu svih dostupnih tutora:
            <ul>
              <li>Smjer i razred tutora</li>
              <li>Rang (ocjena tutora iz tog predmeta)</li>
              <li>Dostupni termini</li>
            </ul>
          </li>
          <li>Učenik bira slobodan termin i klikne <em>Pošaljite zahtjev</em>.</li>
          <li>Zahtjev se pojavljuje pod opcijom <strong>Poslati zahtjevi</strong>.</li>
          <li>Termin je zvanično zakazan tek kada tutor prihvati zahtjev.</li>
        </ol>

        <!-- 4. Upravljanje terminima -->
        <h5 class="fw-bold mt-3">4. Upravljanje terminima</h5>
        <ul>
          <li>Učenik može u svakom trenutku otkazati termin klikom na <strong>X (opozovi)</strong>.</li>
          <li>Tutor takođe može otkazati termin, pa je preporučljivo povremeno provjeravati status termina.</li>
        </ul>

        <!-- 5. Uputstvo za tutore -->
        <h5 class="fw-bold mt-3">5. Uputstvo za tutore</h5>
        <p><strong>Ako nisi tutor:</strong></p>
        <ul>
          <li>Sa početne stranice klikni na dugme <strong>Postani tutor</strong> u gornjem desnom uglu.</li>
          <li>Otvara se formular: selektuješ predmet koji želiš podučavati i ocjenu koju imaš iz tog predmeta.</li>
          <li>Možeš dodati više predmeta koristeći <strong>+</strong> ili ukloniti sa <strong>-</strong>.</li>
          <li>Klikom na <strong>Pošalji</strong>, zahtjev se šalje adminu. Čekaš odobrenje.</li>
          <li>Nakon odobrenja, postaješ tutor.</li>
        </ul>

        <p><strong>Ako si već tutor:</strong></p>
        <ul>
          <li>Sa početne stranice klikom na dugme <strong>Tutor stranica</strong> pristupaš svojoj tutor sekciji.</li>
          <li>Pregled predmeta koje podučavaš sa mogućnostima dodavanja ili prestanka podučavanja pojedinih predmeta.</li>
          <li>Dole meni sa 4 opcije:
            <ul>
              <li><strong>Termini</strong> – selektuješ dane i časove kada si slobodan za podučavanje.</li>
              <li><strong>Zahtjevi</strong> – dolaze zahtjevi od učenika koje možeš prihvatiti ili odbiti.</li>
              <li><strong>Raspored</strong> – pregledaš prihvaćene termine koji još nisu održani.</li>
              <li><strong>Istorija</strong> – pregledaš termine koji su održani.</li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
// Ovaj collapse radi automatski preko Bootstrap-a data-bs-toggle
</script>



