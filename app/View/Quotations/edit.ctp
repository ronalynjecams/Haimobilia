<div class="quotations form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Edit Quotation'); ?></h1>
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

																<li><?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Delete'), array('action' => 'delete', $this->Form->value('Quotation.id')), array('escape' => false), __('Are you sure you want to delete # %s?', $this->Form->value('Quotation.id'))); ?></li>
																<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Quotations'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Companies'), array('controller' => 'companies', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Company'), array('controller' => 'companies', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New User'), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Quotation', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('id', array('class' => 'form-control', 'placeholder' => 'Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('quote_number', array('class' => 'form-control', 'placeholder' => 'Quote Number'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('company_id', array('class' => 'form-control', 'placeholder' => 'Company Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('user_id', array('class' => 'form-control', 'placeholder' => 'User Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('terms', array('class' => 'form-control', 'placeholder' => 'Terms'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('shipping_address', array('class' => 'form-control', 'placeholder' => 'Shipping Address'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('billing_address', array('class' => 'form-control', 'placeholder' => 'Billing Address'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('sub_total', array('class' => 'form-control', 'placeholder' => 'Sub Total'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('delivery_amount', array('class' => 'form-control', 'placeholder' => 'Delivery Amount'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('installation_amount', array('class' => 'form-control', 'placeholder' => 'Installation Amount'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('discount', array('class' => 'form-control', 'placeholder' => 'Discount'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('grand_total', array('class' => 'form-control', 'placeholder' => 'Grand Total'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('collection_remarks', array('class' => 'form-control', 'placeholder' => 'Collection Remarks'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('collection_date', array('class' => 'form-control', 'placeholder' => 'Collection Date'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('status', array('class' => 'form-control', 'placeholder' => 'Status'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
