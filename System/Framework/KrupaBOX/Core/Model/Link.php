<?php

namespace Model
{

    use KrupaBOX\Internal\Kernel;
    use Symfony\Component\Config\Definition\Exception\Exception;

    class Link extends \Arr
    {
        const OPERATOR_EQUALS = "=";
        const OPERATOR_NOT_EQUALS = "!=";
        
        const OPERATOR_OR_EQUALS = "|="; // TODO: diff QEX
        const OPERATOR_OR_NOT_EQUALS = "|!="; // TODO: diff QEX
        
        const OPERATOR_LIKE = "%=";
        const OPERATOR_NOT_LIKE = "!%";
        
        const OPERATOR_OR_LIKE = "|%="; // TODO: diff QEX
        const OPERATOR_OR_NOT_LIKE = "|!%"; // TODO: diff QEX
        
        const OPERATOR_BIGGER  = ">";
        const OPERATOR_SMALLER = "<";
        
        const OPERATOR_OR_BIGGER  = ">"; // TODO: diff QEX
        const OPERATOR_OR_SMALLER = "<"; // TODO: diff QEX

        const ORDER_ASC  = \Model::ORDER_ASC;
        const ORDER_DESC = \Model::ORDER_DESC;

        protected static $useCache    = false;
        protected static $linkCIDB    = null;
        protected static $memoryCache = null;
        
        protected $modelInstanceRef = null;
        protected $structure        = null;
        protected $joinsStructures  = null;

        protected $structureHash = null;
        
        // Clean after query
        protected $currentJoin = null;
         
        protected $selectFields = null;
        protected $whereFields  = null;
        protected $setFields    = null;
        protected $orderFields  = null;
        
        protected $limit    = null;
        protected $offset   = null;
        // Clean after query END

        protected static $config = null;

        protected static $isInitialized = false;
        protected static function __onInitialize()
        {
            if (self::$isInitialized == true) return;
            self::$isInitialized = true;

            self::$config = \Config::get();
            //if (self::$config->database->cache == true)
            self::$useCache = true;
            self::cleanMemory();
        }

        public static function cleanMemory()
        {
            // Force remove from alread get instance in all code
            if (self::$memoryCache !== null)
                foreach (self::$memoryCache as $_memoryCache)
                    if ($_memoryCache != null && $_memoryCache->count > 0)
                        foreach ($_memoryCache as $_memoryInstance)
                            $_memoryInstance = null;

            self::$memoryCache = Arr();
        }

        public function __construct(\Model\Structure $structure, $modelInstanceRef = null)
        {
            self::__onInitialize();

            if (!($structure != null && $structure instanceof \Model\Structure))
                throw new Exception("Ops! Something is wrong...");
                
            $this->structure = $structure;
            $this->modelInstanceRef = $modelInstanceRef;
            $this->joinsStructures = \Arr();

            $this->selectFields = \Arr();
            $this->whereFields  = \Arr();
            $this->setFields    = \Arr();
            $this->orderFields  = \Arr();
        }
        
        private static function GetDB()
        {
            if (self::$linkCIDB != null)
                return self::$linkCIDB;
                
            self::$linkCIDB = \CodeIgniter::getInstance();
            return self::$linkCIDB;
        }

        public static function getNativeLink()
        { return self::GetDB(); }

        public static function cleanMemoryCache()
        {
            self::$memoryCache = Arr();
            self::checkMemoryCacheKey();
        }

        public static function cleanMemoryCacheByTable($table)
        {
            $table = stringEx($table)->toString();
            if (stringEx($table)->isEmpty() == true) return null;

            self::$memoryCache[$table] = Arr();
        }

        public function reset()
        {
            $this->currentJoin  = null;
            $this->selectFields = \Arr();
            $this->whereFields  = \Arr();
            $this->setFields    = \Arr();
            $this->orderFields  = \Arr();
            
            $this->limit    = null;
            $this->offset   = null;
            
            $link = self::GetDB();
            $link->db->reset_query();
        }
        
        protected function nativeSelect($canUseCache = false)
        {
            $link = self::GetDB();
            //dump($this->selectFields);

            if ($canUseCache == true)
                $link->db->select($this->structure->table . "." . $this->structure->primaryField[key]);
            
            if ($canUseCache == false && $this->selectFields->count <= 0)
            {
                foreach ($this->structure->fields as $field => $_)
                    $link->db->select($this->structure->table . "." . $field);
                    
                return;
            }

            foreach ($this->selectFields as $fieldKey => $fieldInfo)
            {
                if ($fieldInfo->fieldType == normal && $canUseCache == false)
                    $link->db->select($fieldKey);
                elseif ($fieldInfo->fieldType == join)
                {
                    $joinFieldAdvanced = stringEx(
                        '('. $link->db->protect_identifiers($fieldKey).') AS ' .
                        $link->db->escape_identifiers("joinfield")
                    )->replace("joinfield", $fieldInfo->table . "." . $fieldInfo->field);

                    $link->db->select($joinFieldAdvanced);
                }
            }
        }
        
