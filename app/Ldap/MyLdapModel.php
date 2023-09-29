<?php

namespace App\Ldap;

use LdapRecord\Models\Model;

class MyLdapModel extends Model
{
    /**
     * The object classes of the LDAP model.
     */
    public static array $objectClasses = [];
protected ?string $connection = 'ldap'; // Replace 'ldap' with your LDAP connection name if different


    protected $baseDn = 'dc=nacc,dc=go,dc=th';
}
