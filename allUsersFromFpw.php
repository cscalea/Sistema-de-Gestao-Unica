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
//ORACLE

$database = "fpwipem";
$username = "fpw";
$password = "Ip3m5pfpw";
$hostname = "(DESCRIPTION=
(ADDRESS_LIST=
  (ADDRESS=(PROTOCOL=TCP) 
    (HOST=10.15.16.92)(PORT=1521)
  )
)
(CONNECT_DATA=(SERVICE_NAME=fpwipem))
)";

$connection = oci_connect($username, $password, $hostname);

if (!$connection) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$query = 'select f.fumatfunc, f.funomfunc,
f.fucpf,
f.fuidentnum,
f.fuidentfun,
f.fucodcargo,
f.fucodlot,
c1.cadescargo,
f.fucargocom,
c2.cadescargo,
l.lodesclot,
fucodsitu, 
s.stdescsitu, s.sttipositu,f.fudtinisit
from funciona  f,
lotacoes  l,
cargos    c1,
cargos    c2,
situacao  s
where f.fucodlot  =  l.locodlot  
and f.fuorgresp  in (3,6)
and f.fucodsitu = s.stcodsitu
and f.fucargocom  = c1.cacodcargo (+)
and f.fucodcargo  = c2.cacodcargo (+)
order by f.funomfunc';
$stmt = oci_parse($connection, $query);
oci_execute($stmt);

?>
<a href="index.php" ;>home</a>
    <table id="customers">
        <tr>
            <th onclick="sortTable(0)" style="cursor: pointer;">Nome</th>
            
            <th onclick="sortTable(1)" style="cursor: pointer;">Cargo</th>
            
            <th onclick="sortTable(2)" style="cursor: pointer;">Cargo Comissionado</th>

    <th onclick="sortTable(3)" style="cursor: pointer;">Prontuário</th>

    <th onclick="sortTable(4)" style="cursor: pointer;">Matrícula</th>

    <th onclick="sortTable(5)" style="cursor: pointer;">Setor</th>
    
        </tr>


        <?php
        while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $setor = explode(" ", $row['LODESCLOT']);
            $setorformat = $setor[0];
        ?>
            <tr>
                <td>
               
                    <?php echo $row['FUNOMFUNC'] ?>

                </td>
                <td>
                <?php echo $row['CADESCARGO'] ?>
                </td>

                <td><?php echo $row['FUCODCARGO'] ?></td>
                
                <td><?php echo $row['FUMATFUNC'] ?></td>

                <td><?php echo $row['FUIDENTFUN'] ?></td>
                <td><?php echo $setorformat ?></td>

            </tr>
            <?php
        }
?>

    </table>
</div>

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




        
