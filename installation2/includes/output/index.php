<?php
/**
 * @package akeebainstaller
 * @copyright Copyright (C) 2009-2013 Nicholas K. Dionysopoulos. All rights reserved.
 * @author Nicholas K. Dionysopoulos - http://www.dionysopoulos.me
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL v3 or later
 *
 * Akeeba Backup Installer Output: The first page to load
 */

defined('_ABI') or die('Direct access is not allowed');

global $view;
extract($view);

$allGood = true;
foreach($phpOptions as $option) {
	if(!$option['state']) $allGood = false;
}
foreach($phpSettings as $option) {
	if(!$option['state']) $allGood = false;
}
foreach($directories as $option) {
	if(!$option['writable']) $allGood = false;
}
?>
<h2><?php echo ABIText::_('TITLE_SERVERSETUP') ?></h2>

<noscript>
<div style="font-size: 18pt; color: red; background: yellow; padding: 0em 1em 0.5em; margin: 0 2em 2em; border: thick solid #c00; border-top: none; box-shadow: #300 1px 1px 5px; border-radius: 0 0 10px 10px">
	<h1 style="font-size: 128pt; margin: 0; padding: 0; text-shadow: black 0 0 3px">
		<?php echo ABIText::_('INDEX_NOJS_STOP') ?>
	</h1>
	<p>
		<?php echo ABIText::_('INDEX_NOJS_YOUDISABLED') ?>
	</p>
	<p>
		<?php echo ABIText::_('INDEX_NOJS_DOENABLE') ?>
	</p>
</div>
</noscript>

<div id="accordion">

<?php if(!$allGood): ?>
<div id="mayday">
	<?php echo ABIText::_('SETUP_HELPME_HAVINGSOMETROUBLE') ?> <a href="https://www.akeebabackup.com/documentation/troubleshooter/abiredsettings.html" target="_blank"><?php echo ABIText::_('GENERIC_HELPME_CLICKHERE_TROUBLESHOOTING') ?></a>
</div>
<?php else: ?>
<div id="helpme">
	<?php echo ABIText::_('GENERIC_HELPME_WONDERING') ?> <a href="https://www.akeebabackup.com/documentation/quick-start-guide/abi-system-check.html" target="_blank"><?php echo ABIText::_('GENERIC_HELPME_CLICKHERE') ?></a>
</div>
<?php endif; ?>
	
<h3><?php echo ABIText::_('REQUIREMENTS') ?></h3>
<div class="categoryitems">
<table>
	<thead>
		<tr>
			<th><?php echo ABIText::_('ITEM'); ?></th>
			<th><?php echo ABIText::_('REALSET'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($phpOptions as $option): ?>
		<tr>
			<td><?php echo $option['label'] ?></td>
			<td><?php echo $option['state'] ? '<span class="green">'.ABIText::_('Yes').'</span>' : '<span class="red">'.ABIText::_('No').'</span>'  ?>
				<?php if(isset($option['notice'])): ?>
				<br/><?php echo $option['notice'] ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div>

<h3><?php echo ABIText::_('OPTIONAL_SETTINGS') ?></h3>
<div class="categoryitems">
<table>
	<thead>
		<tr>
			<th><?php echo ABIText::_('ITEM'); ?></th>
			<th><?php echo ABIText::_('RECSET'); ?></th>
			<th><?php echo ABIText::_('REALSET'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($phpSettings as $option): ?>
		<tr>
			<td><?php echo $option['label'] ?></td>
			<td><?php echo $option['setting'] ? ABIText::_('Yes') : ABIText::_('No') ?></td>
			<td><?php echo $option['state'] ? '<span class="green">' : '<span class="red">';
				echo $option['actual'] ? ABIText::_('Yes') : ABIText::_('No'); ?></span>
				<?php if(isset($option['notice'])): ?>
				<br/><?php echo $option['notice'] ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div>

<h3><?php echo ABIText::_('DIRECTORIES') ?></h3>
<div class="categoryitems">
<table>
	<thead>
		<tr>
			<th><?php echo ABIText::_('ITEM'); ?></th>
			<th><?php echo ABIText::_('REALSET'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($directories as $option): ?>
		<tr>
			<td><?php echo $option['label'] ?><br/><tt><?php echo $option['directory'] ?></tt></td>
			<td><?php echo $option['writable'] ? '<span class="green">' : '<span class="red">';
				echo $option['writable'] ? ABIText::_('Yes') : ABIText::_('No'); ?></span>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div>

</div>