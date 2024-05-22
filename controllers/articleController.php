<?php
session_start();
include "../models/articleModel.php";
include "../models/functions/validateImg.php";

if(isset($_POST['submit_admin_create_article'])){
    if(!empty($_POST["title"]) && !empty($_POST["subtitle"]) && !empty($_POST["place"]) && !empty($_POST["description"]) && !empty($_POST["categories"])){
        $title = htmlspecialchars(trim($_POST['title']));
        $subtitle = htmlspecialchars(trim($_POST['subtitle']));
        $place = htmlspecialchars(trim($_POST['place']));
        $description = htmlspecialchars(trim($_POST['description']));
        $category = htmlspecialchars(trim($_POST['categories']));
        $files = $_FILES['images']; 
        
         

        try{
            $uploadedFiles = [];
            $articleId = createArticle($title, $subtitle, $place, $description, $category); 
            for($i= 0; $i < count($files['name']); $i++){
                $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
                ];
                $fileExtension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);  

                $_SESSION['errors'] = validateImg($file, $fileExtension);

                if(empty($_SESSION["errors"])){                    
                    $filename = pathImg($articleId, $fileExtension,"article", $file, $i);
                    $uploadedFiles[] = $filename;
                    $articleImg = createArticleImg($filename, $articleId);
                }
            }
           
        $_SESSION['articles'] = getAllArticle();
        }catch(\Exception $e){
            $_SESSION['errors']= $e->getMessage();
            header("Location: ../views/admin_create_article.php"); 
            exit;
        }
        header("Location: ../views/admin_articles.php?page=admin_articles"); 
        exit;
    }
//UPDATE ARTICLE
}else if(isset($_POST['submit_admin_update_article'])){
    if(!empty($_POST["title"]) && !empty($_POST["subtitle"]) && !empty($_POST["place"]) && !empty($_POST["description"]) && !empty($_POST["categories"])){
        $title = htmlspecialchars(trim($_POST["title"])); 
        $subtitle = htmlspecialchars(trim($_POST["subtitle"])); 
        $place = htmlspecialchars(trim($_POST["place"])); 
        $description = htmlspecialchars(trim($_POST["description"])); 
        $category = htmlspecialchars(trim($_POST["categories"])); 
        $id = htmlspecialchars(trim($_POST['update_article_id']));  
        $files = $_FILES['images'];
        try{
           updateArticle($id, $title, $subtitle, $place, $description, $category);       
            deleteImgArticle($id);        
            $uploadedFiles = [];
            for($i= 0; $i < count($files['name']); $i++){
              
                $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
                ];
                $filename = validateImg($file, $id, "article", $i); 
                $uploadedFiles[] = $filename;    
                updateImgArticle($id,$filename);   
            } 
            unset($_SESSION['images']); 
            $_SESSION["articles"] = getAllArticle();
            header("Location: ../views/admin_articles?page=admin_articles"); 
            exit; 

        }catch(\Exception $e){
            $_SESSION['errors']= $e->getMessage();
            
        }
        header("Location: ../views/admin_update_article.php?article_id=". $id); 
        exit;
    }
}

//READ ARTICLE
if(isset($_GET['page']) && $_GET['page'] === "home"){
    $_SESSION['articles_villa'] = getAllType("villa");
    $_SESSION['articles_hotel'] = getAllType("hotel");
    $_SESSIOn['images'] = getAllImg();
    header("Location: ../views/home.php?page=home"); 
    exit;
}
if(isset($_GET['page']) && $_GET['page'] === "admin_articles"){
    $_SESSION['articles'] = getAllArticle();
    header("Location: ../views/admin_articles.php?page=admin_articles"); 
    exit;
}

if(isset($_GET['page']) && $_GET['page'] === "blog"){
    $_SESSION['images'] = getAllImg(); 
    $_SESSION['articles'] = getAllArticle();   
    header("Location: ../views/blog?page=blog"); 
    exit;
}
if(isset($_GET['page']) && $_GET['page'] === "blog_villa"){
    $_SESSION['images'] = getAllImg(); 
    $_SESSION['articles'] = getAllType("villa");
    header("Location: ../views/blog?page=blog_villa"); 
    exit;
}
if(isset($_GET['page']) && $_GET['page'] === "blog_hotel"){
    $_SESSION['images'] = getAllImg(); 
    $_SESSION['articles'] = getAllType("hotel");
    header("Location: ../views/blog?page=blog_hotel"); 
    exit;
}

// DELETE ARTICLE
if(isset($_GET['article_id'])){
    deleteArticle($_GET['article_id']); 
    $_SESSION['articles'] = getAllArticle();
    header("Location: ../views/admin_articles.php?page=admin_articles"); 
    exit;
}


