<?php

namespace WebId\Persil\Tests\Unit\Repositories;

use App\Models\User;

trait RepositoryTestTrait {
    public function test_we_can_use_all_method(): void
    {
        User::factory()->count(2)->create();

        $users = $this->repository->all();

        $this->assertCount(2, $users);
    }

    public function test_we_can_use_delete_method(): void
    {
        User::factory()->create();
        $user = User::factory()->create();

        $this->repository->delete($user);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseMissing('users', [
            'id' =>  $user->getKey()
        ]);
    }

    public function test_we_can_use_find_method(): void
    {
        User::factory()->create();
        $user = User::factory()->create();

        $search = $this->repository->find($user->getKey());

        $this->assertEquals($user->getKey(), $search->getKey());
    }

    public function test_we_can_use_store_method(): void
    {
        $this->repository->store([
            'name' => 'fakeName',
            'email' => 'fake@gmail.com',
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'fakeName',
            'email' => 'fake@gmail.com',
            'password' => 'password'
        ]);
    }

    public function test_we_can_use_update_method(): void
    {
        $user = User::factory()->create([
            'name' => 'oldName',
            'email' => 'old@gmail.com'
        ]);

        $this->repository->update($user, [
            'name' => 'newName',
            'email' => 'new@gmail.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'newName',
            'email' => 'new@gmail.com',
        ]);
    }
}
