<?php 
    include "components/header.php"; 
    include "../models/functions/formatDate.php";

    if(isset($_GET["page"]) && $_GET['page'] === "display_article"){
        $article = $_SESSION['article']; 
        $images = $_SESSION['images_article'];
    }
    if(isset($_GET['message'])){
        $message = $_GET["message"];
    }    
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    if(isset($_SESSION["user_comments"])){
        $comments = $_SESSION["user_comments"]; 
    }
?>
<div class="banner">
    <img src="<?php echo $article['img']?>" alt="">
</div>

<main>
    <section class="section-article-container">   
        <h1><?php echo $article['title'];?></h1>
        <span><?php echo $article['place'];?> </span>
        <h2><?php echo $article['subtitle'];?></h2>
        <p><?php echo $article['description'];?></p>
    </section>

    <section class="section-carroussel-container">
        <div class="wrapper-carroussel">
                <ul class="carroussel">
                    <?php 
                    $index = 0;
                    foreach($images as $image): 
                    ?>
                    <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $image['img']; ?>" alt="">       
                    </li>
                    <?php 
                    $index++;
                    endforeach 
                    ?>
                </ul>
                <button class="btn-carroussel btn-left" id="prev">
                    <img src="../assets/svg/chevron-left.svg" alt="Bouton permettant d'aller à l'image précédente">
                </button>
                <button class="btn-carroussel btn-right" id="next">
                    <img src="../assets/svg/chevron-right.svg" alt="Bouton permettant d'aller à l'image suivante">
                </button>
        </div>
    </section>

    <section class="section-comment-container">
        <div>        
            <?php if(isset($user)): ?>
            <form action="/controllers/commentController.php" method="post">
            <span><?php echo $message ?? ""; ?></span> 
            <input type="hidden" name="id_article" value="<?php echo $article["id_article"];?>">
                <textarea name="user_comment" class="textarea-comment"></textarea>   
                <label class="label-textarea">Laissez un commentaire !</label>
                <input type="submit" name="submit_create_comment" value="Poster" class="btn">
            </form>
            <?php else : ?>
                <p>Si vous souhaitez laisser un commentaire, <a class="btn" href="signup.php">Inscrivez vous</a> ou <a class="btn" href="signin.php">Connectez vous </a></p>
            <?php endif ?>
        </div>
    </section>

    <?php if(!empty($comments)): ?>
    <section class="display__user-comment-container">
        <?php foreach($comments as $comment) : ?>
        <div class="user-comment-card">
            <div class="img-user-container">
                <img src="../assets/img/banner_pool.png" alt="">
            </div>
            <div class="user-comment-container">            
                <p><?php echo $comment['lastname'] . " ". $comment['firstname'];?></p>
                <p><?php echo $comment['description'];?></p>
                <p>Posté le <?php 
                $comment['date_creation'] = formatDateFr($comment['date_creation']);
                echo $comment['date_creation']; ?></p>
                
            </div>
        </div>
        <?php endforeach ?>
        <?php endif ?>

    </section>
</main>

<?php include "components/footer.php"; ?>

