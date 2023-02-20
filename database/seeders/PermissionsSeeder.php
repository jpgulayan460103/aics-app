<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'super-admin']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'encoder']);
        $role4 = Role::create(['name' => 'aics-client']);

        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'view permissions']);

        Permission::create(['name' => 'create aics_clients']);
        Permission::create(['name' => 'edit aics_clients']);
        Permission::create(['name' => 'delete aics_clients']);
        Permission::create(['name' => 'view aics_clients']);
        Permission::create(['name' => 'upload masterlists']);

        Permission::create(['name' => 'create payrolls']);
        Permission::create(['name' => 'edit payrolls']);
        Permission::create(['name' => 'delete payrolls']);
        Permission::create(['name' => 'view payrolls']);
        Permission::create(['name' => 'assign payrolls']);
        
        
        $role1->givePermissionTo(Permission::all());
        $role2->givePermissionTo();

        $role2->givePermissionTo('create aics_clients');
        $role3->givePermissionTo('edit aics_clients');
        $role3->givePermissionTo('view aics_clients');
        $role3->givePermissionTo('assign payrolls');
        
        $role3->givePermissionTo('create aics_clients');
        $role3->givePermissionTo('edit aics_clients');
        $role3->givePermissionTo('view aics_clients');
        $role3->givePermissionTo('assign payrolls');
         
        $role4->givePermissionTo('create aics_clients');
        $role4->givePermissionTo('edit aics_clients');        
        $role4->givePermissionTo('view aics_clients');
        
      

    }
}
