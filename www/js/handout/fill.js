function init(data)
{
    console.log(data);
}

var members_datatable = false;
var available_members = {};


$().ready(function(){
    
    request('handout/get_document', {'id' : id}, function(result){
        
            set_page_title(  $('.page-title').html() + ' №'  +  result.document.number );
        
            fill_vars({
                doc_number: result.document.number,
                doc_date: result.document.date
            });
            
            items_datatable = $('.items_datatable').DataTable( {
                data: result.items,
                dom:    
                        "<'row'<'col-12'tr>>" +
                         "<'row'<'col-12 col-xs-12'p>>",
                       
                        
                language: arr_ext(dataTables_language, {
                    search: '',
                    searchPlaceholder: 'Пошук'
                }),
                columns: [
                    {data: 'number'},
                    {data: 'name'},
                    {data: 'category'},
                    
                    {data: 'price'}
                ],
                rowCallback: function( row, data ) {
                   //$(row).attr('data-doc-item-id', data.record_id);
                }
            } );
            
            members_datatable = $('.members_datatable').DataTable( {
                
                data: result.members,
                dom: 
                        "<'row'<'col-12'tr>>" +
                        "<'col-12'p>" ,
                     
                language: arr_ext(dataTables_language, {
                    zeroRecords: lang.article_search_no_records,
                    search: ''
                }),
                columns: [
                    {data: 'position', sortable: false},
                    {data: 'rank', sortable: false},
                    {data: 'name', sortable: false},
                    {
                        searchable: false,
                        sortable: false,
                        render: function(data, type, row, meta){
                            return '<a href="#" onclick="delete_member(this, event)"  data-row="'+ meta.row +'" data-id="'+ row.id +'" >X</a>';
                        }
                    }
                ],
                rowCallback: function( row, data ) {
                   $(row).attr('data-member-id', data.id);
                  }
            } );
            
            $('#members_search_input').autocomplete({
                source: '/handout/search_members/?h=' + id,
                minLength: 1,
                
                select: function( event, ui ) {
                    var member = ui.item;
                    event.preventDefault();
                    $('#members_search_input').val('');
                    request('handout/add_member', {'handout_id' : id, member_id: member.id}, function(){
                        members_datatable.rows.add([member]).draw();
                    });
                }
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                    var li = $( "<li>" )
                      .attr( "data-value", item.value )
                      .append( item.label );
              
                    if (item.disabled)
                    {
                        li.addClass('ui-state-disabled');                        
                    }
                    
                    return li.appendTo( ul );
            };
            
            $('.export-link').attr('href', '/handout/export/?id=' + result.document.id);
    });
});


function delete_member(i, e){
    e.preventDefault();
    
    var row = $(i).attr('data-row');
    var member_id = $(i).attr('data-id');
    
    request('handout/delete_member', {'handout_id' : id, member_id: member_id}, function(){
        members_datatable.row( row )
        .remove();


        members_datatable.rows().invalidate();
        members_datatable.draw( false );
    });
    
    
    //invalidate  
}