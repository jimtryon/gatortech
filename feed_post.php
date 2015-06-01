<?

    include('includes/session.php');
    require "includes/db.php";

    if($_POST['message'] && $_POST['message'] != '' && strlen($_POST['message'] != 0))
    {
        
        try
        {
            // New database connection
            $dbh = new PDO("mysql:host=$hostname; dbname=mlant_GT", $username, $password);
    
            // Login account verification
            $sql = $dbh->prepare("SELECT name, picture, status FROM account WHERE email = '$_SESSION[login_session]'");
            $sql->execute();
            $result = $sql->fetch();
    
            // display all of the rows
    
            //$data = $_POST['serialize'];
            $name = $result['name'];
            $picture = $result['picture'];
            $status = $result['status'];
            
            if (isset($_POST['tags'])) {
                echo $_POST['tags'];
            } else {
                echo "nothing";
            }
            $stmt = $dbh->prepare("INSERT INTO feed (user_email, user_name, user_post, picture, user_status, hashtag) VALUES (:user_email, :user_name, :user_post, :picture, :user_status, :hashtag)");
            $stmt->bindParam(':user_name', $name);
            $stmt->bindParam(':user_email', $_SESSION['login_session']);
            $stmt->bindParam(':user_post', $_POST['message']);
            $stmt->bindParam(':picture', $picture);
            $stmt->bindParam(':user_status', $status);
            $stmt->bindParam(':hashtag', $_POST['tags']);
            $stmt->execute();
    
            //header("Location: index.php");
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
?>