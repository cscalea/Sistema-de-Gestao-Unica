<?php
$ldap_server = "10.15.16.191";
        $dominio = "ipem.sp"; //Dominio local ou global
        $user = "casjunior";
        $ldap_porta = "389";
        $ldap_pass   = "King@2134";
        $ldap_base_dn = "dc=ipem,dc=sp";
        $ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server."); //CONEXÃO LDAP

        if ($ldapcon) {

            ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0);

            $ldapbind = ldap_bind($ldapcon, "$user@$dominio", $ldap_pass);

            // verify binding

            if ($ldapbind) { //SUCESSO NA CONEXÃO
                // $this->verifyUser($_SESSION['login']); //FIRST ACCESS ???
                $filter = "(objectClass=user)"; //CONFIGURAÇÃO PARA RESGATAR DADOS DO USUÁRIO LOGADO
                $attributes = array("cn", "samaccountname", "mail");
                $search_result = ldap_search($ldapcon, $ldap_base_dn, $filter, $attributes);
                $entry = ldap_first_entry($ldapcon, $search_result);
                $fullname = ldap_get_values($ldapcon, $entry, "cn")[0];
                $email = ldap_get_values($ldapcon, $entry, "mail")[0];
                $name = ldap_get_values($ldapcon, $entry, "samaccountname")[0];
                $ldap_entries = ldap_get_entries($ldapcon, $search_result);
            }
        }