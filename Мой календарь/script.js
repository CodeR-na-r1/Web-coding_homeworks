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
    // console.log(form[0]);
    form[0].value = row.children[1].innerHTML;    // Заполняем поля
    form[2].value = row.children[3].innerHTML;
    form[6].value = row.children[2].innerHTML;

    previous = this;
}