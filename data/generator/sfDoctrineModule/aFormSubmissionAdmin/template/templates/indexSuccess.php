[?php use_helper('I18N', 'Date', 'jQuery') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="a-admin-container" class="[?php echo $sf_params->get('module') ?]">

  [?php include_partial('<?php echo $this->getModuleName() ?>/list_bar', array('a_form' => $a_form, 'filters' => $filters)) ?]

	<div id="a-admin-content" class="main">
		
		<ul id="a-admin-list-actions" class="a-controls a-admin-action-controls">
  		<li class="filters">[?php echo jq_link_to_function("Filters", "$('#a-admin-filters-container').slideToggle()" ,array('class' => 'a-btn icon a-settings', 'title'=>'Filter Data')) ?]</li>
			[?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]		
		</ul>
		<?php if ($this->configuration->hasFilterForm()): ?>
		  [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
		<?php endif; ?>

		[?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
		<?php if ($this->configuration->getValue('list.batch_actions')): ?>
			<form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post" id="a-admin-batch-form">
		<?php endif; ?>
		[?php include_partial('<?php echo $this->getModuleName() ?>/list', array('a_form' => $a_form, 'pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
				<ul class="a-admin-actions">
		      [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
		    </ul>
		<?php if ($this->configuration->getValue('list.batch_actions')): ?>
		  </form>
		<?php endif; ?>
	</div>

  <div id="a-admin-footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>

</div>
