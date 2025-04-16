const jours = ["lundi", "mardi", "mercredi", "jeudi", "vendredi"];
const container = document.getElementById("jours-container");

// Fonction pour générer les champs de menu pour chaque jour de la semaine
function genererChampsAvecDates(baseDate) {
    container.innerHTML = ""; // Clear existing fields

    // Si aucune date n'est fournie, ne rien afficher
    if (!baseDate) {
        return;
    }

    const startDate = new Date(baseDate);
    jours.forEach((jour, index) => {
        const currentDate = new Date(startDate);
        currentDate.setDate(startDate.getDate() + index);

        const dateStr = currentDate.toLocaleDateString('fr-FR');

        const div = document.createElement("div");
        div.classList.add("jour");
        div.innerHTML = `
     <h3>${jour.charAt(0).toUpperCase() + jour.slice(1)} (${dateStr})</h3>
      <input name="${jour}_horsdoeuvre" placeholder="Hors d'œuvre">
      <input name="${jour}_plat1" placeholder="Plat 1">
      <input name="${jour}_plat2" placeholder="Plat 2">
      <input name="${jour}_acc1" placeholder="Accompagnement 1">
      <input name="${jour}_acc2" placeholder="Accompagnement 2">
      <input name="${jour}_fromage" placeholder="Fromage">
      <input name="${jour}_dessert" placeholder="Dessert">
    `;
        container.appendChild(div);
    });
}

// Fonction pour ajuster la date de fin en fonction du lundi sélectionné
function ajusterDateFin(lundiDate) {
    const lundi = new Date(lundiDate);
    lundi.setDate(lundi.getDate() + 4); // Ajouter 4 jours pour obtenir le vendredi suivant
    const dateFin = document.getElementById('date_fin');
    dateFin.value = lundi.toISOString().split('T')[0]; // Formater la date au format 'YYYY-MM-DD'
}

// Fonction pour vérifier si un menu existe déjà pour la semaine
function chargerDonneesExistantes(debut, fin) {
    const url = `load.php?debut=${debut}&fin=${fin}`;
    fetch(url)
        .then(res => {
            if (!res.ok) {
                throw new Error(`Erreur de chargement du menu: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            if (data && data.jours) {
                // Remplir les champs avec les données récupérées
                jours.forEach(jour => {
                    document.querySelector(`[name="${jour}_horsdoeuvre"]`).value = data.jours[jour].horsdoeuvre || "";
                    document.querySelector(`[name="${jour}_plat1"]`).value = data.jours[jour].plat1 || "";
                    document.querySelector(`[name="${jour}_plat2"]`).value = data.jours[jour].plat2 || "";
                    document.querySelector(`[name="${jour}_acc1"]`).value = data.jours[jour].accompagnement1 || "";
                    document.querySelector(`[name="${jour}_acc2"]`).value = data.jours[jour].accompagnement2 || "";
                    document.querySelector(`[name="${jour}_fromage"]`).value = data.jours[jour].fromage || "";
                    document.querySelector(`[name="${jour}_dessert"]`).value = data.jours[jour].dessert || "";
                });
            } else {

                console.log("Aucun menu trouvé pour cette semaine.");
            }
        })
        .catch(err => {
            console.error("Erreur lors de la récupération des données : ", err);
        });
}


// Fonction pour vérifier si la date est un lundi
function estLundi(date) {
    const jour = new Date(date).getDay();
    return jour === 1;

}

// Fonction pour ajuster la date de début pour ne permettre que les lundis
function ajusterDateDebut() {
    const inputDate = document.getElementById('date_debut');
    const inputDateFin = document.getElementById('date_fin');
    const today = new Date();
    let lundiSemaineEnCours = new Date(today);

    // Calculer le lundi de la semaine en cours
    const jourActuel = today.getDay();
    lundiSemaineEnCours.setDate(today.getDate() - ((jourActuel + 6) % 7)); // Reculer jusqu'au lundi précédent

    // Si aujourd'hui est après le vendredi de la semaine en cours, passer au lundi suivant
    if (jourActuel > 5) { // Samedi (6) ou dimanche (0)
        lundiSemaineEnCours.setDate(lundiSemaineEnCours.getDate() + 7);
    }

    // Limiter le champ de date aux lundis
    inputDate.min = lundiSemaineEnCours.toISOString().split('T')[0];

    // Événement lors de la sélection d'une date
    inputDate.addEventListener('change', () => {
        const debut = inputDate.value;



        if (debut && estLundi(debut)) {
            genererChampsAvecDates(debut);
            ajusterDateFin(debut);

            // Appeler la fonction pour charger les données existantes si la date de fin est valide
            if (debut && document.getElementById('date_fin').value) {
                chargerDonneesExistantes(debut, document.getElementById('date_fin').value); // Charger les données existantes
            }
        } else {
            inputDate.value = '';
            inputDateFin.value = '';
            genererChampsAvecDates(null); // Effacer les champs
            alert("Veuillez sélectionner un lundi.");
        }
    });
}


ajusterDateDebut();