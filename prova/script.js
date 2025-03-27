// Função para carregar as tarefas ao carregar a página
function loadTasks() {
    $.ajax({
        url: 'fetch_tasks.php', // O arquivo PHP que irá buscar as tarefas no banco
        method: 'GET',
        success: function (response) {
            const tasks = JSON.parse(response); // Convertendo a resposta para JSON
            const taskList = document.getElementById("taskList");
            taskList.innerHTML = ""; // Limpa a lista antes de adicionar as novas tarefas

            tasks.forEach(function (task) {
                let li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.setAttribute('data-task-id', task.id); // Adiciona o id da tarefa como atributo

                // Determinando o texto de importância
                let importanceText = "";
                switch (task.importancia) {
                    case "1":
                        importanceText = "Baixa"; // Baixa importância
                        break;
                    case "2":
                        importanceText = "Média"; // Média importância
                        break;
                    case "3":
                        importanceText = "Alta"; // Alta importância
                        break;
                    default:
                        importanceText = "Indefinida";
                }

                li.innerHTML = `
                <div>
                    <span class="task-titulo">${task.titulo}</span><br>
                    <span class="task-text">${task.descricao}</span><br>
                    <span class="task-important">${importanceText}</span><br>
                    <span class="task-date">Data: ${new Date(task.data).toLocaleString("pt-BR")}</span><br>
                </div>
                <div>
                    <button class="btn btn-warning btn-sm me-2" onclick="editTask(this)">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteTask(this)">Excluir</button>
                </div>
                `;
                taskList.appendChild(li);
            });
        },
        error: function () {
            alert("Erro ao carregar as tarefas.");
        }
    });
}

// Função de adicionar tarefa
function addTask() {

    let taskInputTitle = document.getElementById("taskInputTitle");
    let taskInput = document.getElementById("taskInput");
    let taskDateTime = document.getElementById("taskDateTime");
    let taskImportance = document.getElementById("taskImportance");
    let taskTitle = taskInputTitle.value.trim();
    let taskText = taskInput.value.trim();
    let importanceValue = taskImportance.value; // Pega o valor da importância

    // Obtém a data e hora local
    let dateTime = new Date(taskDateTime.value);

    // Formata para o formato MySQL DATETIME (YYYY-MM-DD HH:MM:SS)
    let formattedDateTime = dateTime.getFullYear() + '-'
        + (dateTime.getMonth() + 1).toString().padStart(2, '0') + '-'
        + dateTime.getDate().toString().padStart(2, '0') + ' '
        + dateTime.getHours().toString().padStart(2, '0') + ':'
        + dateTime.getMinutes().toString().padStart(2, '0') + ':'
        + dateTime.getSeconds().toString().padStart(2, '0');

    // Verifica se os campos não estão vazios

    if (taskInputTitle === "") {
        showErrorModal("Preencha um título");
        return; // Se a tarefa estiver vazia, não prossegue
    }

    if (taskTitle === "") {
        showErrorModal("Preencha sua tarefa");
        return; // Se a tarefa estiver vazia, não prossegue
    }

    if (taskText === "") {
        showErrorModal("Preencha sua tarefa");
        return; // Se a tarefa estiver vazia, não prossegue
    }

    if (taskDateTime.value === "") {
        showErrorModal("Preencha uma data válida");
        return; // Se a data estiver vazia, não prossegue
    }

    // Enviar os dados para o servidor
    $.ajax({
        url: 'add_task.php', // O arquivo PHP que irá salvar a tarefa no banco
        method: 'POST',
        data: {
            title: taskTitle,
            tarefa: taskText,
            data: formattedDateTime,  // Passa a data e hora formatada
            status: 1, // Status inicial é 1
            importancia: importanceValue // Passa o valor da importância
        },
        success: function (response) {
            if (response === "success") {
                // Atualiza a lista de tarefas após adicionar
                loadTasks();
                taskInputTitle.value = "";
                taskInput.value = "";
                taskDateTime.value = "";
            } else {
                console.log("Erro ao adicionar tarefa.");
            }
        },
        error: function () {
            console.log("Erro na requisição AJAX.");
        }
    });
}

