<?php require APPROOT .'/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <h2>Posts</h2>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT ?>/posts/add" class="btn btn-success pencilFavIcon">
            <i class="fa fa-pencil"></i>Add Post
        </a>
    </div>
</div>

<?php foreach ($data['posts'] as $post) : ?>

    <div class="card mb-3 mt-4 card-body">
        <div class="card-title"><?php echo $post->title ?></div>
        <div class="bg-light p-2 mb-3">
            Written by <?php echo $post->name ?> on <?php echo $post->postCreatedAt ?>
        </div>
        <p class="card-text"><?php echo $post->body ?></p>
        <a href="<?php echo URLROOT ?>/posts/show/<?php echo $post->postId ?>" class="btn btn-dark">View More</a>
    </div>

<?php endforeach; ?>
<?php require APPROOT .'/views/inc/footer.php'; ?>
