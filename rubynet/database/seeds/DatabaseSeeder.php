<?php

use App\Job;
use App\Post;
use App\Role;
use App\User;
use App\Comment;
use App\PostLike;
use App\UserTree;
use App\Department;
use App\DepartmentManager;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Department::truncate();
        Role::truncate();
        Job::truncate();
        UserTree::truncate();
        DepartmentManager::truncate();
        Post::truncate();
        PostLike::truncate();
        Comment::truncate();

        User::flushEventListeners();
        
        $usersQuantity = 50;
        $departmentsQuantity = 4;
        $userTreesQuantity = 50;
        $postsQuantity = 25;
        $postLikesQuantity = 50;
        $commentsQuantity = 15;
        $rolesQuantity = 4;
        $departmentManagersQuantity = 4;
        $jobsQuantity = 10;

        factory(Department::class, $departmentsQuantity)->create();
        factory(Role::class, $rolesQuantity)->create();
        factory(Job::class, $jobsQuantity)->create();
        factory(User::class, $usersQuantity)->create();
        factory(UserTree::class, $userTreesQuantity)->create();
        factory(DepartmentManager::class, $departmentManagersQuantity)->create();
        factory(Post::class, $postsQuantity)->create();
        factory(PostLike::class, $postLikesQuantity)->create();
        factory(Comment::class, $commentsQuantity)->create();
    }
}
