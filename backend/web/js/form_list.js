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

        /*$('div#table tbody tr').click(function(el){
            var key = $(this).attr('data-key');
            if ($.inArray(key, listForm.ids) > -1) {
                $(this).removeClass('selected');
                listForm.ids = $.grep(listForm.ids, function(value) { // remove element from array
                  return value != key;
                });
                $(this).find('input.col_id').val('');
            } else {
                $(this).addClass('selected');
                listForm.ids.push(key);
                $(this).find('input.col_id').val(key);
            }
        });*/
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
        //$('#ids_x').change(function() {
        $('#ids_x').on('change', function() {
            //console.log($(this));
            if ($(this).prop('value') == '' || $(this).prop('value') == '1') { 
                $('input.ids').prop('checked', '');
                //$(this).prop('value', '0')
                $(this).val('1');
            }
            else { 
                $('input.ids').prop('checked', 'checked');
                $(this).val('');
            }
            $(this).checkboxX('refresh');
            //return false;
            //$('input.ids:checked')
        });
        $('.ids').on('change', function() {
            var newVal = '';
            if ($('input.ids:checked').length == $('input.ids').length) {
                newVal = '1';
            }
            else if ($('input.ids:checked').length == 0) {
                newVal = '0';
            }
            $('#ids_x').val(newVal);
            $('#ids_x').checkboxX('refresh');
        });
    },
    submitForm: function(element) {
        var ids = $('input.ids:checked');
        var new_ids = ids.clone();
        $('form#formList').prepend(new_ids);
        $('form#formList').attr('action', $(element).attr('href'));
        //$('form#formList').attr('method', 'post');
        console.log($('form#formList'));
        console.log(element);
        $('form#formList').submit();
        return false;
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
