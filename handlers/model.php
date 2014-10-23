<?php
/**
 * LightPHP Framework
 * LitePHP is a framework that has been designed to be lite waight, extensible and fast.
 * 
 * @author Robert Pitt <robertpitt1988@gmail.com>
 * @category core
 * @copyright 2013 Robert Pitt
 * @license GPL v3 - GNU Public License v3
 * @version 1.0.0
 */
!defined('SECURE') && die('Access Forbidden!');

/**
 * Native Session Interface
 */
class Session_Library_Driver_Model implements SessionHandlerInterface
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		/**
		 * Fetch the configuration properties for the model
		 */
		$this->config = Registry::get('ConfigLoader')->session->driver_model;

		/**
		 * Check to see if the configuration for hte model is set
		 */
		if(!isset($this->config['model']))
		{
			throw new Exception("varialbe 'driver model' required with model name");			
		}

		/**
		 * Load the model
		 */
		$this->model = Registry::get('ModelLoader')->get($this->config['model']);

		/**
		 * Valdiate the session model extends SessionHandlerInterface
		 */
		if(!($this->model instanceof SessionHandlerInterface))
		{
			throw new Exception("Model for session must implement SessionHandlerInterface");
		}
	}

	/**
	 * Close a session pointer
	 * @return boolean returns true if session closed successfully
	 */
	public function close()
	{
		return $this->model->close();
	}

	/**
	 * Destroys a session
	 * @param  string $id Session Identifier
	 * @return boolean    returns true if the session was destroyed.
	 */
	public function destroy($id)
	{
		return $this->model->destroy($id);
	}

	/**
	 * Garbage Cleaner
	 * @param  int $maxlifetime clears sessions within this lifetime
	 * @return bool             Returns true if the garbage collection was successful.
	 */
	public function gc($maxlifetime)
	{
		return $this->model->close($maxlifetime);
	}

	/**
	 * Opens the session for reading and writing.
	 * @param  string $savepath path to save the session
	 * @param  string $name     the session name
	 * @return boolean          returns true on success, false on failure.
	 */
	public function open($savepath, $name)
	{
		return $this->model->open($savepath, $name);
	}

	/**
	 * Reads a value from a session
	 * @param  string $id Session identifier
	 * @return string     Value stored, null if no value exists.
	 */
	public function read($id)
	{
		return $this->model->read($id);
	}

	/**
	 * Set value to the session store
	 * @param  string $id   the id that represents the value being stored
	 * @param  string $data data to be stored
	 * @return boolean      returns true if the value is stored, false otherwise
	 */
	public function write($id, $data)
	{
		return $this->model->write($id, $data);
	}
}