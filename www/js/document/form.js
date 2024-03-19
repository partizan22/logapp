function init(data)
{
    console.log(data);
}

var add_subject_dialog = false;
var subject_select = false;
var subject_search_text = '';

var items_datatable = false;
var article_search_datatable = false;

var available_items = {};

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
//        templateSelection: function(r){
//            console.log(r);
//            return 'xxx';
//        }
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
            /*{
                text: "Скасувати",
                'class': 'btn',
                click: function() {
                  $( this ).dialog( "close" );
                }
            } */
        ]
    });
    
    $('#add-article-dialog').dialog({
        title: lang.add_article_title,
        width: 450,
        autoOpen: false,
        buttons: [
            {
                text: "Додати",
                'class': "btn btn-success",
                click: function() {
                  if (create_article())
                  {
                      $( this ).dialog( "close" );
                  }
                }
            }
            /*{
                text: "Скасувати",
                'class': 'btn',
                click: function() {
                  $( this ).dialog( "close" );
                }
            } */
        ]
    });
    
    $('#btn-add-subject').click(function(){
        show_add_subject_dlg();
    });
    
    $('#btn-add-article').click(function(){
        show_add_article_dlg();
    });
    
    $(document).on('keyup', '.select2-search__field', function(e){       
       subject_search_text = $(e.currentTarget).val();
    });
    
    if ($('.article-search-table').length)
    {
        article_search_datatable = $('.article-search-table').DataTable( {
            ajax: '/ajax.php?c=data&action=articles',
            dom: 
                    "<'row'<'col-sm-12'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'col-12'p>",
                    //"<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'p>>",
            language: arr_ext(dataTables_language, {
                zeroRecords: lang.article_search_no_records,
                search: ''
            }),
            columns: [
                {data: 'number'},
                {data: 'name'}
            ],
            rowCallback: function( row, data ) {
               $(row).attr('data-article-id', data.id);
              }
        } );
    }
    
    if ($('.available_items_search_datatable').length)
    {
        
        request('book/get_available_items', {department: from_department}, function(result){
            
            available_items = {};
            for (var i of result.data)
            {
                available_items[i.record_id] = i;
            }
            
            available_items_search_datatable = $('.available_items_search_datatable').DataTable( {
                data: result.data,
                dom: 
                        "<'row'<'col-sm-12'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'col-12'p>",
                        //"<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'p>>",
                language: arr_ext(dataTables_language, {
                    zeroRecords: lang.article_search_no_records,
                    search: ''
                }),
                columns: [
                    {data: 'number'},
                    {data: 'name'},
                    {data: 'category'},
                    {data: 'count'},
                    {data: 'price'}
                ],
                rowCallback: function( row, data ) {
                   $(row).attr('data-record-id', data.record_id);
                  }
            } );
            
        });
    }
    
    
    items_datatable = $('.doc-items-table').DataTable( {
        source: [],
        dom: 
                "<'row'<'col-sm-12'tr>>" +
                "<'col-12'p>",
                //"<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'p>>",
        language: arr_ext(dataTables_language, {
            zeroRecords: lang.items_no_records,
        }),
        columns: [
            {data: 'number'},
            {data: 'name'},
            {
                data: 'category',
                searchable: false,
                render: function(data, type, row, meta){ 
                    
                    if (row.is_cat > 0)
                    {
                        if (type === 'display')
                        {
                            var cats = ['I', 'II', 'III', 'IV', 'V'];
                            
                            if (items_editable)
                            {
                                var o = '';
                                for (var i in cats)
                                {
                                    var j = 1*i+1;
                                    o += '<option value="'+ j +'" '+ ( j == data ? 'selected' : '') +'>'+ cats[i] + '</option>';
                                }
                                return "<select class='form-control' onchange='update_items_data(this)' data-row='"+ meta.row +"' data-name='category'>"+ o +"</select>";
                            }
                            else
                            {
                                var j = data - 1;
                                return cats[j];
                            }
                        }
                        
                        return data;   
                    }
                    else
                    {
                        return '-';
                    }
                }
            },
            {
                data: 'count',
                searchable: false,
                render: function(data, type, row, meta){
                    if (type === 'display')
                    {   
                        return "<input  class='form-control' type='text' onchange='update_items_data(this)' data-row='"+ meta.row +"' data-name='count' value='"+ round_text(data) +"' />";
                    }

                    return data;
                }
            },
            {
                data: 'price',
                searchable: false,
                render: function(data, type, row, meta){
                    if (type === 'display')
                    {   
                        return "<input  class='form-control' type='text' onchange='update_items_data(this)' data-row='"+ meta.row +"' data-name='price' value='"+ round_text(data) +"' " + (items_editable ? '' : 'disabled') + " />";
                    }

                    return data;
                }
            },
            {
                searchable: false,
                sortable: false,
                render: function(data, type, row, meta){
                    return '<a href="#" onclick="delete_item(this, event)"  data-row="'+ meta.row +'" >X</a>';
                }
            }
        ]
    } );
    
    $(document).on("click", '#article-search-table tr[data-article-id]', function() {
        
        var id = $(this).attr("data-article-id");
        
        console.log(id);
        
        request('data/get_article', {id: id}, function(result){
            var item = arr_ext(result.data, {count: 1, category: (result.data.is_cat>0 ? 1 : '')});
            items_datatable.rows.add([item]).draw();
        });
    });
    
    $(document).on("click", '#available_items_search_datatable tr[data-record-id]', function() {
        
        var id = $(this).attr("data-record-id");
        add_item_from_available_table(id);
        
    });
    
    $('#btn-submit').click(function(){
        submit();
    });
    
    $('.datepicker').datepicker({
        dateFormat: 'dd.mm.yy'
    });
    
});

