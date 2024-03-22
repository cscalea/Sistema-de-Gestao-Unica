<?php require_once("config/db.php");
require_once("dao/UserDAO.php");
$userDao = new UserDAO($conn, $BASE_URL);
?>

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 2px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<?php
// $userDao->allUsersFromAd();
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
    <table>
  <tr>
    <th>Nome</th>
    <th>Login</th>
    <th>E-mail</th>
    <th>Setor</th>
  </tr>
  
  <?php foreach ($ldap_entries as $entry) : { ?>
  <tr>
    <td><?php if (isset($entry["cn"][0])) {
                      echo "Nome completo: " . $entry["cn"][0] . "<br>";
                    
                    } ?></td>
    <td><?php if (isset($entry["samaccountname"][0])) {
                        echo "Login: " . $entry["samaccountname"][0] . "<br>";
                        
                    } ?></td>
    <td><?php if (isset($entry["mail"][0])) {
                        echo "E-mail: " . $entry["mail"][0] . "<br>";
                        
                    } ?></td>
    <td><?php if (isset($entry["department"][0])) {
                        echo "Departamento: " . $entry["department"][0] . "<br>";
                   
                    } ?> </td>
                    <?php
  
  
  
 
 
  
?>
  </tr>
                    


  <?php } endforeach; ?>
</table>

  <?php
  }
}
