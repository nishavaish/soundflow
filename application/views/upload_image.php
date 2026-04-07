<form method="POST" action="<?php echo site_url('Assets/uploadFileS3'); ?>" enctype="multipart/form-data">
 \
   
   <input type="file" name="upload_image" accept="image/png, image/jpeg, image/jpg">
    <br><br>
    <button type="submit">Submit</button>
</form>