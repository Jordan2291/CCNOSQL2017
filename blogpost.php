<?php
$action = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Salvar')) ? 'save_article' : 'show_form';
 switch ($action){
     case 'save_article':
         try {
            $connection = new Mongo();
            $database = $connection->selectDB('miblog');
            $collection = $database->selectCollection('articles');
            $article = array();
            $article['title'] = $_POST['title'];
            $article['content'] = $_POST['content'];
            $article['saved_at'] = new MongoDate();
            $collection->insert($article);
         } catch (MongoConnectionException $e) {
             die("No se ha podido conectar a la base de datos" . $e->getMessage());             
         } catch (MongoException $e) {
             die('No se han podido insertar los datos' . $e->getMessage());
         }
         break;
     case 'show_form':
     default :
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="style.css"/>
        <title>Creador de Post para el blog</title>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Creador de Post para el Blog</h1>
                <?php if ($action === 'show_form'): ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h3>T&iacute;tulo</h3>
                    <p>
                        <input type="text" name="title" id="title"></input>
                    </p>
                    <h3>Contenido</h3>
                    <textarea name="content" rows="20" cols="50"></textarea>
                    <p>
                        <input type="submit" name="btn_submit" value="Salvar"/>
                    </p>
                </form>
                <?php else: ?>
                <p>
                    Art&iacute;culo salvado. _id:<?php echo $article['_id']; ?>.
                    <a href="blogpost.php"> &iquest;Escribir otro?</a>
                </p>
                <?php endif; ?>
            </div>
        </div>        
    </body>
</html>
