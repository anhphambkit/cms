<?php 
namespace Core\User\Services\Excute;
use Core\User\Services\Interfaces\ChangePasswordServiceInterface;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Repositories\Interfaces\UserInterface;
use Exception;
use Illuminate\Http\Request;

class ChangePasswordServiceExcute extends CoreServiceAbstract implements ChangePasswordServiceInterface
{
	/**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * ResetPasswordService constructor.
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return bool|\Exception
     * @author TrinhLe
     */
    public function execute(Request $request)
    {
        
    }
}