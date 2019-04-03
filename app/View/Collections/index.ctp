<div class="collections index">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Collections'); ?></h1>
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
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Collection'), array('action' => 'add'), array('escape' => false)); ?></li>
								<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Quotations'), array('controller' => 'quotations', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Quotation'), array('controller' => 'quotations', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Banks'), array('controller' => 'banks', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Bank'), array('controller' => 'banks', 'action' => 'add'), array('escape' => false)); ?> </li>
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
						<th><?php echo $this->Paginator->sort('quotation_id'); ?></th>
						<th><?php echo $this->Paginator->sort('paid_amount'); ?></th>
						<th><?php echo $this->Paginator->sort('ewt_amount'); ?></th>
						<th><?php echo $this->Paginator->sort('other_amount'); ?></th>
						<th><?php echo $this->Paginator->sort('balance'); ?></th>
						<th><?php echo $this->Paginator->sort('mode'); ?></th>
						<th><?php echo $this->Paginator->sort('type'); ?></th>
						<th><?php echo $this->Paginator->sort('cheque_date'); ?></th>
						<th><?php echo $this->Paginator->sort('status'); ?></th>
						<th><?php echo $this->Paginator->sort('bank_id'); ?></th>
						<th><?php echo $this->Paginator->sort('cheque_number'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
						<th><?php echo $this->Paginator->sort('modified'); ?></th>
						<th class="actions"></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($collections as $collection): ?>
					<tr>
						<td><?php echo h($collection['Collection']['id']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($collection['Quotation']['id'], array('controller' => 'quotations', 'action' => 'view', $collection['Quotation']['id'])); ?>
		</td>
						<td><?php echo h($collection['Collection']['paid_amount']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['ewt_amount']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['other_amount']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['balance']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['mode']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['type']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['cheque_date']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['status']); ?>&nbsp;</td>
								<td>
			<?php echo $this->Html->link($collection['Bank']['id'], array('controller' => 'banks', 'action' => 'view', $collection['Bank']['id'])); ?>
		</td>
						<td><?php echo h($collection['Collection']['cheque_number']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['created']); ?>&nbsp;</td>
						<td><?php echo h($collection['Collection']['modified']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $collection['Collection']['id']), array('escape' => false)); ?>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $collection['Collection']['id']), array('escape' => false)); ?>
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $collection['Collection']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $collection['Collection']['id'])); ?>
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