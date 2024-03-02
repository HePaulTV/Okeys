async function getCommuneByPostalCode(codePostal) {
    const url = `https://geo.api.gouv.fr/communes?codePostal=${codePostal}`;

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Erreur HTTP ! statut : ${response.status}`);
        }
        const communes = await response.json();
        console.log(communes);
        return communes;
    } catch (error) {
        console.error("Erreur lors de la récupération des données de l'API :", error);
    }
}