// Função de editar tarefa - abre o modal e preenche com as informações atuais
function editTask(button) {
    let taskLi = button.closest('li');

    if (!taskLi) {
        console.log("Tarefa não encontrada.");
        return;
    }

    let taskTitulo = taskLi.querySelector('.task-titulo').innerText;
    let taskText = taskLi.querySelector('.task-text').innerText;
    let taskDate = taskLi.querySelector('.task-date').innerText.trim(); // Obtendo a data
    let taskImportantElement = taskLi.querySelector('.task-important');

    let taskImportant = taskImportantElement.innerText.trim();
    let importanceText = taskImportant.split(':')[0]?.trim();  // Corrigido com optional chaining

    let importanceValue;
    switch (importanceText.toLowerCase()) {
        case 'baixa':
            importanceValue = "1";
            break;
        case 'média':
        case 'media':
            importanceValue = "2";
            break;
        case 'alta':
            importanceValue = "3";
            break;
        default:
            importanceValue = "1";  // valor padrão
            break;
    }

    if (!taskText || !taskDate) {
        console.log("Informações da tarefa estão faltando.");
        return;
    }

    // Remover a parte "Data: " da string da data
    taskDate = taskDate.replace('Data: ', '').trim();  // Agora apenas a data será processada

    // Agora podemos formatar corretamente a data
    let formattedDate = taskDate;

    if (formattedDate.includes('T')) {
        // Se já estiver no formato ISO, não faz nada
        formattedDate = taskDate;
    } else {
        let [datePart, timePart] = formattedDate.split(','); // Divide data e hora
        let [day, month, year] = datePart.trim().split('/'); // Divide a data
        formattedDate = `${year}-${month}-${day}T${timePart.trim()}`; // Formata para o formato ISO
    }

    // Preencher os campos do modal
    document.getElementById("editTaskInputTitle").value = taskTitulo;
    document.getElementById("editTaskInput").value = taskText;
    document.getElementById("editTaskDateTime").value = formattedDate;
    document.getElementById("editTaskImportance").value = importanceValue;

    document.getElementById('editModal').setAttribute('data-task-id', taskLi.getAttribute('data-task-id'));

    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
}

// Função de atualizar tarefa
function updateTask() {
    // Pega os valores dos campos de input
    let taskTextTitle = document.getElementById("editTaskInputTitle").value.trim();
    let taskText = document.getElementById("editTaskInput").value.trim();
    let taskDate = document.getElementById("editTaskDateTime").value;
    let taskImportance = document.getElementById("editTaskImportance").value; // Pega o valor da importância

    // Verifica se os campos não estão vazios

    if (taskTextTitle === "") {
        showErrorModal("Preencha sua tarefa");
        return; // Se a tarefa estiver vazia, não prossegue
    }

    if (taskText === "") {
        showErrorModal("Preencha sua tarefa");
        return; // Se a tarefa estiver vazia, não prossegue
    }

    if (taskDate === "") {
        showErrorModal("Preencha uma data válida");
        return; // Se a data estiver vazia, não prossegue
    }

    // Pega o ID da tarefa (que foi salvo como atributo do modal)
    let taskId = document.getElementById("editModal").getAttribute('data-task-id');

    // Enviar os dados para o servidor para atualizar a tarefa
    $.ajax({
        url: 'update_task.php', // O arquivo PHP que irá salvar a atualização no banco
        method: 'POST',
        data: {
            title: taskTextTitle,
            task_id: taskId, // Aqui usei task_id para coincidir com o PHP
            nome_tarefa: taskText, // Passando corretamente o nome da tarefa
            data: taskDate,
            importancia: taskImportance // Adiciona o valor da importância
        },
        success: function (response) {
            if (response === "success") {
                // Atualiza a lista de tarefas após atualização
                loadTasks();
                $('#editModal').modal('hide'); // Fecha o modal após sucesso
            } else {
                console.log("Erro ao atualizar tarefa.");
            }
        },
        error: function () {
            console.log("Erro na requisição AJAX.");
        }
    });
}

// Função para mostrar o modal de erro com uma mensagem personalizada
function showErrorModal(message) {
    // Insere a mensagem no modal
    document.getElementById("errorModalMessage").innerText = message;

    // Mostra o modal
    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
    errorModal.show();
}


// Função para abrir o modal de confirmação
function deleteTask(button) {
    let taskLi = button.closest('li');
    if (!taskLi) {
        console.log("Tarefa não encontrada.");
        return;
    }

    taskToDelete = taskLi; // Guarda a referência da tarefa

    // Abre o modal de confirmação
    var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    myModal.show();
}

// Evento de clique no botão "Deletar" dentro do modal
document.getElementById("confirmDeleteBtn").addEventListener("click", function () {
    if (taskToDelete) {
        deleteTaskConfirmed(taskToDelete);
    }
});

// Função para confirmar exclusão
function deleteTaskConfirmed(taskLi) {
    let taskId = taskLi.getAttribute('data-task-id');

    $.ajax({
        url: 'delete_task.php',
        method: 'POST',
        data: { id: taskId },
        success: function (response) {
            if (response.trim() === "success") {
                taskLi.remove(); // Remove a tarefa da tela
            } else {
                alert("Erro ao excluir a tarefa.");
            }
        },
        error: function () {
            alert("Erro na requisição AJAX.");
        }
    });

    // Fecha o modal após a ação
    var modalInstance = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
    modalInstance.hide();
}

// Carregar as tarefas assim que a página for carregada
window.onload = function () {
    loadTasks();
};
