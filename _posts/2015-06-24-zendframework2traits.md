---
layout: post
title: Zend Framework 2 Traits
---

Zend Framework 2 starting from version 2.5 comes with a handy collection
of traits that with no doubt could enhance the workflow of the majority
of developers. For those who do not program in ZF2 it is a valuable
asset as well - it may serve as an example of naming convention (at
last!) and as an application of the so called horizontal reuse in PHP.

```
ack -g "Trait" vendor/zendframework/
zend-inputfilter/src/InputFilterAwareTrait.php
zend-code/src/Generator/TraitGenerator.php
zend-code/src/Generator/TraitUsageInterface.php
zend-code/src/Generator/TraitUsageGenerator.php
zend-stdlib/src/Hydrator/HydratorAwareTrait.php
zend-stdlib/src/Guard/NullGuardTrait.php
zend-stdlib/src/Guard/AllGuardsTrait.php
zend-stdlib/src/Guard/ArrayOrTraversableGuardTrait.php
zend-stdlib/src/Guard/EmptyGuardTrait.php
zend-log/src/LoggerAwareTrait.php
zend-eventmanager/src/ListenerAggregateTrait.php
zend-eventmanager/src/EventManagerAwareTrait.php
zend-servicemanager/src/MutableCreationOptionsTrait.php 
zend-servicemanager/src/ServiceLocatorAwareTrait.php
zend-form/src/LabelAwareTrait.php 
zend-form/src/FormFactoryAwareTrait.php
zend-i18n/src/Translator/TranslatorAwareTrait.php

```

**OBS: this is not an exaustive list, these are only from a little collection of ZF2's modules that I use currently.**


Those with at least a bit of experience of ZF2 probably already faced
some */AwareInterface$/* usage; this is Zend's way of asserting [design
by contract](https://en.wikipedia.org/wiki/Design_by_contract).


Below is an example of utilization of the *ServiceLocatorAwareTrait*.

```
<?php

namespace Core\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class Metadata implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
}

```

*OBS: This pattern of usage applies as well for all the other
AwareTraits listed above*.

To maintain the contract the interface *ServiceLocatorAwareInterface*
must remain. Anyway now you are free from implementing it.

Here is the implementation of *ServiceLocatorAwareTrait* (there are
bigger aware interfaces than this one):

```
    protected $serviceLocator = null;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
```

--- 

By browsing this files you note a worth mentioning pattern: almost all
of them are followed with an respective interface.

The exceptions are: - *Generators*: these aren't event traits, they are
classes for trait generation; - *Guards*: for argument type validation
- which is a very recent resource (introduced on 2.3) - albeit I'm not
certain if it will remain relevant with PHP 7.

So keep your traits near it's interfaces!

That's it, let me know if it was useful to you.

