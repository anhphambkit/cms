<?php 
namespace Core\User\Services\Excute;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Services\Interfaces\RoleServiceInterface;
use Core\User\Repositories\Interfaces\RoleInterface;

class RoleServiceExcute extends CoreServiceAbstract implements RoleServiceInterface
{	
	/**
	 * @var RoleInterface
	 */
	protected $roleInterface;

	function __construct(RoleInterface $roleInterface)
	{
		$this->roleInterface = $roleInterface;
	}

	/**
	 * Get flags
	 * @param array $array 
	 * @author TrinhLe
	 * @return mixed
	 */
	public function getFlagsPermission(array $array)
	{
		
	}
}