        protected function nativeWhere()
        {
            $link = self::GetDB();
            //dump($this->whereFields);

            foreach ($this->whereFields as $whereField)
            {
                $whereField = Arr($whereField);

                $whereFieldValue = null;
                if (!($whereField->containsKey(group) && ($whereField->group == start || $whereField->group == "or" || $whereField->group == end)))
                    $whereFieldValue = Arr($whereField)->value;

                if ($whereField->where == join)
                    $link->db->join($whereField->table, $whereField->foreignKey, (($whereField->keepJoin == true) ? "left" : null));
                elseif ($whereField->where == normal)
                {
                    if ($whereField->operator == self::OPERATOR_EQUALS)
                        $link->db->where($whereField->field, $whereFieldValue);
                    elseif ($whereField->operator == self::OPERATOR_NOT_EQUALS)
                        $link->db->where($whereField->field . " !=", $whereFieldValue);

                    elseif ($whereField->operator == self::OPERATOR_OR_EQUALS)
                        $link->db->or_where($whereField->field, $whereFieldValue);
                    elseif ($whereField->operator == self::OPERATOR_OR_NOT_EQUALS)
                        $link->db->or_where($whereField->field . " !=", $whereFieldValue);

                    elseif ($whereField->operator == self::OPERATOR_LIKE)
                        $link->db->like($whereField->field, $whereFieldValue);
                    elseif ($whereField->operator == self::OPERATOR_NOT_LIKE)
                        $link->db->not_like($whereField->field, $whereFieldValue);

                    elseif ($whereField->operator == self::OPERATOR_OR_LIKE)
                        $link->db->or_like($whereField->field, $whereFieldValue);
                    elseif ($whereField->operator == self::OPERATOR_OR_NOT_LIKE)
                        $link->db->or_not_like($whereField->field, $whereFieldValue);

                    elseif ($whereField->operator == self::OPERATOR_BIGGER)
                        $link->db->where($whereField->field . " >", $whereFieldValue);
                    elseif ($whereField->operator == self::OPERATOR_SMALLER)
                        $link->db->where($whereField->field . " <", $whereFieldValue);

                    elseif ($whereField->operator == self::OPERATOR_OR_BIGGER)
                        $link->db->or_where($whereField->field . " >", $whereFieldValue);
                    elseif ($whereField->operator == self::OPERATOR_OR_SMALLER)
                        $link->db->or_where($whereField->field . " <", $whereFieldValue);
                }
                elseif ($whereField->where == group)
                {
                    if ($whereField->group == "start")
                        $link->db->group_start();
                    elseif ($whereField->group == "or")
                        $link->db->or_group_start();
                    elseif ($whereField->group == "end")
                        $link->db->group_end();
                }
            } 
        }

        protected function nativeExtra()
        {
            $link = self::GetDB();

            if ($this->limit != null && $this->offset != null)
                $link->db->limit($this->limit, $this->offset);
            elseif ($this->limit != null)
                $link->db->limit($this->limit);
        }

        protected function nativeSet()
        {
            $link = self::GetDB();

            foreach ($this->setFields as $field => $value)
                $link->db->set($field, $value);
        }

        protected function nativeOrder()
        {
            $link = self::GetDB();

            foreach ($this->orderFields as $orderField)
                $link->db->order_by($orderField->field, $orderField->order);
        }

        protected function checkMemoryCacheKey()
        {
            if (self::$memoryCache == null)
                self::$memoryCache = Arr();
            if (self::$memoryCache->containsKey($this->structure->table) == false)
                self::$memoryCache[$this->structure->table] = Arr();
        }

        protected function isValidCacheSecurityStructure()
        {
            if (self::$useCache == true)
            {

                if (self::$config->database->cache->redis === true) {
                    $key = '.krupabox.' . ROOT_HASH . '.database.' . $this->structure->table . '.security.blob';
                    $structureHash = $this->getCurrentSecurityStructureHash();
                    $structureCachedHash = \KrupaBOX\Internal\Kernel::getRedis()->get($key);
                    return ($structureHash == $structureCachedHash);
                }
                else
                {
                    $cachePath = ("cache://.krupabox/database/" . $this->structure->table . "/.security.blob");
                    $structureHash = $this->getCurrentSecurityStructureHash();
                    $structureCachedHash = \File::getContents($cachePath);
                    return ($structureHash == $structureCachedHash);
                }
            }

            return false;

//            if (self::$useCache == true)
//            {
//                $primaryField = $this->structure->primaryField;
//                if ($primaryField != null)
//                {
//                    $cacheKeySecurityStructure = ("database.security." . $this->structure->table);
//                    if (\Cache\Database::isCached($cacheKeySecurityStructure) == false)
//                        return false;
//
//                    $cacheSecurityStructure = \Cache\Database::get($cacheKeySecurityStructure);
//                    return ($cacheSecurityStructure == $this->structure);
//                }
//            }
//
//            return false;
        }

        protected function getCurrentSecurityStructureHash()
        {
            if ($this->structureHash != null)
                return $this->structureHash;

            if (self::$useCache == true) {
                $primaryField = $this->structure->primaryField;
                if ($primaryField != null)
                    $this->structureHash = \Security\Hash::toSha1(\Serialize\Php::encode($this->structure));
            }

            return $this->structureHash;
        }

