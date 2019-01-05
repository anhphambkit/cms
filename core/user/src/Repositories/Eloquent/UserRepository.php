<?php

namespace Core\User\Repositories\Eloquent;

use Core\User\Repositories\Interfaces\UserInterface;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class UserRepository extends RepositoriesAbstract implements UserInterface
{

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getDataSiteMap()
    {
        $data = $this->model->where('username', '!=', null)
            ->select('username', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
        $this->resetModel();
        return $data;
    }

    /**
     * Get unique username from email
     *
     * @param $email
     * @return string
     * @author TrinhLe
     */
    public function getUniqueUsernameFromEmail($email)
    {
        $emailPrefix = substr($email, 0, strpos($email, '@'));
        $username = $emailPrefix;
        $offset = 1;
        while ($this->getFirstBy(['username' => $username])) {
            $username = $emailPrefix . $offset;
            $offset++;
        }
        $this->resetModel();
        return $username;
    }
}
