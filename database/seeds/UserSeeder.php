<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->name = 'Игорь';
        $user1->email = 'aigor9534@gmail.com';
        $user1->password = bcrypt('12345678');
        $user1->save();


        $user2 = new User();
        $user2->name = 'Наденька';
        $user2->email = 'nadyusha84@bk.ru';
        $user2->password = bcrypt('12345678');
        $user2->save();
    }
}
