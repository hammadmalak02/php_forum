   <!doctype html>
   <html lang="en">

   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>threadlist page</title>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   </head>

   <body>
       <?php include 'partials/_dbconnect.php'; ?>
       <?php include 'partials/_header.php'; ?>
       <?php
        $id = $_GET['catid'];
        // $sno = $_POST['sno'];
        $sql = "SELECT * FROM `categories` WHERE category_id=$id";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
        ?>
       <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            // Insert thread into database
            $th_tittle = $_POST['tittle'];
            $th_desc = $_POST['desc'];

            $th_tittle = str_replace("<", "&lt;", $th_tittle);
            $th_tittle = str_replace("<", "&gt;", $th_tittle);

            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace("<", "&gt;", $th_desc);

            $sql = "INSERT INTO `threads` (`thread_tittle`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_tittle', '$th_desc', '$id', '0' current_timestamp())";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if ($showAlert) {
                echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong> Success </strong> your thread has been added! please wait for community to respond
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
        ?>

       <!-- Category container start here -->
       <div class="container my-4 my-3">
           <div class="jumbotron">
               <h1 class="display-4">welcome to <?php echo $catname; ?> forums </h1>
               <p class="lead"> <?php echo $catdesc; ?> </p>
               <hr class="my-4">
               <p>This is peer to peer forum for sharing knowledge with each other <br>
                   Treat fellow members with courtesy and respect. Disagreements are natural, but please express your
                   opinions in a constructive and considerate manner. <br>
                   Create unique posts. ... <br>
                   Keep posts courteous. ...
                   Edit and delete posts as necessary using the tools provided by the forum. <br>
                   Use respectful language when posting. <br>
                   Posting content from private messages and displaying that subject matter on the public forum is
                   prohibited. ... <br>
               </p>
               <p class="lead">
                   <a class="btn btn-success btn-lg my-3" href="#" role="button">Learn more</a>
               </p>
           </div>
       </div>
       <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<div class="container">
           <h1 class="py-2 my-3">Start a Discussion</h1>
           <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
               <div class="form-group">
                   <label for="exampleInputEmail1">Problem Tittle</label>
                   <input type="text" class="form-control" id="tittle" name="tittle" aria-describedby="emailHelp"
                       placeholder="">
                   <small id="emailHelp" class="form-text text-muted">keep your tittle as short and crisp as possible
                   </small>

               </div>
               <div class="form-group my-4">
                   <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                   <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
               </div>
               <button type="submit" class="btn btn-success">Submit</button>
           </form>
       </div>';
        } else {
            echo '<div class="container">
           <h1 class="py-2 my-3">Start a Discussion</h1>
            <p class="lead">To start a Discussion first you need to log in </p>
        </div>';
        }
        ?>

       <div class="container">
           <h1 class="py-2 my-3">Browse Questions</h1>
           <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $id = $row['thread_id'];
                $tittle = $row['thread_tittle'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];
                echo '<div class="media">
               <img class="mr-3" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEABQODxIPDRQSEBIXFRQYHjIhHhwcHj0sLiQySUBMS0dARkVQWnNiUFVtVkVGZIhlbXd7gYKBTmCNl4x9lnN+gXwBFRcXHhoeOyEhO3xTRlN8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fP/AABEIAIIAggMBIgACEQEDEQH/xAAaAAEAAwEBAQAAAAAAAAAAAAAAAwQFAgEG/8QAKxAAAgIBAgQGAQUBAAAAAAAAAAECAxEEIRIxQVETIjJhcYGhBTNykcFS/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/APswAAAAAAAADxyS5tID0HnFF9V/Z6AAAAAAAAAAAAAAACO62NMOKX0u4HcpKMcyaSXVlK3XpbVRz7sq3XzulmT26LoiMCSeotn6pv4WxHz5gADqFs4emcl9nIAt1a+cdrFxLutmXqrYWxzB5/wxj2E5QlxQeGBtgr6bUq5Ye0107lgAAAAAAAADyUlGLlLZJbmRfc7rHJ8ui7Fr9QtwlUuu7KIAAAAd1VStliP2+xchoq0vM3J/0BQBoS0dTWya+GVb9NKrf1R7gQgAD2MnCSlF4aNbT3K6tSWz6oyCfR2+Hck/TLZgaoAAAAAAeSeItgZGonx3zl77EYAAJZeFzB3R+/DP/SA0aq1VBRX37s7AABrKw+TAzvgDLvr8K1x6dDgs6/8Adj/ErAAABs1T8SqMu6OyvoXnTR9sosAAAAPJbxfwegDDB3bHgtnHszgAE2mmuaAA1K5eJBSXU6wzOovlS9t4vmi5DVVSXq4X2YEuGMM4lqKorea+typfqnYnGC4Y9e7Aj1FniWtrktkRgAAABp6BY00fllki08eCiEfYlAAAAAAM79Qq4bFYuUtn8lQ2bq1bW4Pr+DHnBwk4yWGgPCajTSt3flj37nulo8WWZehfk0OWy5ARw09UFhRT93ucS0dUnlZj8MnAFdaKtPdyZJ4FXDw8CwSACldo3HzVbrt1KprlXV0ZTshzXqQFIk09fi3Rj05v4IzT0dHhV5kvNLn7AWQAAAAAAACvqtMro5jhTXJ9ywAIK61VXGC6I6JGsnDi0B4AAAAAA9SbOlHAFanRqFrnLdJ+VFsAAAAAAAAAAAAAAA8wjzhR0AOeFHuEegAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP/Z" width="70px" alt="Generic placeholder image">
               <div class="media-body">' .
                    '<h5 class="mt-0"> <a href="thread.php?threadid=' . $id . '"> ' . $tittle . '</a></h5>
               ' . $desc  . ' </div>' . '<p class="font-weight-bold"> Asked By:  at ' . $thread_time . '</p>' .
                    '</div>';
            }
            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid my-3">
                <div class="container">
                  <p class="display-5">No Comments Found</p>
                  <p class="lead">Be the first Person to comment</p>
                </div>
              </div>';
            }
            ?>
       </div>
       <?php include 'partials/_footer.php'; ?>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
       </script>
   </body>

   </html>