        protected function updateCacheSecurityStructure()
        {
            if (self::$useCache == true)
            {
                if (self::$config->database->cache->redis === true) {
                    $key = (".krupabox." . ROOT_HASH . ".database." . $this->structure->table . ".security.blob");
                    $structureHash = $this->getCurrentSecurityStructureHash();
                    \KrupaBOX\Internal\Kernel::getRedis()->set($key, $structureHash);
                }
                else {
                    $cachePath = ("cache://.krupabox/database/" . $this->structure->table . "/.security.blob");
                    $structureHash = $this->getCurrentSecurityStructureHash();
                    \File::setContents($cachePath, $structureHash);
                }
            }

//            if (self::$useCache == true)
//            {
//                $primaryField = $this->structure->primaryField;
//                if ($primaryField != null) {
//                    $cacheKeySecurityStructure = ("database.security." . $this->structure->table);
//                    \Cache\Database::set($cacheKeySecurityStructure, $this->structure);
//
//                    $cacheKeyIndex = ("database.index." . $this->structure->table);
//                    \Cache\Database::set($cacheKeyIndex, Arr([0]));
//                }
//            }
        }

        protected function isCachedUniqueId($uniqueId = null)
        {
            $this->checkMemoryCacheKey();
            $memoryKeyUid = ("uid." . stringEx($uniqueId)->toString());

            if (self::$memoryCache[$this->structure->table]->containsKey($memoryKeyUid) && self::$memoryCache[$this->structure->table][$memoryKeyUid] != null)
                return true;

            if (self::$config->database->cache->redis === true) {
                $key = (".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                return \KrupaBOX\Internal\Kernel::getRedis()->exists($key);
            }
            else {
                $cachePath = ("cache://.krupabox/database/". $this->structure->table . "/uid." . stringEx($uniqueId)->toString() . ".blob");
                return \File::exists($cachePath);
            }


//            $cacheKeyUid = ("database.uid." . $this->structure->table . "." . stringEx($uniqueId)->toString());
//            if (self::$memoryCache->containsKey($cacheKeyUid) && self::$memoryCache[$cacheKeyUid] != null)
//                return true;
//            return \Cache\Database::isCached($cacheKeyUid);
        }

        protected function getCachedUniqueId($uniqueId = null)
        {
            $this->checkMemoryCacheKey();
            $memoryKeyUid = ("uid." . stringEx($uniqueId)->toString());

            if (self::$memoryCache[$this->structure->table]->containsKey($memoryKeyUid) && @self::$memoryCache[$this->structure->table][$memoryKeyUid] != null)
                return self::$memoryCache[$this->structure->table][$memoryKeyUid];

            $modelSerialized = null;

            if (self::$config->database->cache->redis === true) {
                $key = (".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                $modelSerialized = \KrupaBOX\Internal\Kernel::getRedis()->get($key);
            }
            else {
                $cachePath = ("cache://.krupabox/database/". $this->structure->table . "/uid." . stringEx($uniqueId)->toString() . ".blob");
                $modelSerialized = \File::getContents($cachePath);
            }

            $modelSerialized = \Serialize::fromSerialized($modelSerialized);
            if ($modelSerialized == null) return null;

            $modelInstance = $modelSerialized->toInstance();
            if ($modelInstance != null)
                self::$memoryCache[$this->structure->table][$memoryKeyUid] = $modelInstance;

            return self::$memoryCache[$this->structure->table][$memoryKeyUid];


//            $cacheKeyUid = ("database.uid." . $this->structure->table . "." . stringEx($uniqueId)->toString());
//
//            if (self::$memoryCache->containsKey($cacheKeyUid) && @self::$memoryCache[$cacheKeyUid] != null)
//                return self::$memoryCache[$cacheKeyUid];
//
//            $cacheDatabase = \Cache\Database::get($cacheKeyUid);
//            if ($cacheDatabase != null)
//                self::$memoryCache[$cacheKeyUid] = $cacheDatabase;
//            return @self::$memoryCache[$cacheKeyUid];
        }

        protected function removeCachedUniqueId($uniqueId = null)
        {
            $this->checkMemoryCacheKey();
            $memoryKeyUid = ("uid." .  stringEx($uniqueId)->toString());

            self::$memoryCache[$this->structure->table][$memoryKeyUid] = null;

            if (self::$config->database->cache->redis === true) {
                $key = (".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                return \KrupaBOX\Internal\Kernel::getRedis()->del($key);
            }
            else {
                $cachePath = ("cache://.krupabox/database/". $this->structure->table . "/uid." . stringEx($uniqueId)->toString() . ".blob");
                return \File::delete($cachePath);
            }

//            $cacheKeyUid = ("database.uid." . $this->structure->table . "." . stringEx($uniqueId)->toString());
//            self::$memoryCache[$cacheKeyUid] = null;
//            return \Cache\Database::remove($cacheKeyUid);
        }

        protected function setCachedUniqueId($uniqueId = null, $modelInstance)
        {
            $this->checkMemoryCacheKey();

            $modelSerialized = \Serialize::fromInstance($modelInstance)->toSerialized();

            if (self::$config->database->cache->redis === true) {
                $key = (".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                \KrupaBOX\Internal\Kernel::getRedis()->set($key, $modelSerialized);
            }
            else {
                $cachePath = ("cache://.krupabox/database/". $this->structure->table . "/uid." . stringEx($uniqueId)->toString() . ".blob");
                \File::setContents($cachePath, $modelSerialized);
            }

            $memoryKeyUid = ("uid." . stringEx($uniqueId)->toString());
            self::$memoryCache[$this->structure->table][$memoryKeyUid] = $modelInstance;

            return self::$memoryCache[$this->structure->table][$memoryKeyUid];

//            $cacheKeyIndex = ("database.index." . $this->structure->table);
//
//            if (\Cache\Database::isCached($cacheKeyIndex)) {
//                $cacheIndex = \Cache\Database::get($cacheKeyIndex);
//                if (!$cacheIndex->contains($uniqueId)) $cacheIndex->add($uniqueId);
//                \Cache\Database::set($cacheKeyIndex, $cacheIndex);
//            }
//            else \Cache\Database::set($cacheKeyIndex, Arr([$uniqueId]));
//
//            $memoryKeyUid = ("database.uid." . $this->structure->table . "." . stringEx($uniqueId)->toString());
//            if (self::$memoryCache->containsKey($cacheKeyUid) && self::$memoryCache[$cacheKeyUid] != null)
//                return self::$memoryCache[$cacheKeyUid];
//            return \Cache\Database::set($cacheKeyUid, $modelInstance);
        }

        protected function cleanAllCache()
        {
            self::checkMemoryCacheKey();
            self::$memoryCache[$this->structure->table] = Arr();

            if (self::$config->database->cache->redis === true) {
                $redis = \KrupaBOX\Internal\Kernel::getRedis();
                $keys = $redis->keys('*');
                $keyBase = (".krupabox." . ROOT_HASH . ".database.". $this->structure->table);

                if ($keys != null && count($keys) > 0 && is_array($keys))
                    foreach ($keys as $_key)
                        if (stringEx($_key)->startsWith($keyBase))
                            $redis->del($_key);
            }
            else {
                $cachePath = ("cache://.krupabox/database/". $this->structure->table . "/");
                \DirectoryEx::delete($cachePath);
            }

//            self::$memoryCache = Arr();
//            $cacheKeyIndex = ("database.index." . $this->structure->table);
//
//            if (\Cache\Database::isCached($cacheKeyIndex))
//            {
//                $cacheIndex = \Cache\Database::get($cacheKeyIndex);
//                foreach ($cacheIndex as $uniqueId)
//                    $this->removeCachedUniqueId($uniqueId);
//            }
        }

        public function getCount()
        {
            $link = self::GetDB();

            $this->nativeWhere();
            $this->nativeExtra();
            $this->nativeOrder();

            $link->db->from($this->structure->table);
            $queryCompiled = $link->db->get_compiled_select();

            if (stringEx($queryCompiled)->toLower(false)->startsWith("select *") == false)
                throw new \Exception(
                    "Database error: " . 500 . "\n" .
                    "Message: "        . "Missing starts with 'SELECT *' to convert to 'SELECT count(*)'". "\n" .
                    "Query: "          . $queryCompiled
                );

            $queryCompiled = ("SELECT count(*) " . stringEx($queryCompiled)->subString(9));

            //dump($queryCompiled);
            $queryExecution = @$link->db->query($queryCompiled);

            if (!$queryExecution)
            {
                $error = $link->db->error(); //i:key/i:message

                if (stringEx($error["message"])->startsWith("No such file or directory"))
                    throw new \Exception(
                        "Database error: " . $error["code"] . "\n" .
                        "Message: Connection failed."
                    );

                throw new \Exception(
                    "Database error: " . $error["code"] . "\n" .
                    "Message: "        . $error["message"] . "\n" .
                    "Query: "          . $queryCompiled
                );
            }

            $results = $queryExecution->result();

            $countValue = 0;

            foreach ($results as $result)  {
                $break = false;
                foreach ($result as $key => $value)
                    if (stringEx($key)->toLower(false)->contains("count")) {
                        $countValue = intEx($value)->toInt();
                        $break = true; break;
                    }
                if ($break == true)
                    break;
            }

            $this->reset();
            return $countValue;
        }

        public function result()
        {
            $queriesExecuted = Arr();
            $canUseCache = false;

            if (self::$useCache == true)
            {
                if ($this->isValidCacheSecurityStructure() == false)
                { $this->cleanAllCache(); $this->updateCacheSecurityStructure(); }
                else
                {
                    $canUseCache = true;

                    if ($this->whereFields->count == 1 && $this->whereFields[0]->containsKey(field) && $this->whereFields[0]->field == ($this->structure->table . "." . $this->structure->primaryField[key]) &&
                        $this->whereFields[0]->operator == self::OPERATOR_EQUALS && $this->whereFields[0]->where == normal &&
                        $this->isCachedUniqueId(Arr($this->whereFields[0])->value) == true)
                    {
                        $simulateResult = Arr();
                        $simulateResult->add($this->getCachedUniqueId(Arr($this->whereFields[0])->value));
                        //dump("GET FROM CACHE");
                        $this->reset();
                        return $simulateResult;
                    }
                }
            }

            $link = self::GetDB();

            $this->nativeSelect($canUseCache);
            $this->nativeWhere();
            $this->nativeExtra();
            $this->nativeOrder();

            $link->db->from($this->structure->table);
            $queryCompiled = $link->db->get_compiled_select();
            $queriesExecuted->add($queryCompiled);

//            dump($queryCompiled);
            $queryExecution = @$link->db->query($queryCompiled);

            if (!$queryExecution)
            {
                $error = $link->db->error(); //i:key/i:message

                if (stringEx($error["message"])->startsWith("No such file or directory"))
                    throw new \Exception(
                        "Database error: " . $error["code"] . "\n" .
                        "Message: Connection failed."
                    );

                throw new \Exception(
                    "Database error: " . $error["code"] . "\n" .
                    "Message: "        . $error["message"] . "\n" .
                    "Query: "          . $queryCompiled
                );
            }
            //dump($queryCompiled);

            $results = $queryExecution->result();
            $data = \Arr();

            // Parse Response
            foreach ($results as $result)
            {
                $newModelInstance = new $this->modelInstanceRef();
                $joinResults = null;
                
                foreach ($result as $key => $value)
                {
                    if (stringEx($key)->contains("."))
                    {
                        $split = stringEx($key)->split(".");
                        
                        if ($split->count != 2)
                            continue;

                        if ($joinResults == null)
                            $joinResults = \Arr();
                            
                        $table = $split[0];
                        if (!$joinResults->containsKey($table))
                            $joinResults[$table] = \Arr();
                        
                        $joinResults[$table][($split[1])] = $value;
                        continue;    
                    }
                    
                    $newModelInstance[$key] = $value;
                }

                if ($joinResults != null)
                {
                    $parsedJoinResults = Arr();

                    foreach ($joinResults as $joinTable => $joinValue)
                    {
                        $structure = \Model\Structure::getByTable($joinTable);
                        if ($structure != null && $structure->__class__ != null)
                        {
                            $joinInstance = new $structure->__class__();
                            foreach ($joinValue as  $joinField => $_joinValue)
                                $joinInstance[$joinField] = $_joinValue;

                            $parsedJoinResults->addKey($joinTable, $joinInstance->toArr());
                        }
                        else $parsedJoinResults->addKey($joinTable, $joinValue);
                    }

                    $joinResults = $parsedJoinResults;
                }

                if ($canUseCache == false)
                {
                    $uniqueId = $newModelInstance[($this->structure->primaryField[key])];
                    $this->setCachedUniqueId($uniqueId, $newModelInstance);
                }

                if ($joinResults != null)
                    $newModelInstance->join = $joinResults;

                $data[] = $newModelInstance;
            }

            $this->reset();

            if ($canUseCache == true)
            {
                $inteligData = Arr(); // Get from cache (is find) and lasts on DB (join)

                foreach ($data as $row)
                {
                    $uniqueId = $row[($this->structure->primaryField[key])];
                    $inteligData[$uniqueId] = null;
                }

                if (self::$config->database->cache->redis === true) {
                    $redis = \KrupaBOX\Internal\Kernel::getRedis();
                    $this->checkMemoryCacheKey();

                    if (count($data) > 0) {

                        // Check multiple keys
                        $cachedKeys = Arr();

                        $redis->multi();
                        foreach ($data as $row) {
                            $uniqueId = $row[($this->structure->primaryField[key])];
                            $memoryKeyUid = ("uid." . stringEx($uniqueId)->toString());

                            if (self::$memoryCache[$this->structure->table]->containsKey($memoryKeyUid) && self::$memoryCache[$this->structure->table][$memoryKeyUid] != null) {
                                $inteligData[$uniqueId] = self::$memoryCache[$this->structure->table][$memoryKeyUid];
                                if ($row->containsField(join))
                                    $inteligData[$uniqueId]->join = $row->join;
                                continue;
                            }
                            $redis->exists(".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                        }
                        $redisData = $redis->exec();

                        if (count($redisData) === count($data)) {
                            $redisIndex = 0;
                            foreach ($data as $row) {
                                if ($redisData[$redisIndex] === 1 || $redisData[$redisIndex] === true)
                                    $cachedKeys->add($row[($this->structure->primaryField[key])]);
                                $redisIndex++;
                            }
                        }


                        // Instantiate multiple models
                        $redis->multi();
                        foreach ($cachedKeys as $uniqueId)
                            $redis->get(".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                        $redisData = $redis->exec();

                        if (count($redisData) === count($cachedKeys)) {

                            $redisIndex = 0;
                            foreach ($cachedKeys as $uniqueId) {
                                $memoryKeyUid = ("uid." . stringEx($uniqueId)->toString());

                                if (self::$memoryCache[$this->structure->table]->containsKey($memoryKeyUid) && @self::$memoryCache[$this->structure->table][$memoryKeyUid] != null) {
                                    $inteligData[$uniqueId]  = self::$memoryCache[$this->structure->table][$memoryKeyUid];
                                    if ($data[$redisIndex]->containsField(join))
                                        $inteligData[$uniqueId]->join = $data[$redisIndex]->join;
                                    $redisIndex++;
                                    continue;
                                }

                                $modelSerialized = null;

                                $key = (".krupabox." . ROOT_HASH . ".database.". $this->structure->table . ".uid." . stringEx($uniqueId)->toString() . ".blob");
                                $modelSerialized = $redisData[$redisIndex];

                                $modelSerialized = \Serialize::fromSerialized($modelSerialized);
                                if ($modelSerialized == null) return null;

                                $modelInstance = $modelSerialized->toInstance();
                                if ($modelInstance != null)
                                    self::$memoryCache[$this->structure->table][$memoryKeyUid] = $modelInstance;

                                $inteligData[$uniqueId] = self::$memoryCache[$this->structure->table][$memoryKeyUid];
                                if ($data[$redisIndex]->containsField(join))
                                    $inteligData[$uniqueId]->join = $data[$redisIndex]->join;
                                $redisIndex++;
                            }

                        }
                    }
                }
                else {
                    foreach ($data as $row)
                    {
                        $uniqueId = $row[($this->structure->primaryField[key])];

                        if ($this->isCachedUniqueId($uniqueId) == true)
                        {
                            $inteligData[$uniqueId] = $this->getCachedUniqueId($uniqueId);

                            if ($row->containsField(join))
                                $inteligData[$uniqueId]->join = $row->join;
                        }
                    }
                }

                $nonCachedPrimaryIds = Arr();

                foreach ($inteligData as $_uniqueId => $value)
                    if ($value == null)
                        $nonCachedPrimaryIds->add($_uniqueId);

                if ($nonCachedPrimaryIds->count > 0)
                {
                    $this->nativeSelect();
                    $link->db->where($this->structure->table . "." . $this->structure->primaryField[key], $nonCachedPrimaryIds[0]);

                    foreach ($nonCachedPrimaryIds as $_uniqueId)
                        if ($_uniqueId != $nonCachedPrimaryIds[0])
                            $link->db->or_where($this->structure->table . "." . $this->structure->primaryField[key], $_uniqueId);

                    $link->db->from($this->structure->table);
                    $queryCompiled = $link->db->get_compiled_select();
                    $queriesExecuted->add($queryCompiled);

                    $queryExecution = $link->db->query($queryCompiled);
                    $results = $queryExecution->result();

                    if ($results != null)
                    {
                        foreach ($results as $result)
                        {
                            if ($result == null) continue;

                            $newModelInstance = new $this->modelInstanceRef();

                            foreach ($result as $key => $value)
                                if (stringEx($key)->contains(".") == false)
                                    $newModelInstance[$key] = $value;

                            $uniqueId = $newModelInstance[($this->structure->primaryField[key])];
                            $this->setCachedUniqueId($uniqueId, $newModelInstance);

                            foreach ($data as $row)
                            {
                                $joinUniqueId = $row[($this->structure->primaryField[key])];
                                if ($uniqueId == $joinUniqueId)
                                {
                                    if ($row->containsField(join))
                                        $newModelInstance->join = $row->join;
                                    break;
                                }
                            }

                            $inteligData[$uniqueId] = $newModelInstance;
                        }
                    }

                    $this->reset();
                }

                $data = Arr();
                foreach ($inteligData as $inteligRow)
                    if ($inteligRow != null)
                        $data->add($inteligRow);
            }

            $data = (($data->count > 0) ? $data : null);
            if ($data == null) return null;

            $container = new \Model\Container();
            foreach ($data as $row) $container->add($row);

//            foreach ($queriesExecuted as $queryExecuted)
//                $container->addLogSQL($queryExecuted);

            return $container;
        }

        public function limit($limit = 10, $offset = null)
        {
            if ($offset != null)
                $this->offset = intEx($offset)->toInt();

            $this->limit = intEx($limit)->toInt();
            return $this;
        }
        
        public function offset($offset = 0)
        {
            $this->offset = intEx($offset)->toInt();
            return $this;
        }

        public function order($field, $order = self::ORDER_ASC)
        {
            if ($order != self::ORDER_ASC && $order != self::ORDER_DESC)
                return $this;

            if ($this->currentJoin == null)
            {
                if ($this->structure->fields->containsKey($field))
                    $this->orderFields[] = \Arr([
                        order => $order,
                        field => $this->structure->table . "." . $field
                    ]);
            }
            else
            {
                if ($this->currentJoin->fields->containsKey($field))
                    $this->orderFields[] = \Arr([
                        order => $order,
                        field => $this->currentJoin->table . "." . $field
                    ]);
            }

            return $this;
        }

        public function startJoin($foreignKey, \Model\Structure $joinStructure, $notJoinKeepSelected = false)
        {
            if (!($joinStructure != null && $joinStructure->table != null &&
                !stringEx($joinStructure->table)->isEmpty() && $joinStructure->fields->count > 0))
                throw new Exception("Join class has corrupted.");
                
            if (!$this->joinsStructures->containsKey($joinStructure->table))
                $this->joinsStructures[$joinStructure->table] = $joinStructure;
                
            $join = $this->joinsStructures[$joinStructure->table];
            $foreignKey = stringEx($foreignKey)->toString();
            
            if (!$this->structure->fields->containsKey($foreignKey) || !$join->fields->containsKey($foreignKey))
                throw new Exception("Invalid foreignKey.");

            $this->currentJoin = $join;
            $this->whereFields[] = \Arr([
                where       => "join",
                table       => $joinStructure->table,
                foreignKey  => $foreignKey,
                "keepJoin"  => $notJoinKeepSelected
            ]);

            return $this;
        }
        
        public function endJoin()
        {
            $this->currentJoin = null;
            return $this;
        }
        
        public function startGroup()
        { $this->whereFields[] = [where => group, group => start]; return $this; }
        
        public function endGroup()
        { $this->whereFields[] = [where => group, group => "end"];; return $this; }
        
        public function orStartGroup()
        { $this->whereFields[] = [where => group, group => "or"];; return $this; }

        public function selectByFunction($func)
        {
            if (@\function_exists("token_get_all") == false)
            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing Tokenizer extension."]); exit; }

            \KrupaBOX\Internal\Library::load("FunctionParser");
            $ref = \FunctionParser\FunctionParser::fromCallable($func);

            $code = $ref->getBody();

            if (stringEx($code)->contains("return") && stringEx($code)->contains(";"))
            {
                $code = stringEx($code)->subString(stringEx($code)->indexOf("return") + 7);
                $code = stringEx($code)->subString(0, stringEx($code)->indexOf(";"));
                //dump($code);

            }
        }

        public function selectByArray($array)
        {
            $array = \Arr($array);
            
            if ($this->currentJoin == null)
                foreach ($array as $field)
                {
                    $field = stringEx($field)->toString();
                    
                    if ($this->structure->fields->containsKey($field))
                    {
                        $fullField = $this->structure->table . "." . $field;
                        if (!$this->selectFields->containsKey($fullField))
                            $this->selectFields[$fullField] = [fieldType => normal];
                    }

                    else throw new Exception("Invalid field :'" . $field . "'.");
                }
            else
                foreach ($array as $field)
                {
                    $field = stringEx($field)->toString();

                    //$fullField = $this->structure->table . "." . $field;
                    //if (!$this->selectFields->containsKey($fullField))
                    //    $this->selectFields[$fullField] = [fieldType => normal];

                    if ($this->currentJoin->fields->containsKey($field))
                    {
                        $fullField = $this->currentJoin->table . "." . $field;
                        if (!$this->selectFields->containsKey($fullField))
                            $this->selectFields[$fullField] = [
                                fieldType   => "join",
                                table       => $this->currentJoin->table,
                                field       => $field
                            ];
                    }
                    else throw new Exception("Invalid field :'" . $field . "'.");
                }
                
            return $this;
        }
        
        public function whereByOperatorFV($field, $operator = self::OPERATOR_LIKE, $value = null)
        {
            $field = stringEx($field)->toString();

            if ($this->currentJoin == null)
            {
                if ($this->structure->fields->containsKey($field) && self::isValidOperator($operator))
                {
                    $fieldData = $this->structure->fields[$field];
                    if ($fieldData->type == "bool" && $fieldData->dbType == "enum") {
                        $value = toBool($value);
                        if ($value === true)
                            $value = "true";
                        elseif ($value === false)
                            $value = "false";
                    }

                    $this->whereFields[] = \Arr([
                        where => normal,
                        field => $this->structure->table . "." . $field,
                        operator => $operator, value => $value
                    ]);
                }

            }
            else
            {
                if ($this->currentJoin->fields->containsKey($field) && self::isValidOperator($operator))
                {
                    $fieldData = $this->currentJoin->fields[$field];
                    if ($fieldData->type == "bool" && $fieldData->dbType == "enum") {
                        $value = toBool($value);
                        if ($value === true)
                            $value = "true";
                        elseif ($value === false)
                            $value = "false";
                    }

                    $this->whereFields[] = \Arr([
                        where => normal,
                        field => $this->currentJoin->table . "." . $field,
                        operator => $operator, value => $value
                    ]);
                }

            }
            
            return $this;
        }
  
        public function select()
        {  $array = func_get_args(); return $this->selectByArray($array); }
        
        public function selectAll()
        {
            if ($this->currentJoin == null)
                foreach ($this->structure->fields as $field => $_)
                {
                    $field = stringEx($field)->toString();
                    $this->selectByArray([$field]);
                }
            else
                foreach ($this->currentJoin->fields as $field => $_)
                {
                    $field = stringEx($field)->toString();
                    $this->selectByArray([$field]);
                }

            return $this;
        }
        
        public function selectExcept()
        { $array = func_get_args(); return $this->selectExceptByArray($array); }
        
        public function whereEquals($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_EQUALS, $value); }
        
        public function whereNotEquals($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_NOT_EQUALS, $value); }
        
        public function orWhereEquals($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_EQUALS, $value); }
        
        public function orWhereNotEquals($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_NOT_EQUALS, $value); }
        
        public function whereLike($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_LIKE, $value); }
        
        public function whereNotLike($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_NOT_LIKE, $value); }
        
        public function orWhereLike($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_LIKE, $value); }
        
