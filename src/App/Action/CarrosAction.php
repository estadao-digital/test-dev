<?php

namespace App\Action;

use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db\Adapter\AdapterInterface as DbAdapterInterface;
use Zend\Db\Sql\Sql as ZdbSQL;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;

class CarrosAction
{
    private $dbAdapter;

    public function __construct(DbAdapterInterface $dbAdapter)
    {
        $this->dbAdapter   = $dbAdapter;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $carro = $request->getAttribute('carro');
        $sql = new ZdbSQL($this->dbAdapter);

        if ($carro) {
            switch ($request->getMethod()) {
                case 'GET':
                    $select = $sql->select('carros');
                    $select->where(array('id' => $carro));

                    $statement = $sql->prepareStatementForSqlObject($select);
                    $result = $statement->execute();
                    return new JsonResponse(['carro' => $result->current()]);
                    break;
                case 'PUT':
                    //testar put
                    $update = $sql->update('carros');
                    $postData = $request->getQueryParams();
                    $update->set(['modelo' => $postData['modelo'], 'marca' => $postData['marca'], 'cor' => $postData['cor']]);
                    $update->where(array('id' => $carro));

                    $statement = $sql->prepareStatementForSqlObject($update);
                    $statement->execute();
                    return new JsonResponse(['carro' => $carro]);
                    break;
                case 'DELETE':
                    $delete = $sql->delete('carros');
                    $delete->where(array('id' => $carro));

                    $statement = $sql->prepareStatementForSqlObject($delete);
                    $statement->execute();
                    return new JsonResponse(['id' => $carro]);
                    break;
            }
        } else {
            switch ($request->getMethod()) {
                case 'GET':
                    $select = $sql->select('carros');
                    $statement = $sql->prepareStatementForSqlObject($select);
//                    var_dump($sql, $select);
                    $result = $statement->execute();

                    if ($result instanceof ResultInterface && $result->isQueryResult()) {
                        $resultSet = new ResultSet;
                        $resultSet->initialize($result);

                        foreach ($resultSet as $row) {
                            $allResults[] = ['id' => $row->id, 'modelo' => $row->modelo, 'marca' => $row->marca, 'cor' => $row->cor];
                        }
                    }
                    return new JsonResponse(['carros' => $allResults]);
                    break;
                case 'POST':
                    $insert = $sql->insert('carros');
                    $postData = $request->getQueryParams();
                    $insert->values(['modelo' => $postData['modelo'], 'marca' => $postData['marca'], 'cor' => $postData['cor']]);

                    $statement = $sql->prepareStatementForSqlObject($insert);
                    $result = $statement->execute();
                    return new JsonResponse(['carro' => $result->current()]);
                    break;
            }
        }

    }
}
