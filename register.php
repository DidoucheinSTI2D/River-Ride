<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - S'inscrire</title>
</head>
<body>

    <header>
        <?php include "./component/header.php"; ?>
    </header>

<main style="margin-top: 7rem;">
  <div class="container">
    <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">

    
<div class="tab-content">
  <div class="tab-pane fade show active">
  
    <div class="text-center mb-3">
    <p>S'inscrire : </p>
        <div id="register">
            <form method="POST" action="./component/register_rules.php">
            <div class="form-outline mb-4">
            <input type="email" name="email" class="form-control" placeholder="Votre adresse email" required />
            </div>
            <div class="form-outline mb-4">
            <input type="text" name="pseudo" class="form-control" placeholder="Votre pseudo" required />
            </div>
            <div class="form-outline mb-4">
            <input type="date" name="date" class="form-control" required />
            </div>
            <div class="form-outline mb-4">
            <input type="password" name="password" class="form-control" placeholder="Votre mot de passe" required />
            </div>
            <div class="form-outline mb-4">
            <input type="password" name="confirmation_pw" class="form-control" placeholder="Confirmez votre mot de passe" required />
            </div>
            <div class="form-outline mb-4 text-center">
            <button type="submit" name="submitButton" id="submitButton" class="btn btn-primary"> Confirmer votre inscription </button>
            </div>
            </form>
        </div>
    </div>

      <!-- 2 column grid layout -->
      <div class="row mb-4">
        <div class="col-md-6 d-flex justify-content-center">
          <!-- Checkbox -->
          <div class="form-check mb-3 mb-md-0">
            <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked />
            <label class="form-check-label" for="loginCheck"> Remember me </label>
          </div>
        </div>

        <div class="col-md-6 d-flex justify-content-center">
          <!-- Simple link -->
          <a href="./forgotpw.php">Forgot password?</a>
    </div>
</div>

</div>                                                                                                            
</main>

    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>



    
</body>
</html>