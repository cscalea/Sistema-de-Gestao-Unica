<?php
// Conexão com o servidor LDAP
$ldap_server = "10.15.16.191";
$ldap_username = "casjunior";
$ldap_password = "King@2134";
$ldap_conn = ldap_connect($ldap_server);
ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($ldap_conn) {
    // Autenticação no servidor LDAP
    $ldap_bind = ldap_bind($ldap_conn, $ldap_username, $ldap_password);

    if ($ldap_bind) {
        // Usuário autenticado, agora vamos buscar suas informações
        $filter = "(sAMAccountName={$_POST['username']})"; // Substitua $_POST['username'] pelo nome do campo do formulário
        $attributes = array("cn", "mail"); // Atributos que queremos buscar

        $search_result = ldap_search($ldap_conn, "seu_base_dn", $filter, $attributes);
        $entry = ldap_first_entry($ldap_conn, $search_result);

        if ($entry) {
            $fullname = ldap_get_values($ldap_conn, $entry, "cn")[0];
            $email = ldap_get_values($ldap_conn, $entry, "mail")[0];

            echo "Nome completo: $fullname<br>";
            echo "E-mail: $email<br>";
        } else {
            echo "Usuário não encontrado.";
        }
    } else {
        echo "Falha na autenticação LDAP.";
    }

    // Fechar conexão LDAP
    ldap_unbind($ldap_conn);
} else {
    echo "Falha ao conectar ao servidor LDAP.";
}
?>
