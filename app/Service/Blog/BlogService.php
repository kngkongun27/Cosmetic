<?php

namespace  App\Service\Blog;

use App\Service\BaseService;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Service\Blog\BlogServiceInterface;

class BlogService extends BaseService implements BlogServiceInterface 
{
    public $repository;
    
    public function __construct(BlogRepositoryInterface $BlogRepository)
    {   
            $this->repository = $BlogRepository;
    }

    public function getLatestBlogs($limit = 4) {
        return $this->repository->getLatestBlogs($limit);
    }
    public function getBlogByUserId($userId)
    {
        return $this->repository->getBlogByUserId(($userId));
       
    }

    
}

?>