function init(data)
{
    console.log(data);
}

var items_datatable = false;

$().ready(function(){
    
    request('document/get_document', {'id' : document_id}, function(result){
        
            set_page_title(  $('.page-title').html() + ' №'  +  result.document.reg_number );
        
            fill_vars({
                doc_number: result.document.number,
                doc_date: result.document.date,
                reg_number: result.document.reg_number,
                reg_date: result.document.reg_date,
                subject_name: result.subject.name,
                total_items: result.total_items
            });
                        
            items_datatable = $('.items_datatable').DataTable( {
                data: result.items,
                dom: 
                       "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-4 col-xs-12 sb'f><'col-8 col-xs-12'p>>",
                language: arr_ext(dataTables_language, {
                    search: '',
                    searchPlaceholder: 'Пошук'
                }),
                columns: [
                    {data: 'number'},
                    {data: 'name'},
                    {data: 'category'},
                    {data: 'count'},
                    {data: 'price'}
                ],
                rowCallback: function( row, data ) {
                   //$(row).attr('data-doc-item-id', data.record_id);
                }
            } );
            
            var n = 0;
            for (var i of result.items){
                $('.print-items-table-total').before('<tr>'  
                        + '<td>'+ (++n) +'.</td>'
                        + '<td class="l">'+ (i.name) +'</td>'
                        + '<td class="bl">'+ (i.number) +'</td>'
                        + '<td>'+ (i.unit) +'</td>'
                        + '<td>'+ display_category(i.category) +'</td>'
                        + '<td>'+ (round_text(i.count)) +'</td>'
                        + '<td class="br">'+ (round_text(i.count)) +'</td>'
                        + '<td>Ціна '+ (i.price) +' грн</td>'
                    + '</tr>'
                );
            }
            
            $('.export-link').attr('href', '/document/word_export/?id=' + result.document.id);
    });
});
