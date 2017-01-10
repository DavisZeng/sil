<?php

/**
 * @filename RedisSingleInstanceLockTest.php
 * @touch    10/01/2017 14:52
 * @author   Davis <daviszeng@outlook.com>
 * @version  1.0.0
 */

namespace Sil\Tests;

use Sil\RedisSingleInstanceLock;

class RedisSingleInstanceLockTest extends BaseTestCase
{
    /**
     * @var RedisSingleInstanceLock
     */
    protected $redisSingleInstanceLock;

    /**
     *
     * @author Davis <daviszeng@outlook.com>
     */
    public function setUp()
    {
        parent::setUp();
        $this->redisSingleInstanceLock = new RedisSingleInstanceLock($this->client);
    }

    /**
     *
     * @author Davis <daviszeng@outlook.com>
     */
    public function testAcquireLock()
    {
        $lockName            = 'acquire-lock';
        $identifier          = sha1(uniqid(mt_rand(), true));
        $timeoutMilliseconds = 5000;
        $this->assertTrue($this->redisSingleInstanceLock->acquireLock($lockName, $identifier, $timeoutMilliseconds));
        $this->assertFalse($this->redisSingleInstanceLock->acquireLock($lockName, $identifier, $timeoutMilliseconds));
        $this->assertFalse($this->redisSingleInstanceLock->acquireLock($lockName, $identifier, $timeoutMilliseconds));
//        sleep(5);
//        $this->assertTrue($this->redisSingleInstanceLock->acquireLock($lockName, $identifier, $timeoutMilliseconds));
    }

    /**
     *
     * @author  Davis <daviszeng@outlook.com>
     * @depends testAcquireLock
     */
    public function testReleaseLock()
    {
        $lockName            = 'release-lock';
        $identifier          = sha1(uniqid(mt_rand(), true));
        $timeoutMilliseconds = 5000;
        $this->assertTrue($this->redisSingleInstanceLock->acquireLock($lockName, $identifier, $timeoutMilliseconds));
        $this->assertFalse($this->redisSingleInstanceLock->acquireLock($lockName, $identifier, $timeoutMilliseconds));
        $this->assertTrue($this->redisSingleInstanceLock->releaseLock($lockName, $identifier));
        $this->assertFalse($this->redisSingleInstanceLock->releaseLock($lockName, $identifier));
    }

}