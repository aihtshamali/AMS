<?php
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $permissions=[
                 [
                     'name' => 'dispatch/create',
                     'display_name' => 'Create Dispatch',
                     'description' => 'Dispatch'
                 ],
                 [
                     'name' => 'permissions-create',
                     'display_name' => 'Create Role',
                     'description' => 'Create New Role'
                 ],
                 [
                     'name' => 'permissions-edit',
                     'display_name' => 'Edit Role',
                     'description' => 'Edit Role'
                 ],
                 [
                     'name' => 'permissions-delete',
                     'display_name' => 'Delete Role',
                     'description' => 'Delete Role'
                 ],
                 [
                     'name' => 'notebook-list',
                     'display_name' => 'Display Notebook Listing',
                     'description' => 'See only Listing Of Notebook'
                 ],
                 [
                     'name' => 'notebook-create',
                     'display_name' => 'Create Notebook',
                     'description' => 'Create New Notebook'
                 ],
                 [
                     'name' => 'notebook-edit',
                     'display_name' => 'Edit Notebook',
                     'description' => 'Edit Notebook'
                 ],
                 [
                     'name' => 'notebook-delete',
                     'display_name' => 'Delete Notebook',
                     'description' => 'Delete Notebook'
                 ]
         ];
         foreach ($permissions as $key=>$value){
          Permission::create($value);
         }

    }
}
