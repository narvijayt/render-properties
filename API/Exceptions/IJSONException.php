<?php

namespace API\Exceptions;

interface IJSONException
{
	/**
	 * Set the status code
	 *
	 * @param integer $statusCode
	 * @return IJSONException
	 */
	public function setStatusCode($statusCode);

	/**
	 * Get the exception message
	 *
	 * @return string
	 */
	public function getMessage();

	/**
	 * Get the status code
	 *
	 * @return integer
	 */
	public function getStatusCode();

	/**
	 * Convert serializes exception to array
	 *
	 * @return array
	 */
	public function respond();

	/**
	 * Serialize the exception
	 *
	 * @return string
	 */
	public function serialize();
}