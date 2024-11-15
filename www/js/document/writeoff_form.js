function init(data)
{
    console.log(data);
}

var add_subject_dialog = false;
var subject_select = false;
var subject_search_text = '';

var available_items_search_datatable = false;

var available_items = {};

var selected_items = [];
var all_departments = {};

$().ready(function(){
    
    request('document/get_number', {type: document_type}, function(result){
       if ($('[name=reg_number]').length)
       {
           $('[name=reg_number]').val(result.number);
       }
       else
       {
           $('[name=number]').val(result.number);
       }
    });
    
    subject_select = $('.subject-select').select2({
        dropdownCssClass: 'subject-select2',
        ajax: {
          url: '/ajax.php?c=data&action=subjects&type=' + (Array.isArray(subject_type) ? subject_type.join(',') : subject_type) ,
          dataType: 'json'
        }
    });
    
    add_subject_dialog = $('#add-subject-dialog').dialog({
        title: lang.add_subj_title,
        width: 350,
        autoOpen: false,
        buttons: [
            {
                text: "Додати",
                'class': "btn btn-success",
                click: function() {
                  $( this ).dialog( "close" );
                  request('data/create_subject', {name: $('input[name=add-subject-name]').val(), 'type' : (Array.isArray(subject_type) ? subject_type[0] : subject_type) }, subject_added);
                }
            }
        ]
    });
    
    $('#btn-add-subject').click(function(){
        show_add_subject_dlg();
    });
    
    $(document).on('keyup', '.select2-search__field', function(e){       
       subject_search_text = $(e.currentTarget).val();
    });
    
        
    request('book/get_total_available_items', {}, function(result){

        available_items = {};
        for (var i of result.data)
        {
            if (!available_items[i.item_id])
            {
                available_items[i.item_id] = {};
            }
            available_items[i.item_id][i.category] = i;
        }

        all_departments = result.all_departments;
        
        available_items_search_datatable = $('.available_items_search_datatable').DataTable( {
            data: result.data,
            dom: 
                    "<'row'<'col-sm-12'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'col-12'p>",
            language: arr_ext(dataTables_language, {
                zeroRecords: lang.article_search_no_records,
                search: '',
                searchPlaceholder: 'Пошук'
            }),
            columns: [
                {data: 'number'},
                {data: 'name'},
                {data: 'category', render: category_render},
                {data: 'count', render: count_render},
                {data: 'storage', render: count_render},
                {data: 'department', render: count_render},
                {data: 'price'}
            ],
            rowCallback: function( row, data ) {
                $(row).attr('data-item-id', data.item_id)
                      .attr('data-cat', data.category);
            }
        } );

    });
    
    $(document).on("click", '#available_items_search_datatable tr[data-item-id]', function() {
        
        var id = $(this).attr("data-item-id");
        var cat = $(this).attr("data-cat");
        
        console.log(id + '/' + cat);
        
        add_item_from_available_table(id, cat);
        
    });
    
    $('#btn-submit').click(function(){
        submit();
    });
    
    $('.datepicker').datepicker({
        dateFormat: 'dd.mm.yy'
    });
    
    $(document).on("click", '.remove[data-idx]', function() {
        var idx = $(this).attr("data-idx");
        selected_items.splice(idx, 1);
        render_selected();
    });
    
});

function add_item_from_available_table(item_id, cat)
{
    console.log(item_id, cat);
    var item = arr_ext (available_items[ item_id ][cat], {departments:{}});
    selected_items.push(item);
    
    render_selected();
}

