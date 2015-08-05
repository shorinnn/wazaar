<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
		<div class="pagination-container clear">
            <ul>
            <?php echo with(new MaxPresenter($paginator))->render(); ?>
            </u>
		</div>

<?php endif; ?>
