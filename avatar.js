function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = () => reject(new Error("Erreur de chargement de l'image"));
        img.src = src;
    });
}

async function genererAvatar() {
    var rond = document.getElementById("rond").value;
    var yeux = document.getElementById("yeux").value;
    var nez = document.getElementById("nez").value;
    var sourire = document.getElementById("sourire").value;

    var avatarResult = document.getElementById("avatar-result");
    var avatarPreview = avatarResult.querySelector(".avatar-preview");
    avatarPreview.innerHTML = "";

    try {
        var [imgRond, imgYeux, imgNez, imgSourire] = await Promise.all([
            loadImage(rond),
            loadImage(yeux),
            loadImage(nez),
            loadImage(sourire),
        ]);

        var canvas = document.createElement("canvas");
        var context = canvas.getContext("2d");
        canvas.width = 100;
        canvas.height = 100;

        context.drawImage(imgRond, 0, 0, 100, 100);
        context.drawImage(imgYeux, 30, 10, 40, 20);
        context.drawImage(imgNez, 40, 40, 20, 20);
        context.drawImage(imgSourire, 35, 60, 30, 30);


        avatarPreview.appendChild(canvas);
    } catch (error) {
        console.error(error);
    }
}

function enregistrerAvatar() {
    var rond = document.getElementById("rond").value;
    var yeux = document.getElementById("yeux").value;
    var nez = document.getElementById("nez").value;
    var sourire = document.getElementById("sourire").value;

    var formData = new FormData();
    formData.append('rond', rond);
    formData.append('yeux', yeux);
    formData.append('nez', nez);
    formData.append('sourire', sourire);

    fetch('enregistrer_avatar.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                alert("Votre avatar à bien été sauvegardé !");
                console.log('Les valeurs des choix ont été enregistrées dans la base de données.');
            } else {
                console.error('Erreur lors de l\'enregistrement des valeurs des choix.');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête HTTP:', error);
        });
}

// On genere une premiere previsualisation automatique de l'avatar
genererAvatar()