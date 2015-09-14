<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
            <?php if( isset($paginator->_presenterTableMode) && $paginator->_presenterTableMode==true ):?>
                <div class="table-pagination clear">
            <?php else: ?>
                <div class="pagination-container clear">
            <?php endif;?>
            <ul class="pagination">
            <?php echo with(new MaxPresenter($paginator))->render(); ?>
            </u>
		</div>

<?php endif; ?>
