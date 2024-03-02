//  ! Gestion de la page d'estimation

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("estimationForm");
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const nombrePieces = document.getElementById("nombrePieces").value;
        const surface = document.getElementById("surface").value;
        const jardin = document.getElementById("jardin").checked;
        const garage = document.getElementById("garage").checked;
        const fibre = document.getElementById("fibre").checked;
        
        const estimation = calculerEstimation(nombrePieces, surface, jardin, garage, fibre);
        
        // Met à jour le modal avec le résultat de l'estimation
        document.getElementById("estimationResult").textContent = estimation;
        // Affiche le modal
        const estimationModal = new bootstrap.Modal(document.getElementById('estimationModal'));
        estimationModal.show();
    });
});

function calculerEstimation(nombrePieces, surface, jardin, garage, fibre) {
    let estimation = surface * 1000;
    estimation += nombrePieces * 5000;
    if (jardin) estimation += 10000;
    if (garage) estimation += 5000;
    if (fibre) estimation += 2000;
    
    return estimation;
}


