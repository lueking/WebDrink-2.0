<?php

namespace WebDrink\Utils;


use Exception;

class LDAP {
    private $userDn = "cn=users,cn=accounts,dc=csh,dc=rit,dc=edu";
    private $appDn = "cn=services,cn=accounts,dc=csh,dc=rit,dc=edu";
    private $conn = null;


    public function __construct() {
        // LDAP connection info
        $ldapUser = LDAP_USER;
        $ldapPass = LDAP_PASS;
        $ldapHost = LDAP_HOST;

        // Append the appropriate dn to the username
        if (LDAP_APP) {
            $ldapUser .= "," . $this->appDn;
        } else {
            $ldapUser .= "," . $this->userDn;
        }

        // Connect to LDAP and bind the connection
        $conn = ldap_connect($ldapHost);
        if (!ldap_bind($conn, $ldapUser, $ldapPass)) {
            print("LDAP ERROr!");
            print(ldap_err2str(ldap_errno($conn)));
            throw new Exception("BAAAD");
        } else {
            $this->conn = $conn;
        }
    }

    private function getconn(){
        if(is_null($this->conn)){
            throw new Exception("Error, no connection to LDAP");
        }

        return $this->conn;
    }

    function ldap_lookup($uid, $fields = null) {
            // Make the search
            $filter = "(uid=" . $uid . ")";

            if (is_array($fields)) {
                $search = ldap_search($this->getconn(), $this->userDn, $filter, $fields);

            } else
                $search = ldap_search($this->getconn(), $this->userDn, $filter);
            // Grab the results
            if ($search)
                return ldap_get_entries($this->getconn(), $search);
            else
                return false;

    }

    function ldap_lookup_uid($uid, $fields = null) {
        return $this->ldap_lookup($uid, $fields);
    }

    function ldap_lookup_ibutton($ibutton, $fields = null) {
        try {
            // Make the search
            $filter = "(ibutton=" . $ibutton . ")";
            if (is_array($fields))
                $search = ldap_search($this->conn, $this->userDn, $filter, $fields);
            else
                $search = ldap_search($this->conn, $this->userDn, $filter);
            // Grab the results
            if ($search)
                return ldap_get_entries($this->conn, $search);
            else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }

    function ldap_update($uid, $replace) {
        try {
            // Form the dn
            $dn = "uid=" . $uid . "," . $this->userDn;
            // Make the update
            return ldap_mod_replace($this->conn, $dn, $replace);
        } catch (Exception $e) {
            return false;
        }
    }
}