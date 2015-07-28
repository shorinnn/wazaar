<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>

            <ul>
            <?php echo with(new MaxPresenter($paginator))->render(); ?>
            </u>


<?php endif; ?>
