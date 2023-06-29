// Fonction appelée lorsque le glisser commence
function handleDragStart(e) {
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
    this.classList.add('dragging');
}

// Fonction appelée lorsque l'élément est déposé
function handleDrop(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    if (dragSrcEl !== this) {
        // Effectuez les actions appropriées pour le déplacement d'une ligne vers une autre
        // Par exemple, mettez à jour la base de données pour refléter le nouvel ordre des utilisateurs
    }
    return false;
}

// Fonction appelée lorsque le curseur entre dans une zone de dépôt
function handleDragEnter(e) {
    this.classList.add('over');
}

// Fonction appelée lorsque le curseur se déplace sur une zone de dépôt
function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
}

// Fonction appelée lorsque le curseur quitte une zone de dépôt
function handleDragLeave(e) {
    this.classList.remove('over');
}

// Ajoutez les gestionnaires d'événements aux éléments de ligne de votre tableau
var rows = document.getElementsByTagName('tr');
for (var i = 0; i < rows.length; i++) {
    rows[i].addEventListener('dragstart', handleDragStart, false);
    rows[i].addEventListener('drop', handleDrop, false);
    rows[i].addEventListener('dragenter', handleDragEnter, false);
    rows[i].addEventListener('dragover', handleDragOver, false);
    rows[i].addEventListener('dragleave', handleDragLeave, false);
}