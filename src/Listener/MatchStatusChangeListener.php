<?php


namespace App\Listener;


use App\Command\MatchChangeListenRedisCommand;
use App\Entity\Match;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

class MatchStatusChangeListener implements AutoloadedEventListener
{

    private ClientInterface $redis;

    public function __construct(ClientInterface $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [Events::postUpdate];
    }


    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        var_dump("test");

        $entity = $eventArgs->getEntity();
        if ($entity instanceof Match) {

            var_dump("test");

            // nekako provjeriti koji je atribut promijenjen

            $this->redis->push(MatchChangeListenRedisCommand::MATCH_CHANGE_KEY, $entity->getId());
        }
    }
}