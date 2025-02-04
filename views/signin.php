<?php include "components/header.php"; 

if(isset($_SESSION['errors'])){
  $errors = $_SESSION['errors'];
  // Je détruis la sessions pour eviter que les erreurs s'affichent lors d'un changement de page 
  unset($_SESSION['errors']);
}
if(isset($_GET['message'])){
  $message = $_GET['message']; 
}
?>

<div class="connexion-container">
      <div class="img-container">
        <img
          src="../assets/img/mer-voilier.jpg"
          alt="Image représentant un voilier sur la mer"
        />
      </div>
      <main class="form-container">
        <div>
          <form action="/controllers/userController.php" method="post" class="form-connexion">
            <h1>Connectez vous !</h1>
            <span class="token"><?php echo $message ?? "";?></span>
            <div class="input-form-container">
              <input type="email" required id="email" autofocus autocomplete="off" name="email"/>
              <label for="email">Email</label>
              <span class="error"><?php echo $errors['email'] ?? ""; ?></span>
            </div>
            <div class="input-form-container">
              <input
                type="password"
                required
                id="password"
                name="password"
                autocomplete="off"
              />
              <label for="password">Mot de passe</label>
              <span class="error"><?php echo $errors['password'] ?? "";  ?></span>

            </div>
            <input type="submit" name="submit_connexion" value="Se connecter" class="submit" />
            <a href="reset_password.php" class="link-forgot-password">
              <p>Mot de passe oublié</p>
            </a>
            <a href="signup.php" class="link-to-inscription"
              ><p>Vous n'avez pas encore de compte ?</p></a
            >
          </form>
        </div>
      </main>
    </div>