function add_item_from_available_table(record_id)
{
    var item = arr_ext (available_items[ record_id ], {});
    item.count = 1;
    
    console.log(item);

    items_datatable.rows.add([item]).draw();
}

function show_add_subject_dlg(){
    $('input[name=add-subject-name]').val(subject_search_text);
    $( "#add-subject-dialog" ).dialog( "open" );
}

function show_add_article_dlg(){
    $('input[name=add-article-name]').val($('#article-search-table_filter input').val());
    $( "#add-article-dialog" ).dialog( "open" );
}

function subject_added(result)
{
    console.log(result);
    var option = new Option(result.subject.name, result.subject.id, true, true);
    subject_select.append(option).trigger('change');
}

function update_items_data(e)
{
    var name = $(e).attr('data-name');
    var row = $(e).attr('data-row');
    
    var val = $(e).val();
    
    if ((name === 'price') || (name === 'count'))
    {
        val = round(val);
    }
    
    var data =  items_datatable.row( row )
        .data(  );

    data[name] = val;

    items_datatable.row( row )
        .data( data )
        .draw( false );
    
}

function create_article(){
    var data = {
        name: $('input[name=add-article-name]').val(),
        number: $('input[name=add-article-number]').val(),
        unit: $('input[name=add-article-unit]').val(),
        is_cat: $('select[name=add-article-is_cat]').val()
    };
    
    if (! data.name)
    {
        alert('Введіть найменування майна!');
        return;
    }
     
    if ( data.is_cat === '')
    {
        alert('Виберіть тип майна!');
        return;
    }
    
    request('data/create_article', data, function(result){
        var item = arr_ext(result.article, {count: 1, category: (result.article.is_cat>0 ? 1 : '')});
        items_datatable.rows.add([item]).draw();
        article_search_datatable.rows.add([item]).draw();
    });
    return true;
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
        alert('Виберіть підрозділ!');
        return;
    }
    
    if (items_datatable.data().length === 0)
    {
        alert('Не вибрано жодної позиції!');
        return;
    }
    
    var data = [];
    
    items_datatable.data().each( function (row) {
        var price = parseFloat(row.price);
        var count = parseFloat(row.count);
        
        var d = {};
        if (row.item_id)
        {
            d.item_id = row.item_id;
        }
        else
        {
            d.article_id = row.id;
        }
            
        data.push( arr_ext(d, {
            category: row.category,
            price: price,
            count: count
        }));
        
    } );
    
    for (var row of data)
    {
        if (!row.price )
        {
            alert('Введіть ціну!');
            return;
        }
        
        if (!row.count )
        {
            alert('Введіть кількість!');
            return;
        }
    }
    
    request('document/create', {
        type : document_type,
        document: {
            'reg_number': $('[name=reg_number]').val(),
            'reg_date' : $('[name=reg_date]').val(),
            'number' : $('[name=number]').val(),
            'date' : $('[name=date]').val(),
            'subject_id' : $('[name=subject_id]').val()
        },
        items: data
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