<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>
<?php if ($paginator->getLastPage() > 1): ?>
            <?php if( isset($presenter->_presenterTableMode) ):?>
                <div class="pagination-container clear">
            <?php else: ?>
                <div class="table-pagination clear">
            <?php endif;?>
            <ul>
            <?php echo with(new MaxPresenter($paginator))->render(); ?>
            </u>
		</div>

<?php endif; ?>
