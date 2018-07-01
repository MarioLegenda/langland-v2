<?php

namespace App\Symfony\Serializer;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\Metadata\PropertyMetadata;

class BooleanDeserializationFix implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => 'serializer.pre_deserialize',
                'method' => 'onPreDeserialize',
                'class' => 'App\\PresentationLayer\\Infrastructure\\Model\\Language',
                'format' => 'json',
            ],
            [
                'event' => 'serializer.pre_deserialize',
                'method' => 'onPreDeserialize',
                'class' => 'App\\PresentationLayer\\Infrastructure\\Model\\User',
                'format' => 'json',
            ],
            [
                'event' => 'serializer.pre_deserialize',
                'method' => 'onPreDeserialize',
                'class' => 'App\\DataSourceLayer\\Infrastructure\\Security\\Doctrine\\Entity\\User',
                'format' => 'json',
            ],
        ];
    }
    /**
     * @param PreDeserializeEvent $event
     */
    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $data = $event->getData();
        $class = $event->getType()['name'];
        $propertyMetadata = $propertyMetadata = $event
            ->getContext()
            ->getMetadataFactory()
            ->getMetadataForClass($class)
            ->propertyMetadata;

        if (empty($data)) {
            return;
        }

        /** @var PropertyMetadata $property */
        foreach ($propertyMetadata as $propName => $property) {
            if ($property->type['name'] === 'bool') {
                $propValue = $data[$propName];

                if (!is_bool($propValue) and $propValue !== 'true' and $propValue !== 'false') {
                    $data[$propName] = null;
                }
            }
        }

        $event->setData($data);
    }
}