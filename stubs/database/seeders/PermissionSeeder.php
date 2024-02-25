<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Permission;
use Takshak\Adash\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public $permissions = [];

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();

        foreach ($this->data() as $item) {
            $permission = Permission::create([
                'name' => $item['name'],
                'title' => $item['title'],
            ]);
            $this->bifurcatePermissions($item);

            if (count($item['children']) > 0) {
                foreach ($item['children'] as $child) {
                    Permission::create([
                        'name' => $child['name'],
                        'permission_id' => $permission->id,
                        'title' => $child['title'],
                    ]);
                    $this->bifurcatePermissions($child);
                }
            }
        }

        foreach ($this->permissions as $role => $permissions) {
            $permissions = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
            $role = Role::where('name', $role)->first();
            $role->permissions()->sync($permissions);
        }
    }

    public function bifurcatePermissions($item)
    {
        foreach ($item['roles'] ?? [] as $role) {
            if (!isset($this->permissions[$role])) {
                $this->permissions[$role] = [];
            }

            $this->permissions[$role][] = $item['name'];
        }
    }

    public function data($value = '')
    {
        return collect([
            [
                'name' => 'queries_access',
                'title' => 'Queries Management',
                'roles' => ['admin'],
                'children'    =>    [
                    ['name' => 'queries_show', 'title' => 'Queries Create', 'roles' => ['admin']],
                    ['name' => 'queries_create', 'title' => 'Queries Create', 'roles' => ['admin']],
                    ['name' => 'queries_update', 'title' => 'Queries Update', 'roles' => ['admin']],
                    ['name' => 'queries_delete', 'title' => 'Queries Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'roles_access',
                'title'  => 'Roles Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'roles_create', 'title' => 'Roles Create', 'roles' => ['admin']],
                    ['name' => 'roles_update', 'title' => 'Roles Update', 'roles' => ['admin']],
                    ['name' => 'roles_delete', 'title' => 'Roles Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'permissions_access',
                'title'  => 'Permissions Access',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'permissions_create', 'title' => 'Permissions Update', 'roles' => ['admin']],
                    ['name' => 'permissions_update', 'title' => 'Permissions Update', 'roles' => ['admin']],
                    ['name' => 'permissions_delete', 'title' => 'Permissions Update', 'roles' => ['admin']],
                    ['name' => 'permissions_roles_update', 'title' => 'Permissions Roles Update', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'users_access',
                'title'  => 'Users Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'users_show', 'title' => 'Users Show', 'roles' => ['admin']],
                    ['name' => 'users_create', 'title' => 'Users Create', 'roles' => ['admin']],
                    ['name' => 'users_update', 'title' => 'Users Update', 'roles' => ['admin']],
                    ['name' => 'users_delete', 'title' => 'Users Delete', 'roles' => ['admin']],
                    ['name' => 'login_to_user', 'title' => 'Users Login To', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'pages_access',
                'title'  => 'Pages Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'pages_create', 'title' => 'Pages Create', 'roles' => ['admin']],
                    ['name' => 'pages_show', 'title' => 'Pages Show', 'roles' => ['admin']],
                    ['name' => 'pages_update', 'title' => 'Pages Update', 'roles' => ['admin']],
                    ['name' => 'pages_delete', 'title' => 'Pages Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'faqs_access',
                'title'  => 'FAQs Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'faqs_create', 'title' => 'FAQs Create', 'roles' => ['admin']],
                    ['name' => 'faqs_show', 'title' => 'FAQs Show', 'roles' => ['admin']],
                    ['name' => 'faqs_update', 'title' => 'FAQs Update', 'roles' => ['admin']],
                    ['name' => 'faqs_delete', 'title' => 'FAQs Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'settings_access',
                'title'  => 'Settings Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'settings_create', 'title' => 'Settings Create', 'roles' => ['admin']],
                    ['name' => 'settings_update', 'title' => 'Settings Update', 'roles' => ['admin']],
                    ['name' => 'settings_delete', 'title' => 'Settings Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'testimonials_access',
                'title'  => 'Testimonials Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'testimonials_create', 'title' => 'Testimonials Create', 'roles' => ['admin']],
                    ['name' => 'testimonials_update', 'title' => 'Testimonials Update', 'roles' => ['admin']],
                    ['name' => 'testimonials_delete', 'title' => 'Testimonials Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'blog_categories_access',
                'title'  => 'Blog Categories Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'blog_categories_create', 'title' => 'Blog Categories Create', 'roles' => ['admin']],
                    ['name' => 'blog_categories_update', 'title' => 'Blog Categories Update', 'roles' => ['admin']],
                    ['name' => 'blog_categories_delete', 'title' => 'Blog Categories Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'blog_posts_access',
                'title'  => 'Blog Posts Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'blog_posts_create', 'title' => 'Blog Posts Create', 'roles' => ['admin']],
                    ['name' => 'blog_posts_show', 'title' => 'Blog Posts Show', 'roles' => ['admin']],
                    ['name' => 'blog_posts_update', 'title' => 'Blog Posts Update', 'roles' => ['admin']],
                    ['name' => 'blog_posts_delete', 'title' => 'Blog Posts Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'blog_comments_access',
                'title'  => 'Blog Comments Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'blog_comments_update', 'title' => 'Blog Comments Update', 'roles' => ['admin']],
                    ['name' => 'blog_comments_show', 'title' => 'Blog Comments Show', 'roles' => ['admin']],
                    ['name' => 'blog_comments_delete', 'title' => 'Blog Comments Delete', 'roles' => ['admin']],
                ]
            ],
        ]);
    }
}
