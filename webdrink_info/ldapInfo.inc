<?php

// LDAP connection info
$ldapUser = "uid=";
$ldapPass = "";
$ldapHost = "ldap.csh.rit.edu";
$appDn = "ou=Apps,dc=csh,dc=rit,dc=edu";
$userDn = "ou=Users,dc=csh,dc=rit,dc=edu";

// Append the appropriate dn to the username
$ldapUser .= "," . $userDn;

// Connect to LDAP and bind the connection
try {
    $conn = ldap_connect($ldapHost);
    if (!ldap_bind($conn, $ldapUser, $ldapPass)) {
        die ('LDAP Bind Error...');
    }
}
catch (Exception $e) {
    die ('LDAP Connection Failed: ' . $e->getMessage());
}

?>