<?php
/**
 * @package    FrameworkOnFramework
 * @copyright  Copyright (C) 2010 - 2012 Akeeba Ltd. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// Protect from unauthorized access
defined('_JEXEC') or die();

if (!class_exists('JFormFieldText'))
{
	require_once JPATH_LIBRARIES . '/joomla/form/fields/text.php';
}

/**
 * Form Field class for the FOF framework
 * Supports a one line text field.
 *
 * @since       2.0
 */
class FOFFormFieldText extends JFormFieldText implements FOFFormField
{

	protected $static;
	protected $repeatable;

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   2.0
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'static':
				if (empty($this->static))
				{
					$this->static = $this->getStatic();
				}

				return $this->static;
				break;

			case 'repeatable':
				if (empty($this->repeatable))
				{
					$this->repeatable = $this->getRepeatable();
				}

				return $this->static;
				break;

			default:
				return parent::__get($name);
		}
	}

	/**
	 * Get the rendering of this field type for static display, e.g. in a single
	 * item view (typically a "read" task).
	 *
	 * @since 2.0
	 */
	public function getStatic()
	{
		$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$empty_replacement = '';
		if ($this->element['empty_replacement'])
		{
			$empty_replacement = (string) $this->element['empty_replacement'];
		}

		if (!empty($empty_replacement) && empty($this->value))
		{
			$this->value = JText::_($empty_replacement);
		}

		return '<span id="' . $this->id . '" ' . $class . '>' .
			htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') .
			'</span>';
	}

	/**
	 * Get the rendering of this field type for a repeatable (grid) display,
	 * e.g. in a view listing many item (typically a "browse" task)
	 *
	 * @since 2.0
	 */
	public function getRepeatable()
	{
		// Initialise
		$class = '';
		$format_string = '';
		$show_link = false;
		$link_url = '';
		$empty_replacement = '';

		// Get field parameters
		if ($this->element['class'])
		{
			$class = ' class="' . (string) $this->element['class'] . '"';
		}
		if ($this->element['format'])
		{
			$format_string = (string) $this->element['format'];
		}
		if ($this->element['show_link'] == 'true')
		{
			$show_link = true;
		}
		if ($this->element['url'])
		{
			$link_url = $this->element['url'];
		}
		else
		{
			$show_link = false;
		}
		if ($show_link && ($this->item instanceof FOFTable))
		{
			// Replace [ITEM:ID] in the URL with the item's key value (usually:
			// the auto-incrementing numeric ID)
			$keyfield = $this->item->getKeyName();
			$replace = $this->item->$keyfield;
			$link_url = str_replace('[ITEM:ID]', $replace, $link_url);

			// Replace other field variables in the URL
			$fields = $this->item->getFields();
			foreach ($fields as $fielddata)
			{
				$fieldname = $fielddata->Field;
				$search = '[ITEM:' . strtoupper($fieldname) . ']';
				$replace = $this->item->$fieldname;
				$link_url = str_replace($search, $replace, $link_url);
			}
		}
		else
		{
			$show_link = false;
		}

		if ($this->element['empty_replacement'])
		{
			$empty_replacement = (string) $this->element['empty_replacement'];
		}

		// Get the (optionally formatted) value
		if (!empty($empty_replacement) && empty($this->value))
		{
			$this->value = JText::_($empty_replacement);
		}
		if (empty($format_string))
		{
			$value = htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
		}
		else
		{
			$value = sprintf($format_string, $this->value);
		}

		// Create the HTML
		$html = '<span id="' . $this->id . '" ' . $class . '>';

		if ($show_link)
		{
			$html .= '<a href="' . $link_url . '">';
		}

		$html .= $value;

		if ($show_link)
		{
			$html .= '</a>';
		}

		$html .= '</span>';
		return $html;
	}

}
