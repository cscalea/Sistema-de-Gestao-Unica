<style>
body {
  font-family: 'lato', sans-serif;
}
.container {
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 10px;
  padding-right: 10px;
}

h2 {
  font-size: 26px;
  margin: 20px 0;
  text-align: center;
  small {
    font-size: 0.5em;
  }
}

.responsive-table {
  li {
    border-radius: 3px;
    padding: 5px 10px;
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
  }
  .table-header {
    background-color: #95A5A6;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
  }
  /* .table-row {
    background-color: #ffffff;
    box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.1);
  } */
  .col-1 {
    flex-basis: 40%;
  }
  .col-2 {
    flex-basis: 20%;
  }
  .col-3 {
    flex-basis: 35%;
  }
 
  
  @media all and (max-width: 767px) {
    .table-header {
      display: none;
    }
    .table-row{
      
    }
    li {
      display: inline-block;
    }
    .col {
      
      flex-basis: 100%;
      
    }
    .col {
      display: flex;
      padding: 10px 0;
      &:before {
        color: #6C7A89;
        padding-right: 10px;
        content: attr(data-label);
        flex-basis: 50%;
        text-align: right;
      }
    }
  }
}
</style>


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
                


                
                ?>

 <a href="index.php";>home</a>
  <ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1">Nome</div>
      <div class="col col-2">Login</div>
      <div class="col col-3">E-mail</div>
    </li>

    <?php foreach ($ldap_entries as $entry): { ?>
    <li class="table-row">
      <div class="col col-1" data-label="Job Id"><?php if (isset($entry["cn"][0])) {
                        echo "Nome completo: " . $entry["cn"][0] . "<br>";
                    } 
                    ?>
                    </div>
      <div class="col col-2" data-label="Customer Name"><?php if (isset($entry["samaccountname"][0])) {
                        echo "Login: " . $entry["samaccountname"][0] . "<br>";
                    }  
                    ?>
                    </div>
      <div class="col col-3" data-label="Amount"><?php  if (isset($entry["mail"][0])) {
                        echo "E-mail: " . $entry["mail"][0] . "<br>";
                    } 
                    ?></div>
    </li>
<?php } endforeach; ?>
    
   
  </ul>



<?php


            }
        }