document.addEventListener("DOMContentLoaded", function() {
    // Initialisation et chargement des départements
    fetch('https://geo.api.gouv.fr/departements?fields=nom,code')
    .then(response => response.json())
    .then(data => {
        const selectDepartement = document.getElementById('departement');
        data.forEach(dept => {
            const option = new Option(dept.nom, dept.code);
            selectDepartement.add(option);
        });
    })
    .catch(error => console.error('Erreur lors du chargement des départements:', error));

    let selectedPopulation = 0; // Variable pour stocker la population de la commune sélectionnée

    // Gestion de la sélection de la commune
    document.getElementById('departement').addEventListener('change', function() {
        const deptCode = this.value;
        fetch(`https://geo.api.gouv.fr/departements/${deptCode}/communes?fields=nom,code,population`)
        .then(response => response.json())
        .then(communes => {
            window.communes = communes; // Stocke les communes pour la recherche
        })
        .catch(error => console.error('Erreur lors du chargement des communes:', error));
    });

    document.getElementById('communeInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const communeList = document.getElementById('communeList');
        communeList.innerHTML = '';
        const filteredCommunes = window.communes.filter(commune => commune.nom.toLowerCase().includes(searchTerm));
        
        filteredCommunes.forEach(commune => {
            const li = document.createElement('li');
            li.textContent = commune.nom;
            li.className = 'list-group-item';
            li.addEventListener('click', function() {
                document.getElementById('communeInput').value = commune.nom;
                selectedPopulation = commune.population; // Stocke la population pour l'utiliser dans l'estimation
                communeList.style.display = 'none';
            });
            communeList.appendChild(li);
        });

        communeList.style.display = filteredCommunes.length > 0 ? 'block' : 'none';
    });

    // Modification ici : Gestionnaire d'événements pour le bouton 'Calculer l'estimation'
    document.getElementById("estimationForm").addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche la soumission classique du formulaire
        
        // Appel à la fonction d'estimation avec la population sélectionnée
        const nombrePieces = document.getElementById("nombrePieces").value;
        const surface = document.getElementById("surface").value;
        const jardin = document.getElementById("jardin").checked;
        const garage = document.getElementById("garage").checked;
        const fibre = document.getElementById("fibre").checked;
        
        const estimation = calculerEstimation(nombrePieces, surface, jardin, garage, fibre, selectedPopulation);
        
        document.getElementById("estimationResult").textContent = `${estimation}`;
        // Affiche le modal d'estimation
        const estimationModal = new bootstrap.Modal(document.getElementById('estimationModal'));
        estimationModal.show();
    });
    
    // Pas de changements ici, sauf l'ajout de la population comme paramètre
    function calculerEstimation(nombrePieces, surface, jardin, garage, fibre, population) {
        let estimation = surface * 3000;
        estimation += nombrePieces * 10000;
        if (jardin) estimation += 50000;
        if (garage) estimation += 15000;
        if (fibre) estimation += 2000;
        
        if (population > 100000) {
            estimation *= 1.5;
        } else if (population > 50000) {
            estimation *= 1.3;
        } else if (population > 10000) {
            estimation *= 1.1;
        }
        
        return estimation;
    }
});
