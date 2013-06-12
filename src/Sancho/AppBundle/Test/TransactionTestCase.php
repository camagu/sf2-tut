<?php

namespace Sancho\AppBundle\Test;

class TransactionTestCase extends BaseTestCase
{
    static private $inited = false;
    static private $dbPath;
    static private $bkPath;

    static protected function init()
    {
        if (!self::$inited) {
            $client = static::createClient();
            $connection = $client
                ->getContainer()
                ->get('doctrine')
                ->getConnection();

            self::$dbPath = $connection->getParams()['path'];
            self::$bkPath = self::$dbPath.'.bk';

            copy(self::$dbPath, self::$bkPath);

            self::$inited = true;
        }
    }

    static protected function restore()
    {
        copy(self::$bkPath, self::$dbPath);
    }

    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        self::init();
    }

    public function tearDown()
    {
        parent::tearDown();
        self::restore();
    }

    protected function getEntityManager()
    {
        return $this->get('doctrine')->getManager();
    }

    protected function getConnection()
    {
        return $this->getEntityManager()->getConnection();
    }
}
