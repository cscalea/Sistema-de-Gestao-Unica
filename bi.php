<?php
require_once("templates/header.php");
// Configurações de conexão LDAP
$ldap_host = "10.15.16.191"; // Endereço IP do servidor LDAP
$ldap_port = 389; // Porta LDAP padrão
$ldap_domain = "ipem.sp"; // Domínio do AD
$ldap_user = "casjunior"; // Usuário de acesso ao AD
$ldap_pass = "King@2134"; // Senha do usuário de acesso ao AD
$ldap_base_dn = "dc=ipem,dc=sp"; // Base DN do seu AD

// Dados do usuário para autenticação
$user = "casjunior";
$password = "King@2134";

// Conexão com o servidor LDAP
$ldap_conn = ldap_connect($ldap_host, $ldap_port) or die("Could not connect to LDAP server.");

if (!$ldap_conn) {
    echo "Falha ao conectar ao servidor LDAP.";
    exit;
}

ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

// Autenticação no servidor LDAP
$ldap_bind = ldap_bind($ldap_conn, "$user@$ldap_domain", $password);

if (!$ldap_bind) {
    echo "Falha na autenticação LDAP.";
    exit;
}

// Busca pelo usuário autenticado
$filter = "(&(objectClass=user)(objectCategory=person)(sAMAccountName=$user))";
$attributes = array("cn", "mail");

$search_result = ldap_search($ldap_conn, $ldap_base_dn, $filter, $attributes);
$entry = ldap_first_entry($ldap_conn, $search_result);
$values = ldap_get_values($ldap_conn, $entry, "mail");



// Fechar a conexão LDAP
ldap_close($ldap_conn);


require_once("templates/footer.php");
?>