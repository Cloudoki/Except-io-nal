# Except-io-nal

The Cloudoki PHP Exception extensions throw manageable errors in a multi-tier MQ alignment.

The main goal of this package is to correctly bubble exceptions from the worker to the api layer.
On the API layer, cases for production and development environments can be implemented.
 

####Dependencies
None so far.

---

## Install

1. Add the cloudoki/except-io-nal package to your composer file (dev-master is fine).
1. The Classes load as `\Cloudoki\SomeException`.
1. Load the custom exception handler in `App/Exceptions/Handler.php`, like so:

```
namespace App\Exceptions;

use Cloudoki\Proc\ExceptionalHandler;

class Handler extends ExceptionalHandler {}
```

##Usage
The package defines a set of **Exception** extensions. They are easy to emplement in any PHP environment, but are especially useful in a **MQ alignment** (API <-> Worker).
The Exceptions assist worker level errors to correctly bubble up in the API response.

####DatabaseException
We use the DatabaseException to define unexpected database responses and time-outs on connections.

####InvalidEnvironmentException
If an interaction is triggered outside the desired environment scope (eg. development or production), an InvalidEnvironment should be thrown to kill the process.

####MissingParameterException
A common exception in API applications. Bubbles a useful error message if set up correctly.

####InvalidParameterException
Probably the most common custom Exception.

####IncompleteModelException
While developing new model scopes, this exception can be useful to flag accidently accessed unfinished logic.

####MissingSchemaException
Schema's are used in the **Cloudoki/SchemaModel** package. To be released soon.

####QuotaExceededException
Some quota limitation has been exceeded. Used in eg. the Limiter package. 

####InvalidUserException
A default authorisation error response.

####WorkerException
The API should define errors bubbled up from the Worker response as a *WorkerException* for logging purposes. 


##Responses
The exceptions are even more useful in a development/production divided environment, where an endpoint consumer has no business with internal problems as eg. a worker-level logic bug.
By default, the package returns 3 responses.

#### 400 Response
Malformed method or request syntax

#### 403 Response
No valid authorization provided

#### 404 Response
Not Found

*A 500 response should be avoided in any production situation.*