<?php

use App\Models\Todo;
use App\Models\User;

beforeEach(function () {
    $this->user = login();
});

it('deve exibir a lista de tarefas', function () {
    $minhasTarefas = Todo::factory()->count(5)->for($this->user)->create();
    Todo::factory()->count(3)->create();

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertViewHas('todos', function ($todos) use ($minhasTarefas) {
            expect($todos)->toHaveCount(5)
                ->and($todos->modelKeys())->toEqualCanonicalizing($minhasTarefas->modelKeys());

            return true;
        });
})->only();

it('deve exibir o botão de concluir quando a tarefa estiver pendente', function () {
    $tarefa = Todo::factory()->for($this->user)->create(['completed_at' => null]);

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertSee(route('todos.done', $tarefa));
})->only();

it('não deve exibir o botão de concluir quando a tarefa estiver concluida', function () {
    $tarefa = Todo::factory()->for($this->user)->create(['completed_at' => now()]);

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertDontSee(route('todos.done', $tarefa));
})->only();

it('não deve exibir o botão de excluir a tarefa', function () {
    $tarefa = Todo::factory()->for($this->user)->create();

    $this->get(route('todos.index'))
        ->assertOk()
        ->assertSee(route('todos.destroy', $tarefa));
})->only();
// it('deve exibir a lista de tarefas', function () { })->todo();
it('deve remover uma tarefa ao clicar no botão de excluir tarefa', function () {
    $tarefas = Todo::factory()->count(5)->for($this->user)->create();
    $tarefaASerDeletada = $tarefas->first();

    $this->delete(route('todos.destroy', $tarefaASerDeletada))
        ->assertRedirect(route('todos.index'));

    $this->assertModelMissing($tarefaASerDeletada);
    $this->assertDatabaseCount('todos', 4);
})->only();

it('não deve permitir excluir a tarefa de outro usuário', function () {
    $tarefaDeOutro = Todo::factory()->create();

    $this->delete(route('todos.destroy', $tarefaDeOutro))
        ->assertForbidden();

    $this->assertModelExists($tarefaDeOutro);
})->only();
