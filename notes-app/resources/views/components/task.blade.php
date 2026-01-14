@pushOnce('styles')
    <link href="{{asset('css/task.css')}}" rel="stylesheet" />
@endPushOnce

<div class="task" data-id="{{ $id }}">
    <div class="task_header">
        <h1>{{ $title }}</h1>

        <div class="task_actions">
            <x-microns-edit title="Alterar" />
            <x-fas-trash-can title="Remover" />
        </div>
    </div>

    <div class="task_content">
        {{ $slot }}
    </div>

    <button class="task_add">
        <x-monoicon-add />
        <span>Adicionar Item</span>
    </button>
</div>

<x-modal id="box-modal-task-edit" taskid="{{ $id }}">
    <div class="modal_header">
        <h1>Editar tarefa</h1>
        <x-vaadin-close id="close-modal-task-edit" />
    </div>

    <div class="modal_content">
        <form method="POST" action="{{route('update-task')}}">
            @csrf
            @method('PUT')

            @error('title')
                <p class="field_error">{{ $message }}</p>
            @enderror
            <input class="fullwidth" type="text" name="title" placeholder="Título da tarefa" value="{{ $title }}" class="@error('title') field_error @enderror"/>

            <input type="hidden" name="task_id" value="{{ $id }}" />

            <x-button class='btn_fullwidth' linkto='update-task'>Atualizar tarefa</x-button>
        </form>
    </div>
</x-modal>

<x-modal id="box-modal-task-item" taskid="{{ $id }}">
    <div class="modal_header">
        <h1>Adicionar item</h1>
        <x-vaadin-close id="close-modal-task-item" />
    </div>

    <div class="modal_content">
        <form method="POST" action="{{route('store-task-item')}}">
            @csrf

            @error('content')
                <p class="field_error">{{ $message }}</p>
            @enderror
            <input class="fullwidth" type="text" name="content" placeholder="Item" value="{{old('content')}}" class="@error('content') field_error @enderror"/>

            <input type="hidden" name="task_id" value="{{ $id }}" />
            <input type="hidden" name="is_marked" value="{{ App\Models\TaskItem::IS_NOT_MARKED }}" />

            <x-button class='btn_fullwidth' linkto='store-task-item'>Criar novo item</x-button>
        </form>
    </div>
</x-modal>

<x-modal id="box-modal-task-item-edit" taskid="{{ $id }}">
    <div class="modal_header">
        <h1>Editar item</h1>
        <x-vaadin-close id="close-modal-task-item-edit" />
    </div>

    <div class="modal_content">
        <form method="POST" action="{{route('update-task-item')}}">
            @csrf

            @error('content')
                <p class="field_error">{{ $message }}</p>
            @enderror
            <input class="fullwidth" type="text" name="content" placeholder="Item" value="{{old('content')}}" class="@error('content') field_error @enderror"/>

            <input type="hidden" name="task_item_id" id="task-item-id-input" value="" />
            <input type="hidden" name="is_marked" value="{{ App\Models\TaskItem::IS_NOT_MARKED }}" />

            <x-button class='btn_fullwidth' linkto='update-task-item'>Atualizar item</x-button>
        </form>
    </div>
</x-modal>


@pushOnce('scripts')
    <script>
        const btnsAddItems = document.querySelectorAll('.task_add');
        const iconsCloseModal = document.querySelectorAll('#close-modal-task-item');
        const btnsEditTask = document.querySelectorAll('[title="Alterar"]');
        const iconsCloseModalEdit = document.querySelectorAll('#close-modal-task-edit');
        const btnsEditTaskItem = document.querySelectorAll('[title="AlterarItem"]');
        const iconsCloseModalEditItem = document.querySelectorAll('#close-modal-task-item-edit');

        btnsAddItems.forEach(btnAddIt => {
            btnAddIt.addEventListener('click', (event) => {
                event.preventDefault();

                const taskId = btnAddIt.parentNode.dataset.id;
                const modal = document.querySelector(`[data-task-id='${taskId}']`)
                modal.classList.add('opened');
            })
        });

        iconsCloseModal.forEach(icCloseMod => {
            icCloseMod.addEventListener('click', (event) => {
                event.preventDefault();

                const modal = icCloseMod.parentNode.parentNode.parentNode;
                modal.classList.remove('opened');
            })
        });

        btnsEditTask.forEach(btnEdit => {
            btnEdit.addEventListener('click', (event) => {
                event.preventDefault();

                const taskId = btnEdit.closest('.task').dataset.id;
                const modal = document.querySelector(`[data-task-id='${taskId}'][id='box-modal-task-edit']`)
                modal.classList.add('opened');
            })
        });

        iconsCloseModalEdit.forEach(icCloseMod => {
            icCloseMod.addEventListener('click', (event) => {
                event.preventDefault();

                const modal = icCloseMod.parentNode.parentNode.parentNode;
                modal.classList.remove('opened');
            })
        });

        btnsEditTaskItem.forEach(btnEditIt => {
            btnEditIt.addEventListener('click', (event) => {
                event.preventDefault();

                const taskItemId = btnEditIt.closest('.task_item').dataset.taskitemid;
                const taskId = btnEditIt.closest('.task').dataset.id;
                const modalEditItem = document.querySelector(`#box-modal-task-item-edit[taskid="${taskId}"]`);
                
                document.getElementById('task-item-id-input').value = taskItemId;
                modalEditItem.classList.add('opened');
            });
        });

        iconsCloseModalEditItem.forEach(icCloseMod => {
            icCloseMod.addEventListener('click', (event) => {
                event.preventDefault();

                const modal = icCloseMod.parentNode.parentNode.parentNode;
                modal.classList.remove('opened');
            })
        });

    </script>
@endPushOnce