function render_selected()
{
    $('.selected-table tbody > tr').remove();
    $('.selected-table thead > tr > th:not(:first-child)').remove();
    
    var c = selected_items.length;
    
    if (c == 0)
    {
        $('.selected-items-container').css({display: 'none'});
    }
    else
    {
        $('.selected-items-container').css({display: ''});
    }
    
    var d = (c===1) ? 75 : Math.ceil( 100 / (c+1)) ;
    $('.selected-table thead > tr > th').attr('width', (100-c*d) + '%'); 
    
    let dep_available = {};
    for (let item of selected_items)
    {
        for (let dep_id in item.available_by_departments)
        {
            dep_available[ dep_id ] = dep_id;
        }
    }
    
    let current_departments = {};
    for (let i in all_departments)
    {
        if (dep_available[i])
        {
            current_departments[i] = all_departments[i];
        }
    }
    
    for (let i in selected_items)
    {
        let item = selected_items[i];
        $('.selected-table thead > tr').append(`<th><div class="remove" data-idx="`+ i +`">X</div><span class="number">${item.number}</span> <span class='name'>${item.name}</span><br /><span class="label">Ціна:</span> <span class="price">${item.price} грн</span></th>`);
    }
    
    for (let dep_id in current_departments)
    {
        let row = $('<tr></tr>');
        row.append(`<th>${current_departments[dep_id]}</th>`);
        
        for (let i in selected_items)
        {
            let item = selected_items[i];
            let cell = $(`<td width="${d}%"></td>`);
            if (item.available_by_departments[dep_id])
            {
                let count = item.available_by_departments[dep_id];
                let input = $('<input type="number" step="1" min="0">');
                input.attr('max', count);
                input.attr('data-selected-index', i);
                input.attr('data-dep-id', dep_id);
                input.val(item.selected_by_departments[dep_id]);
                input.attr('onchange', 'update_items_data(this)');
                cell.append(input);
                
                cell.append(`<span> / ${count}</span>`);
            }
            row.append(cell);
        }
        
        $('.selected-table tbody').append(row);
    }
}



function show_add_subject_dlg(){
    $('input[name=add-subject-name]').val(subject_search_text);
    $( "#add-subject-dialog" ).dialog( "open" );
}

function subject_added(result)
{
    console.log(result);
    var option = new Option(result.subject.name, result.subject.id, true, true);
    subject_select.append(option).trigger('change');
}

function update_items_data(e)
{
    var idx = parseInt($(e).attr('data-selected-index'));
    var dep_id = $(e).attr('data-dep-id');
    var max = parseFloat($(e).attr('max'));
            
    var val = parseFloat($(e).val());
    
    if (!val)
    {
        return ;
    }
    
    if (val > max)
    {
        alert('Кількість більше наявності!');
        val = max;
    }
    
    selected_items[idx].selected_by_departments[dep_id] =  val;
}

function submit()
{
    if (!$('[name=number]').val())
    {
        alert('Введіть номер документу!');
        return ;
    }
    
    if (!$('[name=date]').val())
    {
        alert('Введіть дату документу!');
        return ;
    }
    
    if (subject_required && ! $('[name=subject_id]').val() )
    {
        alert('Виберіть "Підрозділ"!');
        return;
    }
    
    var items = [];
    for (var i of selected_items)
    {
        for (var dep_id in i.selected_by_departments)
        {
            var cnt = i.selected_by_departments[dep_id];
            if (cnt > 0.00001)
            {
                items.push({
                    dep_id: dep_id,
                    item_id: i.item_id,
                    category: i.category,
                    count: cnt
                });
            }
        }
    }
        
    request('document/create', {
        type : document_type,
        document: {
            'number' : $('[name=number]').val(),
            'date' : $('[name=date]').val(),
            'subject_id' : $('[name=subject_id]').val()
        },
        items: items
    }, function(result){
        window.location.href = '?c=document&a=view&id=' + result.document.id;
    });
    
}

function delete_item(i, e){
    e.preventDefault();
    
    var row = $(i).attr('data-row');
    
    console.log(row);
    
    items_datatable.row( row )
        .remove();


        console.log('=====');
    //items_datatable.draw( true );

    items_datatable.rows().invalidate();
    items_datatable.draw( false );
    //invalidate  
}