<?php  if (!empty($edit_products[0]->prod_gallery)) {?>
    <?php foreach(json_decode($edit_products[0]->prod_gallery) as $imagegallery){ ?>
    <input type="hidden" name="oldgallery[]" value="<?php echo $imagegallery;?>">
<?php }} ?>

{{-- Fahad Gallery Code --}}

<?php  $images = json_decode($edit_products[0]->prod_gallery);
    if (!empty($images)) {
        foreach (  $images as $images ) { ?>
            <img style="height:50px; width:50px;border-radius: 50%;" src="{{url('images/'.$images)}}"/>
            <a href="{{url('del_galery_image/'.$images.'/'.$edit_products[0]->id)}}">
                <button type="button" class="btn btn-danger" >Delete</button>
            </a>
<?php } } ?>

<?php if (!empty($pro[0]->images)) { ?>
    <?php foreach (json_decode($pro[0]->images) as $imagegallery) { ?>
    <input type="hidden" name="oldgallery[]" value="<?php echo $imagegallery; ?>">
<?php }} ?>
