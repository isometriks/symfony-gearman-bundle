<?php

namespace Laelaps\GearmanBundle\EventListener;

use Doctrine\DBAL\Connection;
use Laelaps\GearmanBundle\Event\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DoctrineSubscriber implements EventSubscriberInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function refreshDoctrine()
    {
        if ($this->connection->ping() === false) {
            $this->connection->close();
            $this->connection->connect();
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::JOB_STARTED => 'refreshDoctrine',
        );
    }
}
