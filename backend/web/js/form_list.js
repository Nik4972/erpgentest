var listForm = {ids: [], group: -1, group_tr: 0, 
    selectGroup: function(id) {
        if (this.group == id) {
            this.group = -1;
            $('#btnMove').addClass('disabled');
        }
        else {
            this.group = id;
            $('#btnMove').removeClass('disabled');
        }
    },
    init: function() { // place there code will be called after page load or after pajax call
        this.ids = [];
        this.group = -1;
        this.group_tr = 0;

        $('div#table tbody tr').click(function(el){
            var key = $(this).attr('data-key');
            if ($.inArray(key, listForm.ids) > -1) {
                $(this).removeClass('selected');
                listForm.ids = $.grep(listForm.ids, function(value) { // remove element from array
                  return value != key;
                });
            } else {
                $(this).addClass('selected');
                listForm.ids.push(key);
            }
        });
        $('table#tree tr').click(function(el){
            var key = $(this).attr('data-key');
            if (key == listForm.group) {
                $(this).removeClass('selected');
                listForm.group = 0;
            } else {
                if (listForm.group_tr)
                    listForm.group_tr.removeClass('selected');
                listForm.group = key;
                listForm.group_tr = $(this);
                $(this).addClass('selected');
            }
        });
    }
};

listForm.init(); // 

$('#btn_alphabetFilter').click(function(){
    if ($('#alphabetFilter').css('display') == 'none')
        $('#alphabetFilter').css('display', '');
    else
        $('#alphabetFilter').css('display', 'none');
    return false;
});

$("#tabs tbody").sortable({
    items: "> tr:not(:first)",
    appendTo: "parent",
    helper: "clone"
}).disableSelection();

$("#tabs ul li a").droppable({
    hoverClass: "drophover",
    tolerance: "pointer",
    drop: function(e, ui) {
        var tabdiv = $(this).attr("href");
        $(tabdiv + " table tr:last").after("<tr>" + ui.draggable.html() + "</tr>");
        ui.draggable.remove();
    }
});
