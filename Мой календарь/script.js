// ----------- Создание запросов на фильтрацию данных (записей) -----------

let source_href = window.location.href.split('?')[0];
let old_params = window.location.href.split('?').length > 1 ? window.location.href.split('?')[1] : '';

let filter_status_task = old_params.split('status=').length > 1 ? old_params.split('status=')[1].split('&')[0] : null;
let filter_day_task = old_params.split('day=').length > 1 ? old_params.split('day=')[1].split('&')[0] : null;
let filter_date_task = old_params.split('date=').length > 1 ? old_params.split('date=')[1].split('&')[0]: null;

let elements = document.getElementsByClassName("element_for_filter");
for (let index = 0; index < elements.length; index++)
{
    if (elements[index].tagName == "SELECT" || elements[index].tagName == "INPUT")
    {
        elements[index].addEventListener("change", filter_manage);
    }
    else
    {
        elements[index].addEventListener("click", filter_manage);
    }
}

function filter_manage(event)
{
    let params = "?";

    if (event.target.tagName == "SELECT")
    {
        filter_status_task = event.target.value;
    }
    else if (event.target.tagName == "INPUT")
    {
        filter_day_task = event.target.value;
        filter_date_task = null;
    }
    else if (event.target.tagName == "SPAN")
    {
        filter_date_task = event.target.attributes.value.value;
        filter_day_task = null;
    }

    if (filter_status_task != null) { params += "status=" + filter_status_task + "&"; }
    if (filter_day_task != null) {params += "day=" + filter_day_task + "&";}
    if (filter_date_task != null) {params += "date=" + filter_date_task;}

    window.location.href = source_href + params;

    return;
}

// ----------- Редактирование данных (записей) -----------

elements = document.getElementsByClassName("list_cont_tasks_td_taskName");
for (let index = 0; index < elements.length; index++)
{
    elements[index].addEventListener("click", task_editor_manage);
}

let previous = null;

function task_editor_manage(event)
{
    if (previous) { previous.style.color = ""; }    // Метка цветом текущей редактируемой записи
    this.style.color = "red";

    document.getElementsByClassName("task_cont_header")[0].innerHTML = "Редактирование задачи";    // Изменяем заголовок

    let row = this.parentNode;    // Строка с нужными данными от задачи

    let form = document.getElementsByClassName("form_cont_form")[0];    // Форма

    // Заполняем поля формы данными редактируемой записью

    form[0].value = row.children[1].innerHTML;   // Тема

    for (let index = 0; index < form[1].children.length; index++)   // Тип
    {
        if (form[1].children[index].selected) { form[1].children[index].selected = false; }
        if (form[1].children[index].innerHTML.includes(row.children[0].innerHTML)) { form[1].children[index].selected = true; }
    }

    form[2].value = row.children[3].innerHTML;   // Место

    form[3].value = row.children[4].innerHTML.split(" ")[0];   // Дата

    form[4].value = row.children[4].innerHTML.split(" ")[1];   // Время

    for (let index = 0; index < form[5].children.length; index++)   // Длительность
    {
        if (form[5].children[index].selected) { form[5].children[index].selected = false; }
        if (form[5].children[index].innerHTML.includes(row.children[5].innerHTML)) { form[5].children[index].selected = true; }
    }

    form[6].value = row.children[2].innerHTML;   // Описание

    form[7].innerHTML = "Сохранить";   // Button

    if (!form[8])   // Проверка на наличие элемента с данными об id редактируемой записи, иначе его создание
    {
        let mark_element = document.createElement('input');
        mark_element.type = "hidden";
        mark_element.name = "task_id";
        form.append(mark_element);
    }
    
    let task_id = row.children[0].getAttribute("data__id");   // Достаём id редактируемой записи
    form[8].value = task_id;   // Сохраняем в элемент с данными об id записи
    
    previous = this;
}