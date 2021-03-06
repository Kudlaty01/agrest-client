# AgREST Client
## REST client quick as a silver

## Setup
rename file `src/Modules/ISystems/credentials.json.dist` to `src/Modules/ISystems/credentials.json` and put right authentication data there if you prefer storing the credentials in a file.

## Usage
For practical usage an environment has to be initialized. The API calls share common _domains_ for share address fragment and for operations on a the same particular model. 
```php
<?php
require_once 'vendor/autoload.php';

use Qdt01\AgRest\{Environments\ISystems\ApiCalls\GetAllProducersApiCall, Environments\ISystems\ApiCalls\CreateOneProducerApiCall,Modules\ISystems\ISystemsEnvironment,Modules\ISystems\Models\Producer};
$environment = new ISystemsEnvironment('user','password');
$client      = $environment->getClient();
$getAllCall  = new GetAllProducersApiCall();
$result      = $client->get($getAllCall);
$producers   = $result->getModel();

$producer = new Producer();
$producer->setName("Fredi Makury")
	->setLogoFilename('noLogo.png')
	->setOrdering(999)
	->setSiteUrl('http://i-systems.pl')
	->setSourceId('222');
$result = $client->exec(new CreateOneProducerApiCall($producer));
```

## Modularity
### Environments
New environments should be defined as extensions of `AbstractEnvironment` and have the required `EnvironmentInterface` methods implemented. Dependencies registration and authorization method is also specified there.
### Api calls
New api calls are created by implementation of  `ApiCallInterface` and specifically `QueryApiCallInterface` for receiving data and `CommandApiCallInterface` for modifications and new data setup.
### Models
Domain models should implement `ModelInterface` (and `ModelArrayInterface` for grouped models returned). Both must also implement `ModelResultInterface` for unified result returning by adapters.
### Adapters
For each domain api calls will operate on implementations of `ModelToRequestAdapterInterface` and `ResponseToModelAdapterInterface` are needed to specify stepping between application layers. More precisely extening of the corresponding abstractions `AbstractModelToRequestAdapter` and `AbstractResponseToModelAdapter` will be best.


## Extensibility
Some components may be replaced with implementations of the same interface (extension of abstract classes already implemented the particular interface is highly recommended to use the default behavior). To use it, their dependency resolution must be registered to `DependencyReolver`. This may be environment-specific with registration in main environment file or as a default implementation in `Core` class in `src` directory. They both implement `DependencyRegistrarInterface`, which is an interface of all classes being able to add their own dependencies. They have an order property too to define the override order of the implementations for their interfaces (modules with lower `Order` property will replace the implementations defined in modules with higher order).
### Connector layer
Currently only connector layer may be replaced if one finds anything better than curl, but a `ResponseAdapterInterface` would have to be implemented to adapt new connector result to PSR-7 Response

### Authentication
Authentication methods may be added via implementation of `AuthenticationInterface` and registering the dependency in the desired module (or in Core if it is meant to be new default authentication method)

### TODO
* implement all missing dependencies factories
* implement errors handling
* make reading layer for queryApiCalls
* make `ModelResultAdapter`
* fix all code errors
* make all `ArrayModels` iterable (implement the interfaces)

### Remarks
I am still considering if implementing official _PSR-7_ interfaces was the best idea, as it blocks usage of php7 methods definitions (type-defined parameters)\
After time I am not so sure about replaceable validators and filters components registration in DependencyResolver, and next time would end up with in-place instantions instead.\
For particular models I have decided to put Adapters directory separately for each model for more consistent further ApiCalls implementations
