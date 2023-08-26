
const search = document.getElementById('chercher');
console.log(search);

search.addEventListener("input", function (e) {
    console.log(document.getElementById('chercher').value);
    const reponse = fetch('/RiverRide/src/backoffice/utilisateur.php?search=' + search.value).then(function (response) {
        return response.json();
    }).then(function (data) {
        console.log(data);
        const table = document.querySelector('table');
        table.innerHTML = '';
        for (const user of data) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.nom}</td>
                <td>${user.prenom}</td>
                <td>${user.email}</td>
                <td>${user.admin ? 'Admin' : 'Utilisateur'}</td>
                <td><button class="btn btn-danger"> <a href="?supprimer=${user.id_utilisateur}">Supprimer</a></button></td>
            `;
            table.appendChild(row);
        }
    }).catch(function (error) {
        console.log(error);
    });
})



