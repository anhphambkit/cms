<?php
/**
 * Activation repository implemented
 */
namespace Core\User\Repositories\Eloquent;
use Core\User\Repositories\Interfaces\ActivationRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Core\User\Models\Activation;
use Core\User\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class EloquentActivationRepositories extends RepositoriesAbstract implements ActivationRepositories {
	/**
     * The activation expiration time, in seconds.
     *
     * @var int
     */
    protected $expires = 259200;

    /**
     * {@inheritDoc}
     */
    public function createUser(User $user)
    {
        $activation = $this->model;

        $code = $this->generateActivationCode();

        $activation->fill(compact('code'));

        $activation->user_id = $user->getKey();

        $activation->save();

        return $activation;
    }

    /**
     * {@inheritDoc}
     */
    public function exists(User $user, $code = null)
    {
        $expires = $this->expires();

        /**
         * @var Builder $activation
         */
        $activation = $this
            ->model
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('completed', false)
            ->where('created_at', '>', $expires);

        if ($code) {
            $activation->where('code', $code);
        }

        return $activation->first() ?: false;
    }

    /**
     * {@inheritDoc}
     */
    public function complete(User $user, $code)
    {
        $expires = $this->expires();

        /**
         * @var Activation $activation
         */
        $activation = $this
            ->model
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('code', $code)
            ->where('completed', false)
            ->where('created_at', '>', $expires)
            ->first();

        if ($activation === null) {
            return false;
        }

        $activation->fill([
            'completed'    => true,
            'completed_at' => now(config('app.timezone')),
        ]);

        $activation->save();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function completed(User $user)
    {
        $activation = $this
            ->model
            ->newQuery()
            ->where('user_id', $user->getKey())
            ->where('completed', true)
            ->first();

        return $activation ?: false;
    }

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    public function remove(User $user)
    {
        /**
         * @var Activation $activation
         */
        $activation = $this->completed($user);

        if ($activation === false) {
            return false;
        }

        return $activation->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function removeExpired()
    {
        $expires = $this->expires();

        return $this
            ->model
            ->newQuery()
            ->where('completed', false)
            ->where('created_at', '<', $expires)
            ->delete();
    }

    /**
     * Returns the expiration date.
     *
     * @return \Carbon\Carbon
     */
    protected function expires()
    {
        return now(config('app.timezone'))->subSeconds($this->expires);
    }

    /**
     * Return a random string for an activation code.
     *
     * @return string
     */
    protected function generateActivationCode()
    {
        return Str::random(32);
    }
}