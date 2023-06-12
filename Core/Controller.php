<?php
namespace Core;

class Controller
{
	public function before(string $action): bool
	{
		// echo "before $action";

		return true;
	}
 
	public function after(string $action): void
	{
		// echo "after $action";
	}
}
