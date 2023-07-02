function decouperImageEn9(imagePath) {
    // Créer un élément image
    var image = new Image();

    // Charger l'image
    image.onload = function() {
        // Créer un élément canvas
        var canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;

        // Obtenir le contexte du canvas
        var context = canvas.getContext("2d");
        context.drawImage(image, 0, 0);

        // Calculer la largeur et la hauteur de chaque partie
        var largeurPartie = Math.floor(canvas.width / 3);
        var hauteurPartie = Math.floor(canvas.height / 3);

        // Tableau pour stocker les parties de l'image
        var partiesImage = [];

        for (var i = 0; i < 3; i++) {
            for (var j = 0; j < 3; j++) {
                // Créer un nouvel élément canvas pour chaque partie
                var partieCanvas = document.createElement("canvas");
                partieCanvas.width = largeurPartie;
                partieCanvas.height = hauteurPartie;

                // Obtenir le contexte de la partie du canvas
                var partieContext = partieCanvas.getContext("2d");

                // Découper la partie de l'image
                partieContext.drawImage(
                    canvas,
                    j * largeurPartie,
                    i * hauteurPartie,
                    largeurPartie,
                    hauteurPartie,
                    0,
                    0,
                    largeurPartie,
                    hauteurPartie
                );

                // Renommer la partie de manière aléatoire de 1 à 9
                var partieNom = Math.floor(Math.random() * 9) + 1;

                // Stocker la partie dans le tableau
                partiesImage.push({
                    nom: partieNom,
                    canvas: partieCanvas
                });
            }
        }

        // Utilisation des parties de l'image découpées
        partiesImage.forEach(function(partie) {
            document.body.appendChild(partie.canvas);

            var link = document.createElement("a");
            link.href = partie.canvas.toDataURL();
            link.download = "partie_" + partie.nom + ".png";
            link.click();

            document.body.removeChild(partie.canvas);
        });
    };

    image.src = imagePath;
}

// Exemple d'utilisation
var imagePath = "chemin/vers/votre/image.jpg";
decouperImageEn9(imagePath);