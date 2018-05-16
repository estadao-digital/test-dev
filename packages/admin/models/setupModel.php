<?php
class setupModel {
    private $request;
    
    
    
    function addacl($page,$gid,$pid) {
    	$auth = new auth();
    	$auth->acl->setpage($page);
    	$auth->acl->setenable(1);
    	$auth->acl->setgroups_idgroup($gid);
    	$auth->acl->setprofile_idprofile($pid);
    	$auth->acl->saveAcl();
    	unset($auth);
    }
    function save($request) {
        $this->request = $request;
        debug::log(print_r($this->request,true));
        if ($this->request['secMode'] != 1) {
            // Secure mode Login !
            
            $myfile = fopen(getcwd() . '/config/config.php', "w");
            
            $file = "<?php
                
/*
*  Copyright (C) 2016 vagner
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
//--------------------------------------------------------------------------------------------
/*
  Templete default
*/
//config::set(\"theme\",\"default\");
config::set(\"theme\",\"material\");
//--------------------------------------------------------------------------------------------
/*
*
* set another vars ...
*
*/
config::set(\"\",\"\");
//--------------------------------------------------------------------------------------------
// Show exec time PHP script
config::set(\"showexectime\", 0);";
            $url = $this->request['siteUrl'];
            $file .= "
//Website URL
config::set(\"siteRoot\",'$url');
//--------------------------------------------------------------------------------------------";
            
            $siteName = $this->request['siteName'];
            $file .= "
//Website Name
config::set(\"siteName\",'$siteName');
//--------------------------------------------------------------------------------------------";
            
            $file .= "
// Default Controller
config::set(\"defaultController\",\"start\");
//--------------------------------------------------------------------------------------------
// Default Metlhod
config::set(\"defaultMethod\", \"index\");
//--------------------------------------------------------------------------------------------
// Recapcha Config
// Get this on https://www.google.com/recaptcha
config::set(\"recapchaSiteKey\",\"\");
config::set(\"recapchaSecretKey\",\"\");
//--------------------------------------------------------------------------------------------
/*
 *
 *  In this place you can configure access mode for some packages or Controllers
 *
 *  the modes is  open, login and closed
 *
 *  open : the access for public
 *
 *  login :  Login access is necessary to access
 *
 *  closed :  Deny all access
 *
 *  admin : For acces to Admin user type
 *
 *  if is not set on package or controller the DefaultAccess is apply
 *
 */
//--------------------------------------------------------------------------------------------";
            
            $file .= "
                
config::set(\"defaultAccess\",\"open\");
                
accesspkg::add(\"login\",\"open\");
accesspkg::add(\"pkgTest\",\"open\");
accesspkg::add(\"sys\",\"open\");
accesspkg::add(\"public\",\"open\");
                
# access::add(\"foo\",\"open\");
# access::add(\"bar\",\"login\");
# access::add(\"faa\",\"closed\");
access::add(\"ctrlTest\",\"login\");";
            
            fwrite($myfile, $file);
            fclose($myfile);
            
           
        } else {
            
            $dbType = $this->request['kdbServerType'];
            $dbHost = $this->request['kdbServerHost'];
            $dbPort = $this->request['kdbServerPort'];
            $dbUser = $this->request['kdbServerUser'];
            $dbPass = $this->request['kdbServerPass'];
            $dbData = $this->request['kdbServerData'];
            
            database::add('kolibriDB', "$dbType", "$dbHost", "$dbPort", "$dbUser", "$dbPass", "$dbData");
            $links = mysqli_connect($dbHost, $dbUser, $dbPass, $dbData, $dbPort) or die("DATABASE Access Error");
            
            if (database::kolibriDB()) {
                $auth = new auth();
                
                $auth->users->install();
                $auth->group->install();
                $auth->profile->install();
                $auth->acl->install();
                $auth->groupsprofiles->install();
                $auth->userObj->install();
                
                // creating groups
                $auth->group->setname('Admin Group');
                $auth->group->setenable(1);
                $gpid = $auth->group->save();
                
                
                // creating profile
                $auth->profile->setname('Admin Profile');
                $auth->profile->setgroups_idgroup($gpid);
                $auth->profile->setenable(1);
                $auth->profile->setadminprofile(0);
                $profId = $auth->profile->save();
                
              
                
                // creating ACLS
                $this->addAcl('acl/aclRemove', $gpid, $profId);
                $this->addAcl('acl/newAcl', $gpid, $profId);
                $this->addAcl('acl/profileAccess', $gpid, $profId);
                $this->addAcl('acl/saveAcl', $gpid, $profId);
                $this->addAcl('group/delGroup', $gpid, $profId);
                $this->addAcl('group/index', $gpid, $profId);
                $this->addAcl('group/newGroup', $gpid, $profId);
                $this->addAcl('group/saveGroup', $gpid, $profId);
                $this->addAcl('menuManager/delete', $gpid, $profId);
                $this->addAcl('menuManager/deleteItem', $gpid, $profId);
                $this->addAcl('menuManager/index', $gpid, $profId);
                $this->addAcl('menuManager/itens', $gpid, $profId);
                $this->addAcl('menuManager/menuNew', $gpid, $profId);
                $this->addAcl('menuManager/menuNewItem', $gpid, $profId);
                $this->addAcl('menuManager/saveItem', $gpid, $profId);
                $this->addAcl('menuManager/saveMenu', $gpid, $profId);
                $this->addAcl('profile/delProfile', $gpid, $profId);
                $this->addAcl('profile/groupProfile', $gpid, $profId);
                $this->addAcl('profile/index', $gpid, $profId);
                $this->addAcl('profile/listUsers', $gpid, $profId);
                $this->addAcl('profile/newProfile', $gpid, $profId);
                $this->addAcl('profile/profileName', $gpid, $profId);
                $this->addAcl('profile/saveProfile', $gpid, $profId);
                $this->addAcl('users/ajaxGroup', $gpid, $profId);
                $this->addAcl('users/ajaxProfile', $gpid, $profId);
                $this->addAcl('users/index', $gpid, $profId);
                $this->addAcl('users/listUser', $gpid, $profId);
                $this->addAcl('users/profileName', $gpid, $profId);
                $this->addAcl('users/saveUser', $gpid, $profId);
                $this->addAcl('users/userEdit', $gpid, $profId);
                
                // creating users
                
                $auth->users->setlogin('admin');
                $auth->users->setuserName('System Admin');
                $auth->users->setPassword($this->request['adminPassB']);
                $auth->users->setenable(1);
                $uid = $auth->users->save();
                
                // Set Profile Group of user
                $auth->groupsprofiles->setgroups_idgroup($gpid);
                $auth->groupsprofiles->setprofile_idprofile($profId);
                $auth->groupsprofiles->setusers_idusers($uid);
                $auth->groupsprofiles->save();
                
                
                $menu = new menuGen();
                $menu->install();
                $idMenu = $menu->addMenu('nav');
                // addItemMenu($idMenu, $itemName, $address, $idParent = 0, $class, $name, $id, $icon, $idgroup = '', $idprofile = '')
                $menu->addItemMenu($idMenu, 'Groups', '::siteroot::/index.php/group/index/', '', '', '', '', 'glyphicon glyphicon-user');
                $menu->addItemMenu($idMenu, 'Menu Editor', '::siteroot::/index.php/menuManager/index/', '', '', '', '', 'glyphicon glyphicon-th-list');
                $menu->addItemMenu($idMenu, 'Profiles', '::siteroot::/index.php/profile/index/', '', '', '', '', 'glyphicon glyphicon-tags');
                $menu->addItemMenu($idMenu, 'Users', '::siteroot::/index.php/users/index/', '', '', '', '', 'glyphicon glyphicon-user');
                
                // secure mode Open !
                $myfile = fopen(getcwd() . '/config/databases.php', "w");
                
                $file = "<?php
                
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
					
					
					/*
					* Here add connection to mysql using the above syntax
					* datababase::add(conectionName, host, port, user, pass, database);
					*/
					
					database::add(\"kolibriDB\",\"$dbType\" , \"$dbHost\", \"$dbPort\", \"$dbUser\", \"$dbPass\", \"$dbData\");
					#database::add(\"kolibriDB\",\"sqlite\" , __DIR__ . \"../data/menu.sqlite\", \"\", \"\", \"\", \"kolibri\");";
                fwrite($myfile, $file);
                fclose($myfile);
                
                $myfile = fopen(getcwd() . '/config/config.php', "w");
                
                $file = "<?php
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
//--------------------------------------------------------------------------------------------
/*
 *  Templete default
 */
//config::set(\"theme\",\"default\");
config::set(\"theme\",\"material\");
//--------------------------------------------------------------------------------------------
/*
 *
 * set another vars ...
 *
 */
config::set(\"\",\"\");
//--------------------------------------------------------------------------------------------
// Show exec time PHP script
config::set(\"showexectime\", 0);";
                $url = $this->request['siteUrl'];
                $file .= "//Website URL
					config::set(\"siteRoot\",'$url');
					//--------------------------------------------------------------------------------------------";
                
                $siteName = $this->request['siteName'];
                $file .= "//Website Name
					config::set(\"siteName\",'$siteName');
					//--------------------------------------------------------------------------------------------";
                
                $file .= "// Default Controller
config::set(\"defaultController\",\"start\");
//--------------------------------------------------------------------------------------------
// Default Metlhod
config::set(\"defaultMethod\", \"index\");
//--------------------------------------------------------------------------------------------
// Recapcha Config
// Get this on https://www.google.com/recaptcha
config::set(\"recapchaSiteKey\",\"\");
config::set(\"recapchaSecretKey\",\"\");
//--------------------------------------------------------------------------------------------
/*
 *
 *  In this place you can configure access mode for some packages or Controllers
 *
 *  the modes is  open, login and closed
 *
 *  open : the access for public
 *
 *  login :  Login access is necessary to access
 *
 *  closed :  Deny all access
 *
 *  admin : For acces to Admin user type
 *
 *  if is not set on package or controller the DefaultAccess is apply
 *
 */
//--------------------------------------------------------------------------------------------";
                
                $file .= "
                    
config::set(\"defaultAccess\",\"login\");
                    
accesspkg::add(\"login\",\"open\");
accesspkg::add(\"pkgTest\",\"open\");
accesspkg::add(\"sys\",\"open\");
accesspkg::add(\"public\",\"open\");
                    
# access::add(\"foo\",\"open\");
# access::add(\"bar\",\"login\");
# access::add(\"faa\",\"closed\");
access::add(\"ctrlTest\",\"login\");";
                
                fwrite($myfile, $file);
                fclose($myfile);
                page::addBody("Setup complete");
            } else {
                page::addBody("Fail ! Database not accessible");
            }
            
            page::render();
        }
    }
}