<?php

namespace Plugins\Customer\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Plugins\Customer\Requests\RegisterCustomerRequest;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Core\Base\Responses\BaseHttpResponse;
use Carbon\Carbon;
use URL;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Plugins\Customer\Notifications\ConfirmEmail;

class RegisterController extends BasePublicController
{
	/*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = null;

    /**
     * @var CustomerRepositories
     */
    protected $customerRepository;

    /**
     * Create a new controller instance.
     *
     * @param CustomerRepositories $customerRepository
     * @author Trinh Le
     */
    public function __construct(CustomerRepositories $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->redirectTo = route('homepage');
        parent::__construct();
    }
	/**
	 * [showRegisterForm description]
	 * @param  Request $request [description]
	 * @return Illuminate\View\View
	 */
	public function showRegisterForm(Request $request)
	{
		page_title()->setTitle('Register');
		return view('plugins-customer::auth.register');
	}

	/**
     * Confirm a user with a given confirmation code.
     *
     * @param $email
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param CustomerRepositories $customerRepository
     * @return BaseHttpResponse
     * @author Trinh Le
     */
    public function confirm($email, Request $request, BaseHttpResponse $response, CustomerRepositories $customerRepository)
    {
        if (!URL::hasValidSignature($request)) {
            abort(404);
        }

        $member = $customerRepository->getFirstBy(['email' => $email]);

        if (!$member) {
            abort(404);
        }

        if($member->confirmed_at) 
            return $response
                ->setError()
                ->setMessage(__('Verified your email'));

        $member->confirmed_at = Carbon::now();
        $this->customerRepository->createOrUpdate($member);

        $this->guard()->login($member);

        return $response
            ->setNextUrl(route('homepage'))
            ->setMessage(trans('plugins-customer::customer.confirmation_successful'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     * @author Trinh Le
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Resend a confirmation code to a user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param CustomerRepositories $customerRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Trinh Le
     */
    public function resendConfirmation($email, CustomerRepositories $customerRepository, BaseHttpResponse $response)
    {
        $member = $customerRepository->getFirstBy(['email' => $email]);
        if (!$member) {
            return $response
                ->setError()
                ->setMessage(__('Cannot find this account!'));
        }

        $this->sendConfirmationToUser($member);

        return $response
            ->setMessage(trans('plugins-customer::member.confirmation_resent'));
    }

    /**
     * Send the confirmation code to a user.
     *
     * @param Member $member
     * @author Trinh Le
     */
    protected function sendConfirmationToUser($member)
    {
        // Notify the user
        $member->notify(new ConfirmEmail());
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Trinh Le
     */
    public function register(RegisterCustomerRequest $request, BaseHttpResponse $response)
    {
        event(new Registered($member = $this->create($request->input())));

        if (config('plugins-customer.general.verify_email', true)) {
            $this->sendConfirmationToUser($member);
            return $this->registered($request, $member)
                ?: $response->setNextUrl($this->redirectPath())->setMessage(trans('plugins-customer::customer.confirmation_info'));
        }

        $member->confirmed_at = Carbon::now();
        $this->customerRepository->createOrUpdate($member);
        $this->guard()->login($member);
        return $this->registered($request, $member)
            ?: $response->setNextUrl($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return Member
     * @author Trinh Le
     */
    protected function create(array $data)
    {
        return $this->customerRepository->create([
			'email'      => $data['email'],
			'username'   => $data['username'],
			'password'   => bcrypt($data['password']),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVerify()
    {
        return view('plugin-customer::auth.verify');
    }
}