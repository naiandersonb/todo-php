<x-app-layout>
    <div class="mb-4 flex flex-row items-center justify-end">
        <a href="{{ route('todos.create') }}">
            <x-primary-button>Criar tarefa</x-primary-button>
        </a>
    </div>
    <div class="flex flex-col gap-2">
        @foreach ($todos as $todo)
            @php
                $completed = isset($todo->completed_at)
            @endphp

            <div class="flex flex-row items-center justify-between gap-4 dark:bg-gray-800 bg-white p-4 rounded-md">
                <div class="flex flex-row items-start gap-2">
                    @if($completed)
                        <span>
                            ✅
                        </span>
                    @endif
                    <p @class([
                        "text-white",
                        "line-through" => $completed
                    ])>
                        {{ $todo->title }}
                    </p>
                </div>



                <div class="flex flex-row items-center gap-2">
                    @unless($completed)
                        <x-form put action="{{ route('todos.done', $todo) }}">
                            <x-primary-button>Conluir</x-primary-button>
                        </x-form>
                    @endunless

                    <x-form delete action="{{ route('todos.destroy', $todo) }}">
                        <x-secondary-button type='submit'>🗑️</x-secondary-button>
                    </x-form>


                </div>
            </div>


        @endforeach
    </div>
</x-app-layout>