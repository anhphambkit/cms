<?php 
namespace Core\User\Services\Interfaces;
use Core\Master\Services\CoreServiceInterface;

interface RoleServiceInterface extends CoreServiceInterface
{	
	/**
	 * Get flags
	 * @param array $array 
	 * @author TrinhLe
	 * @return array
	 */
	public function getFlagsPermission():array;
}