<?php

namespace App\Validators;

// fields is already array of 'fieldName' => 'fieldValue'

class BaseValidator
{
	protected array $rules = [], $errors = [], $errorMessages = [];

	public function validate(array $fields): bool
	{
		foreach ($this->rules as $field => $rules) {
			foreach ($rules as $rule => $value) {
				$method = 'validate' . ucfirst($rule);

				if (!method_exists($this, $method)) {
					throw new \Exception("Method $method does not exist");
				}

				$fieldValue = array_key_exists($field, $fields) ? $fields[$field] : '';

				$this->$method($field, $fieldValue, $value, $fields);
			}
		}

		return empty($this->errors);
	}

	private function validateRequired(string $field, $value, bool $required): void
	{
		if ($required && empty($value)) {
			$this->setError($field, $this->errorMessages[$field]['required']);
		}
	}

	private function validateType(string $field, $value, string $type): void
	{
		if ($type === 'email') {
			$reg = '/^[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i';
		}

		if ($type === 'password') {
			$reg = '/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{8,}/';
		}

		if (!preg_match($reg, $value)) {
			$this->setError($field, $this->errorMessages[$field]['type']);
		}
	}

	private function validateMin(string $field, $value, int $min): void
	{
		if (strlen($value) < $min) {
			$this->setError($field, $this->errorMessages[$field]['min']);
		}
	}

	private function validateMax(string $field, $value, int $max): void
	{
		if (strlen($value) > $max) {
			$this->setError($field, $this->errorMessages[$field]['max']);
		}
	}

	private function validateSameAs(string $field, $value, string $sameAs, array $fields): void
	{
		if ($value !== $fields[$sameAs]) {
			$this->setError($field, $this->errorMessages[$field]['sameAs']);
		}
	}

	public function getErrors(): array
	{
		return $this->errors;
	}

	protected function setError(string $field, string $message): void
	{
		$this->errors[$field][] = $message;
	}
}
