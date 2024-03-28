<?php require_once("config/db.php");
require_once("dao/UserDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
?>

<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>

<?php
// $userDao->allUsersFromAd();
$ldap_server = "10.15.16.191";
$dominio = "ipem.sp"; //Dominio local ou global
$user = "svc_app";
$ldap_porta = "389";
$ldap_pass   = "Ipem@2024";
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
        $attributes = array("cn", "samaccountname", "mail", "department");
        $search_result = ldap_search($ldapcon, $ldap_base_dn, $filter, $attributes);
        $entry = ldap_first_entry($ldapcon, $search_result);
        // $fullname = ldap_get_values($ldapcon, $entry, "cn")[0];
        // $email = ldap_get_values($ldapcon, $entry, "mail")[0];
        // $name = ldap_get_values($ldapcon, $entry, "samaccountname")[0];
        // $departamento = ldap_get_values($ldapcon, $entry, "samaccountname")[0];
        $ldap_entries = ldap_get_entries($ldapcon, $search_result);
?>

        <a href="index.php" ;>home</a>

        <table id="customers">
            <tr>
                <th onclick="sortTable(0)" style="cursor: pointer;">Nome</th>
                <th onclick="sortTable(1)" style="cursor: pointer;">Login</th>
                <th onclick="sortTable(2)" style="cursor: pointer;">E-mail</th>
                <th onclick="sortTable(3)" style="cursor: pointer;">Setor</th>
            </tr>
            <?php
            foreach ($ldap_entries as $entry) : {

            ?>
                    <?php if (isset($entry["department"][0])) : { ?>
                            <tr>
                                <td>
                                    <?php if (isset($entry["cn"][0])) {
                                        echo $entry["cn"][0] . "<br>";
                                    } ?>
                                </td>
                                <td>
                                    <?php if (isset($entry["samaccountname"][0])) {
                                        echo $entry["samaccountname"][0] . "<br>";
                                    } ?>
                                </td>
                                <td><?php if (isset($entry["mail"][0])) {
                                        echo  $entry["mail"][0] . "<br>";
                                    } ?></td>
                                <td><?php if (isset($entry["department"][0])) {
                                        echo $entry["department"][0] . "<br>";
                                    } ?></td>
                        <?php }
                    endif; ?>
                <?php }
            endforeach;  ?>
                            </tr>
                        <?php
                    }
                        ?>

        </table>

        <script>
            function sortTable(colIndex) {
                var table = document.getElementById("customers");
                var rows = Array.from(table.rows).slice(1); // Ignora a linha de cabeçalho
                var sortOrder = 1;

                // Alterna a ordem de classificação ao clicar na mesma coluna novamente
                if (table.lastSortedColumn === colIndex) {
                    sortOrder = -1;
                    table.lastSortedColumn = null; // Remove a coluna de classificação anterior
                } else {
                    table.lastSortedColumn = colIndex;
                }

                rows.sort((a, b) => {
                    var aText = a.cells[colIndex].textContent.trim().toLowerCase();
                    var bText = b.cells[colIndex].textContent.trim().toLowerCase();
                    return sortOrder * aText.localeCompare(bText);
                });

                // Reordena as linhas na tabela
                table.tBodies[0].append(...rows);
            }
        </script>
    <?php

}
