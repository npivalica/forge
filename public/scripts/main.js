$(document).ready(function () {
    // filter by subject 
    $(document).on('change', '#ddlSub', function () {
        let idSub = $("#ddlSub").val();
        //alert(idSub)
        $.ajax({
            url: '../../models/filter_pages_by_subject.php',
            method: "post",
            data: {
                id: idSub
            },
            dataType: "json",
            success: function (result) {
                //console.log(result)
                showListOfPages(result);
            },
            error: function (xhr) {
                console.error(xhr);
            }
        })

    })
})

function showListOfPages(pages) {
    let html = "";
    html += `
        <table class="list">
        <tr>
          <th>ID</th>
          <th>Subject</th>
          <th>Position</th>
          <th>Visible</th>
          <th>Name</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>`;
    for (let page of pages) {
        html += `
        <tr>
            <td>${page.id}</td>
            <td>${page.menu_name}</td>
            <td>${page.position}</td>
            <td>${$page['visible'] == 1 ? 'true' : 'false'}</td>
                        <td>${page.menu_name}</td>

            <td><a href="#" data-idpost="${page.id}" class="brisanje-postova">Obriši</a></td>
        </tr>`;
    }
    html += `</table>`;
    $("#pagesList").html(html);
}