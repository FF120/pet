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
	<p>在你的 Joomla! 网站任意位置轻松发布模块</p>
	<p>你可以通过下列语法来插入模块：<br />
	使用模块名称： {<span style="color:green">module <span style="color:blue">主菜单</span></span>}<br />
	使用模块 ID： {<span style="color:green">module <span style="color:blue">3</span></span>}</p>
	<p>你也可以使用这个方法来插入整个模块位置：<br />
	{<span style="color:green">modulepos <span style="color:blue">mainmenu</span></span>}</p>
	<p>如果要使用不同于默认样式的其它样式，可以这么做：<br />
	{<span style="color:green">module <span style="color:blue">主菜单</span>|<span style="color:blue">horz</span></span>}<br />
	可选样式： table, horz, xhtml, rounded, none (以及你模板支持的任何其它样式).</p>
';