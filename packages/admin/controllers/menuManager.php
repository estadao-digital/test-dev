<?php

/*
 *  Copyright (C) 2016 vagner    
 * 
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>. 
 */

class menuManager extends controller {

   function index() {
     
     
       $m = new menuGen();
       $v = new menuView();
       $v->listMenus($m->listMenu());
   }

   function menuNew() {
     
     
     $g = new userModel ();
     $tmp = $g->getgroupList ();
     $i = 0;
     foreach ( $tmp ['idgroup'] as $k ) {
     	$groupList [$i] [0] = $k;
     	$groupList [$i] [1] = $tmp ['name'] [$i];
     	$i ++;
     }
     $v  = new menuView();
     $v->menuNew($groupList);  
     
   }
   
   function saveMenu() {
       
       $m = new menuGen();
       $m->addMenu($this->request['menuName'],$this->request['group'],$this->request['profile']);
       $this->index();
       
   }
   
   function delete() {
       $m = new menuGen();
       $m->delMenu($this->request['idMenu']);
       $this->index();
   }
   
   function itens() {
       $m = new menuGen();
       $v = new menuView();
       $v->listMenusItens($m->listItemMenu($this->request['idMenu']),$this->request['idMenu']);
       
   }
 
   function menuNewItem() {
       $m = new menuGen();
       $v = new menuView();
       
       $g = new userModel ();
       $tmp = $g->getgroupList ();
       $i = 0;
       foreach ( $tmp ['idgroup'] as $k ) {
       	$groupList [$i] [0] = $k;
       	$groupList [$i] [1] = $tmp ['name'] [$i];
       	$i ++;
       }
       
       $v->newItem($m->listItemMenu($this->request['idMenu']),$this->request['idMenu'],$groupList);
       
   }
   
   function saveItem() {
       $m = new menuGen();
       $m->addItemMenu($this->request['idMenu'], $this->request['itemName'], $this->request['address'], $this->request['idParent'], $this->request['class'], $this->request['name'], $this->request['id'], $this->request['icon'],$this->request['group'],$this->request['profile']);
       $this->itens();
   }
   
   function deleteItem() {
         $m = new menuGen();
         $m->delItemMenu($this->request['idMenuItem']);
         $this->itens();
   }
}