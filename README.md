# Provable

This package provides the means to create provibly fair random numbers and provably fair random shuffles.

## Installation

via composer:
```
composer require gamebetr/provable ^1.0
```

## Basic Useage

```php
// set some vars
$clientSeed = 'your client seed here';
$serverSeed = 'your server seed here';
$min = 1;
$max = 52;
$type = 'shuffle';

// instanciate the provable class
$provable = new Gamebetr\Provable\Provable($clientSeed, $serverSeed, $min, $max, $type);

// get the results
print $provable->results();
// prints [6,21,19,13,41,28,40,43,2,39,5,24,18,52,46,26,20,7,29,38,23,37,30,31,33,44,22,16,35,48,25,14,45,27,11,8,17,36,51,4,42,15,49,32,3,9,1,47,10,34,50,12]
```

## Methods

### __construct(string $clientSeed = null, string $serverSeed = null, int $min = 0, int $max = 0, string $type = 'number')

The class constructor takes the optional parameters, clientSeed, serverSeed, min, max, and type. If clientSeed or serverSeed are not provided, it will generate random seeds automatically. The min and max parameters are the minimum and maximum values of the random number or shuffle. Type is either `number` or `shuffle`.

### static init(string $clientSeed = null, string $serverSeed = null, int $min = 0, int $max = 0, string $type = 'number')

The init method is just a static constructor. It allows you to do the following:

```
$provable = Gamebetr\Provable::init()
// returns an instance of Gamebetr\Provable
```

### setClientSeed(string $clientSeed = null)

This sets the client seed. If no seed is provided, one will be automatically generated. The Provable instance is returned allowing you to chain commands.

### getClientSeed()

This returns the current client seed.

### setServerSeed(string $serverSeed = null)

This sets the server seed. If no seed is provided, one will be automatically generated. The Provable instance is returned allowing you to chain commands.

### getServerSeed()

This returns the current server seed.

### getHashedServerSeed()

This returns the hashed version of the server seed.

### setMin(int $min)

This sets the minimum value property. The Provable instance is returned allowing you to chain commands.

### getMin()

This returns the current minimum value property.

### setMax(int $max)

This sets the maximum value property. The Provable instance is returned allowing you to chain commands.

### getMax()

This returns the current maximum value property.

### setType(string $type)

This sets the type property. Allowed values are number and shuffle. The Provable instance is returned allowing you to chain commands.

### getType()

This returns the current type property.

### results()

This calculates the random number or shuffle and returns it.

### number(int $minimumNumber = null, int $maximumNumber = null)

This generates a random number between $minimumNumber and $maximumNumber. If no values are provided, it will use the $min and $max properties of the object.

### shuffle(int $minimumNumber = null, int $maximumNumber = null)

This generates a random shuffle of numbers between $minimumNumber and $maximumNumber. If no values are provided, it will use the $min and $max properties of the object.




