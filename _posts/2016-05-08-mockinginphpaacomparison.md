---
layout: post
title: Mocking in PHP a comparison
keywords: PHP,TDD
---

If one is committed to TDD, one needs a fast test suite. And a fast test
suite is only reachable through a lot of mocking. When testing a given
class, ideally only it's core behaviour is being tested and all the
rest is mocked. In PHP there's many ways of mocking. I'll present
in this post the one's I'm used to and in which situations each one of
them excels.

##  Anonymous classes

Anonymous classes API offer a clean way of mocking. I find them useful
mainly when I don't have to implement behaviour and the dependency
signature is really simple.

Another *trait* of anonymous classes is that the implementation is 
forcibly in your face. With libs of mocking one sometimes see the
implementation being searched and override before testing. Which can
decrease readability. 

``` php
    private function getTransmitterMock()
    {
        return new class () {
            public function transmit($nfe)
            {

            }
        };
    }

```

##  Mockery


The mockery is a good for spying, on simple cases.

```
        $uploadMock = \Mockery::mock('Core\Service\Upload\UploadInterface');
        $uploadMock->shouldReceive('upload')
            ->once()
            ->andReturn((new \Core\Service\Upload\File))
            ->byDefault();

```

One can define how it's called as well. Ideal to test
interaction with third party libs.

```
        $mockResponse = Mockery::mock();
        $mockResponse->shouldReceive('get')
            ->withArgs(['89700000'])
            ->andReturn(
                [
                    'cep' => '89700-000',
                    'localidade' => 'Concórdia',
                    'uf' => 'SC',
                    'bairro' => '',
                    'complemento' => '',
                ]
            );

``` 

I tend to see Mockery as an simpler mocking lib than PHP unit's
one,  but it sometimes lacks it's power as well.

And a last good aspect of Mockery is that it's independent of test
frameworks. For those who cannot rely on phpunit this might be a
great choice.

##  PHPUnits Mocks Feature

The phpunit's API is good to work together with concrete
implementations, overriding only parts of a concrete class.

The impression I've got it's that it's API is more verbose,
nevertheless more powerful as well.

```
    $mock = $this->getMockBuilder('\Finance\Service\Category\GatewayInterface')
        ->setMethods(['saveCategory', 'getCategoryByName'])
        ->getMock();

    $mock->method('saveCategory')->will(
        $this->throwException(
            PersistenceException::duplicatedEntry()
        )
    );

```

Another good use for phpunit's mocks features is to test if an given
object is called with the right arguments when these given arguments
needs some sort of processing.

```
    $mock = $this->getMockBuilder('PaymentService')
        ->setMethods(['create'])
        ->getMock();

    $mock->method('create')
        ->with($this->callback(function ($arg) {
            return (
                $arg->getPhoneEntity()->getNumber() == '35242189'
                && $arg->getPhoneEntity()->getAreaCode() == '47'
            );
        }))->will($this->returnValue(null));

```

---

##  Conclusion

This post is not supposed to dictate which option is better for
mocking. It seems to me that each of those methods shines better
in specific contexts. And this is the posture I stand for when
mocking, I use the libs interchangeably, depending on the context.

If you have a different opinion about these libs, or some advice
about other libs please let me know :).
