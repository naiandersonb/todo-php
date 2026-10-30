<x-app-layout>
    <div class="mb-4 flex flex-row items-center justify-start">
        <a href="{{ route('todos.index') }}" class="gap-2 text-gray-900 dark:text-gray-400 flex flex-row">
            ⬅️
            <p>Voltar</p>
        </a>
    </div>

    <x-form post action="{{ route('todos.create') }}" class="flex flex-col gap-2">
        <div class="mt-4">
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" name="title" required />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-textarea id="description" name="description"></x-textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex flex-row items-center justify-end gap-2">
            <x-secondary-button type='reset'>
                cancelar
            </x-secondary-button>
            <x-primary-button type='submit'>
                Criar tarefa
            </x-primary-button>
        </div>
    </x-form>
</x-app-layout>