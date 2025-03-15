<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="task-container">
        <h2 class="text-center">Gerenciador de Tarefas</h2>

        <div class="input-group mb-3">
            <input type="text" id="taskInputTitle" class="form-control" placeholder="Digite seu título">
        </div>

        <div class="input-group mb-3">
            <input type="text" id="taskInput" class="form-control" placeholder="Digite sua tarefa">
        </div>

        <div class="input-group mb-3">
            <select id="taskImportance" class="form-select">
                <option value="1">Baixa</option>
                <option value="2">Média</option>
                <option value="3">Alta</option>
            </select>
        </div>

        <div class="input-group mb-3">
            <input type="datetime-local" id="taskDateTime" class="form-control">
        </div>

        <button class="btn btn-primary w-100 mb-3" onclick="addTask()">Adicionar</button>
        <ul id="taskList" class="list-group"></ul>
    </div>

    <!-- Modal para edição da tarefa -->
    <div class="modal" tabindex="-1" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" id="editTaskInputTitle" class="form-control" placeholder="Digite seu título">
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" id="editTaskInput" class="form-control" placeholder="Digite sua tarefa">
                    </div>

                    <div class="input-group mb-3">
                        <input type="datetime-local" id="editTaskDateTime" class="form-control">
                    </div>

                    <!-- Campo de Importância -->
                    <div class="input-group mb-3">
                        <select id="editTaskImportance" class="form-select">
                            <option value="1">Baixa</option>
                            <option value="2">Média</option>
                            <option value="3">Alta</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="updateTask()">Salvar mudanças</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmDeleteLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body text-dark">
                    Tem certeza que deseja excluir esta tarefa?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Deletar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Erro -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="errorModalLabel">Erro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark" id="errorModalMessage">
                    <!-- Mensagem de erro será inserida aqui -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>