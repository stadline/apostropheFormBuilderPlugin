<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>

	[?php slot('a-admin.current-header') ?]
	<th class="a-admin-<?php echo strtolower($field->getType()) ?> a-admin-list-th-<?php echo $name ?>">
	<?php if ($field->isReal()): ?>
	  [?php if ('<?php echo $name ?>' == $sort[0]): ?]
	    [?php echo link_to(__('<?php echo $field->getConfig('label') ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '<?php echo $this->getModuleName() ?>/index?sort=<?php echo $name ?>&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?]
	    [?php echo image_tag(sfConfig::get('app_aAdmin_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'apostrophe'), 'title' => __($sort[1], array(), 'apostrophe'))) ?]
	  [?php else: ?]
	    [?php echo link_to(__('<?php echo $field->getConfig('label') ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '<?php echo $this->getModuleName() ?>/index?sort=<?php echo $name ?>&sort_type=asc') ?]
	  [?php endif; ?]
	<?php else: ?>
	  [?php echo __('<?php echo $field->getConfig('label') ?>', array(), '<?php echo $this->getI18nCatalogue() ?>') ?]
	<?php endif; ?>
	</th>
	[?php end_slot(); ?]

<?php echo $this->addCredentialCondition("[?php include_slot('a-admin.current-header') ?]", $field->getConfig()) ?>

<?php endforeach; ?>

[?php foreach($a_form->aFormFieldsets as $aFormFieldset): ?]
[?php slot('a-admin.current-header') ?]
[?php if(count($aFormFieldset->aFormFields) > 1): ?]
  <th class="a-admin-text a-admin-list-th-field" style="text-align:center;" colspan="[?php echo count($aFormFieldset->aFormFields); ?]">
    [?php echo $aFormFieldset['label'] ?]
  </th>
[?php else: ?]
<th colspan="1"></th>
[?php endif; ?]

[?php end_slot(); ?]
[?php include_slot('a-admin.current-header') ?]
[?php endforeach ?]

