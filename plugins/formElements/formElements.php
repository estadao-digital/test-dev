<?php
/*
 * Copyright (C) 2016 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */
class formElements {
	private $type;
	private $value;
	public $name;
	private $id;
	private $class;
	private $size;
	private $checked;
	private $alt;
	private $disabled;
	private $maxlength;
	private $readonly;
	private $dir;
	private $lang;
	private $style;
	private $tabindex;
	private $title;
	private $onblur;
	private $onchange;
	private $onclick;
	private $ondbclick;
	private $onfocus;
	private $onmousedown;
	private $onmousemove;
	private $onmouseout;
	private $onmouseover;
	private $onmouseup;
	private $onkeydown;
	private $onkeypress;
	private $onkeyup;
	private $onselect;
	private $accesskey;
	private $align;
	private $accept;
	private $cols;
	private $rows;
	private $result;
	private $label;
	private $usedt;
	private $method;
	private $action;
	private $multiple;
	private $required;
	private $myStack;
	private $src;
	private $list;
	private $placeholder;
	private $pattern;
	private $target;
	
	function reset() {
		$this->type = '';
		$this->value = '';
		$this->name = '';
		$this->id = '';
		$this->class = '';
		$this->size = '';
		$this->checked = '';
		$this->alt = '';
		$this->disabled = '';
		$this->maxlength = '';
		$this->readonly = '';
		$this->dir = '';
		$this->lang = '';
		$this->style = '';
		$this->tabindex = '';
		$this->title = '';
		$this->onblur = '';
		$this->onchange = '';
		$this->onclick = '';
		$this->ondbclick = '';
		$this->onfocus = '';
		$this->onmousedown = '';
		$this->onmousemove = '';
		$this->onmouseout = '';
		$this->onmouseover = '';
		$this->onmouseup = '';
		$this->onkeydown = '';
		$this->onkeypress = '';
		$this->onkeyup = '';
		$this->onselect = '';
		$this->accesskey = '';
		$this->align = '';
		$this->accept = '';
		$this->cols = '';
		$this->rows = '';
		$this->label = '';
		$this->method = '';
		$this->action = '';
		$this->list = '';
		$this->target = '';
		$this->placeholder = '';
		$this->pattern= '';
		
		
	}
	function __constructor() {
	}
	function __call($method, $value) {
		foreach ( $value as $v ) {
			if ($v) {
				$out = $v;
			}
		}
		
		$method = strtolower ( $method );
		$this->$method = $out;
		return $this;
	}
	function closeSelect() {
		$output = "</select><br>";
		$this->myStack .= $output;
		return $output;
	}
	function closeDatalist() {
		$output = "</datalist><br>";
		$this->myStack .= $output;
		return $output;
	}
	function openForm() {
		if (! $this->method) {
			$this->method = 'POST';
		}
		$output = "<form ";
		if ($this->name) {
			$output .= " name='" . $this->name . "' ";
		}
		if ($this->id) {
			$output .= " id='" . $this->id . "' ";
		}
		if ($this->class) {
			$output .= " class='" . $this->class . "' ";
		}
		if ($this->method) {
			$output .= " method='" . $this->method . "' ";
		}
		if ($this->action) {
			$output .= " action='" . $this->action . "' ";
		}
		if ($this->type) {
			$output .= " enctype='" . $this->type . "' ";
		}
		if ($this->target) {
			$output .= " target='" . $this->target . "' ";
		}
		$output .= ">\n";
		$this->reset ();
		$this->myStack .= $output;
		return $output;
	}
	function closeForm() {
		$output = "</form>";
		$this->reset ();
		$this->myStack .= $output;
		return $output;
	}
	function addhtml($cod) {
		$this->myStack .= $cod;
	}
	function done() {
		if (($this->type == 'text') or ($this->type == 'password') or ($this->type == 'hidden') or ($this->type == 'file') or ($this->type == 'email') or ($this->type == 'color') or ($this->type == 'time') or ($this->type == 'date')) {
			
			$this->result = "<input type='" . $this->type . "' ";
			if ($this->value) {
				$this->result .= " value='" . $this->value . "' ";
			}
			if ($this->name) {
				$this->result .= " name='" . $this->name . "' ";
			}
			if ($this->placeholder) {
				$this->result .= " placeholder='" . $this->placeholder . "' ";
			}
			
			if ( $this->pattern) {
				$this->result .= " pattern='" . $this->pattern . "' ";
			}
			
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			if ($this->class) {
				$this->result .= " class='" . $this->class . "' ";
			}
			if ($this->size) {
				$this->result .= " size='" . $this->size . "' ";
			}
			if ($this->checked) {
				$this->result .= " checked='" . $this->checked . "' ";
			}
			if ($this->alt) {
				$this->result .= " alt='" . $this->alt . "' ";
			}
			if ($this->disabled) {
				$this->result .= " disabled='" . $this->disabled . "' ";
			}
			if ($this->maxlength) {
				$this->result .= " maxlength='" . $this->maxlength . "' ";
			}
			if ($this->readonly) {
				$this->result .= " readonly='" . $this->readonly . "' ";
			}
			if ($this->dir) {
				$this->result .= " dir='" . $this->dir . "' ";
			}
			if ($this->lang) {
				$this->result .= " lang='" . $this->lang . "' ";
			}
			if ($this->style) {
				$this->result .= " style='" . $this->style . "' ";
			}
			if ($this->tabindex) {
				$this->result .= " tabindex='" . $this->tabindex . "' ";
			}
			if ($this->title) {
				$this->result .= " title='" . $this->title . "' ";
			}
			if ($this->onblur) {
				$this->result .= " onblur='" . $this->onblur . "' ";
			}
			if ($this->onchange) {
				$this->result .= " onchange='" . $this->onchange . "' ";
			}
			if ($this->onclick) {
				$this->result .= " onclick='" . $this->onclick . "' ";
			}
			if ($this->ondbclick) {
				$this->result .= " ondbclick='" . $this->ondbclick . "' ";
			}
			if ($this->onfocus) {
				$this->result .= " onfocus='" . $this->onfocus . "' ";
			}
			if ($this->onmousedown) {
				$this->result .= " onmousedown='" . $this->onmousedown . "' ";
			}
			if ($this->onmousemove) {
				$this->result .= " onmousemove='" . $this->onmousemove . "' ";
			}
			if ($this->onmouseout) {
				$this->result .= " onmouseout='" . $this->onmouseout . "' ";
			}
			if ($this->onmouseover) {
				$this->result .= " onmouseover='" . $this->onmouseover . "' ";
			}
			if ($this->onmouseup) {
				$this->result .= " onmouseup='" . $this->onmouseup . "' ";
			}
			if ($this->onkeydown) {
				$this->result .= " onkeydown='" . $this->onkeydown . "' ";
			}
			if ($this->onkeypress) {
				$this->result .= " onkeypress='" . $this->onkeypress . "' ";
			}
			if ($this->onkeyup) {
				$this->result .= " onkeyup='" . $this->onkeyup . "' ";
			}
			if ($this->onselect) {
				$this->result .= " onselect='" . $this->onselect . "' ";
			}
			if ($this->accesskey) {
				$this->result .= " accesskey='" . $this->accesskey . "' ";
			}
			if ($this->align) {
				$this->result .= " align='" . $this->align . "' ";
			}
			if ($this->accept) {
				$this->result .= " accept='" . $this->accept . "' ";
			}
			if ($this->required) {
				$this->result .= " required ";
			}
			if ($this->list) {
				$this->result .= " list='" . $this->list . "'";
			}
			
			$this->result .= ">\n";
		}
		
		if (($this->type == 'textarea')) {
			
			$this->result = "<textarea ";
			if ($this->name) {
				$this->result .= " name='" . $this->name . "' ";
			}
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			if ($this->cols) {
				$this->result .= " cols='" . $this->cols . "' ";
			}
			if ($this->rows) {
				$this->result .= " rows='" . $this->rows . "' ";
			}
			if ($this->onblur) {
				$this->result .= " onblur='" . $this->onblur . "' ";
			}
			if ($this->onchange) {
				$this->result .= " onchange='" . $this->onchange . "' ";
			}
			if ($this->onclick) {
				$this->result .= " onclick='" . $this->onclick . "' ";
			}
			if ($this->ondbclick) {
				$this->result .= " ondbclick='" . $this->ondbclick . "' ";
			}
			if ($this->onfocus) {
				$this->result .= " onfocus='" . $this->onfocus . "' ";
			}
			if ($this->onmousedown) {
				$this->result .= " onmousedown='" . $this->onmousedown . "' ";
			}
			if ($this->onmousemove) {
				$this->result .= " onmousemove='" . $this->onmousemove . "' ";
			}
			if ($this->onmouseout) {
				$this->result .= " onmouseout='" . $this->onmouseout . "' ";
			}
			if ($this->onmouseover) {
				$this->result .= " onmouseover='" . $this->onmouseover . "' ";
			}
			if ($this->onmouseup) {
				$this->result .= " onmouseup='" . $this->onmouseup . "' ";
			}
			if ($this->onkeydown) {
				$this->result .= " onkeydown='" . $this->onkeydown . "' ";
			}
			if ($this->onkeypress) {
				$this->result .= " onkeypress='" . $this->onkeypress . "' ";
			}
			if ($this->onkeyup) {
				$this->result .= " onkeyup='" . $this->onkeyup . "' ";
			}
			if ($this->onselect) {
				$this->result .= " onselect='" . $this->onselect . "' ";
			}
			if ($this->accesskey) {
				$this->result .= " accesskey='" . $this->accesskey . "' ";
			}
			if ($this->class) {
				$this->result .= " class='" . $this->class . "' ";
			}
			if ($this->dir) {
				$this->result .= " dir='" . $this->dir . "' ";
			}
			if ($this->lang) {
				$this->result .= " lang='" . $this->lang . "' ";
			}
			if ($this->style) {
				$this->result .= " style='" . $this->style . "' ";
			}
			if ($this->tabindex) {
				$this->result .= " tabindex='" . $this->tabindex . "' ";
			}
			if ($this->title) {
				$this->result .= " title='" . $this->title . "' ";
			}
			
			if ($this->value) {
				$this->result .= ">" . $this->value . " </textarea>\n";
			} else {
				$this->result .= "> </textarea>\n";
			}
		}
		
		if (($this->type == 'select')) {
			
			$this->result = "<select ";
			if ($this->name) {
				$this->result .= " name='" . $this->name . "' ";
			}
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			if ($this->size) {
				$this->result .= " size='" . $this->size . "' ";
			}
			if ($this->multiple) {
				$this->result .= " multiple='multiple' ";
			}
			if ($this->onblur) {
				$this->result .= " onblur='" . $this->onblur . "' ";
			}
			if ($this->onchange) {
				$this->result .= " onchange='" . $this->onchange . "' ";
			}
			if ($this->onclick) {
				$this->result .= " onclick='" . $this->onclick . "' ";
			}
			if ($this->ondbclick) {
				$this->result .= " ondbclick='" . $this->ondbclick . "' ";
			}
			if ($this->onfocus) {
				$this->result .= " onfocus='" . $this->onfocus . "' ";
			}
			if ($this->onmousedown) {
				$this->result .= " onmousedown='" . $this->onmousedown . "' ";
			}
			if ($this->onmousemove) {
				$this->result .= " onmousemove='" . $this->onmousemove . "' ";
			}
			if ($this->onmouseout) {
				$this->result .= " onmouseout='" . $this->onmouseout . "' ";
			}
			if ($this->onmouseover) {
				$this->result .= " onmouseover='" . $this->onmouseover . "' ";
			}
			if ($this->onmouseup) {
				$this->result .= " onmouseup='" . $this->onmouseup . "' ";
			}
			if ($this->onkeydown) {
				$this->result .= " onkeydown='" . $this->onkeydown . "' ";
			}
			if ($this->onkeypress) {
				$this->result .= " onkeypress='" . $this->onkeypress . "' ";
			}
			if ($this->onkeyup) {
				$this->result .= " onkeyup='" . $this->onkeyup . "' ";
			}
			if ($this->onselect) {
				$this->result .= " onselect='" . $this->onselect . "' ";
			}
			if ($this->accesskey) {
				$this->result .= " accesskey='" . $this->accesskey . "' ";
			}
			if ($this->class) {
				$this->result .= " class='" . $this->class . "' ";
			}
			if ($this->dir) {
				$this->result .= " dir='" . $this->dir . "' ";
			}
			if ($this->lang) {
				$this->result .= " lang='" . $this->lang . "' ";
			}
			if ($this->style) {
				$this->result .= " style='" . $this->style . "' ";
			}
			if ($this->tabindex) {
				$this->result .= " tabindex='" . $this->tabindex . "' ";
			}
			if ($this->title) {
				$this->result .= " title='" . $this->title . "' ";
			}
			$this->result .= ">";
		}
		
		if (($this->type == 'option')) {
			
			$this->result = "<option ";
			if ($this->label) {
				$this->result .= " label='" . $this->label . "' ";
			}
			if ($this->disabled) {
				$this->result .= " disabled='" . $this->disabled . "' ";
			}
			if ($this->selected) {
				$this->result .= " selected";
			}
			// if ($this->value) {
			$this->result .= " value='" . $this->value . "' ";
			// }
			
			$this->result .= ">" . $this->label . "</option>\n";
		}
		
		if (($this->type == 'datalist')) {
			$this->result = "<datalist ";
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			$this->result .= ">\n";
		}
		
		if (($this->type == 'radio')) {
			
			$this->result = "<input type='radio' ";
			if ($this->name) {
				$this->result .= " name='" . $this->name . "' ";
			}
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			if ($this->class) {
				$this->result .= " class='" . $this->class . "' ";
			}
			if ($this->label) {
				$this->result .= " label='" . $this->label . "' ";
			}
			if ($this->disabled) {
				$this->result .= " disabled='" . $this->disabled . "' ";
			}
			if ($this->selected) {
				$this->result .= " selected='" . $this->selected . "' ";
			}
			if ($this->checked) {
				$this->result .= " checked='" . $this->checked . "' ";
			}
			if ($this->value) {
				$this->result .= " value='" . $this->value . "' ";
			}
			
			if ($this->label) {
				$this->result .= ">" . $this->label . "\n";
			} else {
				$this->result .= "></radio>\n";
			}
			
			$this->result .= "</radio>\n";
		}
		
		if (($this->type == 'checkbox')) {
			
			$this->result = "<input type='checkbox' ";
			if ($this->name) {
				$this->result .= " name='" . $this->name . "' ";
			}
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			if ($this->class) {
				$this->result .= " class='" . $this->class . "' ";
			}
			if ($this->label) {
				$this->result .= " label='" . $this->label . "' ";
			}
			if ($this->disabled) {
				$this->result .= " disabled='" . $this->disabled . "' ";
			}
			if ($this->selected) {
				$this->result .= " selected='" . $this->selected . "' ";
			}
			if ($this->checked) {
				$this->result .= " checked='" . $this->checked . "' ";
			}
			if ($this->value) {
				$this->result .= " value='" . $this->value . "' ";
			}
			
			if ($this->label) {
				$this->result .= ">" . $this->label . "\n";
			} else {
				$this->result .= ">\n";
			}
			
			// $this->result .= ">\n";
		}
		
		if (($this->type == 'submit') or ($this->type == 'button') or ($this->type == 'reset') or ($this->type == 'image')) {
			
			$this->result = "<input type='" . $this->type . "' ";
			if ($this->value) {
				$this->result .= " value='" . $this->value . "' ";
			}
			if ($this->name) {
				$this->result .= " name='" . $this->name . "' ";
			}
			if ($this->id) {
				$this->result .= " id='" . $this->id . "' ";
			}
			if ($this->class) {
				$this->result .= " class='" . $this->class . "' ";
			}
			if ($this->alt) {
				$this->result .= " alt='" . $this->alt . "' ";
			}
			if ($this->src) {
				$this->result .= " src='" . $this->src . "' ";
			}
			if ($this->disabled) {
				$this->result .= " disabled='" . $this->disabled . "' ";
			}
			if ($this->dir) {
				$this->result .= " dir='" . $this->dir . "' ";
			}
			if ($this->lang) {
				$this->result .= " lang='" . $this->lang . "' ";
			}
			if ($this->style) {
				$this->result .= " style='" . $this->style . "' ";
			}
			if ($this->tabindex) {
				$this->result .= " tabindex='" . $this->tabindex . "' ";
			}
			if ($this->title) {
				$this->result .= " title='" . $this->title . "' ";
			}
			if ($this->onblur) {
				$this->result .= " onblur='" . $this->onblur . "' ";
			}
			if ($this->onchange) {
				$this->result .= " onchange='" . $this->onchange . "' ";
			}
			if ($this->onclick) {
				$this->result .= " onclick='" . $this->onclick . "' ";
			}
			if ($this->ondbclick) {
				$this->result .= " ondbclick='" . $this->ondbclick . "' ";
			}
			if ($this->onfocus) {
				$this->result .= " onfocus='" . $this->onfocus . "' ";
			}
			if ($this->onmousedown) {
				$this->result .= " onmousedown='" . $this->onmousedown . "' ";
			}
			if ($this->onmousemove) {
				$this->result .= " onmousemove='" . $this->onmousemove . "' ";
			}
			if ($this->onmouseout) {
				$this->result .= " onmouseout='" . $this->onmouseout . "' ";
			}
			if ($this->onmouseover) {
				$this->result .= " onmouseover='" . $this->onmouseover . "' ";
			}
			if ($this->onmouseup) {
				$this->result .= " onmouseup='" . $this->onmouseup . "' ";
			}
			if ($this->onkeydown) {
				$this->result .= " onkeydown='" . $this->onkeydown . "' ";
			}
			if ($this->onkeypress) {
				$this->result .= " onkeypress='" . $this->onkeypress . "' ";
			}
			if ($this->onkeyup) {
				$this->result .= " onkeyup='" . $this->onkeyup . "' ";
			}
			if ($this->onselect) {
				$this->result .= " onselect='" . $this->onselect . "' ";
			}
			if ($this->accesskey) {
				$this->result .= " accesskey='" . $this->accesskey . "' ";
			}
			if ($this->align) {
				$this->result .= " align='" . $this->align . "' ";
			}
			if ($this->accept) {
				$this->result .= " accept='" . $this->accept . "' ";
			}
			$this->result .= ">\n";
		}
		
		if (! $this->label) {
			$output = $this->result . "\n";
		} else {
			if (($this->type != 'radio') and ($this->type != 'checkbox')) {
				$output .= "<label for='" . $this->id . "'>" . $this->label . "</label>" . $this->result . "<br>\n";
			} else {
				$output = $this->result . "\n";
			}
		}
		
		$this->reset ();
		$this->myStack .= $output;
		return $output;
	}
	function writeln() {
		echo $this->done () . '<br>';
	}
	function printform() {
		$out = $this->myStack;
		$this->myStack = '';
		return $out;
	}
}
?>