// Variables globales
const rows = 3;
const columns = 3;
const imgOrder = ["4", "2", "8", "5", "1", "6", "7", "9", "3"];

// Fonction principale
window.onload = () => {
    for (let r = 0; r < rows; r++) {
        for (let c = 0; c < columns; c++) {
            let tile = document.createElement("img");
            tile.id = `${r}-${c}`;
            tile.src = `${imgOrder.shift()}.jpg`;
            tile.addEventListener("click", swapTiles);
            document.getElementById("board").append(tile);
        }
    }
};

// Fonction de swap
const swapTiles = (event) => {
    let currTile = event.target;
    let emptyTile = document.querySelector("img[src$='3.jpg']");
    if (currTile === emptyTile) return;
    let currTileIndex = parseInt(currTile.src.slice(-5, -4));
    let emptyTileIndex = parseInt(emptyTile.src.slice(-5, -4));
    [currTile.src, emptyTile.src] = [emptyTile.src, currTile.src];
    if (checkWin()) {
        // Effectuez ici les opérations nécessaires avant de soumettre le formulaire
        document.getElementById("submitBtn").disabled = false;
        return;
    }
};

// Fonction de vérification de victoire
const checkWin = () => {
    let images = document.querySelectorAll("#board img");
    for (let i = 0; i < images.length; i++) {
        let index = parseInt(images[i].src.slice(-5, -4));
        if (index !== i + 1) {
            return false;
        }
    }
    return true;
};
