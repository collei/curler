<?php

namespace Curler;

/**
 *	@author Collei <alarido.su@gmail.com> <collei@collei.com.br>
 *	@since 2022-06-25
 *
 *	A class used to handle CURL functions with encapsulation
 *
 */
class Curler
{
	/**
	 *	@var resource $handle
	 */
	private $handle;

	/**
	 *	@var array $optionSet
	 */
	private $optionSet = [];

	/**
	 *	@var array $errors
	 */
	private $errors = [];

	/**
	 *	@var mixed $result
	 */
	private $result = null;

	/**
	 *	Creates and opens a new cURL handle.
	 *	If an existing Curler instance is passed upon call,
	 *	their options get copied to this new instance.
	 *
	 *	@param	\Curler\Curler	$anotherCurler = null
	 *	@return \Curler\Curler	
	 */
	public function __construct(self $anotherCurler = null)
	{
		if ($anotherCurler instanceof self)
		{
			$this->handle = \curl_copy_handle($anotherCurler->getHandle());
			$this->setOptions($anotherCurler->getOptions());
		}
		else
		{
			$this->handle = \curl_init();
		}
	}

	/**
	 *	Closes the cURL handle
	 *
	 *	@return void
	 */
	public function __destruct()
	{
		curl_close($this->handle);
	}

	/**
	 *	Returns the cURL handle
	 *
	 *	@return resource
	 */
	public function getHandle()
	{
		return $this->handle;
	}

	/**
	 *	Sets the URL to work upon.
	 *
	 *	@param	string	$url
	 *	@return \Curler\Curler
	 */
	public function setUrl(string $url)
	{
		return $this->setOption(CURLOPT_URL, $url);
	}

	/**
	 *	Sets a cURL option to the handle.
	 *
	 *	@param	int		$option
	 *	@param	mixed	$value
	 *	@return \Curler\Curler
	 */
	public function setOption(int $option, $value)
	{
		\curl_setopt(
			$this->handle,
			$option,
			$value
		);
		//
		$this->optionSet[$option] = $value;
		//
		return $this;
	}

	/**
	 *	Sets several cURL options at once to the handle.
	 *	Array indexes must be cURL option codes
	 *	and their values must match the required by
	 *	the option within curl_setopt() function.
	 *
	 *	@param	array	$options
	 *	@return \Curler\Curler
	 */
	public function setOptions(array $options)
	{
		\curl_setopt_array(
			$this->handle,
			$options
		);
		//
		foreach ($options as $option => $value)
		{
			$this->optionSet[$option] = $value;
		}
		//
		return $this;
	}

	/**
	 *	Gets the cURL options the instance remember you set.
	 *	This DOES NOT returns them from the handle!
	 *
	 *	@return array
	 */
	public function getOptions()
	{
		return ($e = $this->optionSet);
	}

	/**
	 *	Resets all cURL settings to their defaults.
	 *
	 *	@return \Curler\Curler
	 */
	public function reset()
	{
		\curl_reset($this->handle);
		//
		$this->optionSet = [];
		//
		return $this;
	}

	/**
	 *	Executes the cURL settings.
	 *
	 *	@return \Curler\Curler
	 */
	public function execute()
	{
		$this->result = \curl_exec($this->handle);
		//
		if ($err = \curl_error($this->handle))
		{
			$this->errors[] = $err;
		}
		//
		return $this;
	}

	/**
	 *	Returns whether there is any errors.
	 *
	 *	@return bool
	 */
	public function hasErrors()
	{
		return !empty($this->errors);
	}

	/**
	 *	Returns all errors occurred (if any).
	 *
	 *	@return array
	 */
	public function getErrors()
	{
		return ($e = $this->errors);
	}

	/**
	 *	Returns the cURL query result (if any).
	 *
	 *	@return mixed
	 */
	public function getResult()
	{
		return $this->result;
	}

}


