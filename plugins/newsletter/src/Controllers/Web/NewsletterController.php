<?php

namespace Plugins\Newsletter\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Newsletter\Requests\NewsletterRequest;
use Plugins\Newsletter\Repositories\Interfaces\NewsletterRepositories;

class NewsletterController extends BasePublicController
{
	/**
	 * [create description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function create(NewsletterRequest $request)
	{
		return app(NewsletterRepositories::class)->createOrUpdate([
			'name'  => $request->email,
			'email' => $request->email
		]);
	}
}