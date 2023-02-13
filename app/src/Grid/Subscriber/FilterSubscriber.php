<?php 
// src/EventListener/DatabaseActivitySubscriber.php
namespace App\Grid\Subscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FilterSubscriber implements EventSubscriberInterface
{
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postLoad
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postLoad(LifecycleEventArgs $args): void
    {
        dump($args);
        //$this->logActivity('persist', $args);
    }

    /* 
    // No search? Then return data Provider
    if (!($this->load($params) && $this->validate())) {
        return $dataProvider;
    }
    // We have to do some search... Lets do some magic
    $query->andFilterWhere([
        //... other searched attributes here
    ])
    // Here we search the attributes of our relations using our previously configured
    // ones in "TourSearch"
    ->andFilterWhere(['like', 'tbl_city.name', $this->city])
    ->andFilterWhere(['like', 'tbl_country.name', $this->country]);

    return $dataProvider;
    */
}