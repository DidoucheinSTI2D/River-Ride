<!DOCTYPE html>
<html>
<head>
  <title>Création d'avatar</title>
</head>
<body>
  <h1>Création d'avatar</h1>
  
  <label for="chapeau">Choisissez un chapeau :</label>
  <select id="chapeau">
    <option value="chapeau1">Chapeau 1</option>
    <option value="chapeau2">Chapeau 2</option>
    <option value="chapeau3">Chapeau 3</option>
  </select>
  
  <br>
  
  <label for="visage">Choisissez un visage :</label>
  <select id="visage">
    <option value="visage1">Visage 1</option>
    <option value="visage2">Visage 2</option>
    <option value="visage3">Visage 3</option>
  </select>
  
  <br>
  
  <label for="collier">Choisissez un collier :</label>
  <select id="collier">
    <option value="collier1">Collier 1</option>
    <option value="collier2">Collier 2</option>
    <option value="collier3">Collier 3</option>
  </select>
  
  <br>
  
  <button onclick="creerImage()">Créer l'image</button>
  
  <br>
  
  <div id="imageContainer"></div>
  
  <script>
    function creerImage() {
      var chapeau = document.getElementById("chapeau").value;
      var visage = document.getElementById("visage").value;
      var collier = document.getElementById("collier").value;
      
      var image = document.createElement("img");
      image.src = "./component/avatar/" + chapeau + "_" + visage + "_" + collier + ".png";
      
      var imageContainer = document.getElementById("imageContainer");
      imageContainer.innerHTML = "";
      imageContainer.appendChild(image);
    }
  </script>
</body>
</html>
