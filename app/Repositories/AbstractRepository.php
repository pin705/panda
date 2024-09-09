<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class AbstractRepository{

    protected $model = null;

    public function __construct(Model $model){
        $this->model = $model;
    }

    /**
     * 查询全部
     * @param array $columns
     * @param array $with
     * @return mixed
     */
    public function all(array $columns = ['*'],array $with = []) {
        return $this->model->with($with)->get($columns);
    }

    /**
     * 查询一条数据
     * @param array $columns
     * @param array $with
     * @return Model|null|static
     */
    public function first(array $columns = ['*'],array $with = []){
        return $this->model->with($with)->first($columns);
    }

    /**
     * 分页查询
     * @param $page 当前页
     * @param array $where 查询条件 array(['columns','=',name],['columns1','>',name1])
     * @param int $pageSize 每页显示条数
     * @param array $columns 显示列
     * @return mixed
     */
    public function paginate($page,$where,$pageSize = 10,array $columns = ['*']){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        $list = $model->paginate($pageSize, $columns,'page', $page);
        $data['data'] = $list->data;
        $data['recordsTotal'] = $list->total;
        $data['recordsFiltered'] =  $list->total;

        return $data;
    }

    /**
     * @param $id
     * @param array $columns
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id,array $columns = ['*'],$with = []){
        return $this->model->with($with)->find($id,$columns);
    }

    /**
     * 根据条件查询多条数据
     * @param array $where = [['columns','=',name]，['columns1','>',name1]]
     * @param array $columns
     * @param array $with
     * @return mixed
     */
    public function findWhere($where,array $columns = ['*'],array $with = []){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        return $model->with($with)->get($columns);
    }

    /**
     * 根据条件查询单条
     * @param array $where = [['columns','=',name]，['columns1','>',name1]]
     * @param array $columns
     * @param array $with
     * @return mixed
     */
    public function findFirst($where,array $columns = ['*'],array $with = []){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        return $model->with($with)->first($columns);
    }

    /**
     * 是否存在关联
     */
    public function has($relation){
        $this->model->has($relation);
    }

    /**
     * 插入数据
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes){
        return $this->model->create($attributes);
    }

    /**
     * 修改或添加
     * @param array $attributes 修改添加字段
     * @param array $values 条件
     * @return bool
     */
    public function updateOrCreate(array $attributes = [],$values){
        $model = $this->model;
        if(count($values) == 0){
            //添加
            $model = $this->model->newInstance($attributes);;
            return $model->save();
        }else{
            //修改
            $model = $model -> where($values);
            $row = $model->update($attributes);
            if($row > 0)
                return true;
        }
        return false;
    }

    /**
     * 根据id修改
     * @param $id
     * @param array $attributes 修改字段
     */
    public function update($id,array $attributes){
        return $this->model->where('id',$id)->update($attributes);
    }

    /**
     * 根据条件修改
     * @param array $where
     * @param array $attributes
     * @return bool|int
     */
    public function updateWhere($where,array $attributes = []){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        return $model->update($attributes);
    }

    /**
     * 根据id删除 软删
     * @param $id
     * @return int
     */
    public function delete($id){
        return $this->model->destroy($id);
    }

    /**
     * 根据条件删除
     * @param array $where
     * @return bool|null
     * @throws \Exception
     */
    public function deleteWhere($where){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        return $model->delete();
    }

    /**
     * 根据条件统计条数
     */
    public function count($where){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        return $model->count();
    }

    public function withCount($where,array $with = []){
        $model = $this->model;
        if(count($where) > 0){
            $model = $model -> where($where);
        }
        return $model->withCount($with);
    }
}
