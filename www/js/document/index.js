function init(data)
{
    console.log(data);
}


var items_datatable = false;
var all_documents = false;

$().ready(function(){
    
    for (var i in type_tabs)
    {
        if (i > 0)
        {
            var t = type_tabs[i];
            $('ul.nav-tabs').append('<li class="nav-item"><a class="nav-link" data-idx="'+ i +'" href="#">'+ t.title + '</a></li>');
        }
    }
    
    request('document/get_index', {}, function(result){
        
            all_documents = result.items;
        
            items_datatable = $('.items_datatable').DataTable( {
                data: result.items,
                dom: 
                        
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-4 col-xs-12 sb 'f><'col-8 col-xs-12'p>>",
                        //"<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'p>>",
                language: arr_ext(dataTables_language, {
                    search: '',
                    searchPlaceholder: 'Пошук',
                }),
                columns: [
                    {data: 'reg_number'},
                    {data: 'reg_date', render: date_render},
                    {
                        data: 'type',
                        render: function(data){
                            return names[data];
                        }
                    },
                    {data: 'number'},
                    {data: 'date', render: date_render},
                    {data: 'subject_name'},
                    {
                        data: 'items', 
                        render: function(items, type){
                            
                            switch (type)
                            {
                                case 'display':
                                    var res = '<ul>';
                                    for (var i of items){
                                        res += '<li>' + i.name + ' (' + i.cnt  + ')</li>';
                                    }
                                    res += '</ul>';
                                    return res;
                                    
                                default:
                                    var res = '';
                                    for (var i of items){
                                        res +=  i.name + ', ';
                                    }
                                    return res;
                                    
                            }
                        },
                        sortable: false
                    }
                ],
                rowCallback: function( row, data ) {
                   $(row).attr('doc-id', data.id);
                },
                order: [[1, 'desc'], [0, 'desc']]
                
            } );
            
         
    });
    
    $(document).on("click", '.items_datatable tr[doc-id]', function() {
        
        var id = $(this).attr("doc-id");
        window.location.href = '/document/view/?id=' + id
    });
        
        
    $(document).on('click', 'ul.nav-tabs a.nav-link', function(e){
        var i = $(e.target).attr('data-idx');
        $('ul.nav-tabs a.nav-link').removeClass('active');
        $(e.target).addClass('active');
        
        var filtered = [];
        
        if (i)
        {
            var types = type_tabs[i].types;
            
            for (var doc of all_documents)
            {
                if ( types.indexOf(doc.type) >= 0 )
                {
                    filtered.push(doc);
                }
            }
        }
        else
        {
            filtered = all_documents;
        }
        
        items_datatable.clear();
        items_datatable.rows.add(filtered);
        items_datatable.draw();
    });
        
});