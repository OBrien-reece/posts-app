<?php require APPROOT . '/views/inc/header.php';?>

<a href="<?php echo URLROOT ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<div class="container mt-4">
    <div class="card-body bg-light">
        <h2>Add Post</h2>
        <p>Use this form to add your post</p>
        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="POST">
            <div class="form-group">
                <label for="name">Title <sup>*</sup></label>
                <input type="title" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : '' ?>" value="<?php echo $data['title'] ?>">
                <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="name">Body <sup>*</sup></label>
                <textarea rows="8" name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : '' ?>"><?php echo $data['body'] ?></textarea>
                <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
            </div>
            <input type="submit" class="btn btn-danger" value="Edit Post">
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php';?>

