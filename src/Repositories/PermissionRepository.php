<?php namespace Edutalk\Base\ACL\Repositories;

use Edutalk\Base\Caching\Services\Traits\Cacheable;
use Edutalk\Base\Repositories\Eloquent\EloquentBaseRepository;

use Edutalk\Base\ACL\Repositories\Contracts\PermissionRepositoryContract;
use Edutalk\Base\Caching\Services\Contracts\CacheableContract;

class PermissionRepository extends EloquentBaseRepository implements PermissionRepositoryContract, CacheableContract
{
    use Cacheable;

    public function get(array $columns = ['*'])
    {
        $this->model = $this->model->orderBy('module', 'ASC');
        return parent::get($columns);
    }

    /**
     * @param string $name
     * @param string $alias
     * @param string $module
     * @return $this
     */
    public function registerPermission($name, $alias, $module)
    {
        $this->findWhereOrCreate([
            'slug' => $alias
        ], [
            'name' => $name,
            'module' => $module,
        ]);
        return $this;
    }

    /**
     * @param string|array $alias
     * @return $this
     */
    public function unsetPermission($alias, $force = false)
    {
        if (is_string($alias)) {
            $alias = [$alias];
        }
        $method = $force ? 'forceDelete' : 'delete';
        $this->model->whereIn('slug', $alias)->$method();
        $this->resetModel();
        return $this;
    }

    /**
     * @param string|array $module
     * @param bool $force
     * @return $this
     */
    public function unsetPermissionByModule($module, $force = false)
    {
        if (is_string($module)) {
            $module = [$module];
        }
        $method = $force ? 'forceDelete' : 'delete';
        $this->model->whereIn('module', $module)->$method();
        $this->resetModel();
        return $this;
    }
}
