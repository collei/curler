# Collei Curler
A wraper class for some of php CURL functions, enabled with basic funcionality.
Simple to use, and you can even chain their method calls:

```
<?php

use Curler\Curler;

$curl = new Curler();

$result = $curl->setUrl('http://...')->setOptions([
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_USERAGENT => 'My user agent',
	])->execute()->getResult();

if (!$result)
{
	echo $curl->getErrors();
}

```

No `curl_close()` needed - it gets called on Curler's `__destruct()` method.

##Current Features
* `setURL()` method

##Further improvements
* `setMethod()` and `getMethod()`
* `setUserAgent()` and `getUserAgent()`
* `getTransferInfo()`
* enforce the `CURLOPT_RETURNTRANSFER` flag set to `true` in every call,
so the output gets directly into the instance and thus retrievable through
`getResult()` method

##License
MIT License
(see the LICENSE file for details).
