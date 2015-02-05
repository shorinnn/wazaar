<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <div class="pagination-container clearfix">
        <div class="page-numbers-container clearfix">
            <ul class="clearfix">
            <?php echo with(new MaxPresenter($paginator))->render(); ?>
            </u>
        </div>
    </div>
<?php endif; ?>
