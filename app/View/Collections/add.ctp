<div class="collections form">

	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1><?php echo __('Add Collection'); ?></h1>
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

																<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Collections'), array('action' => 'index'), array('escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Quotations'), array('controller' => 'quotations', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Quotation'), array('controller' => 'quotations', 'action' => 'add'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;List Banks'), array('controller' => 'banks', 'action' => 'index'), array('escape' => false)); ?> </li>
		<li><?php echo $this->Html->link(__('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;New Bank'), array('controller' => 'banks', 'action' => 'add'), array('escape' => false)); ?> </li>
							</ul>
						</div>
					</div>
				</div>			
		</div><!-- end col md 3 -->
		<div class="col-md-9">
			<?php echo $this->Form->create('Collection', array('role' => 'form')); ?>

				<div class="form-group">
					<?php echo $this->Form->input('quotation_id', array('class' => 'form-control', 'placeholder' => 'Quotation Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('paid_amount', array('class' => 'form-control', 'placeholder' => 'Paid Amount'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('ewt_amount', array('class' => 'form-control', 'placeholder' => 'Ewt Amount'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('other_amount', array('class' => 'form-control', 'placeholder' => 'Other Amount'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('balance', array('class' => 'form-control', 'placeholder' => 'Balance'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('mode', array('class' => 'form-control', 'placeholder' => 'Mode'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('type', array('class' => 'form-control', 'placeholder' => 'Type'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('cheque_date', array('class' => 'form-control', 'placeholder' => 'Cheque Date'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('status', array('class' => 'form-control', 'placeholder' => 'Status'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('bank_id', array('class' => 'form-control', 'placeholder' => 'Bank Id'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->input('cheque_number', array('class' => 'form-control', 'placeholder' => 'Cheque Number'));?>
				</div>
				<div class="form-group">
					<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
				</div>

			<?php echo $this->Form->end() ?>

		</div><!-- end col md 12 -->
	</div><!-- end row -->
</div>
