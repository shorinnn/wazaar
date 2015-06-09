<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <div class="pagination pagination-container clearfix">
        <div class="page-numbers-container clearfix">
            <ul class="clearfix">
            <?php echo with(new MaxPresenter($paginator))->render(); ?>
            </u>
<!--            <div class="skip-to">
                <span>SKIP TO</span>
                <input type="text" name="skip-to">
            </div>-->
        </div>
    </div>
<?php endif; ?>
