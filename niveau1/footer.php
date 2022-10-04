<footer>
    <small>♥ <?php echo $post['like_number'] ?> </small>
    <?php $arrTags=explode(',',$post['taglist']);
        foreach ($arrTags as &$tag) {
            ?>
            <a href="">#<?php echo $tag ?></a>
        <?php
        }
        ?>
</footer>