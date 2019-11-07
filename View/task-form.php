<?php include ('head.php')?>
<div class="container">
    <div class="row">
        <div class="page-header">
            File Loader
        </div>
        <div class="col-sm-4">
    <h4><?php echo $title; ?></h4>
        <form method="POST" action="" class="container-fluid form">
            <div class="form-group">
                <label for="file">File Name:</label>
                <input type="file" class="form-control" name="file" value="" required/>
            </div>
                <input type="hidden" name="form-submitted" value="1" />
                <input type="submit" class="btn btn-send" value="Submit" />
            </form>
        </div>
    </div>
</div>
<?php include ('foot.php');