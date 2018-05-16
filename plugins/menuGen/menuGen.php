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

/*
 * menu[0]['name'] = Main Menu
 * menu[0]['link'] = URL
 * menu[1]['name'] = SUBMENU
 * menu[1]['link'] = submenu[0]['name'] = "Subname"
 * submenu[1]['link'] = "URL"
 *
 */
function makeTreeArray($originalArray, $target = 0) {
    $a = $originalArray;
    $i = 0;
    $n = 0;
    if (is_array ( $originalArray )) {
        foreach ( $a ['idMenuItem'] as $idItem ) {
            if ($target == $a ['idParent'] [$i]) {
                $out [$n] ['name'] = $a ['itemName'] [$i];
                $out [$n] ['id'] = $a ['idMenuItem'] [$i];
                $out [$n] ['icon'] = $a ['icon'] [$i];
                $out [$n] ['class'] = $a ['class'] [$i];
                $out [$n] ['idprofile'] = $a ['idprofile'] [$i];
                $out [$n] ['idgroup'] = $a ['idgroup'] [$i];
                if (count ( makeTreeArray ( $originalArray, $a ['idMenuItem'] [$i] ) )) {
                    $out [$n] ['link'] = makeTreeArray ( $originalArray, $a ['idMenuItem'] [$i] );
                } else {
                    
                    $out [$n] ['link'] = $a ['address'] [$i];
                }
                $n ++;
            }
            $i ++;
        }
    }
    return $out;
}
class menuGen {
    private $myMenu;
    private $id;
    private $idgroup;
    private $idprofile;
    function install() {
        if (database::kolibriDB ()) {
            if (database::getType ( 'kolibriDB' ) == 'mysql') {
                $db = new mydataobj ();
                //$db->debug ( 1 );
                $db->setconn ( database::kolibriDB () );
                $sql = "CREATE TABLE  IF NOT EXISTS `menu` (
		          `idMenu` int(11) NOT NULL AUTO_INCREMENT,
		          `menuName` varchar(45) DEFAULT NULL,
		          `ativo` int(11) DEFAULT NULL,
				  `idgroup` int(11) DEFAULT NULL,
				  `idprofile` int(11) DEFAULT NULL,
		          PRIMARY KEY (`idMenu`)
		        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
                $db->query ( $sql );
                //debug::log ( '--------------------------------------------------------------' );
                
                $sql = "CREATE TABLE  IF NOT EXISTS `menuItem` (
		          `idMenuItem` int(11) NOT NULL AUTO_INCREMENT,
		          `itemName` varchar(45) DEFAULT NULL,
		          `idMenu` int(11) DEFAULT NULL,
		          `idParent` int(11) DEFAULT '0',
		          `address` varchar(200) DEFAULT NULL,
						`class` varchar(200) DEFAULT NULL,
						`name` varchar(200) DEFAULT NULL,
						`id` varchar(200) DEFAULT NULL,
						`icon` varchar(200) DEFAULT NULL,
						`idgroup` int(11) DEFAULT NULL,
				  		`idprofile` int(11) DEFAULT NULL,
		          `ativo` int(11) DEFAULT NULL,
		          PRIMARY KEY (`idMenuItem`)
		        ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
       				";
                // Has a Mysql Access create table Menu
                
                $db->query ( $sql );
                //debug::log ( '--------------------------------------------------------------' );
            } elseif (database::getType ( 'kolibriDB' ) == 'sqlite') {
                // or use SQL lite database
                $db = new mydataobj ();
                $db->setconn ( database::kolibriDB () );
                $db->setconType ( 'sqlite' );
                $db->query ( 'CREATE TABLE IF NOT EXISTS "menu" ("idMenu" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL , "menuName" VARCHAR, "ativo" INTEGER)' );
                $db->query ( "CREATE TABLE IF NOT EXISTS \"menuItem\" (\"idMenuItem\" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL , \"itemName\" VARCHAR, \"idMenu\" INTEGER, \"idParent\" INTEGER check(typeof(\"idParent\") = 'integer') , \"address\" VARCHAR, \"class\" VARCHAR, \"name\" VARCHAR, \"id\" VARCHAR, \"icon\" VARCHAR, \"ativo\" INTEGER)" );
            }
        }
    }
    
    
    function load($menu) {
        $this->myMenu = $menu;
    }
    function setId($id) {
        $this->id = $id;
    }
    function done() {
        /*
         * $out = '<nav id="' . $this->id . '">
         * <ul>' . "\n";
         */
        $out .= $this->htmlTreeGen ( $this->myMenu );
        // $out .= "</ul></nav>\n";
        return $out;
    }
    function htmlTreeGen($myArray, $idMenu = '', $delBtn = 0) {
        $out = "";
        // debug::log(print_r($myArray,true));
        if (is_array ( $myArray )) {
            foreach ( $myArray as $item ) {
                if (is_array ( $item ['link'] )) {
                    if (! $delBtn) {
                        $out .= "<li>
	<a href=''>" . $item ['name'] . "</a>
	<ul>\n";
                    } else {
                        $form = new formEasy ();
                        $cod = $form->formActionButton ( config::siteRoot () . "/index.php/menuManager/deleteItem/", "Delete", array (
                            "idMenuItem" => $item ['id'],
                            "idMenu" => $idMenu
                        ) );
                        $out .= "<li>
	<a href=''>" . $item ['name'] . "$cod</a>
	<ul>\n";
                        unset ( $form );
                    }
                    $out .= $this->htmlTreeGen ( $item ['link'], $idMenu, $delBtn );
                    $out .= "</ul>";
                } else {
                    if (! $delBtn) {
                        if ((strlen ( $item ['idprofile'] ) > 0) or (strlen ( $item ['idgroup'] ) > 0)) {
                            $s = new auth ();
                            $mygroup = $s->getloggedGroupId ();
                            $myprofile = $s->getloggedProfileId ();
                            if (($mygroup == $item ['idprofile']) or ($myprofile == $item ['idgroup'])) {
                                $out .= "<li><a href='" . $item ['link'] . "'><i class=\"" . $item ['icon'] . "\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;" . $item ['name'] . "</a></li>\n";
                            }
                            unset ( $s );
                        } else {
                            //<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                            $out .= "<li><a href='" . $item ['link'] . "'><i class=\"" . $item ['icon'] . "\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;" . $item ['name'] . "</a></li>\n";
                        }
                    } else {
                        $form = new formEasy ();
                        $cod = $form->formActionButton ( config::siteRoot () . "/index.php/menuManager/deleteItem/", "Delete", array (
                            "idMenuItem" => $item ['id'],
                            "idMenu" => $idMenu
                        ) );
                        $out .= "<a href='" . $item ['link'] . "'><span class=\"" . $item ['icon'] . "\" aria-hidden=\"true\"></span>&nbsp;&nbsp;&nbsp;" . $item ['name'] . "</a>$cod</li>\n";
                        unset ( $form );
                    }
                }
            }
        }
        
        return $out;
    }
    function htmlTreeTable($myArray, $idMenu = '', $delBtn = 0) {
        $z = 0;
        $form = new formEasy ();
        if (is_array ( $myArray ['idMenuItem'] )) {
            foreach ( $myArray ['idMenuItem'] as $id ) {
                
                if (strlen ( $myArray ['parentName'] [$z] ) != 0) {
                    $table ['Item'] [$z] = $myArray ['parentName'] [$z];
                } else {
                    $table ['Item'] [$z] = '/';
                }
                $table['Group'][$z] =  $myArray ['groupName'] [$z];
                $table['Profile'][$z] =  $myArray ['profileName'] [$z];
                $table ['Sub Item'] [$z] = "<span class=\"" . $myArray ['icon'] [$z] . "\" aria-hidden=\"true\"></span>&nbsp;&nbsp;&nbsp;" . $myArray ['itemName'] [$z];
                $table ['URL'] [$z] = $myArray ['address'] [$z];
                if ($delBtn) {
                    $table ['Action'] [$z] = $form->formActionIcon ( config::siteRoot () . "/index.php/menuManager/deleteItem/", "Delete", array (
                        "idMenu" => $idMenu,
                        'idMenuItem' => $id
                    ), 'glyphicon glyphicon-trash' );
                    ;
                }
                $z ++;
            }
        }
        $t = new htmlTable ();
        return $t->loadTable ( $table );
    }
    function addMenu($menuName,$idgroup,$idprofile) {
        $db = new mydataobj ();
        $db->debug ( 1 );
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->settable ( 'menu' );
        $db->setmenuName ( $menuName );
        $db->setidgroup($idgroup);
        $db->setidgprofile($idprofile);
        $db->setativo ( 1 );
        $db->save ();
        return $db->getlastinsertid ();
    }
    function listMenu() {
        $db = new mydataobj ();
        // $db->debug(1);
        
        $sql = "SELECT idMenu, menuName, ativo, groups.name as groupName, profile.name as profileName
				FROM menu
				left join groups on ( menu.idgroup = groups.idgroup )
				left join profile on ( menu.idprofile = profile.idprofile )
				where menu.ativo = 1";
        
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->settable ( 'menu' );
        $db->query($sql);
        $i = 0;
        while ( $db->getidMenu () ) {
            $out ['idMenu'] [$i] = $db->getidMenu ();
            $out ['menuName'] [$i] = $db->getmenuName ();
            $out ['groupName'] [$i] = $db->getgroupName ();
            $out ['profileName'] [$i] = $db->getprofileName ();
            $i ++;
            $db->next ();
        }
        return $out;
    }
    function delMenu($idMenu) {
        $db = new mydataobj ();
        // $db->debug(1);
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->settable ( 'menu' );
        $db->addkey ( 'ativo', 1 );
        $db->addkey ( 'idMenu', $idMenu );
        $db->setativo ( '-1' );
        $db->save ();
    }
    function addItemMenu($idMenu, $itemName, $address, $idParent = 0, $class, $name, $id, $icon, $idgroup = '', $idprofile = '') {
        $db = new mydataobj ();
        // $db->debug(1);
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->settable ( 'menuItem' );
        $db->setidMenu ( $idMenu );
        $db->setitemName ( $itemName );
        $db->setaddress ( $address );
        $db->setidParent ( $idParent );
        $db->setclass ( $class );
        $db->setname ( $name );
        $db->setid ( $id );
        $db->seticon ( $icon );
        $db->setidgroup ( $idgroup );
        $db->setidprofile ( $idprofile );
        $db->setativo ( 1 );
        $db->save ();
    }
    function listItemMenu($idMenu) {
        
        
        $s = new auth();
		$groupid =  $s->getloggedGroupId();
		$profileid = $s->getloggedProfileId();
        
        $sql = "SELECT 
				idParent, 
				menuItem.idMenuItem, 
				itemName,
				parentName, 
				class, 
				icon,  
				address,
				menuItem.idgroup, 
				menuItem.idprofile 
				FROM menuItem
				left join ( SELECT idMenuItem, itemName as parentName FROM menuItem ) as P on ( P.idMenuItem = menuItem.idParent )
				and ativo = 1
				and idMenu = '$idMenu' 
				and ( idgroup is null or idgroup = '$groupid' )
				and ( idprofile is null or idprofile = '$profileid' )
				order by idParent,itemName asc";
        
        $db = new mydataobj ();
        //$db->debug ( 1 );
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->query ( $sql );
        // $db->settable('menuItem');
        // $db->addkey('ativo', 1);
        // $db->addkey('idMenu', $idMenu);
        
        $i = 0;
        while ( $db->getidMenuItem () ) {
            $out ['idParent'] [$i] = $db->getidParent ();
            $out ['idMenuItem'] [$i] = $db->getidMenuItem ();
            $out ['itemName'] [$i] = $db->getitemName ();
            $out ['address'] [$i] = $db->getaddress ();
            $out ['parentName'] [$i] = $db->getparentName ();
            $out ['class'] [$i] = $db->getclass ();
            $out ['icon'] [$i] = $db->geticon ();
            $out ['idgroup'] [$i] = $db->getidgroup ();
            $out ['idprofile'] [$i] = $db->getidprofile ();
            $out ['groupName'] [$i] = $db->getgroupName ();
            $out ['profileName'] [$i] = $db->getprofileName ();
            $i ++;
            $db->next ();
        }
        
        return $out;
    }
    function getTreeArrayMenu($idMenu) {
        return makeTreeArray ( $this->listItemMenu ( $idMenu ) );
    }
    function delItemMenu($idItemMenu) {
        $db = new mydataobj ();
        // $db->debug(1);
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->settable ( 'menuItem' );
        $db->addkey ( 'ativo', 1 );
        $db->addkey ( 'idMenuItem', $idItemMenu );
        $db->setativo ( '-1' );
        $db->save ();
        unset ( $db );
        $db = new mydataobj ();
        // $db->debug(1);
        $db->setconn ( database::kolibriDB () );
        $db->setconType ( database::getType ( 'kolibriDB' ) );
        $db->settable ( 'menuItem' );
        $db->addkey ( 'ativo', 1 );
        $db->addkey ( 'idParent', $idItemMenu );
        $db->setativo ( '-1' );
        $db->save ();
    }
    function getMenuByName($name, $idHtml = '') {
        if (database::kolibriDB ()) {
            $db = new mydataobj ();
            // $db->debug(1);
            $db->setconn ( database::kolibriDB () );
            $db->setconType ( database::getType ( 'kolibriDB' ) );
            $db->settable ( 'menu' );
            $db->addkey ( 'menuName', $name );
            $db->addkey ( 'ativo', 1 );
            
            $s = new auth ();
            $mygroup = $s->getloggedGroupId ();
            $myprofile = $s->getloggedProfileId ();
            
            //debug::log("idgroup e idprofile do usuario corrente :  $mygroup / $myprofile ");
            
            if ($db->getidMenu ()) {
                
                $idg = $db->getidgroup();
                $idp = $db->getidprofile();
                
                //debug::log("idgroup e idprofile do menu corrente :  $idg / $idp ");
                
                if ((strlen ( $idg ) > 0) or (strlen ( $idp ) > 0)) {
                    if (($idg == $mygroup) or ($idp == $myprofile)) {
                        $id = $db->getidMenu ();
                        unset ( $db );
                        $m = new menuGen ();
                        $m->load ( $m->getTreeArrayMenu ( $id ) );
                        if (! $idHtml) {
                            $m->setId ( $name );
                        } else {
                            $m->setId ( $idHtml );
                        }
                        return $m->done ();
                    }
                } else {
                    $id = $db->getidMenu ();
                    unset ( $db );
                    $m = new menuGen ();
                    $m->load ( $m->getTreeArrayMenu ( $id ) );
                    if (! $idHtml) {
                        $m->setId ( $name );
                    } else {
                        $m->setId ( $idHtml );
                    }
                    return $m->done ();
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    function setprofile($idProfile) {
        $this->idprofile = $idProfile;
    }
    function setgroup($idGroup) {
        $this->idgroup = $idGroup;
    }
}
