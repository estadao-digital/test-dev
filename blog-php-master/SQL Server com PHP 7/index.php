<?php

$connection = new PDO("sqlsrv:Database=hcodedb;server=localhost\SQLEXPRESS", "hcode", "root");

$statement = $connection->prepare("SELECT * FROM users;");

$statement->execute();

$users = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        table, th, tr, td {
            padding: 10px;
            font-size: 25px;
            border-collapse: collapse;
        }
        table, th {
            border: 2px solid #FF760C;
        }
        td {
            border-bottom: 1px solid #8395a7;
            border-right: 1px solid #8395a7;
        }
    </style>
</head>
<body>
    
    <table>
        <thead>
            <tr>
                <th>Nome do Usuário</th>
                <th>Idade</th>
            </tr>
        </thead>
        
        <tbody>

            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['age'] ?></td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</body>
</html>