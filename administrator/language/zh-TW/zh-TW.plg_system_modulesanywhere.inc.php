<?php
/**
 * Language Include File (English)
 * Can overrule set variables used in different elements
 *
 * @package     Modules Anywhere
 * @version     1.10.2
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @translation Peter van Westen <peter@nonumber.nl> NoNumber!
 */

// Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Variables that can be overruled:
 * $image
 * $title
 * $description
 * $help
 */

$description = '
	<p>在你的 Joomla! 網站任意位置輕松發布模組</p>
	<p>你可以通過下列語法來插入模組：<br />
	使用模組名稱： {<span style="color:green">module <span style="color:blue">主選單</span></span>}<br />
	使用模組 ID： {<span style="color:green">module <span style="color:blue">3</span></span>}</p>
	<p>你也可以使用這個方法來插入整個模組位置：<br />
	{<span style="color:green">modulepos <span style="color:blue">mainmenu</span></span>}</p>
	<p>如果要使用不同于預設樣式的其它樣式，可以這么做：<br />
	{<span style="color:green">module <span style="color:blue">主選單</span>|<span style="color:blue">horz</span></span>}<br />
	可選樣式： table, horz, xhtml, rounded, none (以及你模板支持的任何其它樣式).</p>
';