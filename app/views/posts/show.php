<?php require APPROOT .'/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <h2>Posts</h2>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT ?>/posts" class="btn btn-success pencilFavIcon">
            <i class="fa fa-backward"></i>Back
        </a>
    </div>
</div>

    <div class="card mb-3 mt-4 card-body">
        <div class="card-title"><h2><?php echo $data['post']->title ?></h2></div>
        <div class="bg-light p-2 mb-3">
            Written by <?php echo $data['user']->name ?> on <?php echo $data['post']->created_at ?>
        </div>
        <p class="card-text"><?php echo $data['post']->body ?></p>
    </div>

    <?php if($_SESSION['user_id'] == $data['post']->user_id) : ?>
        <a href="<?php echo URLROOT; ?>/posts/edit/ <?php echo $data['post']->id ?>" class="btn btn-warning">Edit Post</a>
        <form class="pull-right" action="<?php echo  URLROOT;?>/posts/delete/<?php echo $data['post']->id ?>" method="POST">
            <input type="submit" class="btn btn-danger" value="Delete Post">
        </form>
    <?php endif; ?>
<?php require APPROOT .'/views/inc/footer.php'; ?>
