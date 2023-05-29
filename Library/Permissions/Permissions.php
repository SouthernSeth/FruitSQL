<?php

class Permissions {

    private $permissionsTemplateFilepath = 'Includes/Perms/permissions_template.json';
    private $permissionsFilepath = 'Includes/Perms/permissions.json';

    private $groups = [];

    public function __construct() {
        $jsonString = '';

        if (file_exists($this->permissionsFilepath)) {
            $jsonString = file_get_contents($this->permissionsFilepath);
        } else {
            if (copy($this->permissionsTemplateFilepath, $this->permissionsFilepath)) {
                $jsonString = file_get_contents($this->permissionsFilepath);
            }
        }

        $jsonData = json_decode($jsonString, true);
        $this->LoadPermissionGroups($jsonData);
    }

    private function LoadPermissionGroups($parsedJson) {
        foreach ($parsedJson as $groupName => $value) {
            $group = new PermissionGroup($groupName);

            $permissions = $value["Permissions"];
            foreach ($permissions as $perm) {
                $group->AddPermission($perm);
            }

            $inheritedGroups = $value["InheritedGroups"];
            foreach ($inheritedGroups as $groupName) {
                $group->AddInheritedGroup($groupName);
            }

            array_push($this->groups, $group);
        }
    }

    public function HasPermission($groupName, $permission) {
        foreach ($this->groups as $groupObj) {
            $_groupName = $groupObj->GroupName();

            if ($_groupName == $groupName) {
                $groupPermissions = $groupObj->GroupPermissionsArray();
                $permission = strtolower($permission);
                foreach ($groupPermissions as $perm) {
                    $perm = strtolower($perm);

                    if ($perm == $permission) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function UserHasPermission($fruitsql, $userid, $permission) {
        $result = $fruitsql->Query('SELECT PermissionGroup FROM users WHERE ID = ' . $userid);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $groupName = strtolower($row["PermissionGroup"]);
                $hasPerm = $this->HasPermission($groupName, $permission);
                return $hasPerm;
            }
        }

        return false;
    }

    public function SetUserPermissionGroup($fruitsql, $userid, $permissiongroup) {
        $permissiongroup = strtoupper($permissiongroup);
        $result = $fruitsql->PreparedStatement('UPDATE users SET PermissionGroup=? WHERE ID=?', 'si', $permissiongroup, $userid);
        return $result;
    }

}

class PermissionGroup {

    private $groupName; // Name of permission group
    private $groupPermissions = []; // Array that stores strings of permission nodes
    private $inheritedGroups = []; // Array of groups that the group inherits permissions from

    public function __construct($groupName) {
        $this->groupName = $groupName;
    }

    public function AddPermission($permission) {
        array_push($this->groupPermissions, $permission);
    }

    public function AddInheritedGroup($groupName) {
        array_push($this->inheritedGroups, $groupName);
    }

    public function GroupName() {
        return strtolower($this->groupName);
    }

    public function GroupPermissionsArray() {
        return $this->groupPermissions;
    }

    public function InheritedGroupsArray() {
        return $this->inheritedGroups;
    }

}

/*

Usage:

Make sure to include this class in the php script you intend to call it from

Instantiate the class, this will load the permissions from the permissions.json or create the permissons.json if it doesnt exists:
$permissions = new Permissions();

You can now call the functions below:
1. $permissions->SetUserPermissionGroup($fruitsql, $userid, $permissiongroup);
2. $permissions->UserHasPermission($fruitsql, $userid, $permission);
3. $permissions->HasPermission($groupName, $permission);

*/

?>