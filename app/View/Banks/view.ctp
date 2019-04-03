<div class="banks view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Bank'); ?></h1>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-3">
			<div class="actions">
				<div class="panel panel-default">
					<div class="panel-heading">Actions</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Bank'), array('action' => 'edit', $bank['Bank']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Bank'), array('action' => 'delete', $bank['Bank']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $bank['Bank']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Banks'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Bank'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Collections'), array('controller' => 'collections', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Collection'), array('controller' => 'collections', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div><!-- end body -->
				</div><!-- end panel -->
			</div><!-- end actions -->
		</div><!-- end col md 3 -->

		<div class="col-md-9">			
			<table cellpadding="0" cellspacing="0" class="table table-striped">
				<tbody>
				<tr>
		<th><?php echo __('Id'); ?></th>
		<td>
			<?php echo h($bank['Bank']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Name'); ?></th>
		<td>
			<?php echo h($bank['Bank']['name']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($bank['Bank']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($bank['Bank']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

<div class="related row">
	<div class="col-md-12">
	<h3><?php echo __('Related Collections'); ?></h3>
	<?php if (!empty($bank['Collection'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-striped">
	<thead>
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Quotation Id'); ?></th>
		<th><?php echo __('Paid Amount'); ?></th>
		<th><?php echo __('Ewt Amount'); ?></th>
		<th><?php echo __('Other Amount'); ?></th>
		<th><?php echo __('Balance'); ?></th>
		<th><?php echo __('Mode'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Cheque Date'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Bank Id'); ?></th>
		<th><?php echo __('Cheque Number'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"></th>
	</tr>
	<thead>
	<tbody>
	<?php foreach ($bank['Collection'] as $collection): ?>
		<tr>
			<td><?php echo $collection['id']; ?></td>
			<td><?php echo $collection['quotation_id']; ?></td>
			<td><?php echo $collection['paid_amount']; ?></td>
			<td><?php echo $collection['ewt_amount']; ?></td>
			<td><?php echo $collection['other_amount']; ?></td>
			<td><?php echo $collection['balance']; ?></td>
			<td><?php echo $collection['mode']; ?></td>
			<td><?php echo $collection['type']; ?></td>
			<td><?php echo $collection['cheque_date']; ?></td>
			<td><?php echo $collection['status']; ?></td>
			<td><?php echo $collection['bank_id']; ?></td>
			<td><?php echo $collection['cheque_number']; ?></td>
			<td><?php echo $collection['created']; ?></td>
			<td><?php echo $collection['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-search"></span>'), array('controller' => 'collections', 'action' => 'view', $collection['id']), array('escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>'), array('controller' => 'collections', 'action' => 'edit', $collection['id']), array('escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>'), array('controller' => 'collections', 'action' => 'delete', $collection['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $collection['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<?php endif; ?>

	<div class="actions">
		<?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Collection'), array('controller' => 'collections', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-default')); ?> 
	</div>
	</div><!-- end col md 12 -->
</div>
