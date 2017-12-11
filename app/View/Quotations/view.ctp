<div class="quotations view">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Quotation'); ?></h1>
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
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-edit"></span>&nbsp&nbsp;Edit Quotation'), array('action' => 'edit', $quotation['Quotation']['id']), array('escape' => false)); ?> </li>
		<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete Quotation'), array('action' => 'delete', $quotation['Quotation']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $quotation['Quotation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Quotations'), array('action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Quotation'), array('action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Companies'), array('controller' => 'companies', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New Company'), array('controller' => 'companies', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp&nbsp;List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp&nbsp;New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
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
			<?php echo h($quotation['Quotation']['id']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Quote Number'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['quote_number']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Company'); ?></th>
		<td>
			<?php echo $this->Html->link($quotation['Company']['name'], array('controller' => 'companies', 'action' => 'view', $quotation['Company']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('User'); ?></th>
		<td>
			<?php echo $this->Html->link($quotation['User']['id'], array('controller' => 'users', 'action' => 'view', $quotation['User']['id'])); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Terms'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['terms']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Shipping Address'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['shipping_address']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Billing Address'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['billing_address']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Sub Total'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['sub_total']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Delivery Amount'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['delivery_amount']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Installation Amount'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['installation_amount']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Discount'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['discount']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Grand Total'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['grand_total']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Collection Remarks'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['collection_remarks']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Collection Date'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['collection_date']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Status'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['status']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Created'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['created']); ?>
			&nbsp;
		</td>
</tr>
<tr>
		<th><?php echo __('Modified'); ?></th>
		<td>
			<?php echo h($quotation['Quotation']['modified']); ?>
			&nbsp;
		</td>
</tr>
				</tbody>
			</table>

		</div><!-- end col md 9 -->

	</div>
</div>

