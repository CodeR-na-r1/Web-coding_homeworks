let source_href = window.location.href.split('?')[0];

let filter_status_task = null;
let filter_day_task = null;
let filter_date_task = null;

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

function filter_manage(event) {
    let params = "?";

    if (event.target.tagName == "SELECT")
    {
        filter_status_task = event.target.value;
    }
    else if (event.target.tagName == "INPUT")
    {
        filter_day_task = event.target.value;
    }
    else if (event.target.tagName == "SPAN")
    {
        filter_date_task = event.target.attributes.value.value;
    }

    if (filter_status_task != null) {params += "status=" + filter_status_task + ";";}
    if (filter_day_task != null) {params += "day=" + filter_day_task + ";";}
    if (filter_date_task != null) {params += "date=" + filter_date_task;}

    window.location.href = source_href + params;

    return;
}