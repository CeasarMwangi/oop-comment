<?php
require_once '../core/init.php';
include('parts/home_header.php');

$user = new User();
$results = 0;

if(!$user->isLoggedIn())
{

    Redirect::to('login.php');

}
else
{
    $posts = new Post();
    $results = $posts->findAll();
//    print_r($results);
//    var_dump($results);
//    echo gettype($results);

}
if(!$results){ ?>
    <section>
    <div class="container error">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <p>No posts</p>
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
            <?php for($i = 0; $i < $num_posts; $i++) { ?>
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="jumbotron">
                        <h1><?php echo $data->next($i)->title; ?></h1>
                        <p><?php echo $data->next($i)->content; ?></p>
                        <p><small><?php echo $data->next($i)->publish_date; ?></small></p>

                        <p><a class="btn btn-primary btn-lg" href="detail_comment.php?id=<?php echo $data->next($i)->id; ?>" role="button">View</a></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>


    <?php
}
include('parts/footer.php');
