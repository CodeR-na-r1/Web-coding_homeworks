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
    if (filter_date_task != null) {params += "date=" + filter_date_task + "&";}

    window.location.href = source_href + params;

    return;
}

// ----------- Редактирование данных (записей) -----------

elements = document.getElementsByClassName("list_cont_tasks_td_taskName");
for (let index = 0; index < elements.length; index++)
{
    elements[index].addEventListener("click", task_editor_manage);
}

let form = document.getElementsByClassName("form_cont_form")[0];    // Форма

let previous = null;

let editing_task_id = document.getElementsByClassName("list_cont_tasks__table")[0].getAttribute('data__now_editing_task_id');
let editing_task_status = document.getElementsByClassName("list_cont_tasks__table")[0].getAttribute('data__now_editing_task_status');

if (editing_task_id > 0)    // Действия, если при редактировании задачи, отправка прошла с ошибками
{
    table = document.getElementsByClassName("list_cont_tasks__table")[0];    // строки, чтобы найти теги <tr> с задачами
    table_tbody = table.children[1];
    table_tr = table_tbody.children;

    let td_event_elem = find_row_by_id(table_tr, editing_task_id).children[1];  // td с заголовком здачи

    change_decoration(td_event_elem);    // Меняем заголовки, кнопку и окрас текущей редактируемой задачи
    add_fields(form);    // добавляем дополнительные поля + скрытное (с id)

    form[9].value = editing_task_id;   // Сохраняем в элемент с данными об id записи
    editing_task_status > 0 ? form[7].setAttribute("checked", "checked") : form[7].removeAttribute("checked");

    previous  = td_event_elem;
}

function task_editor_manage(event)
{
    change_decoration(this);

    let row = this.parentNode;    // Строка с нужными данными от задачи

    // Заполняем поля формы данными редактируемой записью

    change_fields(row);

    if (!form[8])   // Проверка на наличие элемента с данными об id редактируемой записи + кнопка отмена, иначе их создание
    {
        add_fields(form);
    }

    if (row.children[6].innerHTML.includes("Выполненная")) { form[7].setAttribute("checked", "checked"); } else { form[7].removeAttribute("checked"); }
    
    let task_id = row.children[0].getAttribute("data__id");   // Достаём id редактируемой записи
    form[9].value = task_id;   // Сохраняем в элемент с данными об id записи
    
    previous = this;
}

function change_decoration(elem)
{
    if (previous) { previous.style.color = ""; }    // Метка цветом текущей редактируемой записи
    elem.style.color = "red";

    document.getElementsByClassName("task_cont_header")[0].innerHTML = "Редактирование задачи";    // Изменяем заголовок

    form[7].innerHTML = "Сохранить";   // Button
}

function change_fields(row)
{
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
}

function add_fields(form)
{
    let mark_element = document.createElement('input');
        mark_element.type = "hidden";
        mark_element.name = "task_id";
        form.append(mark_element);

        let cancel_button = document.createElement('button');
        cancel_button.innerHTML = "Отмена";
        cancel_button.type = "reset";
        cancel_button.classList += "form_cont_button";
        cancel_button.style = "margin-left: 1%;";
        form.append(cancel_button);

        form[9].addEventListener("click", __exit);

        let status_element = document.getElementsByClassName("form_cont_field")[2].cloneNode(true);
        status_element.children[0].innerHTML = "Задача выполнена: ";
        status_element.children[1].type = "checkbox";
        status_element.children[1].name = "status";
        status_element.children[1].style = "width:auto;";

        form[7].before(status_element);
}

function __exit()
{
    window.location.href = window.location.href;
}

function find_row_by_id(rows, find_id)
{
    for (let index = 0; index < rows.length; index++)
    {
        if (rows[index].children[0].getAttribute("data__id") == find_id)
        {
            return rows[index];
        }
    }
}

// ----------- Смена темы (светлая / тёмная) -----------

// Ищем нужные объекты
let elem = document.getElementsByClassName("main_cont_img")[0]; 

let img_background_names = ["dark_background.jpg", "light_background.jpg"];
let img_icon_names = ["light_choice_topic.png", "dark_choice_topic.png"];
let now_topic = 0;

elem.addEventListener("click", change_color_topic);

function change_color_topic(event)
{
    document.body.style.backgroundImage = "url('/styles/images/" + img_background_names[now_topic] + "')";
    elem.src = "/styles/images/" + img_icon_names[now_topic];

    if (now_topic > 0) { now_topic = 0; } else { now_topic += 1; }
    
}