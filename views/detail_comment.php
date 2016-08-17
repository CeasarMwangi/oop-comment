<?php
require_once '../core/init.php';
include('parts/header.php');

$user = new User();
$results = 0;

if(!$user->isLoggedIn())
{

    Redirect::to('login.php');

}
else
{
    $posts = new Post();
    $comment = new Comment();
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET['id'];
//        $results = $posts->find_post_author_and_comments_and_their_authors($id);
//        $results = $comment->find_all_comments($id);
//        echo "Total comments = ".$comment->get_total_comments();
//        print_r($results);
//      var_dump($results);


//        get all posts and their authors
        $results = $posts->find_post_comments($id);
//        var_dump($results);
//        die();

//         get all posts and their authors
//        $results = $posts->find_posts_and_their_authors();
//        var_dump($results);


        // get all posts and their comments
//        $results = $posts->find_posts_and_their_comments();
//        var_dump($results);


        // get all comments and their authors
//        $results = $comment->find_comments_and_their_authors();
//        var_dump($results);

//        die();

    }


}
if(!$results){ ?>
    <section>
        <div class="container error">

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <p>No post(s)</p>
                </div>
            </div>

        </div>
    </section>
    <?php
}else {
    $num_posts = $posts->get_total_posts();
    $data = $posts->data();
    ?>
    <section>
        <div class="container">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="jumbotron">
                    <h1><?php echo $data->next(0)->title; ?></h1>

                    <p><?php echo $data->next(0)->content; ?></p>

                    <p>
                        <small>Published on: <?php echo $data->next(0)->publish_date; ?></small>
                    </p>

                    <p><a class="btn btn-primary btn-lg" href="?id=<?php echo $data->next(0)->id; ?>" role="button">Comment</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <?php if($data->next(0)->comment_text) { ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <p><?php echo $num_posts. " comment(s)" ?></p>
                </div>
            </div>

            <?php for ($i = 0; $i < $num_posts; $i++) { ?>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">

                        <h1><?php echo $data->next($i)->comment_text; ?></h1>

                        <p>
                            <small>Published on: <?php echo $data->next($i)->date; ?></small>
                        </p>
                        <hr>

                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php } ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <h1>Insert comment code here</h1>
                </div>
            </div>
        </div>
    </section>

    <?php

}
include('parts/footer.php');
