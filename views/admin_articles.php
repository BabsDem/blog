<?php 
    include "components/header.php";
    
    require ("../models/articleModel.php"); 

    if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 1 ){
        session_destroy();
        header("Location: signin.php");
        } 

    if(isset($_GET["page"]) && $_GET['page'] == "admin_articles"){
        $articles = $_SESSION['articles']; 
    }
?>

<section class="section_admin_articles">
    <div class="admin_menu">
        <?php include "components/menu_admin.php";?>
    </div>
    <div class="container_table">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Titre</th>
                        <th>Lieu</th>
                        <th class="large_width">Description</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $article): ?>
                    <tr>
                        <td data-cell="Id"><?php echo $article["id_article"] ?></td>
                        <td data-cell="Nom"><?php echo $article["title"] ?></td>
                        <td class="title_content_admin" data-cell="Titre"><?php echo $article["subtitle"] ?></td>
                        <td data-cell="Lieu"><?php echo $article["place"] ?></td>
                        <td data-cell="Description" class="description_content_admin"><?php echo $article["description"] ?></td>
                        <td data-cell="Catégorie"><?php echo $article["category"] ?></td>
                        <td data-cell="Actions">
                            <div class="icons_container">
                                <a href="admin_update_article.php?article_id=<?php echo $article['id_article']; ?>">
                                    <img src="../assets/svg/pen-solid.svg" alt="bouton modifier article">
                                </a>
                                <a href="../controllers/articleController.php?article_id=<?php echo $article['id_article']; ?>">
                                    <img src="../assets/svg/trash-solid.svg" alt="bouton supprimer article">
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="create_container">

                <a class="btn create-btn" href="admin_create_article.php">Créer un article</a>

            </div>
        </div>
</section>
<?php include "components/footer.php"; ?>