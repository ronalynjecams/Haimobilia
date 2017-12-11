<div class="quotations index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Quotations'); ?></h1>
			</div>
		</div><!-- end col md 12 -->
	</div><!-- end row -->



	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Quotation'), array('action' => 'add'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Companies'), array('controller' => 'companies', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Company'), array('controller' => 'companies', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('quote_number'); ?></th>
						<th><?php echo $this->Paginator->sort('company_id'); ?></th>
						<th><?php echo $this->Paginator->sort('user_id'); ?></th>
						<th><?php echo $this->Paginator->sort('terms'); ?></th>
						<th><?php echo $this->Paginator->sort('shipping_address'); ?></th>
						<th><?php echo $this->Paginator->sort('billing_address'); ?></th>
						<th><?php echo $this->Paginator->sort('sub_total'); ?></th>
						<th><?php echo $this->Paginator->sort('delivery_amount'); ?></th>
						<th><?php echo $this->Paginator->sort('installation_amount'); ?></th>
						<th><?php echo $this->Paginator->sort('discount'); ?></th>
						<th><?php echo $this->Paginator->sort('grand_total'); ?></th>
						<th><?php echo $this->Paginator->sort('collection_remarks'); ?></th>
						<th><?php echo $this->Paginator->sort('collection_date'); ?></th>
						<th><?php echo $this->Paginator->sort('status'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
						<th><?php echo $this->Paginator->sort('modified'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($quotations as $quotation): ?>
					<tr>
						<td><?php echo h($quotation['Quotation']['id']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['quote_number']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($quotation['Company']['name'], array('controller' => 'companies', 'action' => 'view', $quotation['Company']['id'])); ?>
		</td>
								<td>
			<?php echo $this->Html->link($quotation['User']['id'], array('controller' => 'users', 'action' => 'view', $quotation['User']['id'])); ?>
		</td>
						<td><?php echo h($quotation['Quotation']['terms']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['shipping_address']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['billing_address']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['sub_total']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['delivery_amount']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['installation_amount']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['discount']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['grand_total']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['collection_remarks']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['collection_date']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['status']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['created']); ?>&nbsp;</td>
						<td><?php echo h($quotation['Quotation']['modified']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $quotation['Quotation']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $quotation['Quotation']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $quotation['Quotation']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $quotation['Quotation']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<p>
				<small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
			</p>

			<?php
			$params = $this->Paginator->params();
			if ($params['pageCount'] > 1) {
			?>
			<ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
					echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
				?>
			</ul>
			<?php } ?>

		</div> <!-- end col md 9 -->
	</div><!-- end row -->


</div><!-- end containing of content -->