        public function orWhereNotLike($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_NOT_LIKE, $value); }
        
        public function where($field, $operator = self::OPERATOR_EQUALS, $value = null)
        { return $this->whereByOperatorFV($field, $operator, $value); }

        public function orWhere($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_EQUALS, $value); }

        public function whereBatch($array)
        {
            $array = \Arr($array); $lastValid = null;
            foreach ($array as $where)
                if ($where->count >= 3)
                    $lastValid = $this->structure->link->whereBatchByOperatorFV($where[0], $where[1], $where[2], $where[3], $where[4]);

            return $lastValid;
        }
        
        public function whereQEX($QEX)
        { return $this->whereByQEX($QEX); }
        
        public function whereBigger($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_BIGGER, $value); }
        
        public function whereSmaller($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_SMALLER, $value); }
        
        public function orWhereBigger($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_BIGGER, $value); }
        
        public function orWhereSmaller($field, $value = null)
        { return $this->whereByOperatorFV($field, self::OPERATOR_OR_SMALLER, $value); }

        public static function isValidOperator($operator = self::OPERATOR_EQUALS)
        { return 
            $operator ==  self::OPERATOR_EQUALS ||
            $operator ==  self::OPERATOR_NOT_EQUALS ||
            
            $operator ==  self::OPERATOR_OR_EQUALS||
            $operator ==  self::OPERATOR_OR_NOT_EQUALS ||
            
            $operator ==  self::OPERATOR_LIKE ||
            $operator ==  self::OPERATOR_NOT_LIKE ||
            
            $operator ==  self::OPERATOR_OR_LIKE ||
            $operator ==  self::OPERATOR_OR_NOT_LIKE ||
            
            $operator ==  self::OPERATOR_BIGGER  ||
            $operator ==  self::OPERATOR_SMALLER ||
            
            $operator ==  self::OPERATOR_OR_BIGGER  ||
            $operator ==  self::OPERATOR_OR_SMALLER;
        }
        
        public function set($field, $value = null)
        {
            $field = stringEx($field)->toString();

            if ($this->structure->fields->containsKey($field))
            {
                $fullField = $this->structure->table . "." . $field;
                $fieldInfo = $this->structure->fields[$field];

                $value = ($fieldInfo->type != bool)
                    ? $fieldInfo->format($value)
                    : ((boolEx($value)->toBool() === true) ? "true" : "false");

                if ($value === null && $fieldInfo->isNullable == false)
                {
                    if ($this->setFields->containsKey($fullField))
                        $this->setFields->removeKey($fullField);

                    return;
                }

                $this->setFields[$fullField] = $value;
            }

            //dump($this->setFields);
            return $this;
        }

        public function update()
        {
            $link = self::GetDB();

            $this->nativeWhere();
            $this->nativeExtra();
            $this->nativeSet();
            $this->nativeOrder();

            $link->db->from($this->structure->table);

            $queryCompiled = $link->db->get_compiled_update();
            //dump($queryCompiled);
            $queryExecution = @$link->db->query($queryCompiled);

            if (!$queryExecution)
            {
                $error = $link->db->error(); //i:key/i:message

                if (stringEx($error["message"])->startsWith("No such file or directory"))
                    throw new \Exception(
                        "Database error: " . $error["code"] . "\n" .
                        "Message: Connection failed."
                    );

                throw new \Exception(
                    "Database error: " . $error["code"] . "\n" .
                    "Message: " .        $error["message"] . "\n" .
                    "Query: " .          $queryCompiled
                );
            }

            if (self::$useCache == true)
            {
                if ($this->isValidCacheSecurityStructure() == false)
                { $this->cleanAllCache(); $this->updateCacheSecurityStructure(); }

                $containsSinglePrimaryKey = false;
                $uniqueId = null;

                foreach ($this->whereFields as $whereField)
                    if ($whereField->field == ($this->structure->table . "." . $this->structure->primaryField[key]) && $whereField->operator == self::OPERATOR_EQUALS && $whereField->where == normal)
                    { $uniqueId = Arr($whereField)->value; $containsSinglePrimaryKey = true; break; }

                if ($containsSinglePrimaryKey == false)
                    $this->cleanAllCache();
                else $this->removeCachedUniqueId($uniqueId);
            }

            $this->reset();
        }

        public function insert()
        {
            $link = self::GetDB();

            $this->nativeWhere();
            $this->nativeExtra();
            $this->nativeSet();
            $this->nativeOrder();

            $link->db->from($this->structure->table);

            $queryCompiled = $link->db->get_compiled_insert();
            //dump($queryCompiled);
            $queryExecution = @$link->db->query($queryCompiled);

            if (!$queryExecution)
            {
                $error = $link->db->error(); //i:key/i:message

                if (stringEx($error["message"])->startsWith("No such file or directory"))
                    throw new \Exception(
                        "Database error: " . $error["code"] . "\n" .
                        "Message: Connection failed."
                    );

                throw new \Exception(
                    "Database error: " . $error["code"] . "\n" .
                    "Message: " .        $error["message"] . "\n" .
                    "Query: " .          $queryCompiled
                );
            }

            $insertId = intEx($link->db->insert_id())->toInt();
            $this->reset();

            if (self::$useCache == true)
            {
                if ($this->isValidCacheSecurityStructure() == false)
                { $this->cleanAllCache(); $this->updateCacheSecurityStructure(); }

                $this->removeCachedUniqueId($insertId);
            }

            return ($insertId > 0) ? $insertId : null;
        }
    }
}
